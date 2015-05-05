<?php
App::uses('AppModel', 'Model');
/**
 * Recipe Model
 *
 * @property Ethnicity $Ethnicity
 * @property BaseType $BaseType
 * @property Course $Course
 * @property PreparationTime $PreparationTime
 * @property Difficulty $Difficulty
 * @property Source $Source
 * @property User $User
 */
class Recipe extends AppModel {
    public $actsAs = array(
        'Upload.Upload' => array(
            'image' => array(
                'fields' => array(
                    'dir' => 'image_dir'
                )
            )
        )
    );
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
                'notEmpty' => array(
                        'rule' => array('notEmpty'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
        ),
        'private' => array(
                'boolean' => array(
                        'rule' => array('boolean'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
        ),
        'system' => array(
                'notEmpty' => array(
                        'rule' => array('notEmpty'),
                        //'message' => 'Your custom message here',
                        //'allowEmpty' => false,
                        //'required' => false,
                        //'last' => false, // Stop validation after this rule
                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
        ),
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Ethnicity' => array(
                'className' => 'Ethnicity',
                'foreignKey' => 'ethnicity_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'BaseType' => array(
                'className' => 'BaseType',
                'foreignKey' => 'base_type_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'Course' => array(
                'className' => 'Course',
                'foreignKey' => 'course_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'PreparationTime' => array(
                'className' => 'PreparationTime',
                'foreignKey' => 'preparation_time_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'PreparationMethod' => array(
                'className' => 'PreparationMethod',
                'foreignKey' => 'preparation_method_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'Difficulty' => array(
                'className' => 'Difficulty',
                'foreignKey' => 'difficulty_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'Source' => array(
                'className' => 'Source',
                'foreignKey' => 'source_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        ),
        'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        )      
    );
        
    public $hasMany = array(
        'RelatedRecipe' => array(
            'className' => 'RelatedRecipe',
            'foreignKey' => 'parent_id',
            'order' => 'RelatedRecipe.sort_order',
            'dependent' => true
        ),
        'IngredientMapping' => array(
            'className' => 'IngredientMapping',
            'foreignKey' => 'recipe_id',
            'order' => 'IngredientMapping.sort_order',
            'dependent' => true
        ),
        'Image' => array(
            'className' => 'Attachment',
            'foreignKey' => 'recipe_id',
        ),
        'Review' => array(
            'className' => 'Review',
            'foreignKey' => 'recipe_id',
            'order' => 'Review.created',
            'dependent' => true
        ),
    );
        
    public function saveWithAttachments($data) {
        // Sanitize your images before adding them
        $images = array();
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
        throw new Exception(__("This recipe could not be saved. Please try again"));
    }
    
    public function isOwnedBy($recipeId, $user) {
        return $this->field('id', array('id' => $recipeId, 'user_id' => $user)) !== false;
    }
}
