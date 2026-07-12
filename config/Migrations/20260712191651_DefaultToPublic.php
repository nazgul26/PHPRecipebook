<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class DefaultToPublic extends BaseMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/guides/writing-migrations/migration-methods.html#the-up-method
     *
     * @return void
     */
    public function up(): void
    {

        $this->table('recipes')
            ->changeColumn('private', 'boolean', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/guides/writing-migrations/migration-methods.html#the-down-method
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('recipes')
            ->changeColumn('private', 'boolean', [
                'default' => null,
                'length' => null,
                'null' => false,
            ])
            ->update();
    }
}
