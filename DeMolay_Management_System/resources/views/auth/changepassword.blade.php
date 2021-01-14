@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>

                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    <form class="form-horizontal"  id="changePassword-form" method="POST" action="{{ route('changePassword') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                            <label for="new-password" class="col-md-4 control-label">Current Password</label>

                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control" name="current-password" required>

                                @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                            <label for="new-password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                            <input id="new-password" type="password" title="Password must contain at least 8 characters, including UPPER/lowercase, numbers and Special character" 
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,50}$" class="form-control @error('password') is-invalid @enderror" 
                                name="new-password" required autocomplete="new-password" 
                                onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
                                if(this.checkValidity()) form.password_confirmation.pattern = RegExp.escape(this.value);">

                                @if ($errors->has('new-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>

                            <div class="col-md-6">
                            <input id="new-password-confirm" type="password" title="Please enter the same Password as above" 
                                class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,50}$" 
                                name="new-password_confirmation" required autocomplete="new-password" 
                                onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                    <br/>
                    <div class="p-3 mb-2 bg-dark text-warning" >
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

                        var passwordInput = document.getElementById('new-password');

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
