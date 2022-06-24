<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\evaluation;
use App\Models\order;
use App\Models\partyPlace;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\Cast\Double;
use Prophecy\Doubler\Doubler;
use Ramsey\Uuid\Type\Integer;

class UserController extends Controller
{

    //sigin User
    public function signUser(Request $request)
    {

        $rules = [

            'name' => 'required',

            'email' => 'required|email|unique:users|email',

            'password' => 'required|min:6|confirmed'
        ];
        ///validation User

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {

            return    $validate->errors()->all();
        } else {

            ///create user
            $user = User::create([

                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password),

            ]);
            //return Token  , $request->email =>  name of token Stored in personal_access_tokens table
            return $user->createToken($request->email)->plainTextToken;
        }
    }
    ///login User
    public function AuthUser(Request $request)
    {

        $rules = [

            'email' => 'required|email|exists:users,email',

            'password' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {

            return    $validate->errors()->all();
        } else {

            ///get email from database
            $user = User::where('email', $request->email)->first();

            ////check password
            if (!$user || !Hash::check($request->password, $user->password)) {
                return 'Email or password not correct';
            }
        }

        //return Token  , $request->email =>  name of token Stored in personal_access_tokens table
        return $user->createToken($request->email)->plainTextToken;
    }

    //logoutUser
    public function logoutUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }


    public function getPlacees()
    {
        $places = partyPlace::select('name', 'details', 'rating', 'location', 'image')->where('status', '1')->get();
        return response()->json($places);
    }
    public function CreateOrder(Request $request)
    {

        order::create([
            'party_places_id' => $request->place_id,
            'user_id' => auth()->user()->id,
            'number_pepole' => $request->number_pepole,
            'party_type' => $request->party_type,
            'kato_size' => $request->kato_size,
            'photo' => $request->photo,
            'chairs' => $request->chairs,
            'dinner' => $request->dinner,
            'tables' => $request->tables,
            'date' => $request->date,
            'invitation_cards' => $request->invitation_cards,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);
    }


    public function sendEvaluation(Request $request, $place_id)
    {

        evaluation::create([
            'party_place_id' => $place_id,
            'rating' => $request->rating,
        ]);

        $place = partyPlace::find($place_id);

        $countRation = evaluation::where('party_place_id', $place_id)->count();


        $sumRating = evaluation::select('rating')->where('party_place_id', $place_id)->sum('rating');

        $rating = $sumRating / $countRation;

        $place->update([
            'rating' => $rating,
        ]);
        return $place;
    }
}
