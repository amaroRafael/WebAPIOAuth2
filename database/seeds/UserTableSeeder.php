<?php
/**
 * Created by PhpStorm.
 * User: ramaro
 * Date: 6/2/15
 * Time: 10:17 PM
 */

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder {

    public function run()
    {
        User::query()->forceDelete();

        $hasher = app()->make('hash');

        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => $hasher->make('1234')
        ]);
    }

}