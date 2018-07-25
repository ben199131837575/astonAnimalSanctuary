<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Animal;

class AnimalController extends Controller
{

    /*
        Search function for animals
    */
    public function search(){

        if(!count(Input::all()) && "" == Input::get('keyword')){
            return $this->getAdoptableAnimals();
        }
        $animalQuery = Animal::query();
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //if staff and show adopted is selected
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        if(true){
            $animalQuery->where('adopted', '=', 0);
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
            if(Input::get('orderby') == 'age_asc'){//order by age young to old
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
