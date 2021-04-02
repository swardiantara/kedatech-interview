<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->delete();
        
        DB::table('messages')->insert(array (
            0 => array (
                'sender_id' => 1,
                'message' => "Hi, customer 2. I'm customer 1",
                'receiver_id' => 2,
                'created_at' => '2021-04-02 14:52:00',
                'updated_at' => NULL,
            ),
            1 => array (
                'sender_id' => 2,
                'message' => "Ooh. Hi, customer 1. Nice to meet you",
                'receiver_id' => 1,
                'created_at' => '2021-04-02 14:53:00',
                'updated_at' => NULL,
            ),
            2 => array (
                'sender_id' => 3,
                'message' => "Hi, staff 2. I'm staff 1",
                'receiver_id' => 4,
                'created_at' => '2021-04-02 14:54:00',
                'updated_at' => NULL,
            ),
            3 => array (
                'sender_id' => 4,
                'message' => "Ooh. Hi, staff 1. Nice to meet you",
                'receiver_id' => 3,
                'created_at' => '2021-04-02 14:55:00',
                'updated_at' => NULL,
            ),
            4 => array (
                'sender_id' => 3,
                'message' => "Customer 1, please go to counter 1",
                'receiver_id' => 1,
                'created_at' => '2021-04-02 14:56:00',
                'updated_at' => NULL,
            ),
            5 => array (
                'sender_id' => 4,
                'message' => "Customer 2, please go to counter 2",
                'receiver_id' => 2,
                'created_at' => '2021-04-02 14:57:00',
                'updated_at' => NULL,
            ),
        ));
    }
}
