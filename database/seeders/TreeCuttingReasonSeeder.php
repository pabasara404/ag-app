<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreeCuttingReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasonsToCutTrees = [
            ['id' => 1, 'label' => 'To a common developmental need'],
            ['id' => 2, 'label' => 'To build the house intended to be built'],
            ['id' => 3, 'label' => 'Due to death due to natural causes'],
            ['id' => 4, 'label' => 'Because the Electricity Board has asked to cut it off'],
            ['id' => 5, 'label' => 'Because it\'s dangerous'],
            ['id' => 6, 'label' => 'Due to a decision of the court or arbitration panel'],
            ['id' => 7, 'label' => 'Because it does not bear fruit']
        ];

        DB::table('tree_cutting_reasons')->insert($reasonsToCutTrees);
    }
}
