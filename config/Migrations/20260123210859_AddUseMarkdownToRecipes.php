<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddUseMarkdownToRecipes extends BaseMigration
{
    /**
     * Change Method.
     *
     * Add use_markdown boolean field to recipes table.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('recipes');
        $table->addColumn('use_markdown', 'boolean', [
            'default' => false,
            'null' => false,
            'after' => 'directions',
        ]);
        $table->update();
    }
}
