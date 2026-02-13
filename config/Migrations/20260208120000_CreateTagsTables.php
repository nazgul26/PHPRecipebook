<?php
use Migrations\AbstractMigration;

class CreateTagsTables extends AbstractMigration
{
    public function up()
    {
        $this->table('tags')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 64,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                    'user_id',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('recipe_tags')
            ->addColumn('recipe_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('tag_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'recipe_id',
                    'tag_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'tag_id',
                ]
            )
            ->create();
    }
}
