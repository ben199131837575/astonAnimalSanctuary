@extends('layouts.app')

@section('content')

@foreach ($users as $user)
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <!-- User information panel -->
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>User ID: [ {{$user->id}} ]</strong></div>
                    <div class="panel-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <p class="panel-text"><strong>Name:</strong>{{$user->fname.' '.$user->lname}}</p>
                            </li>
                            <li class="list-group-item">
                                <p class="panel-text"><strong>Email:</strong>{{$user->email}}</p>
                            </li>
                            <li class="list-group-item">
                                <p class="panel-text"><strong>Staff?</strong>{{($user->staff ? 'Yes' : 'No')}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End of user information panel -->
                
            </div>
        </div>
    </div>
@endforeach


@if (!count($users))
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
