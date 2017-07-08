<?php

namespace Tests\Unit;

use Jano\Facades\Helper;
use PHPUnit_Framework_Error;
use PHPUnit_Framework_Error_Warning;
use stdClass;
use Tests\TestCase;

class HelperTest extends TestCase
{
    /**
     * Asserts that Helper::flattenArrayKey functions as expected.
     */
    public function testFlattenArrayKey()
    {
        $array = [
            'l1i1' => 'value',
            'l1i2' => [
                'l2i1' => 'value',
                'l2i2' => 'value',
            ],
            'l1i3' => [
                'l2i1' => [
                    'l3i1' => 'value',
                ],
            ]
        ];

        $array = Helper::flattenArrayKey($array);

        $this->assertArrayHasKey('l1i1', $array);
        $this->assertArrayHasKey('l1i2.l2i2', $array);
        $this->assertArrayHasKey('l1i3.l2i1.l3i1', $array);
        $this->assertArrayNotHasKey('l1i2', $array);
        $this->assertArrayNotHasKey('l1i3.l2i1', $array);
    }

    /**
     * Asserts that Helper::flattenArrayKey fails when a non-array object is supplied.
     *
     * @expectedException \TypeError
     */
    public function testFlattenArrayKeyFails()
    {
        $class = new \stdClass();
        Helper::flattenArrayKey($class);
    }
}