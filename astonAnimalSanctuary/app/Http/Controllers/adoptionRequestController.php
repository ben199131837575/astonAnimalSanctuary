<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Adoption_Request;
use App\Animal;
use Illuminate\Support\Facades\Input;
use App\customSecurity;
use App\User;

class adoptionRequestController extends Controller
{
    public function getAdoptionRequestForm($id){
        $notLoggedIn = customSecurity::checkUserIsLoggedIn();
        if($notLoggedIn){
            return $notLoggedIn;
        }else if(Animal::find($id)->adopted){
            return customSecurity::returnMessage('panel-warning',
                'Sorry :(', 'This animal has already been adopted',
                0,
                '',
                '',
                '');
        }
        return view('adoptionRequestForm', array('animalid'=>$id));
    }

    public function denyOrAccept($newStatus, $id){
        $notStaff = customSecurity::checkUserIsStaff();
        if($notStaff){
            return $notStaff;
        }

        $adoptionRequest = Adoption_Request::find($id);

        if($newStatus == 'deny'){
            $adoptionRequest->type = 'denied';
            $adoptionRequest->save();
            return redirect('adoptionRequests/denied');
        }else if($newStatus == 'accept' && !Animal::find($adoptionRequest->animalid)->adopted){

            //deny all other request for this animal
            Adoption_Request::where('animalid', '=', $adoptionRequest->animalid)
            ->where('userid','!=',Auth::user()->id)
            ->update(['type'=> 'denied']);

            $adoptionRequest->type = 'accepted';
            $adoptionRequest->save();
            return redirect('adoptionRequests/accepted');
        }

        return customSecurity::returnMessage('panel-warning',
            'Sorry :(', 'Action could not be completed',
            0,
            '',
            '',
            '');
    }



    public function postAdoptionRequest(){
        $notLoggedIn = customSecurity::checkUserIsLoggedIn();
        if($notLoggedIn){
            return $notLoggedIn;
        }

        $animal = Animal::find(Input::get('animalid'));
        $adoptionRequest = new Adoption_Request;
        $adoptionRequest->animalid = Input::get('animalid');
        $adoptionRequest->userid = Auth::user()->id;
        $adoptionRequest->reason = Input::get('reason');

        if($animal->adopted){
            return customSecurity::returnMessage('panel-danger', 'Sorry :(','You cannot adopt this animal. It already has an owner. If you believe this to be incorrect, please contact a member of staff', 0,'','','');
        }

        // Check if user has already applied to adopt this animal
        $request = Adoption_Request::all()
            ->where('animalid', '=',Input::get('animalid'))
            ->where('userid', '=', Auth::user()->id);
        if(count($request)){
            return customSecurity::returnMessage('panel-danger', 'Error X(','You cannot apply to adopt the same animal more than once.',0,'','','');
        }



        if(Input::get('other_animals')){
            $adoptionRequest->other_animals = Input::get('other_animals');
        }else{
            $adoptionRequest->other_animals = "";
        }
        if($adoptionRequest->save()){
            return customSecurity::returnMessage('panel-success','Success :)', 'Your request has been receive and is now pending for approval!',0,'','','');
        }
        return customSecurity::returnMessage('panel-warning','Sorry :(', 'Your request has failed, please try again or contact a member of staff',0,'','','');

    }



    public function adoptionRequests($type){//type can be: user, all, pending, denied, accepted
        //will return all the adoption requests of a specific user
        if($type == 'user'){
            $notLoggedIn = customSecurity::checkUserIsLoggedIn();
            if($notLoggedIn){
                return $notLoggedIn;
            }
            $adoptionRequests = Adoption_Request::all()->where('userid', '=', Auth::user()->id);
            $animalIds = array();
            foreach ($adoptionRequests as $adoptionRequest) {
                $animalIds[] = $adoptionRequest->animalid;
            }
            $animals = Animal::distinct()->find($animalIds);
            return view('adoptionRequests', array('users'=>0,'animals'=>$animals, 'personal'=>1, 'type'=>'Your adoption requests', 'adoptionRequests'=>$adoptionRequests));
        }

        $notStaff = customSecurity::checkUserIsStaff();
        if($notStaff){
            return $notStaff;
        }

        if($type == 'all'){
            $adoptionRequests = Adoption_Request::all();
        }else{
            $adoptionRequests = Adoption_Request::all()->where('type', '=', $type);
        }

        $animalIds = $userIds = array();
        foreach ($adoptionRequests as $adoptionRequest) {
            $animalIds[] = $adoptionRequest->animalid;
            $userIds[] = $adoptionRequest->userid;
        }

        $animals = Animal::distinct()->find($animalIds);
        $users = User::distinct()->find($userIds);
        return view('adoptionRequests', array('users'=>$users, 'animals'=>$animals, 'personal'=>0, 'type'=>$type, 'adoptionRequests'=>$adoptionRequests));
    }
}
