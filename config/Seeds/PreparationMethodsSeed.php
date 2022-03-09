<?php
use Migrations\AbstractSeed;

class PreparationMethodsSeed extends AbstractSeed
{
    public function run()
    {               
        $data = [
            ['name' => __('Slow cooker')],
            ['name' => __('Microwave')],
            ['name' => __('BBQ')],
            ['name' => __('Canning')],
        ];
        $table = $this->table('preparation_methods');
        $table->insert($data)->save();
    }
}
