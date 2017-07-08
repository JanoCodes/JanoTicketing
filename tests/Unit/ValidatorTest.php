<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * Asserts that sum_between validator rule functions as expected.
     */
    public function testSumBetweenRulePasses()
    {
        $validator = Validator::make([
            'attendees' => [
                2 => 1,
                4 => 0,
            ],
        ],[
            'attendees' => 'sum_between:1,1'
        ]);
        $this->assertFalse($validator->fails());

        $validator = Validator::make([
            'attendees' => [
                2 => 3,
                4 => 2,
            ],
        ],[
            'attendees' => 'sum_between:4,6'
        ]);
        $this->assertFalse($validator->fails());

        $validator = Validator::make([
            'attendees' => [
                2 => [
                    'primary_ticket_holder' => 1,
                ],
                4 => [
                    'primary_ticket_holder' => 0,
                ],
            ],
        ],[
            'attendees.*.primary_ticket_holder' => 'sum_between:1,1,attendees.*.primary_ticket_holder'
        ]);
        $this->assertFalse($validator->fails());

        $validator = Validator::make([
            'attendees' => [
                2 => [
                    'primary_ticket_holder' => 1,
                ],
                5 => [
                    'primary_ticket_holder' => 2,
                ],
            ],
        ],[
            'attendees.*.primary_ticket_holder' => 'sum_between:0,3,attendees.*.primary_ticket_holder'
        ]);
        $this->assertFalse($validator->fails());

        $validator = Validator::make([
            'attendees' => [
                2 => 1,
                5 => 2,
            ],
        ],[
            'attendees.*' => 'sum_between:0,3,attendees.*'
        ]);
        $this->assertFalse($validator->fails());

        $validator = Validator::make([
            2 => 1,
            5 => 2,
        ],[
            '*' => 'sum_between:3,3,*'
        ]);
        $this->assertFalse($validator->fails());
    }

    /**
     * Asserts that sum_between validator rule functions as expected.
     */
    public function testSumBetweenRuleFails()
    {
        $validator = Validator::make([
            'attendees' => [
                1 => [
                    'primary_ticket_holder' => 0,
                ],
                4 => [
                    'primary_ticket_holder' => 0,
                ],
            ],
        ],[
            'attendees.*.primary_ticket_holder' => 'sum_between:1,3,attendees.*.primary_ticket_holder'
        ]);
        $this->assertTrue($validator->fails());

        $validator = Validator::make([
            'attendees' => [
                2 => [
                    'primary_ticket_holder' => 2,
                ],
                7 => [
                    'primary_ticket_holder' => 3,
                ],
            ],
        ],[
            'attendees.*.primary_ticket_holder' => 'sum_between:1,3,attendees.*.primary_ticket_holder'
        ]);
        $this->assertTrue($validator->fails());
    }

    /**
     * Asserts that sum_between rule throws an exception when the attribute title does not contain a wildcard.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testSumBetweenThrowsExceptionWithNoWildcard()
    {
        $validator = Validator::make([
            'attendees' => [
                1 => [
                    'primary_ticket_holder' => 0,
                ],
                4 => [
                    'primary_ticket_holder' => 0,
                ],
            ],
        ],[
            'attendees.*.primary_ticket_holder' => 'sum_between:1,3,attendees.1.primary_ticket_holder'
        ]);
        $validator->fails();
    }

    /**
     * Asserts that sum_between rule throws an exception when the attribute title missing.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testSumBetweenThrowsExceptionWithNoAttribute()
    {
        $validator = Validator::make([
            'attendees' => [
                1 => [
                    'primary_ticket_holder' => 0,
                ],
                4 => [
                    'primary_ticket_holder' => 2,
                ],
            ],
        ],[
            'attendees.*.primary_ticket_holder' => 'sum_between:1,3'
        ]);
        $this->assertTrue($validator->fails());
    }
}