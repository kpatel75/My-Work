@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update') }}</div> 
                <!-- Error Message-->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                 
                
                <div class="card-body">
                    <form method="POST" action="{{url('commituserupdate')}}" id="changePassword-form">
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
                        <input style="display:none" id="id" name="id" value="{{$users->id}}"/>
                        @if($users->id != Auth::user()->id)
                        <div class="form-group row"> 
                            <label for="roles" class="col-md-4 col-form-label text-md-right">Role</label>
                            <div class="col-md-6">
                                <select name="roles" id="roles">
                                    @foreach ($roles as $item)
                                    <option id="{{$item->create_access_role_id}}" value="{{$item->create_access_role_id}}" @if($item->create_access_role_id == old('roles')) selected="selected" @elseif( $item->create_access_role_id == $users->role_id)selected="selected"@endif>{{$item->role_name}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        <!--Jurisdiction Select-->
                        <div class="form-group row" id="jurisdiction-container"> 
                            <label for="roles" class="col-md-4 col-form-label text-md-right">Jurisdiction</label>
                            <div class="col-md-6">
                                <select name="jurisdiction" id="jurisdiction"> 
                                    <option id="jurisdiction-none" value="">Select a Jurisdiction</option>
                                    @foreach ($jurisdiction as $item)
                                    <option value="{{$item->id}}" @if($item->id == old('jurisdiction') || $item->id == $users->jurisdiction_id)selected="selected"@endif>{{$item->description}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        <!--Chapter Select-->
                        <div class="form-group row" id="chapter-container"> 
                            <label for="chapter" class="col-md-4 col-form-label text-md-right">Chapter</label>
                            <div class="col-md-6">
                                <select name="chapter" id="chapter"> 
                                    <option value="">Select a jurisdiction first</option>
                                </select> 
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label> 
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="@if(old('first_name') == null){{$users->first_name}}@else{{ old('first_name') }}@endif"  @if(Auth::user()->id != $users->id)disabled @endif autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong> 
                                        error_log({{$message}});
                                
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="@if(old('last_name') == null){{$users->last_name}}@else{{ old('last_name') }}@endif" @if(Auth::user()->id != $users->id)disabled @endif autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        error_log({{$message}});
                                    </span>
                                @enderror
                            </div>
                    </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@if(old('email') == null){{$users->email}}@else{{ old('email') }}@endif" required autocomplete="email"  @if(Auth::user()->id != $users->id)disabled @endif>

                                @error('email')
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
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
   let rolechange = document.getElementById('roles'); 
   let chapterValue = JSON.parse("{{ json_encode($users->chapter_id) }}");  

  
    console.log("CV: "+chapterValue);
    rolechange.onchange = displayJurisdiction;  
    window.onload = displayJurisdiction;

    function displayJurisdiction(e)
   {    
      
       let jurisdiction =  document.getElementById('jurisdiction-container'); 
       let chapter = document.getElementById('chapter-container');
       
       if(rolechange.value > 7)
       {
           jurisdiction.hidden = false;  
           chapter.hidden = false;
           
       }  
       else if(rolechange.value == 7)
       {
            jurisdiction.hidden = false;  
           chapter.hidden = true;
           document.getElementById('chapter-none').selected = true;
       }
       else
       {
           jurisdiction.hidden = true;  
           chapter.hidden = true; 
           document.getElementById('chapter-none').selected = true;
           document.getElementById('jurisdiction-none').selected = true;

       }
   } 
   $(document).ready(function() {
   $('#jurisdiction').change(function() { 
    var $chapter = $('#chapter'); 
    var $jur = document.getElementById('jurisdiction').value;
    $.ajax({
            url: "{{ route('getchapters') }}/" + $jur,
            success: function(data) { 
                console.log(data);
                $chapter.html('<option id="chapter-none" value="null" selected>Select a chapter</option>');
                $.each(data, function(id, value) { 
                    if(chapterValue == id)
                    {
                    $chapter.append('<option id="chapter'+id+'"value="'+id+'" selected>'+value+'</option>'); 
                    console.log(id);
                    } 
                    else
                    {
                        $chapter.append('<option id="chapter'+id+'"value="'+id+'">'+value+'</option>'); 
                    console.log(id);
                    }
                });
                $('#chapter').show(150);
            }
   }); 
   //console.log('test');
   }).change(); 
   
   });

</script>


@endsection 
