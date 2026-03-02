<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Attachments Model
 *
 * @property \App\Model\Table\RecipesTable&\Cake\ORM\Association\BelongsTo $Recipes
 *
 * @method \App\Model\Entity\Attachment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Attachment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Attachment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Attachment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Attachment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Attachment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Attachment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Attachment findOrCreate($search, callable $callback = null, $options = [])
 */
class AttachmentsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('attachments');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'attachment' => [
                'fields' => [
                    'dir' => 'photo_dir',
                    'size' => 'photo_size',
                    'type' => 'photo_type',
                ],
                /*'nameCallback' => function ($table, $entity, $data, $field, $settings) {
                    return strtolower($data->getClientFilename());
                },*/
                'transformer' => function (\Cake\Datasource\RepositoryInterface $table, \Cake\Datasource\EntityInterface $entity, $data, $field, $settings, $filename) {
                    // $data is a PSR-7 UploadedFileInterface (plugin v8+)
                    $extension = pathinfo($data->getClientFilename(), PATHINFO_EXTENSION);
                    // Store the thumbnail in a temporary file
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    // Use the Imagine library to create a thumbnail
                    $size = new \Imagine\Image\Box(40, 40);
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                    $imagine = new \Imagine\Gd\Imagine();
                    $tmpName = $data->getStream()->getMetadata('uri');
                    $imagine->open($tmpName)
                            ->thumbnail($size, $mode)
                            ->save($tmp);
                    // Return [source_path => destination_filename] for original and thumbnail
                    return [
                        $tmpName => $filename,
                        $tmp => 'thumbnail-' . $filename,
                    ];
                },
                'deleteCallback' => function ($path, $entity, $field, $settings) {
                    // When deleting the entity, both the original and the thumbnail will be removed
                    // when keepFilesOnDelete is set to false
                    return [
                        $path . $entity->{$field},
                        $path . 'thumbnail-' . $entity->{$field},
                    ];
                },
                'keepFilesOnDelete' => false,
            ]
            /*'attachment' => [
                'thumbnailSizes' => [
                    'thumb' => '60w',
                    'preview' => '200w'
                ],
                'thumbnailMethod' => 'php',
                'deleteFolderOnDelete' => true
            ],*/
        ]);

        $this->belongsTo('Recipes', [
            'foreignKey' => 'recipe_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Check that the upload directory is writable before the upload behavior
     * attempts to write files, so a clear error is shown instead of a cryptic
     * database type-mismatch error.
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void
    {
        if (!($entity->get('attachment') instanceof UploadedFileInterface)) {
            return;
        }

        $uploadRoot = WWW_ROOT . 'files';
        if (!is_dir($uploadRoot) || !is_writable($uploadRoot)) {
            $entity->setError('attachment', [__('The image upload directory does not exist or is not writable. Please contact an administrator.')]);
            $event->stopPropagation();
            $event->setResult(false);
        }
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) : Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 32)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            //->scalar('attachment')
            //->maxLength('attachment', 255)
            ->requirePresence('attachment', 'create')
            ->notEmptyString('attachment');

        $validator
            ->scalar('dir')
            ->maxLength('dir', 255)
            ->allowEmptyString('dir');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->integer('size')
            ->allowEmptyString('size');

        $validator
            ->integer('sort_order')
            ->allowEmptyString('sort_order');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) : RulesChecker
    {
        $rules->add($rules->existsIn(['recipe_id'], 'Recipes'));

        return $rules;
    }
}
