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

        Timezone::create( [
            'id'=>1,
            'time_zone'=>'Africa/Cairo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'EG',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>2,
            'time_zone'=>'Africa/Casablanca',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MA',
            'utc_difference'=>'+01:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>3,
            'time_zone'=>'Africa/Harare',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ZW',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>4,
            'time_zone'=>'Africa/Monrovia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'LR',
            'utc_difference'=>'+00:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>5,
            'time_zone'=>'Africa/Nairobi',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'KE',
            'utc_difference'=>'+03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>6,
            'time_zone'=>'Africa/Tripoli',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'LY',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>7,
            'time_zone'=>'Africa/Windhoek',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'NA',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>8,
            'time_zone'=>'America/Araguaina',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BR',
            'utc_difference'=>'-03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>9,
            'time_zone'=>'America/Asuncion',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'PY',
            'utc_difference'=>'-04:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>10,
            'time_zone'=>'America/Bogota',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CO',
            'utc_difference'=>'-05:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>11,
            'time_zone'=>'America/Buenos_Aires',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AR',
            'utc_difference'=>'-03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>12,
            'time_zone'=>'America/Caracas',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'VE',
            'utc_difference'=>'-04:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>13,
            'time_zone'=>'America/Chihuahua',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MX',
            'utc_difference'=>'-07:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>14,
            'time_zone'=>'America/Cuiaba',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BR',
            'utc_difference'=>'-04:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>15,
            'time_zone'=>'America/Denver',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'US',
            'utc_difference'=>'-07:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>16,
            'time_zone'=>'America/Fortaleza',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BR',
            'utc_difference'=>'-03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>17,
            'time_zone'=>'America/Guatemala',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GT',
            'utc_difference'=>'-06:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>18,
            'time_zone'=>'America/Halifax',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CA',
            'utc_difference'=>'-04:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>19,
            'time_zone'=>'America/Manaus',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BR',
            'utc_difference'=>'-04:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>20,
            'time_zone'=>'America/Matamoros',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MX',
            'utc_difference'=>'-06:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>21,
            'time_zone'=>'America/Monterrey',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MX',
            'utc_difference'=>'-06:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>22,
            'time_zone'=>'America/Montevideo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'UY',
            'utc_difference'=>'-03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>23,
            'time_zone'=>'America/Phoenix',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'US',
            'utc_difference'=>'-07:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>24,
            'time_zone'=>'America/Santiago',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CL',
            'utc_difference'=>'-03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>25,
            'time_zone'=>'America/Tijuana',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MX',
            'utc_difference'=>'-08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>26,
            'time_zone'=>'Asia/Amman',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'JO',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>27,
            'time_zone'=>'Asia/Ashgabat',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'TM',
            'utc_difference'=>'+05:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>28,
            'time_zone'=>'Asia/Baghdad',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'IQ',
            'utc_difference'=>'+03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>29,
            'time_zone'=>'Asia/Baku',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AZ',
            'utc_difference'=>'+04:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>30,
            'time_zone'=>'Asia/Bangkok',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'TH',
            'utc_difference'=>'+07:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>31,
            'time_zone'=>'Asia/Beirut',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'LB',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>32,
            'time_zone'=>'Asia/Calcutta',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'IN',
            'utc_difference'=>'+05:30'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>33,
            'time_zone'=>'Asia/Damascus',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SY',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>34,
            'time_zone'=>'Asia/Dhaka',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BD',
            'utc_difference'=>'+06:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>35,
            'time_zone'=>'Asia/Irkutsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RU',
            'utc_difference'=>'+08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>36,
            'time_zone'=>'Asia/Jerusalem',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'IL',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>37,
            'time_zone'=>'Asia/Kabul',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AF',
            'utc_difference'=>'+04:30'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>38,
            'time_zone'=>'Asia/Karachi',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'PK',
            'utc_difference'=>'+05:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>39,
            'time_zone'=>'Asia/Kathmandu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'NP',
            'utc_difference'=>'+05:45'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>40,
            'time_zone'=>'Asia/Kolkata',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'IN',
            'utc_difference'=>'+05:30'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>41,
            'time_zone'=>'Asia/Krasnoyarsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RU',
            'utc_difference'=>'+07:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>42,
            'time_zone'=>'Asia/Magadan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RU',
            'utc_difference'=>'+11:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>43,
            'time_zone'=>'Asia/Muscat',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'OM',
            'utc_difference'=>'+04:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>44,
            'time_zone'=>'Asia/Novosibirsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RU',
            'utc_difference'=>'+07:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>45,
            'time_zone'=>'Asia/Riyadh',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SA',
            'utc_difference'=>'+03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>46,
            'time_zone'=>'Asia/Seoul',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'KR',
            'utc_difference'=>'+09:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>47,
            'time_zone'=>'Asia/Shanghai',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CN',
            'utc_difference'=>'+08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>48,
            'time_zone'=>'Asia/Singapore',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SG',
            'utc_difference'=>'+08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>49,
            'time_zone'=>'Asia/Taipei',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'TW',
            'utc_difference'=>'+08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>50,
            'time_zone'=>'Asia/Tehran',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'IR',
            'utc_difference'=>'+03:30'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>51,
            'time_zone'=>'Asia/Tokyo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'JP',
            'utc_difference'=>'+09:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>52,
            'time_zone'=>'Asia/Ulaanbaatar',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MN',
            'utc_difference'=>'+08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>53,
            'time_zone'=>'Asia/Vladivostok',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RU',
            'utc_difference'=>'+10:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>54,
            'time_zone'=>'Asia/Yakutsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RU',
            'utc_difference'=>'+09:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>55,
            'time_zone'=>'Asia/Yerevan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AM',
            'utc_difference'=>'+04:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>56,
            'time_zone'=>'Atlantic/Azores',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'PT',
            'utc_difference'=>'-01:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>57,
            'time_zone'=>'Australia/Adelaide',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AU',
            'utc_difference'=>'+10:30'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>58,
            'time_zone'=>'Australia/Brisbane',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AU',
            'utc_difference'=>'+10:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>59,
            'time_zone'=>'Australia/Darwin',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AU',
            'utc_difference'=>'+09:30'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>60,
            'time_zone'=>'Australia/Hobart',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AU',
            'utc_difference'=>'+11:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>61,
            'time_zone'=>'Australia/Perth',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AU',
            'utc_difference'=>'+08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>62,
            'time_zone'=>'Australia/Sydney',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AU',
            'utc_difference'=>'+11:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>63,
            'time_zone'=>'Brazil/East',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BR',
            'utc_difference'=>'-03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>64,
            'time_zone'=>'Canada/Newfoundland',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CA',
            'utc_difference'=>'-03:30'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>65,
            'time_zone'=>'Canada/Saskatchewan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CA',
            'utc_difference'=>'-06:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>66,
            'time_zone'=>'Canada/Yukon',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CA',
            'utc_difference'=>'-08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>67,
            'time_zone'=>'Europe/Amsterdam',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'NL',
            'utc_difference'=>'+01:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>68,
            'time_zone'=>'Europe/Athens',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GR',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>69,
            'time_zone'=>'Europe/Dublin',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'IE',
            'utc_difference'=>'+00:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>70,
            'time_zone'=>'Europe/Helsinki',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'FI',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>71,
            'time_zone'=>'Europe/Istanbul',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'TR',
            'utc_difference'=>'+03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>72,
            'time_zone'=>'Europe/Kaliningrad',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RU',
            'utc_difference'=>'+02:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>73,
            'time_zone'=>'Europe/Moscow',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RU',
            'utc_difference'=>'+03:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>74,
            'time_zone'=>'Europe/Paris',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'FR',
            'utc_difference'=>'+01:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>75,
            'time_zone'=>'Europe/Prague',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CZ',
            'utc_difference'=>'+01:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>76,
            'time_zone'=>'Europe/Sarajevo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BA',
            'utc_difference'=>'+01:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>77,
            'time_zone'=>'Pacific/Auckland',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'NZ',
            'utc_difference'=>'+13:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>78,
            'time_zone'=>'Pacific/Fiji',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'FJ',
            'utc_difference'=>'+13:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>79,
            'time_zone'=>'Pacific/Guam',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GU',
            'utc_difference'=>'+10:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>80,
            'time_zone'=>'Pacific/Honolulu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'US',
            'utc_difference'=>'-10:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>81,
            'time_zone'=>'Pacific/Samoa',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'WS',
            'utc_difference'=>'-11:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>82,
            'time_zone'=>'US/Alaska',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'US',
            'utc_difference'=>'-09:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>83,
            'time_zone'=>'US/Central',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'US',
            'utc_difference'=>'-06:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>84,
            'time_zone'=>'US/Eastern',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'US',
            'utc_difference'=>'-05:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>85,
            'time_zone'=>'US/East-Indiana',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'US',
            'utc_difference'=>'-05:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>86,
            'time_zone'=>'US/Pacific',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'US',
            'utc_difference'=>'-08:00'
            ] );
            
            
                        
            Timezone::create( [
            'id'=>87,
            'time_zone'=>'UTC',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'UTC',
            'utc_difference'=>'+00:00'
            ] );
            
            
    }
}
