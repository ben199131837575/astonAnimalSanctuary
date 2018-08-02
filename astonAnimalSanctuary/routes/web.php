<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/home', 'AnimalController@getAdoptableAnimals')->name('home');
Auth::routes();

//Animals
    //GET
Route::get('/', 'AnimalController@getAdoptableAnimals')->name('getAdoptableAnimals');
Route::get('/animalSearch','AnimalController@search')->name('animalSearch');
Route::get('/animal/{id}','AnimalController@animal')->name('animal');
Route::get('/newAnimalForm','AnimalController@newAnimalForm')->name('newAnimalForm');
    // POST
route::post('/addNewAnimal', 'AnimalController@addNewAnimal')->name('addNewAnimal');


// Animal adoption
    // GET
Route::get('/adoptionRequestForm/{id}', 'adoptionRequestController@getAdoptionRequestForm')->name('adoptionRequestForm');
Route::get('/adoptionRequests/{type}', 'adoptionRequestController@adoptionRequests')->name('adoptionRequests');
Route::get('/adoptionRequest/{newStatus}/{id?}','adoptionRequestController@denyOrAccept')->name('denyOrAccept');
    // POST
Route::post('/adoptionRequestForm/postAdoptionRequest', 'adoptionRequestController@postAdoptionRequest')->name('postAdoptionRequest');


//Users
Route::get('/user/{id}','userController@user')->name('user');
Route::get('/allStaff','userController@allStaff')->name('allStaff');

//About
Route::get('/about', function(){
    return view('about');
})->name('about');





//end
