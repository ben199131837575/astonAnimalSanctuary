<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Animal;
use App\User;
use Auth;

class AnimalController extends Controller
{

    public function isStaff(){
        if(Auth::user()->staff){
            return true;
        }
        return false;
    }

    /*
        Search function for animals
    */
    public function search(){

        if(!count(Input::all()) && "" == Input::get('keyword')){
            return $this->getAdoptableAnimals();
        }
        $animalQuery = Animal::query();

        if(!$this::isStaff()){
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

        $animal = $animalQuery->get();

        return view('/home', array('animals'=>$animal));

    }


    public function getAdoptableAnimals(){
        return view('/home', array('animals'=>Animal::all()->where('adopted', '=', 0)));
    }

}
