<?php

class Attachment extends AppModel
{
    public $actsAs = [
        'Upload.Upload' => [
            'attachment' => [
                'thumbnailSizes' => [
                    'thumb'   => '60w',
                    'preview' => '200w',
                ],
                'thumbnailMethod'      => 'php',
                'deleteFolderOnDelete' => true,
            ],
        ],
    ];

    public $belongsTo = [
        'Recipe' => [
            'className'  => 'Recipe',
            'foreignKey' => 'recipe_id',
        ],
    ];
}
