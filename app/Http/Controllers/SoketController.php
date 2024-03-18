<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoketController extends Controller
{

    public function makeOffer(Request $request)
    {
        DB::table('offers')->insert([
            'offer' => $request->offer
        ]);
    }
    public function getOffer()
    {
        return DB::table('offers')->first();
    }
}
