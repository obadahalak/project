<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function getMyReservation(){
        $user_id=auth()->user()->id;
        $reseravtions=order::where('user_id',$user_id)->where('status','1')->get();
        return response()->json($reseravtions);
    }


}
