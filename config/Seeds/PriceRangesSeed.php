<?php
use Migrations\AbstractSeed;

class PriceRangesSeed extends AbstractSeed
{
    public function run()
    {               
        $data = [
            ['name' => __('$0-$10')],
            ['name' => __('$10-$15')],
            ['name' => __('$15-$20')],
            ['name' => __('$20-$25')],
            ['name' => __('$25-$30')],
            ['name' => __('$30+')],
        ];
        $table = $this->table('price_ranges');
        $table->insert($data)->save();
    }
}