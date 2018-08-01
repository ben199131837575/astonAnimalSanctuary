@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel {{$message['panelColour']}}">
                <div class="panel-heading">
                    <h4>{{$message['heading']}}</h4>
                </div>
                <div class="panel-body">
                    {{$message['body']}}
                    @if($message['button'])
                        <a class="btn {{ $message['buttonColour'] }} btn-lg btn-block" href="{{ $message['buttonLink'] }}">
                            {{ $message['buttonText'] }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
