<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Adoption_Request;
use App\Animal;
use Illuminate\Support\Facades\Input;
use App\customSecurity;
use App\User;

/**
 * handles request involving adoption Requests such as adding new entries
 * or altering there status i.e. pending, accepted...
 */
class adoptionRequestController extends Controller
{

    /**
     * Returns an adoption request form to the user
     * @method getAdoptionRequestForm
     * @param  string                 animal id
     * @return view                   adoption request form
     */
    public function getAdoptionRequestForm($id){
        //Checks that the request is coming from a user and not a guest
        $notLoggedIn = customSecurity::checkUserIsLoggedIn();
        if($notLoggedIn){
            return $notLoggedIn;
        // Checks if the animal can be adopted (has not already been adopted)
        }else if(Animal::find($id)->adopted){
            return customSecurity::returnMessage('panel-warning',
                'Sorry :(', 'This animal has already been adopted',
                0,'','','');
        }
        return view('adoptionRequestForm', array('animalid'=>$id));
    }

    /**
     * Handles Requests to either accept or deny an adoption request
     * @method denyOrAccept
     * @param  String       $newStatus   Status can be eithier 'deny' or 'accept'
     * @param  String       $id          The id of the adoption request to alter
     * @return view
     */
    public function denyOrAccept($newStatus, $id){
        // Checks user is staff
        $notStaff = customSecurity::checkUserIsStaff();
        if($notStaff){
            return $notStaff;
        }

        // gets the adoption request and the animal from the database
        $adoptionRequest = Adoption_Request::find($id);
        $animal = Animal::find($adoptionRequest->animalid);

        // If adoption request is to be denied
        if($newStatus == 'deny'){
            // Set the adoption reqeust state to denied (and if need reset
            // reset animal to default (non adopted) state)
            $adoptionRequest->type = 'denied';
            $animal->adopted = 0;
            $animal->userid = 0;
            $adoptionRequest->save();
            $animal->save();

            return redirect('adoptionRequests/denied');
        // If adoption request is to be denied and the animal is not adopted
        }else if($newStatus == 'accept' && !$animal->adopted){

            // Find all other adoption request for this animal and deny them
            Adoption_Request::where('animalid', '=', $adoptionRequest->animalid)
            ->where('userid','!=',Auth::user()->id)
            ->update(['type'=> 'denied']);

            // Accept the current adoption request and update the animals
            // with its new user and state to adopted
            $adoptionRequest->type = 'accepted';
            $animal->adopted = 1;
            $animal->userid = $adoptionRequest->userid;

            $adoptionRequest->save();
            $animal->save();

            return redirect('adoptionRequests/accepted');
        }

        return customSecurity::returnMessage('panel-warning',
            'Sorry :(', 'Action could not be completed. Check if the animal is already adopted.',
            0,'','','');
    }

    private function validateRequestData($request){
        return $request->validate([
            'reason' => 'required|string|max:255',
            'other' => 'max:255',
            'animalid' => 'required',
        ]);
    }

    /**
     * Handles requests to add a new adoption request to the database with the
     * status of 'pending'
     * @method postAdoptionRequest
     * @return view
     */
    public function postAdoptionRequest(Request $request){
        $notLoggedIn = customSecurity::checkUserIsLoggedIn();
        if($notLoggedIn){
            return $notLoggedIn;
        }

        $validatedData = $this->validateRequestData($request);

        // Find animal selected for the adoption request
        $animal = Animal::find($validatedData['animalid']);

        // Create a new adoption request object and populate its feilds with
        // user data
        $adoptionRequest = new Adoption_Request;
        $adoptionRequest->animalid = $validatedData['animalid'];
        $adoptionRequest->userid = Auth::user()->id;
        $adoptionRequest->reason = $validatedData['reason'];

        // Check that the animal is not aleady adopted
        if($animal->adopted){
            return customSecurity::returnMessage('panel-danger',
            'Sorry :(','You cannot adopt this animal. It already has an owner. If you believe this to be incorrect, please contact a member of staff',
            0,'','','');
        }

        // Check if user has already applied to adopt this animal
        $request = Adoption_Request::all()
            ->where('animalid', '=',$validatedData['animalid'])
            ->where('userid', '=', Auth::user()->id);
        if(count($request)){
            return customSecurity::returnMessage('panel-danger',
            'Error X(','You cannot apply to adopt the same animal more than once.',
            0,'','','');
        }

        // Check if there user posted information about other animals they own
        if(Input::get('other_animals')){
            $adoptionRequest->other_animals = $validatedData['other_animals'];
        }else{
            $adoptionRequest->other_animals = "";
        }

        // Try to save the user request
        if($adoptionRequest->save()){
            return customSecurity::returnMessage('panel-success',
            'Success :)',
            'Your request has been receive and is now pending for approval!',
            0,'','','');
        }
        return customSecurity::returnMessage('panel-warning',
        'Sorry :(',
        'Your request has failed, please try again or contact a member of staff',
        0,'','','');

    }

    /**
     * Returns adoption requests to a view. Non staff members can see their own adoption
     * requests
     * @method adoptionRequests
     * @param  String           The type of request to return i.e. pending, accpeted...
     * @return view
     */
    public function adoptionRequests($type){//type can be: user, all, pending, denied, accepted

        //will return all the adoption requests of a specific user
        if($type == 'user'){
            $notLoggedIn = customSecurity::checkUserIsLoggedIn();
            if($notLoggedIn){
                return $notLoggedIn;
            }
            $adoptionRequests = Adoption_Request::orderBy('updated_at', 'desc')->where('userid', '=', Auth::user()->id)->get();
            $animalIds = array();

            foreach ($adoptionRequests as $adoptionRequest) {
                $animalIds[] = $adoptionRequest->animalid;
            }

            $animals = Animal::distinct()->find($animalIds);
            return view('adoptionRequests',
                array('users'=>0,
                'animals'=>$animals,
                'personal'=>1,
                'type'=>'Your adoption',
                'adoptionRequests'=>$adoptionRequests));
        }

        // checks user is staff
        $notStaff = customSecurity::checkUserIsStaff();
        if($notStaff){
            if($type == 'pending'){
                return redirect('home');
            }
            return $notStaff;
        }

        if($type == 'all'){
            // Fetchs all adoption requests
            $adoptionRequests = Adoption_Request::orderBy('updated_at', 'desc')->get();
        }else{
            // Fetch adoption requests based on the specified request status
            $adoptionRequests = Adoption_Request::orderBy('updated_at', 'desc')->where('type', '=', $type)->get();
        }

        // Get the user and animal IDs related to each adoption requests
        $animalIds = $userIds = array();
        foreach ($adoptionRequests as $adoptionRequest) {
            $animalIds[] = $adoptionRequest->animalid;
            $userIds[] = $adoptionRequest->userid;
        }

        $animals = Animal::distinct()->find($animalIds);
        $users = User::distinct()->find($userIds);

        return view('adoptionRequests',
            array('users'=>$users,
            'animals'=>$animals,
            'personal'=>0,
            'type'=>$type,
            'adoptionRequests'=>$adoptionRequests));
    }
}
