<?php

use Illuminate\Database\Seeder;
Use App\TimeZone;
use Carbon\Carbon;

class TimeZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TimeZone::truncate();

        $data = [
            [
                'time_zone' => 'Africa/Cairo',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Africa/Casablanca',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Africa/Harare',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Africa/Monrovia',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Africa/Nairobi',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Africa/Tripoli',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Africa/Windhoek',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Araguaina',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Asuncion',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Bogota',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Buenos_Aires',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Caracas',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Chihuahua',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Cuiaba',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Denver',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Fortaleza',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Guatemala',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Halifax',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Manaus',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Matamoros',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Monterrey',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Montevideo',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Phoenix',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Santiago',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'America/Tijuana',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Amman',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Ashgabat',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Baghdad',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Baku',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Bangkok',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Beirut',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Calcutta',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Damascus',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Dhaka',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Irkutsk',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Jerusalem',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Kabul',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Karachi',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Kathmandu',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Kolkata',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Krasnoyarsk',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Magadan',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Muscat',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Novosibirsk',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Riyadh',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Seoul',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Shanghai',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Singapore',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Taipei',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Tehran',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Tokyo',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Ulaanbaatar',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Vladivostok',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Yakutsk',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Asia/Yerevan',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Atlantic/Azores',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Australia/Adelaide',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Australia/Brisbane',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Australia/Darwin',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Australia/Hobart',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Australia/Perth',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Australia/Sydney',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Brazil/East',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Canada/Newfoundland',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Canada/Saskatchewan',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Canada/Yukon',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Amsterdam',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Athens',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Dublin',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Helsinki',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Istanbul',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Kaliningrad',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Moscow',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Paris',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Prague',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Europe/Sarajevo',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Pacific/Auckland',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Pacific/Fiji',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Pacific/Guam',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Pacific/Honolulu',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'Pacific/Samoa',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'US/Alaska',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'US/Central',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'US/Eastern',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'US/East-Indiana',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'US/Pacific',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [
                'time_zone' => 'UTC',
                'user_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
        ];
        TimeZone::insert($data);

    }
}
