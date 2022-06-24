<?php

namespace App\Http\Controllers\Auth;

use App\Models\order;
use App\Models\provider;
use App\Models\partyPlace;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProviderControler extends Controller
{


    //sigin Provider
    public function signProvider(Request $request)
    {

        $rules = [

            'email' => 'required|email|unique:providers|email',

            'password' => 'required|min:6|confirmed'

        ];

        ///validation provider

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {

            return    $validate->errors()->all();
        } else {

            ///create provider
            $provider = provider::create([

                'email' => $request->email,

                'password' => Hash::make($request->password),

            ]);
            //return Token  , $request->email =>  name of token Stored in personal_access_tokens table
            return $provider->createToken($request->email)->plainTextToken;
        }
    }
    //Login Provider
    public function AuthProvider(Request $request)
    {

        $rules = [

            'email' => 'required|email|exists:providers,email',

            'password' => 'required',
        ];

        ///validation providers
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            //return error
            return   $validate->errors()->all();
        } else {

            ///get email from database
            $provider = provider::where('email', $request->email)->first();
            ////check password
            if (!$provider || !Hash::check($request->password, $provider->password)) {
                return 'Email or password not correct';
            }
            //return Token  , $request->email =>  name of token Stored in personal_access_tokens table
            return $provider->createToken($request->email)->plainTextToken;
        }
    }

    public function logoutProvider(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }


    public function createPlace(Request $request)
    {

        $image = request('image')->HashName();
        $path = request('image')->store('placesImage/', 'public');
        partyPlace::create([
            'provider_id' => auth()->user()->id,
            'name' => $request->name,
            'location' => $request->location,
            'details' => $request->details,
            'image' => 'placesImage/' . $image,
            'status' => '0',
        ]);
    }

    public function getMyOrders()
    {

        $orders = order::whereHas('partyPlace', function ($q) {

            $q->where('provider_id', auth()->user()->id);
        })->get();

        return response()->json($orders);
    }

    public function acceptOrRejectOrder(Request $request, $id)
    {

        $orders = order::whereHas('partyPlace', function ($q) {

            $q->where('provider_id', auth()->user()->id);
        })->get();

        $updateOrder = $orders->find($id);

        $rules = [
            'status' => 'required|in:1,0 else',
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {

            return    $validate->errors()->all();
        } else {
            
            $updateOrder->update([
                'status' => $request->status,
                'price'=> $request->price,
            ]);
            return response()->json();
        }
    }
}
