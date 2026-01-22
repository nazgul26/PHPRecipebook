<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddDinnerRemindersToUsers extends BaseMigration
{
    /**
     * Change Method.
     *
     * Add dinner_reminders_enabled boolean field to users table.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('dinner_reminders_enabled', 'boolean', [
            'default' => false,
            'null' => false,
            'after' => 'meal_plan_start_day',
        ]);
        $table->update();
    }
}
