<?php

// untuk merubah format mata uang menjadi IDR dan membuat konversi tanggal ke bahasa Indonesia.

if (! function_exists('moneyFormat')) {    
    /**
     * moneyFormat
     *
     * @param  mixed $str
     * @return void
     */
    function moneyFormat($str) { // untuk mengubah angka number menjadi mata uang IDR.
        return 'Rp. ' . number_format($str, '0', '', '.');
    }
}

if (! function_exists('dateID')) {         
    /**
     * dateID
     *
     * @param  mixed $tanggal
     * @return void
     */
    function dateID($tanggal) { // untuk merubah format tanggal yang kita dapatkan dari database menjadi format indonesia.
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');
        return $parse->translatedFormat('l, d F Y');
    }
}