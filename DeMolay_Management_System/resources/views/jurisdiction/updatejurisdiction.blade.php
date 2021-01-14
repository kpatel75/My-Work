@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                {{__('Add Jurisdiction')}}
            </div> 
            <form method="POST" action="{{route('viewjurisdiction')}}" class="p-4" id="updateJurisdiction"> 
                @csrf
                @if(session()->has('message'))
                <div class="alert alert-success">
                    <h4>{{ session()->get('message') }}</h4>
                </div> 
                @endif
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @endif
                @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                   
                </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-warning">
                    {{ session()->get('error') }}
                </div>
                @endif
                <div class="form-group row">
                    <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>

                    <div class="col-md-6">
                        <input id="iddisplay" type="text" class="form-control" name="iddisplay" value="{{ $jurisdiction->id }}" disabled>

                        <input id="id" type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ $jurisdiction->id }}" 
                        hidden>

                        @error('id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                error_log({{$message}});
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                    <div class="col-md-6">
                        <input id="description" type="input" class="form-control @error('descriptiion') is-invalid @enderror" name="description" @if($jurisdiction->description == null) value="{{old('description')}}" @else value="{{$jurisdiction->description}}"@endif required>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                error_log({{$message}});
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row" id="country container"> 
                    <label for="roles" class="col-md-4 col-form-label text-md-right">Country</label>
                    <div class="col-md-6">
                        <select name="country" id="country"> 
                            <option id="country-none" value="">Select a Country</option>
                            @foreach ($countries as $item)
                        <option id="{{$item->id}}" value="{{$item->id}}" @if($item->id == $jurisdiction->country_id)selected="selected"@endif>{{$item->country_name}}</option>
                            @endforeach
                        </select> 
                    </div>
                </div> 
                
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary" id="passwordSubmitBtn">
                            @if($jurisdiction->description == null) Add @else {{ __('Update') }}@endif
                        </button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>


@endsection