<?php
use Migrations\AbstractSeed;

class EthnicitiesSeed extends AbstractSeed
{
    public function run() : void
    {               
        $data = [
            ['name' => __('American')],
            ['name' => __('Chinese')],
            ['name' => __('Difficult')],
            ['name' => __('German')],
            ['name' => __('Greek')],
            ['name' => __('Indian')],
            ['name' => __('Italian')],
            ['name' => __('Japanese')],
            ['name' => __('Mexican')],
            ['name' => __('Middle Eastern')],
            ['name' => __('None')],
            ['name' => __('Slavic')],
        ];
        $table = $this->table('ethnicities');
        $table->insert($data)->save();
    }
}
