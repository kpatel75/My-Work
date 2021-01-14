@extends('layouts.app')

@section('content') 

<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                {{__('Add Chapter')}}
            </div> 


            <form method="POST" action="{{url('commitchapterupdate')}}" id="addchapterform" class="p-4" > 
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
                <!--Chapter Name--> 
           
                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Chapter Name') }}</label> 
                    <div class="col-md-6">
                        <input id="description" type="text" class="form-control @error('chapter-name') is-invalid @enderror" name="description" value="{{$chapter->description}}" required autofocus>

                        @error('chapter-name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong> 
                                error_log({{$message}});
                        
                            </span>
                        @enderror
                    </div>
                </div> 
                <!--End Chapter Name-->
                <div class="form-group row">
                    <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label> 
                    <div class="col-md-6">
                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{$chapter->location}}" required autofocus>

                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong> 
                                error_log({{$message}});
                        
                            </span>
                        @enderror
                    </div>
                </div> 


                <!--Jurisdiction-->
                <div class="form-group row" id="chapter-container"> 
                    <label for="jurisdiction" class="col-md-4 col-form-label text-md-right">Jurisdiction</label>
                    <div class="col-md-6">
                        <select name="jurisdiction" id="jurisdiction"> 
                            @foreach($jurisdiction as $item)
                                <option value="{{$item->id}}"@if($item->id == $chapter->jurisdiction_id)selected="selected" @endif>{{$item->description}}</option> 
                            @endforeach
                            
                        </select> 
                    </div>
                </div> 
                <!--End Jurisdiction--> 
                <div class="row justify-content-center mb-3">
                    <button type="submit" class="btn btn-primary">@if($chapter->id == null)Add Chapter @else Update Chapter @endif</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection 