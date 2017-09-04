<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2017 Andrew Ying
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v3.0 as
 * published by the Free Software Foundation. You must preserve all legal
 * notices and author attributions present.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Jano\Http\Controllers\Backend;

use Illuminate\Http\Request;
use function is_string;
use Jano\Http\Controllers\Controller;
use Jano\Jobs\ImportPaymentFromFile;
use League\Csv\Reader;
use SplFileObject;
use Validator;

class PaymentImportController extends Controller
{
    /**
     * PaymentImportController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'staff']);
    }

    /**
     * Render the payment import page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.paymentimports.create');
    }

    /**
     * Return the validator instance.
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function validator($data)
    {
        return Validator::make($data, [
            'file' => 'file|mimes:csv,txt'
        ]);
    }

    /**
     * Match CSV file header against specified pattern(s), defined in `field_name` => `rules` format as
     * an array. `rules` can optionally contain additional validation functions to call against entries
     * in the file within the matched column.
     *
     * @param \League\Csv\Reader $reader
     * @param array $pattern
     * @return array
     */
    protected function matchFileHeader(Reader $reader, $pattern)
    {
        $headers = collect($reader->getHeader());
        $records = $reader->fetchOne();

        $results = array();

        foreach ($pattern as $key => $rules) {
            $rules = collect($rules);

            $matches = $headers->filter(function ($value) use (&$rules, &$records) {
                $regex = $rules->shift();

                return preg_match($value, $regex, $matches)
                    && $regex === $value
                    && $this->testAgainstFunctions($records[$value], $rules);
            });

            $results[$key] = $matches->count() === 1 ? $matches[0] : false;
        }

        return [
            'matches' => $results,
            'columns' => $headers,
            'sample' => $records
        ];
    }

    /**
     * Test a specified value against an array of functions.
     *
     * @param $value
     * @param array $functions
     * @return bool
     */
    protected function testAgainstFunctions($value, $functions)
    {
        $return = true;

        foreach ($functions as $function) {
            $return &= $function($value);
        }

        return $return;
    }

    /**
     * Dispatch job for payment import.
     *
     * @param string|\SplFileObject $file
     * @param array $definition
     */
    protected function dispatchJob($file, $definition)
    {
        if (is_string($file)) {
            $file = new SplFileObject($file);
        }

        $this->dispatch(new ImportPaymentFromFile($file, $definition));
    }

    /**
     * Store the file and queue for its processing.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all());

        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()
                ->json([
                    'success' => false,
                    'file' => null
                ], 400);
        }

        $reader = Reader::createFromFileObject($file);
        $matches = $this->matchFileHeader($reader, [
            'date' => ['/^.*[Dd]ate.*$/', 'strtotime'],
            'amount' => ['/^.*(([Aa]mount.*)|([Pp]ayment(.*[Mm]ade)?)|([Pp]aid)|([Bb]alance))$/', 'is_numeric'],
            'reference' => '/^.*(([Rr]ef(erence)?)|([Dd]escription)).*$/'
        ]);

        if (collect($matches['matches'])->contains(false)) {
            return response()
                ->json([
                    'sucess' => false,
                    'upload' => true,
                    'file' => [
                        'name' => $file->getRealPath(),
                        'matches' => $matches['matches'],
                        'columns' => $matches['columns'],
                        'sample' => $matches['sample']
                    ]
                ], 400);
        }

        $this->dispatchJob($file, $matches['matches']);

        return response()
            ->json([
                'success' => true
            ]);
    }
}
