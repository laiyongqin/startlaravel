<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UsersTableSeeder extends Seeder {
public function run(){
DB::table('users')->insert(array(
'id'=>1,
'username' =>'admin', 
'password' => Hash::make('admin'), 
 'is_admin' => true
        ));
DB::table('users')->insert(array( //User::create()和DB::table('users')->insert区别
'id'=>2,
'username' =>'xie',
'password' => Hash::make('xie'),
'is_admin' => false)
);
}
}