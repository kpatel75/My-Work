@extends('layouts.app')
@section('content')  
    <div class="container">
        <a class="btn btn-secondary" href="{{url('memberprofile').'/'.$id}}">Back</a>
    <div class="row justify-content-center mb-5">
        <h1>Add Merit Bar</h1> 
       
    </div> 
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form method="POST" action="{{route('addmeritbarrecord')}}"> 
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
        <input name="id" id="id" value = "{{$id}}"  style="display:none"/>
        <div class="form-group row"> 
            <label for="roles" class="col-md-4 col-form-label text-md-right">Activity</label>
            <div class="col-md-6">
                <select name="activity" id="activity" value="{{ old('activity') }}">
                    @foreach ($activities as $item)
                    <option value="{{$item->id}}" @if(old('activity') == $item->id) selected="selected" @endif>{{$item->activity}}</option>
                    @endforeach
                </select> 
            </div>
        </div>
        <div class="form-group row"> 
            <label for="roles" class="col-md-4 col-form-label text-md-right">Merit</label>
            <div class="col-md-6">
                <select name="meritBar" id="meritBar" value="{{ old('meritBar') }}">
                    @foreach ($meritBar as $item)
                    <option value="{{$item->id}}" @if(old('meritBar') == $item->id) selected="selected" @endif>{{$item->description}}</option>
                    @endforeach
                </select> 
            </div>
        </div>
        <div class="form-group row"> 
            <label for="roles" class="col-md-4 col-form-label text-md-right">Date Achieved</label>
            <div class="col-md-3">
               <input  name="date_achieved" class="form-control" type="date"  value="{{ old('date_achieved') }}" required/>
            </div>
        </div> 
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-6">
                <button type="submit" class="btn btn-primary" id="passwordSubmitBtn">
                    {{ __('Add') }}
                </button>
            </div>
        </div>
    </form>
    </div>
@endsection