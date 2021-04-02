<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports')->delete();
        
        DB::table('reports')->insert(array (
            0 => array (
                'reporter_id' => 1,
                'type' => 'feedback',
                'description' => "This branch's service is so helpful. There are 2 counters that will be more than happy to solve our problems. Keep up the good work!",
                'created_at' => '2021-04-02 14:52:00',
                'updated_at' => NULL,
            ),
            1 => array (
                'reporter_id' => 2,
                'type' => 'bug',
                'description' => "I tried to make a transaction at 12 a.m, midnight. I received this 1522 error code, and 'Transaction Error!' message. Please help.",
                'created_at' => '2021-04-02 14:52:00',
                'updated_at' => NULL,
            ),
        ));
    }
}
