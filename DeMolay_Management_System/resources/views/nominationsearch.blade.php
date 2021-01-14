@extends('layouts.app')
@section('styles')

@endsection
@section('content')  
    <div class="container">
        <form method="POST" action="">
            @csrf 
            <div class="form-group row">
                <label for="dateawarded" class="col-md-4 col-form-label text-md-right">{{ __('Search for a member') }}</label> 
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
        </form>
    </div>
@endsection