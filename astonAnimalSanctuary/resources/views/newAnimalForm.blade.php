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
              <form method="POST" action="{{ route('addNewAnimal') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Animal Name:') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="" placeholder="name" required>
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
                        <input id="dateofbirth" type="date" class="form-control" name="dateofbirth" value="" placeholder="dateofbirth" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-4 col-form-label text-md-right">{{ __('Animal Description:') }}</label>
                    <div class="col-md-6">
                        <textarea id="description" type="date" class="form-control" name="description" value="" placeholder="description" required></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image_upload" class="col-sm-4 col-form-label text-md-right">{{ __('Select Images to upload:') }}</label>
                    <div class="col-md-6">
                        <input id="image_upload" type="file" name="image_upload[]" accept="image/*" multiple required>
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
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

@endsection
