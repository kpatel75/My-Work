@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                <p class="login-card-description"><b>Reset password</b></p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden"  name="token" value="{{ $request->route('token') }}">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $request->email }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                            <input id="password" type="password" title="Password must contain at least 8 characters, including UPPER/lowercase, numbers and Special character"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,25}$"  class="form-control @error('password') is-invalid @enderror" 
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
                                class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" 
                                name="password_confirmation" required autocomplete="new-password" 
                                onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" name="reset" id="reset" class="btn btn-dark">
                                    {{ __('Update') }}
                                </button>

                            </div>
                        </div>
                    </form>
                    <br/>
                    <div class="p-3 mb-2 bg-dark text-warning" >
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
