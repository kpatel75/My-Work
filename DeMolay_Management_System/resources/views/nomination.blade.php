@extends('layouts.app')
@section('styles')

@endsection
@section('content') 
<div class="container">  
    <h1>Honor Nominations</h1> 
    <div class="card mb-3">
    <form method="POST" action="{{url('autocomplete')}}" class="p-3"> 
        @csrf
        <div class="form-group row">
            <label for="memberid" class="col-md-4 col-form-label text-md-right">{{ __('Search Recipient') }}</label> 
            <div class="col-md-6">
                <input id="fullname" name="fullname" type="text" class="form-control @error('fullname') is-invalid @enderror"  value="{{ old('fullname') }}"required autofocus>

                @error('dateawarded')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> 
                        error_log({{$message}});
                
                    </span>
                @enderror
            </div>
        </div> 
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-info" id="passwordSubmitBtn">
                    {{ __('Search') }}
                </button>
            </div>
        </div>
    </form> 
    @if($search != null)
        <table class="table bordered-table">
            <tr>
                <th>First Name</th> 
                <th>Last Name</th> 
            </tr> 
            @foreach($search as $item) 
            <tr>
                <td>{{$item->first_name}}</td>
                <td>{{$item->last_name}}</td> 
                <td><a href="{{url('nominations').'/'.$item->id}}">Add Nomination</a></td>
            </tr> 
            @endforeach
        </table>
    @endif
    </div>  
    <div class="card" @if($member->id == null) style="display:none" @endif>  
    <h3 class="m-3">Nomination Information</h3>    
    <form method="POST" class="m-4" action="{{url('savenomination')}}"> 
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
            <label for="memberid" class="col-md-4 col-form-label text-md-right">{{ __('Member ID') }}</label> 
            <div class="col-md-6">
                <input id="memberid" name="memberid" type="text" class="form-control @error('memberid') is-invalid @enderror" name="dateawarded" value="@if($member->id == null){{ old('memberid') }}@else {{$member->id}}@endif" required autocomplete="dateawarded" autofocus>

                @error('dateawarded')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> 
                        error_log({{$message}});
                
                    </span>
                @enderror
            </div>
        </div> 
        <div class="form-group row">
            <label for="dateawarded" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label> 
            <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value='@if($member->id == null){{ old('memberid') }}@else {{$member->first_name.' '.$member->last_name}}@endif' required autocomplete="name" autofocus>

                @error('dateawarded')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> 
                        error_log({{$message}});
                
                    </span>
                @enderror
            </div>
        </div> 
        <div class="form-group row" id="chapter-container"> 
            <label for="chapter" class="col-md-4 col-form-label text-md-right">Honor Awarded</label>
            <div class="col-md-6">
                <select name="honor" id="honor"> 
                    <option value="0">Select an Honor Nomination</option> 
                    @foreach($awards as $item)
                        <option id="{{$item->id}}" value="{{$item->id}}">{{$item->description}}</option>
                    @endforeach
                </select> 
            </div>
        </div>
        <div class="form-group row">
            <label for="dateawarded" class="col-md-4 col-form-label text-md-right">{{ __('Date Awarded') }}</label> 
            <div class="col-md-6">
                <input id="dateawarded" type="date" class="form-control @error('date_awarded') is-invalid @enderror" name="dateawarded" value="{{ old('dateawarded') }}" required autocomplete="dateawarded" autofocus>

                @error('dateawarded')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> 
                        error_log({{$message}});
                
                    </span>
                @enderror
            </div>
        </div> 
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary" id="passwordSubmitBtn">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </form>
</div>
</div>



@endsection