<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NepaliYearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nepali_years')->truncate();
        $query = ("INSERT INTO `nepali_years`  VALUES
        (1,2001,'active',NULL,NULL),
        (2,2002,'active',NULL,NULL),
        (3,2003,'active',NULL,NULL),
        (4,2004,'active',NULL,NULL),
        (5,2005,'active',NULL,NULL),
        (6,2006,'active',NULL,NULL),
        (7,2007,'active',NULL,NULL),
        (8,2008,'active',NULL,NULL),
        (9,2009,'active',NULL,NULL),
        (10,2010,'active',NULL,NULL),
        (11,2011,'active',NULL,NULL),
        (12,2012,'active',NULL,NULL),
        (13,2013,'active',NULL,NULL),
        (14,2014,'active',NULL,NULL),
        (15,2015,'active',NULL,NULL),
        (16,2016,'active',NULL,NULL),
        (17,2017,'active',NULL,NULL),
        (18,2018,'active',NULL,NULL),
        (19,2019,'active',NULL,NULL),
        (20,2020,'active',NULL,NULL),
        (21,2021,'active',NULL,NULL),
        (22,2022,'active',NULL,NULL),
        (23,2023,'active',NULL,NULL),
        (24,2024,'active',NULL,NULL),
        (25,2025,'active',NULL,NULL),
        (26,2026,'active',NULL,NULL),
        (27,2027,'active',NULL,NULL),
        (28,2028,'active',NULL,NULL),
        (29,2029,'active',NULL,NULL),
        (30,2030,'active',NULL,NULL),
        (31,2031,'active',NULL,NULL),
        (32,2032,'active',NULL,NULL),
        (33,2033,'active',NULL,NULL),
        (34,2034,'active',NULL,NULL),
        (35,2035,'active',NULL,NULL),
        (36,2036,'active',NULL,NULL),
        (37,2037,'active',NULL,NULL),
        (38,2038,'active',NULL,NULL),
        (39,2039,'active',NULL,NULL),
        (40,2040,'active',NULL,NULL),
        (41,2041,'active',NULL,NULL),
        (42,2042,'active',NULL,NULL),
        (43,2043,'active',NULL,NULL),
        (44,2044,'active',NULL,NULL),
        (45,2045,'active',NULL,NULL),
        (46,2046,'active',NULL,NULL),
        (47,2047,'active',NULL,NULL),
        (48,2048,'active',NULL,NULL),
        (49,2049,'active',NULL,NULL),
        (50,2050,'active',NULL,NULL),
        (51,2051,'active',NULL,NULL),
        (52,2052,'active',NULL,NULL),
        (53,2053,'active',NULL,NULL),
        (54,2054,'active',NULL,NULL),
        (55,2055,'active',NULL,NULL),
        (56,2056,'active',NULL,NULL),
        (57,2057,'active',NULL,NULL),
        (58,2058,'active',NULL,NULL),
        (59,2059,'active',NULL,NULL),
        (60,2060,'active',NULL,NULL),
        (61,2061,'active',NULL,NULL),
        (62,2062,'active',NULL,NULL),
        (63,2063,'active',NULL,NULL),
        (64,2064,'active',NULL,NULL),
        (65,2065,'active',NULL,NULL),
        (66,2066,'active',NULL,NULL),
        (67,2067,'active',NULL,NULL),
        (68,2068,'active',NULL,NULL),
        (69,2069,'active',NULL,NULL),
        (70,2070,'active',NULL,NULL),
        (71,2071,'active',NULL,NULL),
        (72,2072,'active',NULL,NULL),
        (73,2073,'active',NULL,NULL),
        (74,2074,'active',NULL,NULL),
        (75,2075,'active',NULL,NULL),
        (76,2076,'active',NULL,NULL),
        (77,2077,'active',NULL,NULL),
        (78,2078,'active',NULL,NULL)
        ");

        DB::statement($query);
    }
}
