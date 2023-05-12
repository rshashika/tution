<?php

use Illuminate\Database\Seeder;

class admin_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('admins')->insert([
            'username' => 'admin',
            'password' => Hash::make('123456')
            'password_plane'=>'123456',
            'type'=>'Admin',
            'status'=>1,
            'added'=>1
        ]);
    }
}
