<?php

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        for ($i = 0; $i < 5; $i++) {
            $ticket = new Ticket();
            $ticket->name = ucwords($faker->unique()->word);
            $ticket->price = $faker->randomDigit * 100 + $faker->randomDigitNotNull * 10;
            $ticket->save();

            $array = array();
            for ($k = 0; $k < $faker->randomDigitNotNull * 10; $k++) {
                $array[] = [
                    'ticket_id' => $ticket->id,
                    'reserved_time' => 0,
                ];
            }
            DB::table('ticket_store')->insert($array);
        }

        $users = User::inRandomOrder()->get();

        foreach ($users as $user) {
            $number = $faker->randomDigit;

            if ($number !== 0) {
                $ticket = Ticket::inRandomOrder()->first();

                $amount = Helper::getUserPrice($ticket->price, $user, false) * $number;

                $charge = new Charge();
                $charge->account()->associate($user->account()->first());
                $charge->amount = $amount;
                $charge->description = trans_choice(
                    'system.ticket_order_for_attendee',
                    $number,
                    ['count' => $number]
                );
                $charge->due_at = Carbon::now()->addDays(2);
                $charge->paid = false;
                $charge->save();

                for ($j = 0; $j < $number; $j++) {
                    $attendee = new Attendee();
                    $attendee->user()->associate($user);
                    $attendee->ticket()->associate($ticket);
                    $attendee->charge()->associate($charge);
                    $attendee->uuid = Helper::generateUuid();
                    $attendee->title = $j === 0 ? $user->title : $faker->title;
                    $attendee->first_name = $j === 0 ? $user->first_name : $faker->firstName;
                    $attendee->last_name = $j === 0 ? $user->last_name : $faker->lastName;
                    $attendee->email = $j === 0 ? $user->email : $faker->unique()->safeEmail;
                    $attendee->primary_ticket_holder = $j === 0;
                    $attendee->checked_in = false;
                    $attendee->save();
                }
            }
        }
    }
}
