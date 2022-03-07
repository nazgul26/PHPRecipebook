<?php
use Migrations\AbstractMigration;

class AlterSystemOnIngredients extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('ingredients');
        $table->renameColumn('system', 'system_type');
        $table->update();
    }
}
