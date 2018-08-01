@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Auth::user() && Auth::user()->staff && !$personal )
                <h4>User Adoption Requests: </h4><br>
                <div class="btn-group" role="group">
                    <a class="btn btn-primary" type="button" href="{{ route('adoptionRequests', 'all') }}">
                        All
                    </a>
                    <a class="btn btn-primary" type="button" href="{{ route('adoptionRequests', 'pending') }}">
                        Pending
                    </a>
                    <a class="btn btn-danger" type="button" href="{{ route('adoptionRequests', 'denied') }}">
                        Denied
                    </a>
                    <a class="btn btn-success" type="button" href="{{ route('adoptionRequests', 'accepted') }}">
                        Accepted
                    </a>
                </div>
            @endif
            <h3> {{ucwords($type)}}: </h3><br>

            @foreach ($adoptionRequests as $adoptionRequest)
                @if ($adoptionRequest->type == 'accepted')
                    <div class="panel panel-success">
                @elseif ($adoptionRequest->type == 'denied')
                    <div class="panel panel-danger">
                @else
                    <div class="panel panel-primary">
                @endif


                <div class="panel-heading"><h4><strong>Adoption Request ID: [ {{$adoptionRequest->id}} ]</strong><h4></div>

                <div class="panel-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <p class="panel-text"><strong>Reason for wanting to adopt animal:</strong><br>{{$adoptionRequest->reason}}</p>
                        </li>
                        @if($adoptionRequest->other_animals)
                            <li class="list-group-item">
                                <p class="panel-text"><strong>Other animals owned:</strong><br>{{$adoptionRequest->other_animals}}</p>
                            </li>
                        @endif()
                        <li class="list-group-item">
                            <p class="panel-text"><strong>Request State:</strong><br>{{$adoptionRequest->type}}</p>
                        </li>

                        <br>
                        @if ($users)
                            @foreach($users as $user)
                                @if ($user->id == $adoptionRequest->userid)
                                    <p class="panel-text"><strong>User ID: [ {{ $user->id }} ]</strong></p>
                                    <li class="list-group-item">
                                        <p class="panel-text"><strong>Name: </strong>{{$user->fname.' '.$user->lname}}</p>
                                    </li>
                                    <li class="list-group-item">
                                        <p class="panel-text"><strong>Email: </strong>{{$user->email}}</p>
                                    </li>
                                    <li class="list-group-item">
                                        <p class="panel-text"><strong>Staff? </strong>{{($user->staff ? 'Yes' : 'No')}}</p>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                        <br>
                        @foreach($animals as $animal)
                            @if ($animal->id == $adoptionRequest->animalid)
                                <p class="panel-text"><strong>Animal ID: [ {{ $animal->id }} ]</strong></p>
                                <li class="list-group-item">
                                    <p class="panel-text"><strong>Name: </strong>{{$animal->name}}</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="panel-text"><strong>Date of Birth: </strong>{{$animal->dateofbirth}}</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="panel-text"><strong>Type: </strong>{{$animal->type}}</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="panel-text"><strong>Gender: </strong>{{$animal->gender}}</p>
                                </li>
                                <li class="list-group-item">
                                    <a class="btn btn-primary btn-lg btn-block" href="{{route('animal',$adoptionRequest->animalid)}}">
                                        See more about {{$animal->name}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        @if ($adoptionRequest->userid != Auth::user()->id && Auth::user()->staff)
                            <li class="list-group-item">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-success" type="button" href="{{ route('denyOrAccept', ['accept',$adoptionRequest->id]) }}">
                                        Accept
                                    </a>
                                    <a class="btn btn-danger" type="button" href="{{ route('denyOrAccept','deny/'.$adoptionRequest->id) }}">
                                        Deny
                                    </a>
                                </div>
                            </li>
                        @endif
                        </ul>
                    </div>
                </div>
                <br><br><br><br>
            @endforeach

        </div>
    </div>
</div>

@if (!count($adoptionRequests))
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
