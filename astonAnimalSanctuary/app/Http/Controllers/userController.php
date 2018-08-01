<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\customSecurity;
use App\User;

class userController extends Controller
{
    public function user($id){
        $notStaff = customSecurity::checkUserIsStaff();
        if($notStaff){
            return $notStaff;
        }
        return view('user', array('users'=>array(User::find($id))));
    }

    public function allStaff(){
        $staff = User::all()->where('staff', '=', 1);
        return view('user', array('users'=>$staff));
    }
}
