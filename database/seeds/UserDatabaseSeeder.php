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

        $group = Group::create([
            'slug' => 'test-group',
            'name' => 'Test Group',
            'can_order_at' => $faker->dateTimeThisYear(),
            'ticket_limit' => $faker->randomDigitNotNull,
            'surcharge' => 0
        ]);

        User::create([
            'title' => $faker->title,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => 'user@example.com',
            'password' => 'password',
            'method' => User::DATABASE_METHOD,
            'group_id' => $group->id
        ]);
    }
}