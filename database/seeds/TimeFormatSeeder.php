<?php

use Illuminate\Database\Seeder;
Use App\TimeFormat;
use Carbon\Carbon;

class TimeFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TimeFormat::truncate();

        $data = [
            [
                'hours' => '13',
                'hours_format' => '01',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '14',
                'hours_format' => '02',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '15',
                'hours_format' => '03',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '16',
                'hours_format' => '04',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '17',
                'hours_format' => '05',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '18',
                'hours_format' => '06',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '19',
                'hours_format' => '07',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '20',
                'hours_format' => '08',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '21',
                'hours_format' => '09',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '22',
                'hours_format' => '10',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '23',
                'hours_format' => '11',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'hours' => '24',
                'hours_format' => '12',
                'format' => 'PM',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
        ];

        TimeFormat::insert($data);

    }
}
