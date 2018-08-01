<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Animal;
use App\User;
use App\animal_pictures;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\customSecurity;



class AnimalController extends Controller
{

    public function addNewAnimal(){
        $isNotStaff = customSecurity::checkUserIsStaff();
        if($isNotStaff){
            return $isNotStaff;
        }else if(!count(Input::file('image_upload'))){
            return customSecurity::returnMessage('panel-warning',
                 'Error!',
                 'Animal was not saved to the database, you must upload animal with images',
                 0,
                 '',
                 '',
                 '');
        }

        $animal = new Animal;
        $animal->name = Input::get('name');
        $animal->dateofbirth = Input::get('dateofbirth');
        $animal->description = Input::get('description');
        $animal->type = Input::get('type');
        $animal->gender = Input::get('gender');
        $animalSaved = $animal->save();
        $animalId = $animal->id;

        $images = Input::file('image_upload');
        $imagesSaved = 0;
        $success = 0;
        foreach ($images as $image) {
            $imagesSaved++;
            $animal_pictures = new animal_pictures;
            $animal_pictures->animalid = $animalId;
            $animal_pictures->image = base64_encode(file_get_contents($image->getRealPath()));
            $success += $animal_pictures->save();
        }
        if($imagesSaved == $success && $animalSaved){
            return customSecurity::returnMessage('panel-success',
                 'Success!',
                 'Animal has been saved to the database',
                 0,
                 '',
                 '',
                 '');
        }
        return customSecurity::returnMessage('panel-warning',
             'Error!',
             'Animal was not saved to the database',
             0,
             '',
             '',
             '');
    }

    /*
        Search function for animals
    */
    public function search(){

        if(!count(Input::all()) && "" == Input::get('keyword')){
            $animals = Animal::all()->where('adopted', '=', 0);
            return view('/home', array('animals'=>$animals, 'images' => $this->findAnimalImages($animals)));
        }
        $animalQuery = Animal::query();

        if(!Auth::user() || !Auth::user()->staff){
            $animalQuery->where('adopted', '=', 0);
        }else if(!Input::get('adoption') == 'show_adopted'){
            $animalQuery->where('adopted', '=', 0);
        }else if(Input::get('adoption') == 'only_show_adopted'){
            $animalQuery->where('adopted', '=', 1);
        }

        if(Input::get('type')){
            $animalQuery->where('type', '=', Input::get('type'));
        }

        if(Input::get('keywords')){
            $keywords = explode(" ", Input::get('keywords'));
            foreach ($keywords as $keyword) {
                $animalQuery->where(function ($animalQuery) use ($keyword){
                    $animalQuery->orWhere('name', 'like', '%'.$keyword.'%');
                    $animalQuery->orWhere('description', 'like', '%'.$keyword.'%');
                });
            }
        }

        if(Input::has('orderby')){
            if(Input::get('orderby') == 'age_asc'){// order by age young to old
                $animalQuery->orderBy('dateofbirth', 'desc');
            }else if(Input::get('orderby') == 'age_desc'){// order by age old to young
                $animalQuery->orderBy('dateofbirth', 'asc');
            }else if(Input::get('orderby') == 'newest'){ // order by time of post, newest first
                $animalQuery->orderBy('created_at', 'desc');
            }else if(Input::get('orderby') == 'oldest'){ // order by time of post, oldest first
                $animalQuery->orderBy('created_at', 'asc');
            }
        }

        $animals = $animalQuery->get();
        $images = $this->findAnimalImages($animals);
        return view('/home', array('animals'=>$animals, 'images'=>$images));
    }

    private function findAnimalImages($animals){
        $imageQuery = animal_pictures::query();
        //Get images for animals
        foreach ($animals as $animal) {
            $filePaths = $imageQuery->orWhere('animalid', '=', $animal->id);
        }
        $images = $imageQuery->get();
        return $images;
    }

    public function animal($animalId){
        $animal = Animal::find($animalId);
        $images = animal_pictures::all()->where('animalid', '=', $animalId);
        return view('/animal', array('animal'=>$animal, 'images'=>$images));
    }

    public function getAdoptableAnimals(){
        return $this->search();
    }

    public function newAnimalForm(){
        $isNotStaff = customSecurity::checkUserIsStaff();
        if($isNotStaff){
            return $isNotStaff;
        }
        return view('newAnimalForm');
    }



}
