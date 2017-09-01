<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Jano\Models\Charge;
use Jano\Models\TransferRequest;
use Jano\Models\User;

class TransferRequestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $users = User::whereHas('attendees')->with('attendees')->inRandomOrder()->take(10);

        foreach ($users as $user) {
            $attendee = $user->attendees()->inRandomOrder()->first();

            $charge = new Charge();
            $charge->account()->associate($user->account()->first());
            $charge->amount = 40;
            $charge->description = __('system.ticket_transfer_order');
            $charge->save();

            $request = new TransferRequest();
            $request->user()->associate($user);
            $request->attendee()->associate($attendee);
            $request->charge()->associate($charge);
            $request->old_title = $attendee->title;
            $request->old_first_name = $attendee->first_name;
            $request->old_last_name = $attendee->last_name;
            $request->old_email = $attendee->email;
            $request->title = $faker->title;
            $request->first_name = $faker->firstName;
            $request->last_name = $faker->lastName;
            $request->email = $faker->unique()->safeEmail;
            $request->primary_ticket_holder = $attendee->primary_ticket_holder;
            $request->confirmed = true;
            $request->processed = false;
            $request->save();
        }
    }
}
