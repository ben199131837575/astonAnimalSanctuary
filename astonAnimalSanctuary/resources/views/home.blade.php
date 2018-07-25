@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Search Filter</div>
          <div class="panel-body">
            <div class="card-body bg-light">
              <form method="GET" action="{{ route('animalSearch') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="keywords" class="col-sm-4 col-form-label text-md-right">{{ __('Search') }}</label>
                    <div class="col-md-6">
                        <input id="keywords" type="text" class="form-control" name="keywords" value="" placeholder="text search">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="type" class="col-sm-4 col-form-label text-md-right">{{ __('Animal Type') }}</label>
                    <div class="col-md-6">
                        <select id="type" name="type" class="form-control">
                          <option value="" selected disabled hidden>{{''}}</option>
                          <option value="dog">{{ __('Dog') }}</option>
                          <option value="cat">{{ __('Cat') }}</option>
                          <option value="aquatic">{{ __('Aquatic') }}</option>
                          <option value="reptile">{{ __('Reptile') }}</option>
                          <option value="bird">{{ __('Bird') }}</option>
                          <option value="other">{{ __('Other') }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="orderby" class="col-sm-4 col-form-label text-md-right">{{ __('Order By') }}</label>
                    <div class="col-md-6">
                        <select id="orderby" name="orderby" class="form-control">
                            <option value="" selected disabled hidden>{{''}}</option>
                            <optgroup label="Animal Age">
                                <option value="age_asc">{{ __('Youngest to Oldest') }}</option>
                                <option value="age_desc">{{ __('Oldest to Youngest') }}</option>
                            </optgroup>
                            <optgroup label="Time posted">
                                <option value="newest">{{ __('Recent') }}</option>
                                <option value="oldest">{{ __('Old') }}</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Search') }}
                        </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>



<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">


            @foreach($animals as $animal)
            <div class="panel panel-default">
                <div class="panel-heading">picture</div>


                <ul class="list-group list-group-flush">
                  <li class="list-group-item " >
                    <p class="card-text">{{'Name: '}}{{$animal->name}}</p>
                  </li>
                 <li class="list-group-item ">
                   <p class="card-text">{{'Type: '}}{{$animal->type}}</p>
                 </li>
                 <li class="list-group-item ">
                   <p class="card-text">{{'Date of Birth:  '}}{{$animal->dateofbirth}}</p>
                 </li>
                 <li class="list-group-item " >
                   <p class="card-text">{{$animal->adopted == 0 ? 'Available for adoption' : 'Not Available for adoption'}}</p>
                 </li>
               </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>

@if (!count($animals))
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">No results found!</div>


                </div>
            </div>
        </div>
    </div>
@endif

@endsection
