<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Province;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    /**
     * getProvinces
     *
     * @param  mixed $request
     * @return void
     */
    public function getProvinces() // untuk menampilkan data provinsi dalam bentuk format JSON.
    {
        $provinces = Province::all();
        return response()->json([
            'success' => true,
            'message' => 'List Data provinces',
            'data'    => $provinces
        ]);
    }
    
    /**
     * getCities
     *
     * @param  mixed $request
     * @return void
     */
    public function getCities(Request $request) // untuk menampilkan list kota berdasarkan ID provinsi yang dipilih.
    {
        $city = City::where('province_id', $request->province_id)->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Cities By Province',
            'data'    => $city
        ]);
    }
        
    /**
     * checkOngkir
     *
     * @param  mixed $request
     * @return void
     */
    public function checkOngkir(Request $request) // untuk melakukan proses perhitungan biaya ongkos kirim.
    {
        //Fetch Rest API
        $response = Http::withHeaders([
            //api key rajaongkir
            'key'          => config('services.rajaongkir.key')
        ])->post('https://api.rajaongkir.com/starter/cost', [

            //send data
            'origin'      => 444, // ID kota Surabaya di DataBase
            'destination' => $request->city_destination,
            'weight'      => $request->weight,
            'courier'     => $request->courier    
        ]);


        return response()->json([
            'success' => true,
            'message' => 'List Data Cost All Courir: '.$request->courier,
            'data'    => $response['rajaongkir']['results'][0]
        ]);
    }
}