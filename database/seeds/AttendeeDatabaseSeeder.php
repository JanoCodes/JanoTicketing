<?php

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Jano\Models\Attendee;
use Jano\Models\Charge;
use Jano\Models\Ticket;
use Jano\Models\User;
use Jano\Repositories\HelperRepository as Helper;

class AttendeeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $user = User::firstOrFail();
        $ticket = Ticket::firstOrFail();

        $count = $faker->randomDigitNotNull;
        $amount = Helper::getUserPrice($ticket->price, $user, false) * $count;

        $charge = new Charge();
        $charge->account()->associate($user->account()->first());
        $charge->amount = $amount;
        $charge->description = trans_choice(
            'system.ticket_order_for_attendee',
            $count,
            ['count' => $count]
        );
        $charge->due_at = Carbon::now()->addDays(2);
        $charge->paid = false;
        $charge->save();

        for ($i = 0; $i < $count; $i++) {
            $attendee = new Attendee();
            $attendee->user()->associate($user);
            $attendee->charge()->associate($charge);
            $attendee->uuid = Helper::generateUuid();
            $attendee->title = $faker->title;
            $attendee->first_name = $faker->firstName;
            $attendee->last_name = $faker->lastName;
            $attendee->email = $faker->email;
            $attendee->primary_ticket_holder = $i === 0;
            $attendee->ticket()->associate($ticket);
            $attendee->checked_in = false;
            $attendee->save();
        }
    }
}
