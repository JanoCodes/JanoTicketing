<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Jano\Models\Group;
use Jano\Models\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Seed a user and its assoicated group.
     */
    public function run()
    {
        $faker = Factory::create();

        $group = new Group();
        $group->slug = 'test-group';
        $group->name = 'Test Group';
        $group->can_order_at = $faker->dateTimeThisYear();
        $group->ticket_limit = $faker->randomDigitNotNull;
        $group->surcharge = 0;
        $group->right_to_buy = 0;
        $group->save();

        $user = new User();
        $user->title = $faker->title;
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->email = 'user@example.com';
        $user->password = bcrypt('password');
        $user->method = User::DATABASE_METHOD;
        $user->group()->associate($group);
        $user->save();

        $user->staff()->create(['access_level' => 999]);
    }
}