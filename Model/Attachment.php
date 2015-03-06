<?php
class Attachment extends AppModel {
    public $actsAs = array(
        'Upload.Upload' => array(
            'attachment' => array(
                'thumbnailSizes' => array(
                    'thumb' => '60w',
                    'preview' => '200w'
                ),
                'thumbnailMethod' => 'php',
                'deleteFolderOnDelete' => true
            ),
        ),
    );

    public $belongsTo = array(
        'Recipe' => array(
            'className' => 'Recipe',
            'foreignKey' => 'recipe_id',
        )
    );
}
?>
