<?php

namespace App\Http\Controllers;

use App\Models\partyPlace;
use App\Models\provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function GetAllPlaces()
    {
        $places = partyPlace::all();
        return response()->json($places);
    }

    public function acceptOrRject(Request $request)
    {
        $rules = [
            'id' => 'required|exists:party_places,id',
            'status' => 'required|in:1,0 else',
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {

            return    $validate->errors()->all();
        } else {
            $place = partyPlace::find($request->id);
            $place->update([
                'status' => $request->status,
            ]);
        }
    }

    public function getAllProviders(){
        $providers=provider::select('name','email')->get();
            return response()->json($providers);
    }
}
