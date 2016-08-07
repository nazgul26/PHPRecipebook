<?php

App::uses('AppModel', 'Model');
/**
 * Recipe Model.
 *
 * @property Ethnicity $Ethnicity
 * @property BaseType $BaseType
 * @property Course $Course
 * @property PreparationTime $PreparationTime
 * @property Difficulty $Difficulty
 * @property Source $Source
 * @property User $User
 */
class Recipe extends AppModel
{
    public $actsAs = [
        'Upload.Upload' => [
            'image' => [
                'fields' => [
                    'dir' => 'image_dir',
                ],
            ],
        ],
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public $validate = [
        'name' => [
                'required' => [
                 'rule' => 'notBlank',
             ],
        ],
        'private' => [
                'boolean' => [
                    'rule' => 'boolean',
                ],
        ],
        'system' => [
                'required' => [
                    'rule' => 'notBlank',
                ],
        ],
    ];

    /**
     * belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
        'Ethnicity' => [
                'className'  => 'Ethnicity',
                'foreignKey' => 'ethnicity_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'BaseType' => [
                'className'  => 'BaseType',
                'foreignKey' => 'base_type_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'Course' => [
                'className'  => 'Course',
                'foreignKey' => 'course_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'PreparationTime' => [
                'className'  => 'PreparationTime',
                'foreignKey' => 'preparation_time_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'PreparationMethod' => [
                'className'  => 'PreparationMethod',
                'foreignKey' => 'preparation_method_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'Difficulty' => [
                'className'  => 'Difficulty',
                'foreignKey' => 'difficulty_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'Source' => [
                'className'  => 'Source',
                'foreignKey' => 'source_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
        'User' => [
                'className'  => 'User',
                'foreignKey' => 'user_id',
                'conditions' => '',
                'fields'     => '',
                'order'      => '',
        ],
    ];

    public $hasMany = [
        'RelatedRecipe' => [
            'className'  => 'RelatedRecipe',
            'foreignKey' => 'parent_id',
            'order'      => 'RelatedRecipe.sort_order',
            'dependent'  => true,
        ],
        'IngredientMapping' => [
            'className'  => 'IngredientMapping',
            'foreignKey' => 'recipe_id',
            'order'      => 'IngredientMapping.sort_order',
            'dependent'  => true,
        ],
        'Image' => [
            'className'  => 'Attachment',
            'foreignKey' => 'recipe_id',
        ],
        'Review' => [
            'className'  => 'Review',
            'foreignKey' => 'recipe_id',
            'order'      => 'Review.created',
            'dependent'  => true,
        ],
    ];

    public function saveWithAttachments($data)
    {
        // Sanitize your images before adding them
        $images = [];
        if (!empty($data['Image'][0])) {
            foreach ($data['Image'] as $i => $image) {
                if (is_array($data['Image'][$i])) {
                    // Force setting the `model` field to this model

                    // Unset the foreign_key if the user tries to specify it
                    if (isset($image['recipe_id'])) {
                        unset($image['recipe_id']);
                    }

                    //echo $image['attachment'] . ' is size '. $image['size'];

                    $images[] = $image;
                }
            }
        }
        $data['Image'] = $images;

        // Try to save the data using Model::saveAll()
        if ($this->saveAll($data)) {
            return true;
        }

        // Throw an exception for the controller
        throw new Exception(__('This recipe could not be saved. Please try again'));
    }

    public function isOwnedBy($recipeId, $user)
    {
        return $this->field('id', ['id' => $recipeId, 'user_id' => $user]) !== false;
    }
}
