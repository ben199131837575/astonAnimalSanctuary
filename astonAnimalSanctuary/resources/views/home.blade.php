@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Button for collapsing and expanding search filter form -->
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#search_filter" aria-expanded="false" aria-controls="search_filter">
                Search Filter <span class="caret"></span>
            </button><br><br>

            <div class="panel panel-default accordion-body {{ ($errors->isEmpty() ? 'collapse' : '') }}" id=search_filter>
                <div class="panel-body" >
                    <div class="card-body bg-light">

                        <!-- Search Filter form -->
                        <form method="GET" action="{{ route('animalSearch') }}">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="keywords" class="col-sm-4 col-form-label text-md-right">{{ __('Search') }}</label>
                                <div class="col-md-6">
                                    <input id="keywords" type="text" class="form-control" value="{{ old('keywords') }}" name="keywords" value="" placeholder="text search">
                                    @if ($errors->has('keywords'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('keywords') }}</strong>
                                        </span>
                                    @endif
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

                            <!-- Toggles for staff to give them the abilty to see adopted animals,
                             that would, otherwise, be hidden -->
                            @if (Auth::user() && Auth::user()->staff)
                                <div class="form-group row">
                                    <label for="show_adopted" class="col-sm-4 col-form-label text-md-right">{{ __('Include Adopted') }}</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="show_adopted" name="adoption" value="show_adopted">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="only_show_adopted" class="col-sm-4 col-form-label text-md-right">{{ __('Only Include Adopted') }}</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="only_show_adopted" name="adoption" value="only_show_adopted">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- End of Search filter form -->

                    </div>
                </div>
            </div>

            <!-- Simple animal information - contained in link to point to more info -->
            @foreach($animals as $animal)
                <a name="anchor{{$animal->id}}" href="{{URL::to('/')}}/animal/{{$animal->id}}" style="text-decoration:none !important; color: black; text-decoration:none;">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <!-- Finds images relating to specific animal -->
                            @foreach($images as $image)
                                @if ($animal->id == $image->animalid)
                                    <li class="list-group-item">
                                        <img class="img-responsive img-rounded" src="{{ 'data:image/*;base64,'.$image->image }}">
                                    </li>
                                @break
                                @endif
                            @endforeach
                        </div>
                        <div class="panel-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item " >
                                    <p class="panel-text">{{'Name: '}}{{$animal->name}}</p>
                                </li>
                                <li class="list-group-item ">
                                    <p class="panel-text">{{'Type: '}}{{$animal->type}}</p>
                                </li>
                                <li class="list-group-item ">
                                    <p class="panel-text">{{'Date of Birth:  '}}{{$animal->dateofbirth}}</p>
                                </li>

                                <!-- If animal is adopted the name of the user who adopted this animal is displayed -->
                                <li class="list-group-item ">
                                    @if (!$animal->adopted)
                                        <p class="panel-text">{{$animal->name.' is available for adoption :D'}}</p>
                                    @else
                                        @foreach ($users as $user)
                                            @if ($user->id == $animal->userid)
                                                <p class="panel-text">{{'Adopted by '}} {{$user->fname.' '.$user->lname}}</p>
                                            @endif
                                        @endforeach
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
            @endforeach
            <!-- End of animal information -->

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
