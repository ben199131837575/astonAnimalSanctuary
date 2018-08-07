<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animal;
use App\User;
use App\animal_pictures;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\customSecurity;

/*Handles all requests regarding animals i.e. adding,
retrieving and updating animals in the database*/
class AnimalController extends Controller{

    /**
     * Validates animal data from user input, before it
     * gets stored into the database
     * @method validateNewAnimalData
     * @param  $request                 Unvalidated user data
     * @return $validatedData           validated data
     */
    private function validateNewAnimalData($request){
        $currentDate = date('Y-m-d');

        return $request->validate([
            'name' => 'required|string|max:60',
            'dateofbirth' => 'required|date|before:'.$currentDate,
            'description' => 'required|string|max:255',
            'image_upload.*' => 'required|image',
            'type' => 'required',
            'gender' => 'required',
        ]);
    }

    /**
     * Checks that keywords from search filter is not to long
     * @method validateSearchFilterData
     * @param  $request                 Unvalidated user data
     * @return $validatedData           validated data
     */
    private function validateSearchFilterData($request){
        return $request->validate([
            'keywords' => 'max:60',
            'type' => '',
            'adoption' => '',
            'orderby' => '',
        ]);
    }


    /**
     * Handles a post request to add a new animal.
     * Request is not accepted if the user is not staff.
     * @method addNewAnimal
     */
    public function addNewAnimal(Request $request){
        // checks if the user is staff
        $isNotStaff = customSecurity::checkUserIsStaff();
        if($isNotStaff){
            return $isNotStaff;
        }

        $validatedData = $this->validateNewAnimalData($request);

        // Create an animal object and populate its properties with user
        // submitted values
        $animal = new Animal;
        $animal->name = $validatedData['name'];
        $animal->dateofbirth = $validatedData['dateofbirth'];
        $animal->description = $validatedData['description'];
        $animal->type = $validatedData['type'];
        $animal->gender = $validatedData['gender'];
        $animalSaved = $animal->save();
        $animalId = $animal->id;


        $images = $validatedData['image_upload'];
        $imagesTriedTosave = 0;
        $successes = 0;

        foreach ($images as $image) {
            $imagesTriedTosave++;

            // tries to add the images the user upload to the database
            $animal_pictures = new animal_pictures;
            $animal_pictures->animalid = $animalId;
            $animal_pictures->image =
                base64_encode(file_get_contents($image->getRealPath()));
            $successes += $animal_pictures->save();
        }

        // checks if all the images and other animal data have been succesfully
        // saved to the database
        if($imagesTriedTosave == $successes && $animalSaved){
            return customSecurity::returnMessage('panel-success',
            'Success!',
            'Animal has been saved to the database',
            0,'','','');
        }

        // Should not run unless either, or both, the animal data and images
        // were not able to be stored into the database
        return customSecurity::returnMessage('panel-warning',
        'Error!',
        'Animal was not saved to the database',
        0,'','','');
    }

    /**
     * Search function for animals. Builds a query based on values submitted
     * in search form$request->input
     * @return view
     */
    public function search(Request $request){

        $validatedData = $this->validateSearchFilterData($request);

        // If the user searched with no paramaters selected/entered
        if(!count($request->all()) && "" == $request->input('keyword')){
            $animals = Animal::all()->where('adopted', '=', 0);
            return view('/home', array('animals'=>$animals,
                'images' => $this->findAnimalImages($animals)));
        }

        $animalQuery = Animal::query();

        // if the user is not staff, ignore animals that are adopted
        if(!Auth::user() || !Auth::user()->staff){
            $animalQuery->where('adopted', '=', 0);
        // If a staff member didn't select 'show adopted'
        }else if(!isset($validatedData['adoption']) == 'show_adopted'){
            $animalQuery->where('adopted', '=', 0);
        // if a staff member selects to only show adopted then omitt, all but...
        }else if(isset($validatedData['adoption']) == 'only_show_adopted' && $validatedData['adoption'] != 'show_adopted'){
            $animalQuery->where('adopted', '=', 1);
        }

        if(isset($validatedData['type'])){
            $animalQuery->where('type', '=', $validatedData['type']);
        }

        // matches anything in keywords if requested to animal names and
        // animal descriptions
        if(isset($validatedData['keywords'])){
            $keywords = explode(" ", $validatedData['keywords']);
            foreach ($keywords as $keyword) {
                $animalQuery->where(function ($animalQuery) use ($keyword){
                    $animalQuery->orWhere('name', 'like', '%'.$keyword.'%');
                    $animalQuery->orWhere('description', 'like', '%'.$keyword.'%');
                });
            }
        }
        // if selected orders results by a paramter slected by the user
        if(isset($validatedData['orderby'])){
            // order by age young to old
            if($validatedData['orderby'] == 'age_asc'){
                $animalQuery->orderBy('dateofbirth', 'desc');
            // order by age old to young
            }else if($validatedData['orderby'] == 'age_desc'){
                $animalQuery->orderBy('dateofbirth', 'asc');
            // order by time of post, newest first
            }else if($validatedData['orderby'] == 'newest'){
                $animalQuery->orderBy('created_at', 'desc');
            // order by time of post, oldest first
            }else if($validatedData['orderby'] == 'oldest'){
                $animalQuery->orderBy('created_at', 'asc');
            }
        }

        // run the query on the animal table
        $animals = $animalQuery->get();

        // Get all the images for the animals from the query
        $images = $this->findAnimalImages($animals);


        // Stores all the usersids associted with any animal in an array
        // to search form them
        $userIds = array();
        foreach($animals as $animal){
            if($animal->userid){
                $userIds[] = $animal->userid;
            }

        }
        // Find all user from the array of users, but ignore duplicates
        $users = User::distinct()->find($userIds);

        return view('/home', array('users'=>$users, 'animals'=>$animals, 'images'=>$images));
    }

    /**
     * Finds all the images associted with selected animals
     * @method findAnimalImages
     * @param  animals          list of animals as obejects
     * @return imagesy          list of images
     */
    private function findAnimalImages($animals){
        $imageQuery = animal_pictures::query();
        //Get images for animals
        foreach ($animals as $animal) {
            $filePaths = $imageQuery->orWhere('animalid', '=', $animal->id);
        }
        $images = $imageQuery->get();
        return $images;
    }

    /**
     * Returns the data of a specific animal from an
     * @method animal
     * @param  int $animalId    if of a specific animal
     * @return view             view with animal data
     */
    public function animal($animalId){
        $animal = Animal::find($animalId);
        $images = animal_pictures::all()->where('animalid', '=', $animalId);

        $user = 0;
        if($animal->userid){
            $user = User::find($animal->userid);
        }
        return view('/animal', array('user'=>$user, 'animal'=>$animal, 'images'=>$images));
    }

    /**
     * [getAdoptableAnimals description]
     * @method getAdoptableAnimals
     * @return [type]              [description]
     */
    public function getAdoptableAnimals(){
        return $this->search(new Request);
    }

    /**
     * Returns a 'newAnimalform' for the user to fill out
     * @method newAnimalForm
     * @return view
     */
    public function newAnimalForm(){
        //Checks if user is a member of staff
        $isNotStaff = customSecurity::checkUserIsStaff();
        if($isNotStaff){
            return $isNotStaff;
        }
        return view('newAnimalForm');
    }
}
