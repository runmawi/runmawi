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

            // 'id'=>1,
            'time_zone'=>'Africa/Abidjan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CI',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>2,
            'time_zone'=>'Africa/Accra',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GH',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>3,
            'time_zone'=>'Africa/Addis_Ababa',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ET',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>4,
            'time_zone'=>'Africa/Algiers',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'DZ',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>5,
            'time_zone'=>'Africa/Asmara',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ER',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>6,
            'time_zone'=>'Africa/Asmera',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>7,
            'time_zone'=>'Africa/Bamako',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ML',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>8,
            'time_zone'=>'Africa/Bangui',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CF',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>9,
            'time_zone'=>'Africa/Banjul',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GM',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>10,
            'time_zone'=>'Africa/Bissau',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GW',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>11,
            'time_zone'=>'Africa/Blantyre',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MW',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>12,
            'time_zone'=>'Africa/Brazzaville',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CG',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>13,
            'time_zone'=>'Africa/Bujumbura',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BI',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>14,
            'time_zone'=>'Africa/Cairo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'EG',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>15,
            'time_zone'=>'Africa/Casablanca',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MA',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>16,
            'time_zone'=>'Africa/Ceuta',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ES',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>17,
            'time_zone'=>'Africa/Conakry',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GN',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>18,
            'time_zone'=>'Africa/Dakar',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SN',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>19,
            'time_zone'=>'Africa/Dar_es_Salaam',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'TZ',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>20,
            'time_zone'=>'Africa/Djibouti',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'DJ',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>21,
            'time_zone'=>'Africa/Douala',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CM',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>22,
            'time_zone'=>'Africa/El_Aaiun',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'EH',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>23,
            'time_zone'=>'Africa/Freetown',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SL',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>24,
            'time_zone'=>'Africa/Gaborone',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BW',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>25,
            'time_zone'=>'Africa/Harare',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ZW',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>26,
            'time_zone'=>'Africa/Johannesburg',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ZA',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>27,
            'time_zone'=>'Africa/Juba',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SS',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>28,
            'time_zone'=>'Africa/Kampala',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'UG',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>29,
            'time_zone'=>'Africa/Khartoum',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SD',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>30,
            'time_zone'=>'Africa/Khartoum',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SD',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>31,
            'time_zone'=>'Africa/Kigali',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'RW',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>32,
            'time_zone'=>'Africa/Kinshasa',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CD',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>33,
            'time_zone'=>'Africa/Lagos',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'NG',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>34,
            'time_zone'=>'Africa/Libreville',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GA',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>35,
            'time_zone'=>'Africa/Lome',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'TG',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>36,
            'time_zone'=>'Africa/Luanda',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'AO',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>37,
            'time_zone'=>'Africa/Lubumbashi',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'CD',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>38,
            'time_zone'=>'Africa/Lusaka',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ZM',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>39,
            'time_zone'=>'Africa/Malabo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'GQ',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>40,
            'time_zone'=>'Africa/Maputo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MZ',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>41,
            'time_zone'=>'Africa/Maseru',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'LS',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>42,
            'time_zone'=>'Africa/Mbabane',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SZ',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>43,
            'time_zone'=>'Africa/Mogadishu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'SO',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>44,
            'time_zone'=>'Africa/Monrovia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'LR',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>45,
            'time_zone'=>'Africa/Nairobi',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'KE',
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>46,
            'time_zone'=>'Africa/Ndjamena',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'TD',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>47,
            'time_zone'=>'Africa/Niamey',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'NE',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>48,
            'time_zone'=>'Africa/Nouakchott',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'MR',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>49,
            'time_zone'=>'Africa/Ouagadougou',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BF',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>50,
            'time_zone'=>'Africa/Porto-Novo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'BJ',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>51,
            'time_zone'=>'Africa/Sao_Tome',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'ST',
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>52,
            'time_zone'=>'Africa/Timbuktu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>53,
            'time_zone'=>'Africa/Tripoli',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'LY',
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>54,
            'time_zone'=>'Africa/Tunis',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'TN',
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>55,
            'time_zone'=>'Africa/Windhoek',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>'NA',
            'utc_difference'=>'+01:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>56,
        //     'time_zone'=>'AKST9AKDT',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>NULL,
        //     'utc_difference'=>'-09:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>57,
            'time_zone'=>'America/Adak',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>58,
            'time_zone'=>'America/Anchorage',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>59,
            'time_zone'=>'America/Anguilla',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AI",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>60,
            'time_zone'=>'America/Araguaina',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>61,
            'time_zone'=>'America/Buenos_Aires',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AR",
            'utc_difference'=>'-03:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>62,
        //     'time_zone'=>'America/ComodRivadavia',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>NULL,
        //     'utc_difference'=>'-03:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>63,
            'time_zone'=>'America/Cordoba',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AR",
            'utc_difference'=>'-03:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>65,
        //     'time_zone'=>'America/La_Rioja',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"AR",
        //     'utc_difference'=>'-03:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>66,
            'time_zone'=>'America/Mendoza',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AR",
            'utc_difference'=>'-03:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>67,
        //     'time_zone'=>'America/Rio_Gallegos',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"AR",
        //     'utc_difference'=>'-03:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>68,
        //     'time_zone'=>'America/Salta',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"AR",
        //     'utc_difference'=>'-03:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>69,
        //     'time_zone'=>'America/San_Juan',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"AR",
        //     'utc_difference'=>'-03:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>70,
        //     'time_zone'=>'America/San_Luis',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"AR",
        //     'utc_difference'=>'-03:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>71,
        //     'time_zone'=>'America/Tucuman',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"AR",
        //     'utc_difference'=>'-03:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>72,
        //     'time_zone'=>'America/Ushuaia',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"AR",
        //     'utc_difference'=>'-03:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>73,
            'time_zone'=>'America/Aruba',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AW",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>74,
            'time_zone'=>'America/Asuncion',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PY",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>75,
            'time_zone'=>'America/Atikokan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>76,
            'time_zone'=>'America/Atka',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>77,
            'time_zone'=>'America/Bahia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>78,
            'time_zone'=>'America/Bahia_Banderas',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>79,
            'time_zone'=>'America/Barbados',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BB",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>80,
            'time_zone'=>'America/Belem',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>81,
            'time_zone'=>'America/Belize',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BZ",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>82,
            'time_zone'=>'America/Blanc-Sablon',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>83,
            'time_zone'=>'America/Boa_Vista',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>84,
            'time_zone'=>'America/Bogota',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CO",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>85,
            'time_zone'=>'America/Boise',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>86,
            'time_zone'=>'America/Buenos_Aires',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>87,
            'time_zone'=>'America/Cambridge_Bay',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>88,
            'time_zone'=>'America/Campo_Grande',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>89,
            'time_zone'=>'America/Cancun',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>90,
            'time_zone'=>'America/Caracas',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"VE",
            'utc_difference'=>'-04:30',
        ] );
            
        Timezone::create( [

            // 'id'=>91,
            'time_zone'=>'America/Catamarca',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>92,
            'time_zone'=>'America/Cayenne',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GF",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>93,
            'time_zone'=>'America/Cayman',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KY",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>94,
            'time_zone'=>'America/Chicago',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>95,
            'time_zone'=>'America/Chihuahua',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>96,
            'time_zone'=>'America/Coral_Harbour',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>97,
            'time_zone'=>'America/Cordoba',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>98,
            'time_zone'=>'America/Costa_Rica',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CR",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>99,
            'time_zone'=>'America/Creston',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>100,
            'time_zone'=>'America/Cuiaba',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>101,
            'time_zone'=>'America/Curacao',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CW",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>102,
            'time_zone'=>'America/Danmarkshavn',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GL",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>103,
            'time_zone'=>'America/Dawson',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>104,
            'time_zone'=>'America/Dawson_Creek',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>105,
            'time_zone'=>'America/Denver',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>106,
            'time_zone'=>'America/Detroit',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>107,
            'time_zone'=>'America/Dominica',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"DM",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>108,
            'time_zone'=>'America/Edmonton',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>109,
            'time_zone'=>'America/Eirunepe',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>110,
            'time_zone'=>'America/El_Salvador',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SV",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>111,
            'time_zone'=>'America/Ensenada',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>112,
            'time_zone'=>'America/Fort_Wayne',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>113,
            'time_zone'=>'America/Fortaleza',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>114,
            'time_zone'=>'America/Glace_Bay',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>115,
            'time_zone'=>'America/Godthab',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GL",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>116,
            'time_zone'=>'America/Goose_Bay',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>117,
            'time_zone'=>'America/Grand_Turk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TC",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>118,
            'time_zone'=>'America/Grenada',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GD",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>119,
            'time_zone'=>'America/Guadeloupe',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GP",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>120,
            'time_zone'=>'America/Guatemala',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GT",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>121,
            'time_zone'=>'America/Guayaquil',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"EC",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>122,
            'time_zone'=>'America/Guyana',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GY",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>123,
            'time_zone'=>'America/Halifax',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>124,
            'time_zone'=>'America/Havana',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CU",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>125,
            'time_zone'=>'America/Hermosillo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-07:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>126,
        //     'time_zone'=>'America/Indiana',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-05:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>127,
        //     'time_zone'=>'America/Knox',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-06:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>128,
        //     'time_zone'=>'America/Marengo',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-05:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>129,
        //     'time_zone'=>'America/Petersburg',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-05:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>130,
        //     'time_zone'=>'America/Tell_City',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-06:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>131,
        //     'time_zone'=>'America/Vevay',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-05:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>132,
        //     'time_zone'=>'America/Vincennes',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-05:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>133,
        //     'time_zone'=>'America/Winamac',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-05:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>134,
            'time_zone'=>'America/Indianapolis',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>135,
            'time_zone'=>'America/Inuvik',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>136,
            'time_zone'=>'America/Iqaluit',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>137,
            'time_zone'=>'America/Jamaica',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"JM",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>138,
            'time_zone'=>'America/Jujuy',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>139,
            'time_zone'=>'America/Juneau',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-09:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>140,
        //     'time_zone'=>'America/Argentina',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-05:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>141,
        //     'time_zone'=>'America/Kentucky',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-05:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>142,
            'time_zone'=>'America/Knox_IN',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>143142,
            'time_zone'=>'America/Kralendijk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BQ",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>144,
            'time_zone'=>'America/La_Paz',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BO",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>145,
            'time_zone'=>'America/Lima',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PE",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>146,
            'time_zone'=>'America/Los_Angeles',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>147,
            'time_zone'=>'America/Louisville',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>148,
            'time_zone'=>'America/Lower_Princes',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SX",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>149,
            'time_zone'=>'America/Maceio',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>150,
            'time_zone'=>'America/Managua',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NI",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>151,
            'time_zone'=>'America/Manaus',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>152,
            'time_zone'=>'America/Marigot',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MF",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>153,
            'time_zone'=>'America/Martinique',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MQ",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>154,
            'time_zone'=>'America/Matamoros',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>155,
            'time_zone'=>'America/Mazatlan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>156,
            'time_zone'=>'America/Mendoza',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>157,
            'time_zone'=>'America/Menominee',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>158,
            'time_zone'=>'America/Merida',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>159,
            'time_zone'=>'America/Metlakatla',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>160,
            'time_zone'=>'America/Mexico_City',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>161,
            'time_zone'=>'America/Miquelon',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PM",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>162,
            'time_zone'=>'America/Moncton',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>163,
            'time_zone'=>'America/Monterrey',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>164,
            'time_zone'=>'America/Montevideo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UY",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>165,
            'time_zone'=>'America/Montreal',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>166,
            'time_zone'=>'America/Montserrat',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MS",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>167,
            'time_zone'=>'America/Nassau',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BS",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>168,
            'time_zone'=>'America/New_York',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>169,
            'time_zone'=>'America/Nipigon',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>170,
            'time_zone'=>'America/Nome',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>171,
            'time_zone'=>'America/Noronha',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-02:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>172,
        //     'time_zone'=>'America/North_Dakota',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-06:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>173,
        //     'time_zone'=>'America/Center',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-06:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>174,
        //     'time_zone'=>'America/New_Salem',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"US",
        //     'utc_difference'=>'-06:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>175,
            'time_zone'=>'America/Ojinaga',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>176,
            'time_zone'=>'America/Panama',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PA",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>177,
            'time_zone'=>'America/Pangnirtung',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>178,
            'time_zone'=>'America/Paramaribo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>179,
            'time_zone'=>'America/Phoenix',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>180,
            'time_zone'=>'America/Port_of_Spain',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TT",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>181,
            'time_zone'=>'America/Port_of_Spain',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TT",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>182,
            'time_zone'=>'America/Port-au-Prince',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"HT",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>183,
            'time_zone'=>'America/Porto_Acre',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>184,
            'time_zone'=>'America/Porto_Velho',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>185,
            'time_zone'=>'America/Puerto_Rico',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PR",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>186,
            'time_zone'=>'America/Rainy_River',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>187,
            'time_zone'=>'America/Rankin_Inlet',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>188,
            'time_zone'=>'America/Recife',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>189,
            'time_zone'=>'America/Regina',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>190,
            'time_zone'=>'America/Resolute',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>191,
            'time_zone'=>'America/Rio_Branco',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>192,
            'time_zone'=>'America/Rosario',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>193,
            'time_zone'=>'America/Santa_Isabel',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>194,
            'time_zone'=>'America/Santarem',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>195,
            'time_zone'=>'America/Santiago',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CL",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>196,
            'time_zone'=>'America/Santo_Domingo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"DO",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>197,
            'time_zone'=>'America/Sao_Paulo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BR",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>198,
            'time_zone'=>'America/Scoresbysund',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GL",
            'utc_difference'=>'-01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>199,
            'time_zone'=>'America/Shiprock',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>200,
            'time_zone'=>'America/Sitka',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>201,
            'time_zone'=>'America/St_Barthelemy',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BL",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>202,
            'time_zone'=>'America/St_Johns',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>203,
            'time_zone'=>'America/St_Kitts',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KN",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>204,
            'time_zone'=>'America/St_Lucia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"LC",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>205,
            'time_zone'=>'America/St_Thomas',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"VI",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>206,
            'time_zone'=>'America/St_Vincent',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"VC",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>207,
            'time_zone'=>'America/Swift_Current',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>208,
            'time_zone'=>'America/Tegucigalpa',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"HN",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>209,
            'time_zone'=>'America/Thule',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GL",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>210,
            'time_zone'=>'America/Thunder_Bay',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>211,
            'time_zone'=>'America/Tijuana',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MX",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>212,
            'time_zone'=>'America/Toronto',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>213,
            'time_zone'=>'America/Tortola',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"VG",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>214,
            'time_zone'=>'America/Vancouver',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>215,
            'time_zone'=>'America/Virgin',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>216,
            'time_zone'=>'America/Whitehorse',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>217,
            'time_zone'=>'America/Winnipeg',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>218,
            'time_zone'=>'America/Yakutat',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>219,
            'time_zone'=>'America/Yellowknife',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CA",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>220,
            'time_zone'=>'Antarctica/Casey',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>221,
            'time_zone'=>'Antarctica/Davis',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>222,
            'time_zone'=>'Antarctica/DumontDUrville',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>223,
            'time_zone'=>'Antarctica/Macquarie',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>224,
            'time_zone'=>'Antarctica/Mawson',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>225,
            'time_zone'=>'Antarctica/McMurdo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>226,
            'time_zone'=>'Antarctica/Palmer',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>227,
            'time_zone'=>'Antarctica/Rothera',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>228,
            'time_zone'=>'Antarctica/South_Pole',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>229,
            'time_zone'=>'Antarctica/South_Pole',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>230,
            'time_zone'=>'Antarctica/Vostok',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AQ",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>231,
            'time_zone'=>'Arctic/Longyearbyen',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SJ",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>232,
            'time_zone'=>'Asia/Aden',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"YE",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>233,
            'time_zone'=>'Asia/Almaty',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KZ",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>234,
            'time_zone'=>'Asia/Amman',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"JO",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>235,
            'time_zone'=>'Asia/Anadyr',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>236,
            'time_zone'=>'Asia/Aqtau',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KZ",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>237,
            'time_zone'=>'Asia/Aqtobe',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KZ",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>238,
            'time_zone'=>'Asia/Ashgabat',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TM",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>239,
            'time_zone'=>'Asia/Ashkhabad',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>240,
            'time_zone'=>'Asia/Baghdad',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IQ",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>241,
            'time_zone'=>'Asia/Bahrain',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BH",
            'utc_difference'=>'+03:00',
        ] );
            
        

        Timezone::create( [

            // 'id'=>242,
            'time_zone'=>'Asia/Baku',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AZ",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>243,
            'time_zone'=>'Asia/Bangkok',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TH",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>244,
            'time_zone'=>'Asia/Beirut',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"LB",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>245,
            'time_zone'=>'Asia/Bishkek',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KG",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>246,
            'time_zone'=>'Asia/Brunei',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BN",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>247,
            'time_zone'=>'Asia/Calcutta',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'+05:30',
        ] );
            
        Timezone::create( [

            // 'id'=>248,
            'time_zone'=>'Asia/Choibalsan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MN",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>249,
            'time_zone'=>'Asia/Chongqing',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CN",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>250,
            'time_zone'=>'Asia/Chungking',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>251,
            'time_zone'=>'Asia/Colombo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"LK",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>252,
            'time_zone'=>'Asia/Dacca',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>NULL,
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>253,
            'time_zone'=>'Asia/Damascus',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SY",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>254,
            'time_zone'=>'Asia/Dhaka',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BD",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>255,
            'time_zone'=>'Asia/Dili',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TL",
            'utc_difference'=>'+09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>256,
            'time_zone'=>'Asia/Dubai',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AE",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>257,
            'time_zone'=>'Asia/Dushanbe',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"Dushanbe",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>258,
            'time_zone'=>'Asia/Gaza',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PS",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>259,
            'time_zone'=>'Asia/Harbin',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CN",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>260,
            'time_zone'=>'Asia/Hebron',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PS",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>261,
            'time_zone'=>'Asia/Ho_Chi_Minh',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"VN",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>262,
            'time_zone'=>'Asia/Hong_Kong',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"HK",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>263,
            'time_zone'=>'Asia/Hovd',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MN",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>264,
            'time_zone'=>'Asia/Irkutsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>265,
            'time_zone'=>'Asia/Istanbul',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>266,
            'time_zone'=>'Asia/Jakarta',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"ID",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>267,
            'time_zone'=>'Asia/Jayapura',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"ID",
            'utc_difference'=>'+09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>268,
            'time_zone'=>'Asia/Jerusalem',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IL",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>269,
            'time_zone'=>'Asia/Kabul',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AF",
            'utc_difference'=>'+04:30',
        ] );
            
        Timezone::create( [

            // 'id'=>270268,
            'time_zone'=>'Asia/Kamchatka',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>271269,
            'time_zone'=>'Asia/Karachi',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PK",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>272,
            'time_zone'=>'Asia/Kashgar',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CN",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>273,
            'time_zone'=>'Asia/Kathmandu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NP",
            'utc_difference'=>'+05:45',
        ] );
            
        Timezone::create( [

            // 'id'=>274,
            'time_zone'=>'Asia/Katmandu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+05:45',
        ] );
            
        Timezone::create( [

            // 'id'=>275,
            'time_zone'=>'Asia/Kolkata',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IN",
            'utc_difference'=>'+05:30',
        ] );
            
        Timezone::create( [

            // 'id'=>276,
            'time_zone'=>'Asia/Krasnoyarsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>277,
            'time_zone'=>'Asia/Kuala_Lumpur',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MY",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>278,
            'time_zone'=>'Asia/Kuching',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MY",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>279,
            'time_zone'=>'Asia/Kuwait',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KW",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>280,
            'time_zone'=>'Asia/Macao',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>281,
            'time_zone'=>'Asia/Macau',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MO",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>282,
            'time_zone'=>'Asia/Magadan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>283,
            'time_zone'=>'Asia/Makassar',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"ID",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>284,
            'time_zone'=>'Asia/Manila',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PH",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>285,
            'time_zone'=>'Asia/Muscat',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"OM",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>286,
            'time_zone'=>'Asia/Nicosia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CY",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>287,
            'time_zone'=>'Asia/Novokuznetsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>288,
            'time_zone'=>'Asia/Novosibirsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>289,
            'time_zone'=>'Asia/Omsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>290,
            'time_zone'=>'Asia/Oral',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KZ",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>291,
            'time_zone'=>'Asia/Phnom_Penh',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KH",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>292,
            'time_zone'=>'Asia/Pontianak',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"ID",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>293,
            'time_zone'=>'Asia/Pyongyang',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KP",
            'utc_difference'=>'+09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>294,
            'time_zone'=>'Asia/Qatar',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"QA",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>295,
            'time_zone'=>'Asia/Qyzylorda',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KZ",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>296,
            'time_zone'=>'Asia/Rangoon',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MM",
            'utc_difference'=>'+06:30',
        ] );
            
        Timezone::create( [

            // 'id'=>297,
            'time_zone'=>'Asia/Riyadh',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SA",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>298,
            'time_zone'=>'Asia/Saigon',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>299,
            'time_zone'=>'Asia/Sakhalin',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>300,
            'time_zone'=>'Asia/Samarkand',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UZ",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>301,
            'time_zone'=>'Asia/Seoul',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KR",
            'utc_difference'=>'+09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>302,
            'time_zone'=>'Asia/Shanghai',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CN",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>303,
            'time_zone'=>'Asia/Singapore',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SG",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>304,
            'time_zone'=>'Asia/Taipei',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TW",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>305,
            'time_zone'=>'Asia/Tashkent',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UZ",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>306,
            'time_zone'=>'Asia/Tbilisi',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GE",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>307,
            'time_zone'=>'Asia/Tehran',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IR",
            'utc_difference'=>'+03:30',
        ] );
            
        Timezone::create( [

            // 'id'=>308,
            'time_zone'=>'Asia/Tel_Aviv',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>309,
            'time_zone'=>'Asia/Thimbu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>310,
            'time_zone'=>'Asia/Thimphu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BT",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>311,
            'time_zone'=>'Asia/Tokyo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"JP",
            'utc_difference'=>'+09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>312,
            'time_zone'=>'Asia/Ujung_Pandang',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>313,
            'time_zone'=>'Asia/Ulaanbaatar',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MN",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>314,
            'time_zone'=>'Asia/Ulan_Bator',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>315,
            'time_zone'=>'Asia/Urumqi',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CN",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>316,
            'time_zone'=>'Asia/Vientiane',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"LA",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>317,
            'time_zone'=>'Asia/Vladivostok',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>318,
            'time_zone'=>'Asia/Yakutsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>319,
            'time_zone'=>'Asia/Yekaterinburg',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>320,
            'time_zone'=>'Asia/Yerevan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AM",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>321,
            'time_zone'=>'Atlantic/Azores',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PT",
            'utc_difference'=>'-01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>322,
            'time_zone'=>'Atlantic/Bermuda',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BM",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>323,
            'time_zone'=>'Atlantic/Canary',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"ES",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>324,
            'time_zone'=>'Atlantic/Cape_Verde',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CV",
            'utc_difference'=>'-01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>325,
            'time_zone'=>'Atlantic/Faeroe',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>326,
            'time_zone'=>'Atlantic/Faroe',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"FO",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>327,
            'time_zone'=>'Atlantic/Jan_Mayen',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>328,
            'time_zone'=>'Atlantic/Madeira',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PT",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>329,
            'time_zone'=>'Atlantic/Reykjavik',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IS",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>330,
            'time_zone'=>'Atlantic/South_Georgia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GS",
            'utc_difference'=>'-02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>331,
            'time_zone'=>'Atlantic/St_Helena',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SH",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>332,
            'time_zone'=>'Atlantic/Stanley',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"FK",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>333,
            'time_zone'=>'Australia/ACT',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>334,
            'time_zone'=>'Australia/Adelaide',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+09:30',
        ] );
            
        Timezone::create( [

            // 'id'=>335,
            'time_zone'=>'Australia/Brisbane',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>336,
            'time_zone'=>'Australia/Broken_Hill',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+09:30',
        ] );
            
        Timezone::create( [

            // 'id'=>337,
            'time_zone'=>'Australia/Canberra',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>338,
            'time_zone'=>'Australia/Currie',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>339,
            'time_zone'=>'Australia/Darwin',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+09:30',
        ] );
            
        Timezone::create( [

            // 'id'=>340,
            'time_zone'=>'Australia/Eucla',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+08:45',
        ] );
            
        Timezone::create( [

            // 'id'=>341,
            'time_zone'=>'Australia/Hobart',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>342,
            'time_zone'=>'Australia/LHI',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:30',
        ] );
            
        Timezone::create( [

            // 'id'=>343,
            'time_zone'=>'Australia/Lindeman',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>344,
            'time_zone'=>'Australia/Lord_Howe',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+10:30',
        ] );
            
        Timezone::create( [

            // 'id'=>345,
            'time_zone'=>'Australia/Melbourne',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>346,
            'time_zone'=>'Australia/North',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+09:30',
        ] );
            
        Timezone::create( [

            // 'id'=>347,
            'time_zone'=>'Australia/NSW',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>348,
            'time_zone'=>'Australia/Perth',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>349,
            'time_zone'=>'Australia/Queensland',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>350,
            'time_zone'=>'Australia/South',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+09:30',
        ] );
            
        Timezone::create( [

            // 'id'=>351,
            'time_zone'=>'Australia/Sydney',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AU",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>352,
            'time_zone'=>'Australia/Tasmania',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>353,
            'time_zone'=>'Australia/Victoria',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>354,
            'time_zone'=>'Australia/West',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>355,
            'time_zone'=>'Australia/Yancowinna',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+09:30',
        ] );
            
        Timezone::create( [

            // 'id'=>356,
            'time_zone'=>'Brazil/Acre',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>357,
            'time_zone'=>'Brazil/DeNoronha',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>358,
            'time_zone'=>'Brazil/East',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>359,
            'time_zone'=>'Brazil/West',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>360,
            'time_zone'=>'Canada/Atlantic',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>361,
            'time_zone'=>'Canada/Central',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>362,
            'time_zone'=>'Canada/Eastern',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-05:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>363,
        //     'time_zone'=>'Canada/East-Saskatchewan',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'-06:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>364,
            'time_zone'=>'Canada/Mountain',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>365,
            'time_zone'=>'Canada/Newfoundland',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-03:30',
        ] );
            
        Timezone::create( [

            // 'id'=>366,
            'time_zone'=>'Canada/Pacific',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>367,
            'time_zone'=>'Canada/Saskatchewan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>368,
            'time_zone'=>'Canada/Yukon',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>369,
            'time_zone'=>'CET',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>370,
            'time_zone'=>'Chile/Continental',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>371,
            'time_zone'=>'Chile/EasterIsland',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>372,
            'time_zone'=>'CST6CDT',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>373,
            'time_zone'=>'Cuba',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>374,
            'time_zone'=>'EET',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>375,
            'time_zone'=>'Egypt',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>376,
            'time_zone'=>'Eire',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>377,
            'time_zone'=>'EST',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>378,
            'time_zone'=>'EST5EDT',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-05:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>379,
        //     'time_zone'=>'Etc./GMT',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'+00:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>380,
        //     'time_zone'=>'Etc./GMT+0',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'+00:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>381,
        //     'time_zone'=>'Etc./UCT',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'+00:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>382,
        //     'time_zone'=>'Etc./Universal',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'+00:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>383,
        //     'time_zone'=>'Etc./UTC',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'+00:00',
        // ] );
            
        // Timezone::create( [

            // 'id'=>384,
        //     'time_zone'=>'Etc./Zulu',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'+00:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>385,
            'time_zone'=>'Europe/Amsterdam',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NL",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>386,
            'time_zone'=>'Europe/Andorra',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AD",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>387,
            'time_zone'=>'Europe/Athens',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GR",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>388,
            'time_zone'=>'Europe/Belfast',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>389,
            'time_zone'=>'Europe/Belgrade',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RS",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>390,
            'time_zone'=>'Europe/Berlin',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"DE",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>391,
            'time_zone'=>'Europe/Bratislava',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SK",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>392,
            'time_zone'=>'Europe/Brussels',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BE",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>393,
            'time_zone'=>'Europe/Bucharest',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RO",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>394,
            'time_zone'=>'Europe/Budapest',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"HU",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>395,
            'time_zone'=>'Europe/Chisinau',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MD",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>396,
            'time_zone'=>'Europe/Copenhagen',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"DK",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>397,
            'time_zone'=>'Europe/Dublin',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IE",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>398,
            'time_zone'=>'Europe/Gibraltar',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GI",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>399,
            'time_zone'=>'Europe/Guernsey',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GG",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>400,
            'time_zone'=>'Europe/Helsinki',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"FI",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>401,
            'time_zone'=>'Europe/Isle_of_Man',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IM",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>402,
            'time_zone'=>'Europe/Istanbul',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TR",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>403,
            'time_zone'=>'Europe/Jersey',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"JE",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>404,
            'time_zone'=>'Europe/Kaliningrad',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>405,
            'time_zone'=>'Europe/Kiev',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UA",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>406,
            'time_zone'=>'Europe/Lisbon',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PT",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>407,
            'time_zone'=>'Europe/Ljubljana',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SI",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>408,
            'time_zone'=>'Europe/London',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GB",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>409,
            'time_zone'=>'Europe/Luxembourg',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"LU",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>410,
            'time_zone'=>'Europe/Madrid',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"ES",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>411,
            'time_zone'=>'Europe/Malta',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MT",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>412,
            'time_zone'=>'Europe/Mariehamn',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AX",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>413,
            'time_zone'=>'Europe/Minsk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BY",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>414,
            'time_zone'=>'Europe/Monaco',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MC",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>415,
            'time_zone'=>'Europe/Moscow',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>416,
            'time_zone'=>'Europe/Nicosia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>417,
            'time_zone'=>'Europe/Oslo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NO",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>418,
            'time_zone'=>'Europe/Paris',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"FR",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>419,
            'time_zone'=>'Europe/Podgorica',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"ME",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>420,
            'time_zone'=>'Europe/Prague',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CZ",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>421,
            'time_zone'=>'Europe/Riga',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"LV",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>422,
            'time_zone'=>'Europe/Rome',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IT",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>423,
            'time_zone'=>'Europe/Samara',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>424,
            'time_zone'=>'Europe/San_Marino',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SM",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>425,
            'time_zone'=>'Europe/Sarajevo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BA",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>426,
            'time_zone'=>'Europe/Simferopol',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UA",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>427,
            'time_zone'=>'Europe/Skopje',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MK",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>428,
            'time_zone'=>'Europe/Sofia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"BG",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>429,
            'time_zone'=>'Europe/Stockholm',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SE",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>430,
            'time_zone'=>'Europe/Tallinn',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"EE",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>431,
            'time_zone'=>'Europe/Tirane',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AL",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>432,
            'time_zone'=>'Europe/Tiraspol',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>433,
            'time_zone'=>'Europe/Uzhgorod',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UA",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>434,
            'time_zone'=>'Europe/Vaduz',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"LI",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>435,
            'time_zone'=>'Europe/Vatican',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"VA",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>436,
            'time_zone'=>'Europe/Vienna',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AT",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>437,
            'time_zone'=>'Europe/Vilnius',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"LT",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>438,
            'time_zone'=>'Europe/Volgograd',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RU",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>439,
            'time_zone'=>'Europe/Warsaw',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PL",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>440,
            'time_zone'=>'Europe/Zagreb',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"HR",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>441,
            'time_zone'=>'Europe/Zaporozhye',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UA",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>442,
            'time_zone'=>'Europe/Zurich',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CH",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>443,
            'time_zone'=>'GB',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>444,
            'time_zone'=>'GB-Eire',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>445,
            'time_zone'=>'GMT',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>446,
            'time_zone'=>'GMT+0',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>447,
            'time_zone'=>'GMT0',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>448,
            'time_zone'=>'GMT-0',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>449,
            'time_zone'=>'Greenwich',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>450,
        //     'time_zone'=>'Hong Kong',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'+08:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>451,
            'time_zone'=>'HST',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>452,
            'time_zone'=>'Iceland',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>453,
            'time_zone'=>'Indian/Antananarivo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MG",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>454,
            'time_zone'=>'Indian/Chagos',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"IO",
            'utc_difference'=>'+06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>455,
            'time_zone'=>'Indian/Christmas',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CX",
            'utc_difference'=>'+07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>456,
            'time_zone'=>'Indian/Cocos',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CC",
            'utc_difference'=>'+06:30',
        ] );
            
        Timezone::create( [

            // 'id'=>457,
            'time_zone'=>'Indian/Comoro',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KM",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>458,
            'time_zone'=>'Indian/Kerguelen',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TF",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>459,
            'time_zone'=>'Indian/Mahe',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SC",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>460,
            'time_zone'=>'Indian/Maldives',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MV",
            'utc_difference'=>'+05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>461,
            'time_zone'=>'Indian/Mauritius',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MU",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>462,
            'time_zone'=>'Indian/Mayotte',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"YT",
            'utc_difference'=>'+03:00',
        ] );
            
        Timezone::create( [

            // 'id'=>463,
            'time_zone'=>'Indian/Reunion',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"RE",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>464,
            'time_zone'=>'Iran',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+03:30',
        ] );
            
        Timezone::create( [

            // 'id'=>465,
            'time_zone'=>'Israel',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>466,
            'time_zone'=>'Jamaica',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>467,
            'time_zone'=>'Japan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+09:00',
        ] );
            
        // Timezone::create( [

            // 'id'=>468,
        //     'time_zone'=>'JST-9',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'+09:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>469,
            'time_zone'=>'Kwajalein',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>470,
            'time_zone'=>'Libya',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>471,
            'time_zone'=>'MET',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>472,
            'time_zone'=>'Mexico/BajaNorte',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>473,
            'time_zone'=>'Mexico/BajaSur',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>474,
            'time_zone'=>'Mexico/General',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>475,
            'time_zone'=>'MST',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>476,
            'time_zone'=>'MST7MDT',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>477,
            'time_zone'=>'Navajo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>478,
            'time_zone'=>'NZ',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>479,
            'time_zone'=>'NZ-CHAT',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+12:45',
        ] );
            
        Timezone::create( [

            // 'id'=>480,
            'time_zone'=>'Pacific/Apia',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"WS",
            'utc_difference'=>'+13:00',
        ] );
            
        Timezone::create( [

            // 'id'=>481,
            'time_zone'=>'Pacific/Auckland',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NZ",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>482,
            'time_zone'=>'Pacific/Chatham',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NZ",
            'utc_difference'=>'+12:45',
        ] );
            
        Timezone::create( [

            // 'id'=>483,
            'time_zone'=>'Pacific/Chuuk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"FM",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>484,
            'time_zone'=>'Pacific/Easter',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CL",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>485,
            'time_zone'=>'Pacific/Efate',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"VU",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>486,
            'time_zone'=>'Pacific/Enderbury',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KI",
            'utc_difference'=>'+13:00',
        ] );
            
        Timezone::create( [

            // 'id'=>487,
            'time_zone'=>'Pacific/Fakaofo',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TK",
            'utc_difference'=>'+13:00',
        ] );
            
        Timezone::create( [

            // 'id'=>488,
            'time_zone'=>'Pacific/Fiji',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"FJ",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>489,
            'time_zone'=>'Pacific/Funafuti',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TV",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>490,
            'time_zone'=>'Pacific/Galapagos',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"EC",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>491,
            'time_zone'=>'Pacific/Gambier',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PF",
            'utc_difference'=>'-09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>492,
            'time_zone'=>'Pacific/Guadalcanal',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"SB",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>493,
            'time_zone'=>'Pacific/Guam',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"GU",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>494,
            'time_zone'=>'Pacific/Honolulu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"US",
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>495,
            'time_zone'=>'Pacific/Johnston',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UM",
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>496,
            'time_zone'=>'Pacific/Kiritimati',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KI",
            'utc_difference'=>'+14:00',
        ] );
            
        Timezone::create( [

            // 'id'=>497,
            'time_zone'=>'Pacific/Kosrae',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"FM",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>498,
            'time_zone'=>'Pacific/Kwajalein',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MH",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>499,
            'time_zone'=>'Pacific/Majuro',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MH",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>500,
            'time_zone'=>'Pacific/Marquesas',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PF",
            'utc_difference'=>'-09:30',
        ] );
            
        Timezone::create( [

            // 'id'=>501,
            'time_zone'=>'Pacific/Midway',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UM",
            'utc_difference'=>'-11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>502,
            'time_zone'=>'Pacific/Nauru',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NR",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>503,
            'time_zone'=>'Pacific/Niue',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NU",
            'utc_difference'=>'-11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>504,
            'time_zone'=>'Pacific/Norfolk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NF",
            'utc_difference'=>'+11:30',
        ] );
            
        Timezone::create( [

            // 'id'=>505,
            'time_zone'=>'Pacific/Noumea',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"NC",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>506,
            'time_zone'=>'Pacific/Pago_Pago',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"AS",
            'utc_difference'=>'-11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>507,
            'time_zone'=>'Pacific/Palau',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PW",
            'utc_difference'=>'+09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>508,
            'time_zone'=>'Pacific/Pitcairn',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PN",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>509,
            'time_zone'=>'Pacific/Pohnpei',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"FM",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>510,
            'time_zone'=>'Pacific/Ponape',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>511,
            'time_zone'=>'Pacific/Port_Moresby',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PG",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>512,
            'time_zone'=>'Pacific/Rarotonga',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"CK",
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>513,
            'time_zone'=>'Pacific/Saipan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"MP",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>514,
            'time_zone'=>'Pacific/Samoa',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>515,
            'time_zone'=>'Pacific/Tahiti',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"PF",
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>516,
            'time_zone'=>'Pacific/Tarawa',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"KI",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>517,
            'time_zone'=>'Pacific/Tongatapu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"TO",
            'utc_difference'=>'+13:00',
        ] );
            
        Timezone::create( [

            // 'id'=>518,
            'time_zone'=>'Pacific/Truk',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>519,
            'time_zone'=>'Pacific/Wake',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"UM",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>520,
            'time_zone'=>'Pacific/Wallis',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"WF",
            'utc_difference'=>'+12:00',
        ] );
            
        Timezone::create( [

            // 'id'=>521,
            'time_zone'=>'Pacific/Yap',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>522,
            'time_zone'=>'Poland',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+01:00',
        ] );
            
        Timezone::create( [

            // 'id'=>523,
            'time_zone'=>'Portugal',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>524,
            'time_zone'=>'PRC',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>525,
            'time_zone'=>'PST8PDT',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>526,
            'time_zone'=>'ROC',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>527,
            'time_zone'=>'ROK',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>528,
            'time_zone'=>'Singapore',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+08:00',
        ] );
            
        Timezone::create( [

            // 'id'=>529,
            'time_zone'=>'Turkey',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+02:00',
        ] );
            
        Timezone::create( [

            // 'id'=>530,
            'time_zone'=>'UCT',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>531,
            'time_zone'=>'Universal',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>532,
            'time_zone'=>'US/Alaska',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-09:00',
        ] );
            
        Timezone::create( [

            // 'id'=>533,
            'time_zone'=>'US/Aleutian',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>534,
            'time_zone'=>'US/Arizona',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>535,
            'time_zone'=>'US/Central',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>536,
            'time_zone'=>'US/Eastern',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>537,
            'time_zone'=>'US/East-Indiana',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>538,
            'time_zone'=>'US/Hawaii',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-10:00',
        ] );
            
        Timezone::create( [

            // 'id'=>539,
            'time_zone'=>'US/Indiana-Starke',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-06:00',
        ] );
            
        Timezone::create( [

            // 'id'=>540,
            'time_zone'=>'US/Michigan',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-05:00',
        ] );
            
        Timezone::create( [

            // 'id'=>541,
            'time_zone'=>'US/Mountain',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-07:00',
        ] );
            
        Timezone::create( [

            // 'id'=>542,
            'time_zone'=>'US/Pacific',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-08:00',
        ] );
            
        // Timezone::create( [

        //     // 'id'=>543,
        //     'time_zone'=>'US/Pacific-New',
        //     'user_id'=>'1',
        //     'created_at'=>'2023-12-31 13:44:01',
        //     'updated_at'=>NULL,
        //     'country_code'=>"",
        //     'utc_difference'=>'-08:00',
        // ] );
            
        Timezone::create( [

            // 'id'=>544,
            'time_zone'=>'US/Samoa',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'-11:00',
        ] );
            
        Timezone::create( [

            // 'id'=>545,
            'time_zone'=>'UTC',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>546,
            'time_zone'=>'WET',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
        Timezone::create( [

            // 'id'=>547,
            'time_zone'=>'W-SU',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+04:00',
        ] );
            
        Timezone::create( [

            // 'id'=>548,
            'time_zone'=>'Zulu',
            'user_id'=>'1',
            'created_at'=>'2023-12-31 13:44:01',
            'updated_at'=>NULL,
            'country_code'=>"",
            'utc_difference'=>'+00:00',
        ] );
            
    }
}
