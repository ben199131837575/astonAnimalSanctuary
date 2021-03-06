@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Detailed information panel on a specific animal -->
            <div class="panel panel-info">
                <div class="panel-heading"><strong><h3>{{ $animal->name }}</h3></strong></div>
                <div class="panel-body">
                    <p class="panel-text"><h4>Info:</h4></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p class="panel-text">Type: {{ $animal->type }}</p>
                        </li>
                        <li class="list-group-item">
                            <p class="panel-text">Gender: {{$animal->gender}}</p>
                        </li>
                        <li class="list-group-item">
                            <p class="panel-text">Date of Birth: {{ $animal->dateofbirth}}</p>
                        </li>
                        <li class="list-group-item">
                            @if (!$animal->adopted)
                                <p class="panel-text">{{$animal->name.' is available for adoption :D'}}</p>
                            @else
                                <p class="panel-text">{{'Adopted by '}} <a href="{{route('user',$user->id)}}"> <u>{{$user->fname.' '.$user->lname}}</u></a></p>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <p class="panel-text">Description: <br>{{ $animal->description }}</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- If the animal is not adopted a button linking a user to an adoption form -->
            @if ($animal->adopted == 0)
                <div class="panel panel-info">
                    <div class="panel-heading"> Would you like to adopt {{$animal->name}}?</div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="{{URL::to('/').'/adoptionRequestForm/'.$animal->id}}">
                            Click here to fill out an adoption form for {{ $animal->name}}!
                        </a>
                    </div>
                </div>
            @endif

            <!-- All the images for the animal displayed here -->
            @foreach ($images as $image)
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <img class="img-responsive img-rounded" src="{{ 'data:image/*;base64,'.$image->image }}" >
                    </div>
                </div>
            @endforeach

            <!-- If the animal is not adopted a button linking a user to an adoption form -->
            @if ($animal->adopted == 0 && count($images) > 1)
                <div class="panel panel-info">
                    <div class="panel-heading"> Would you like to adopt {{$animal->name}}?</div>
                    <div class="panel-body">
                        <a class="btn btn-primary btn-lg btn-block" href="{{URL::to('/').'/adoptionRequestForm/'.$animal->id}}">
                            Click here to fill out an adoption form for {{ $animal->name}}!
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>




@endsection
