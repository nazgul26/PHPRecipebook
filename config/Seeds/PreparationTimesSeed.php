<?php
use Migrations\AbstractSeed;

class PreparationTimesSeed extends AbstractSeed
{
    public function run() : void
    {               
        $data = [
            ['name' => __('0 Minutes')],
            ['name' => __('1-10 Minutes')],
            ['name' => __('10-30 Minutes')],
            ['name' => __('30-60 Minutes')],
            ['name' => __('60+ Minutes')],
        ];
        $table = $this->table('preparation_times');
        $table->insert($data)->save();
    }
}
