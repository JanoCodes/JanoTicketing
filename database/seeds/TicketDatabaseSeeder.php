<?php

use Illuminate\Database\Seeder;
use Jano\Models\Ticket;

class TicketDatabaseSeeder extends Seeder
{
    /**
     * Seed a new ticket class.
     */
    public function run()
    {
        $ticket = Ticket::create([
            'name' => 'Standard',
            'price' => 100,
        ]);

        $array = array();

        for ($i = 0; $i < 100; $i++) {
            $array[] = [
                'ticket_id' => $ticket->id,
                'reserved_time' => 0,
            ];
        }

        DB::table('ticket_store')->insert($array);
    }
}