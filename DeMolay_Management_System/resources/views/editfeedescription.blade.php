@extends('layouts.app')

@section('content')
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-5'>
            <h3>Editting {{ $desc->description }}</h3>
            <div class='card'>
                <form method='POST' id='feeDescription' action='{{route('updateDescription')}}'>
                    @csrf
                    <div class='card-header'>
                        <div>Edit Description</div>
                    </div>
                    <div class='card-body'>
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class='alert alert-danger'>
                                <ul>
                                    @foreach($errors->all() as $bad)
                                        <li>{{ $bad }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class='form-group'>
                            <label for='id'>{{__('Id')}}</label>
                            <input name='id' id='id' type='text' class='form-control' value='{{ $desc->id }}' readonly>
                        </div>
                        <div class='form-group'>
                            <label for='description'>{{__('Description')}}</label>
                            <input id='description' name='description' type='text' class='form-control @error('description') is-invalid @enderror' value='{{ $desc->description }}'>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class='card-footer'>
                        <div class='form-row'>
                            <div class='col-md-6'>
                                <br>
                                <a class='btn btn-secondary' id='cancelBtn' href='{{ URL('feedescription') }}'>Cancel</a>
                            </div>
                            <div class='col-md-6'>
                                <br>
                                <button id='submitBtn' type='submit' class='btn btn-primary' onclick='return confirmation()'>Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    // Confirm before submitting form
    function confirmation() {
        if (confirm('Are you sure you want to submit it?')) {
            document.getElementById('feeDescription').submit();
        } else {
            return false;
        }
    }
</script>
@endsection