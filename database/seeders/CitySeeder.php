<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Http; // digunakan untuk melakukan fetching ke dalam sebuah Rest API.
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Fetch Rest API
        $response = Http::withHeaders([
            //api key rajaongkir
            'key' => config('services.rajaongkir.key'),
        ])->get('https://api.rajaongkir.com/starter/city');
        
        //loop data from Rest API
        foreach($response['rajaongkir']['results'] as $city) {

            //insert ke table "cities"
            City::create([
                'province_id' => $city['province_id'],
                'city_id'     => $city['city_id'],  
                'name'        => $city['city_name'] . ' - ' . '('. $city['type'] .')', 
            ]);

        }
    }
}
