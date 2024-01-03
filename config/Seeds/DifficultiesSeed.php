<?php
use Migrations\AbstractSeed;

class DifficultiesSeed extends AbstractSeed
{
    public function run() : void
    {               
        $data = [
            ['name' => __('Easy')],
            ['name' => __('Intermediate')],
            ['name' => __('Difficult')],
            ['name' => __('Expert')],
        ];
        $table = $this->table('difficulties');
        $table->insert($data)->save();
    }
}
