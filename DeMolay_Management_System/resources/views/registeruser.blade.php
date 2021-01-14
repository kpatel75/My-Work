@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add User') }}</div> 
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
                    <form method="POST" action="adduser" id="changePassword-form">
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
                            <label for="roles" class="col-md-4 col-form-label text-md-right">Role</label>
                            <div class="col-md-6">
                                <select name="roles" id="roles">
                                    @foreach ($roles as $item)
                                    <option value="{{$item->create_access_role_id}}" @if($item->create_access_role_id == old('roles'))selected="selected"@endif>{{$item->role_name}}</option>
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
                                    <option value="{{$item->id}}" @if($item->id == old('jurisdiction'))selected="selected"@endif>{{$item->description}}</option>
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

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label> 
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

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
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        error_log({{$message}});
                                    </span>
                                @enderror
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                            <input id="password" type="password" title="Password must contain at least 8 characters, including UPPER/lowercase, numbers and Special character"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,50}$"  class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password"
                                onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
                                if(this.checkValidity()) form.password_confirmation.pattern = RegExp.escape(this.value);">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                            <input id="password-confirm" type="password" title="Please enter the same Password as above" 
                                class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,50}$" 
                                name="password_confirmation" required autocomplete="password" 
                                onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
                            </div>
                        </div>

                       
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="passwordSubmitBtn">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="p-3 mb-2 bg-dark text-warning container col-md-6" > 
    <h6>Password Criteria</h6>
    <div id="all-done" class="panel"></div>
        <form id="new-password" class="visible">
            <ul>
                <li id="eight-plus" class="complete">Between 8 and 25 characters long.</li>
                <li id="uppercase" class="complete">Contains uppercase letters.</li>
                <li id="lowercase" class="complete">Contains lowercase letters.</li>
                <li id="numbers" class="complete">Contains numbers.</li>
                <li id="punctuation" class="complete">Contains special characters.</li>
            </ul>               
        </form>
    </div>
</div>
<script>
    var eightPlus = document.getElementById('eight-plus');
    var uppercase = document.getElementById('uppercase');
    var lowercase = document.getElementById('lowercase');
    var numbers = document.getElementById('numbers');
    var punctuation = document.getElementById('punctuation');
    var matchesPassword = document.getElementById('matches-password');

    var passwordInput = document.getElementById('password');
    var passwordForm = document.getElementById('new-password');

    var containsUppercase = /[A-Z]/;
    var containsLowercase = /[a-z]/;
    var containsNumbers = /[0-9]/;
    var containsPunctuation = /[^\w\s]|_/;

    function setForm() {
        eightPlus.classList.remove('complete');
        uppercase.classList.remove('complete');
        lowercase.classList.remove('complete');
        numbers.classList.remove('complete');
        punctuation.classList.remove('complete');
        passwordSubmitBtn.disabled = true;
    }

    passwordInput.addEventListener('input', function() {

        var value = passwordInput.value;

        // More than 8 characters
        if (value.length >= 8 && value.length <= 25)
        eightPlus.classList.add('complete');
        else
        eightPlus.classList.remove('complete');

        // Contains uppercase
        if (containsUppercase.test(value))
        uppercase.classList.add('complete');
        else
        uppercase.classList.remove('complete');

        // Contains lowercase
        if (containsLowercase.test(value))
        lowercase.classList.add('complete');
        else
        lowercase.classList.remove('complete');

        // Contains numbers
        if (containsNumbers.test(value))
        numbers.classList.add('complete');
        else
        numbers.classList.remove('complete');

        // Contains punctuation
        if (containsPunctuation.test(value))
        punctuation.classList.add('complete');
        else
        punctuation.classList.remove('complete');

        var passwordIsValid = (value.length >= 8) &&
            containsUppercase.test(value) &&
            containsLowercase.test(value) &&
            containsNumbers.test(value) &&
            containsPunctuation.test(value);
        passwordSubmitBtn.disabled = !passwordIsValid;
    });
</script>
<style>
    li{color:#ffffff}
    li:before {visibility: hidden;}
    li.complete {color: #F6CD25;}
</style> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
   let rolechange = document.getElementById('roles'); 

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
                $chapter.html('<option id="chapter-none" value="" selected>Select a chapter</option>');
                $.each(data, function(id, value) {
                    $chapter.append('<option value="'+id+'" >'+value+'</option>'); 
                    console.log(id);
                });
                $('#chapter').show(150);
            }
   }); 
   //console.log('test');
   }).change(); 
   
   });

</script>


@endsection 
