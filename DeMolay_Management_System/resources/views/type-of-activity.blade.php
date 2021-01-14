@extends('layouts.app')

@section('content')

<style>
    @media only screen and (max-width: 767px) {
  .mybtn {
    padding-left: 0 !important;
  }
}
</style>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Activity Type') }}</div>

                <div class="card-body">
                @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif 
                    <form method="POST" action="/type-of-activity">
                        @csrf

                        <div class="form-group row">
                            <label for="activity" class="col-md-4 col-form-label text-md-right">{{ __('New Activity Type') }}</label>

                            <div class="col-md-6">
                                <input id="activity" type="text" class="form-control" name="activity" value="{{ old('activity') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group mybtn pl-3">
                            <button type="submit" class="btn btn-primary offset-md-4">{{ __('Submit') }}</button>
                            <a class='btn btn-secondary' role="button" href='{{ URL('/home')}}'>Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection