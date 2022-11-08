<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->truncate();
        $districts = "INSERT INTO `districts` VALUES
        (1, 1, '1', 'ताप्लेजुङ', 'Taplejung', NULL, NULL, '2018-01-24 02:56:20'),
        (2, 1, '2', 'पाचथर', 'Panchthar', NULL , NULL, '2018-01-24 02:57:34'),
        (3, 1, '3', 'ईलाम', 'Ilam', NULL, NULL, '2018-01-24 02:58:05'),
        (4, 1, '4', 'झापा', 'Jhapa', NULL, NULL, '2018-01-24 02:58:31'),
        (5, 1, '5', 'मोरङ', 'Morang', NULL, NULL, '2018-01-24 02:59:18'),
        (6, 1, '6', 'सुनसरि', 'Sunsari', NULL, NULL, '2018-01-24 02:59:20'),
        (7, 1, '7', 'धनकुटा', 'Dhankuta', NULL, NULL, '2018-01-24 02:59:55'),
        (8, 1, '8', 'तेह्थुम', 'Terhathum', NULL, NULL, '2018-01-24 03:00:33'),
        (9, 1, '9', 'Sankhuwasabha', 'Sankhuwasabha', NULL, NULL, NULL),
        (10, 1, '10', 'Bhojpur', 'Bhojpur', NULL, NULL, NULL),
        (11, 1, '11', 'Solukhumbu', 'Solukhumbu', NULL, NULL, NULL),
        (12, 1, '12', 'Okhaldhunga', 'Okhaldhunga', NULL, NULL, NULL),
        (13, 1, '13', 'Khotang', 'Khotang', NULL, NULL, NULL),
        (14, 1, '14', 'Udayapur', 'Udayapur', NULL, NULL, NULL),
        (15, 2, '15', 'सप्तरी', 'Saptari', NULL, NULL, '2018-01-24 02:58:47'),
        (16, 2, '16', 'सिरहा', 'Siraha', NULL, NULL, '2018-01-24 02:59:19'),
        (17, 2, '17', 'धनुषा', 'Dhanusa', NULL, NULL, '2018-01-24 02:56:18'),
        (18, 2, '18', 'महोत्तरी', 'Mahottari', NULL, NULL, '2018-01-24 02:55:58'),
        (19, 2, '19', 'Sarlahi', 'Sarlahi', NULL, NULL, NULL),
        (20, 3, '20', 'सिन्धुली', 'Sindhuli', NULL, NULL, '2018-01-24 02:56:28'),
        (21, 3, '21', 'Ramechhap', 'Ramechhap', NULL, NULL, NULL),
        (22, 3, '22', 'Dolakha', 'Dolakha', NULL, NULL, NULL),
        (23, 3, '23', 'सिन्धुपाल्चोक', 'Sindhupalchok', NULL, NULL, '2018-01-21 01:35:21'),
        (24, 3, '24', 'काभ्रे', 'Kavre', NULL, NULL, '2018-01-24 03:00:38'),
        (25, 3, '25', 'Lalitpur', 'Lalitpur',NULL, NULL, NULL),
        (26, 3, '26', 'भक्तपुर', 'Bhaktapur', NULL, NULL, '2018-01-21 01:35:15'),
        (27, 3, '27', 'काठमाण्डौ', 'Kathmandu', NULL, NULL, '2018-01-21 01:34:31'),
        (28, 3, '28', 'Nuwakot', 'Nuwakot', NULL, NULL, NULL),
        (29, 3, '29', 'रसुवा', 'Rasuwa', NULL, NULL, '2018-01-24 02:56:24'),
        (30, 3, '30', 'धादिङ', 'Dhading', NULL, NULL, '2018-01-24 03:01:09'),
        (31, 3, '31', 'Makwanpur', 'Makwanpur', NULL, NULL, NULL),
        (32, 2, '32', 'Rautahat', 'Rautahat', NULL, NULL, NULL),
        (33, 2, '33', 'बारा', 'Bara', NULL, NULL, '2018-01-24 02:54:33'),
        (34, 2, '34', 'पर्सा', 'Parsa', NULL, NULL, '2018-01-24 02:57:26'),
        (35, 3, '35', 'चितवन', 'Chitawan', NULL, NULL, '2018-01-24 02:59:04'),
        (36, 4, '36', 'गोरखा', 'Gorkha', NULL, NULL, '2018-01-24 02:56:08'),
        (37, 4, '37', 'लम्जुङ', 'Lamjung', NULL, NULL, '2018-01-24 02:59:28'),
        (38, 4, '39', 'तनहुं', 'Tanahu', NULL, NULL, '2018-01-24 02:56:28'),
        (39, 4, '41', 'स्याङ्जा', 'Syangja', NULL, NULL, '2018-01-24 02:57:52'),
        (40, 4, '40', 'कास्की', 'Kaski', NULL, NULL, '2018-01-24 02:58:40'),
        (41, 4, '41', 'Manang', 'Manang', NULL, NULL, NULL),
        (42, 4, '42', 'Mustang', 'Mustang', NULL, NULL, NULL),
        (43, 4, '43', 'Myagdi', 'Myagdi', NULL, NULL, NULL),
        (44, 4, '44', 'पर्वत', 'Parbat', NULL, NULL, '2018-01-24 02:58:25'),
        (45, 4, '45', 'Baglung', 'Baglung', NULL, NULL, NULL),
        (46, 5, '46', 'Gulmi', 'Gulmi', NULL, NULL, NULL),
        (47, 5, '47', 'Palpa', 'Palpa', NULL, NULL, NULL),
        (48, 5, '48', 'Nawalpur', 'Nawalparasi', NULL, NULL, '2018-01-21 01:17:52'),
        (49, 5, '49', 'रुपन्देही', 'Rupandehi', NULL, NULL, '2018-01-24 03:26:26'),
        (50, 5, '50', 'Kapilbastu', 'Kapilbastu', NULL, NULL, NULL),
        (51, 5, '51', 'Arghakhanchi', 'Arghakhanchi', NULL, NULL, '2018-01-20 00:27:33'),
        (52, 5, '52', 'Pyuthan', 'Pyuthan', NULL, NULL, NULL),
        (53, 5, '53', 'रोल्पा', 'Rolpa', NULL, NULL, '2018-01-24 02:57:38'),
        (54, 6, '54', 'रुकुम', 'Rukum', NULL, NULL, '2018-01-24 02:57:25'),
        (55, 6, '55', 'Salyan', 'Salyan', NULL, NULL, NULL),
        (56, 5, '56', 'दाङ्ग', 'Dang', NULL, NULL, '2018-01-24 02:58:05'),
        (57, 5, '57', 'बाँके', 'Banke', NULL, NULL, '2018-01-24 02:56:02'),
        (58, 5, '58', 'Bardiya', 'Bardiya', NULL, NULL, NULL),
        (59, 6, '59', 'सुर्खेत', 'Surkhet', NULL, NULL, '2018-01-24 02:56:12'),
        (60, 6, '60', 'दैलेख', 'Dailekh', NULL, NULL, '2018-01-24 03:01:23'),
        (61, 6, '61', 'जाजरकोटट', 'Jajarkot', NULL, NULL, '2018-01-21 01:34:40'),
        (62, 6, '62', 'डोल्पा', 'Dolpa', NULL, NULL, '2018-01-24 02:57:06'),
        (63, 6, '63', 'जुम्ला', 'Jumla', NULL, NULL, '2018-01-21 01:35:38'),
        (64, 6, '64', 'कालिकोट', 'Kalikot', NULL, NULL, '2018-01-21 01:36:00'),
        (65, 6, '65', 'मुगु', 'Mugu', NULL, NULL, '2018-01-21 01:39:37'),
        (66, 6, '66', 'Humla', 'Humla', NULL, NULL, NULL),
        (67, 7, '67', 'Bajura', 'Bajura', NULL, NULL, NULL),
        (68, 7, '68', 'बझाङ्ग', 'Bajhang', NULL, NULL, '2018-01-24 02:55:50'),
        (69, 7, '69', 'अछाम', 'Achham', NULL, NULL, '2018-01-24 02:55:01'),
        (70, 7, '70', 'डोटी', 'Doti', NULL, NULL, '2018-01-24 02:55:18'),
        (71, 7, '71', 'Kailali', 'Kailali', NULL, NULL, NULL),
        (72, 7, '72', 'Kanchanpur', 'Kanchanpur', NULL, NULL, NULL),
        (73, 7, '73', 'Dadeldhura', 'Dadeldhura', NULL, NULL, NULL),
        (74, 7, '74', 'बैतडि', 'Baitadi', NULL, NULL, '2018-01-24 03:00:36'),
        (75, 7, '75', 'Darchaula', 'Darchaula', NULL, NULL, NULL),
        (76, 5, '76', 'पुर्वि रुकुम', NULL, NULL, '2018-01-21 01:15:57', '2018-01-21 01:16:39'),
        (77, 5, '77', 'नवलपुर', NULL, NULL, '2018-01-21 01:16:59', '2018-01-21 01:16:59');";

        DB::select(DB::raw($districts));

        DB::select(DB::raw('UPDATE districts SET deleted_at = NULL'));
    }
}
