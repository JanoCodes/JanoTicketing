<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Jano\Models\Account;
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

        for ($i = 0; $i < 5; $i++) {
            $group = new Group();
            $name = $faker->unique()->word;
            $group->slug = strtolower($name);
            $group->name = $name;
            $group->can_order_at = $faker->dateTimeThisYear;
            $group->ticket_limit = $faker->randomDigitNotNull;
            $group->surcharge = $faker->randomDigit * 10;
            $group->right_to_buy = 0;
            $group->save();
        }

        for ($j = 0; $j < 50; $j++) {
            $group = Group::inRandomOrder()->first();

            $user = new User();
            $user->title = $faker->title;
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = $j === 0 ? 'user@example.com' : $faker->unique()->safeEmail;
            $user->password = bcrypt('password');
            $user->method = User::DATABASE_METHOD;
            $user->group()->associate($group);
            $user->save();

            if ($j === 0) {
                $user->staff()->create(['access_level' => 999]);
            }

            $account = new Account();
            $account->user()->associate($user);
            $account->amount_due = 0;
            $account->amount_paid = 0;
            $account->save();
        }
    }
}
