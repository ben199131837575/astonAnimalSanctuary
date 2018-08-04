@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Animal
                </div>
                <div class="panel-body" >
                    <div class="card-body bg-light">

                        <!-- Form for adding new animals -->
                        <form method="POST" action="{{ route('addNewAnimal') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Animal Name:') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="name" required>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-4 col-form-label text-md-right">{{ __('Animal Type') }}</label>
                                <div class="col-md-6">
                                    <select id="type" name="type" class="form-control" required>
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
                                <label for="gender" class="col-sm-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                                <div class="col-md-6">
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="" selected disabled hidden>{{''}}</option>
                                        <option value="male">{{ __('Male') }}</option>
                                        <option value="female">{{ __('Female') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dateofbirth" class="col-sm-4 col-form-label text-md-right">{{ __('Date of Birth:') }}</label>
                                <div class="col-md-6">
                                    <input id="dateofbirth" type="date" class="form-control" name="dateofbirth" value="{{old('dateofbirth') }}" placeholder="dateofbirth" required>
                                </div>
                                @if ($errors->has('dateofbirth'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dateofbirth') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label text-md-right">{{ __('Animal Description:') }}</label>
                                <div class="col-md-6">
                                    <textarea id="description" type="date" class="form-control" name="description" value="{{ old('description') }}" placeholder="description" required></textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image_upload" class="col-sm-4 col-form-label text-md-right">{{ __('Select Images to upload:') }}</label>
                                <div class="col-md-6">
                                    <input id="image_upload" type="file" name="image_upload[]" accept="image/*" multiple required>
                                    @if ($errors->has('image_upload'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image_upload') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Animal') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- End of new animal form -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
