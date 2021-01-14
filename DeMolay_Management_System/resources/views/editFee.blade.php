@extends('layouts.app')

@section('content')
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <div class='card'>
                <div class='card-header'>
                    <h4>Editing {{ $feeInfo->description }} ({{ $feeInfo->year }})</h4>
                </div>
                <form id='editFeeForm' method='POST' action='{{route('updateFee')}}'>
                    @csrf
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
                                @foreach($errors->all() as $bad)
                                    <p>{{ $bad }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class='form-group'>
                            <label>{{ __('Fee Id') }}</label>
                            <input type='text' name='id' id='id' value='{{ $feeInfo->id }}' class='form-control' readonly>
                        </div>
                        <div class='form-group'>
                            <label>{{ __('Amount') }}</label>
                            <input type='text' name='amount' id='amount' value='{{ number_format($feeInfo->amount, 2, '.', ',') }}' class='form-control @error('amount') is-invalid @enderror'>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='demolay'>{{__('Contribution to DeMolay')}}</label>
                            <input type='text' id='demolay' name='demolay' class='form-control @error('demolay') is-invalid @enderror' value={{ number_format($feeInfo->demolay_contribution, 2, '.', ',') }}>
                            @error('demolay')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='chapter'>{{__('Contribution to Chapter')}}</label>
                            <input type='text' id='chapter' name='chapter' class='form-control @error('chapter') is-invalid @enderror' value={{ number_format($feeInfo->chapter_contribution, 2, '.', ',') }}>
                            @error('chapter')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class='form-row'>
                            <label for='descriptionSelect'>{{ __('Description') }}</label>
                            <select id='descriptionSelect' name='descriptionSelect' class='form-control @error('descriptionSelect') is-invalid @enderror' disabled>
                                <option value=''>{{__('Select Description...')}}</option>
                                @foreach ($descriptionInfo as $info)
                                    @if ($feeInfo->description == $info->description)
                                        <option value='{{ $info->id }}' selected>{{ $info->description }}</option>
                                    @else
                                        <option value='{{ $info->id }}'>{{ $info->description }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('descriptionSelect')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label>{{ __('Year') }}</label>
                            <input type='hidden' id='hidden-year' name='hidden-year' value='{{ $feeInfo->year }}'>
                            <select name='year' id='year' class='form-control @error('year') is-invalid @enderror'></select>
                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type='hidden' name='edited_by_id' id='edited_by_id' value='{{ Auth::id() }}'>
                        <input type='hidden' name='edited_by_first_name' id='edited_by_first_name' value='{{ Auth::user()->first_name }}'>
                        <input type='hidden' name='edited_by_last_name' id='edited_by_last_name' value='{{ Auth::user()->last_name }}'>
                    </div>
                    <div class='card-footer'>
                        <div class='form-row'>
                            <div class='col-md-6'>
                                <br>
                                <a class='btn btn-secondary' id='cancelBtn' href='{{ URL('/fees')}}'>Cancel</a>
                            </div>
                            <div class='col-md-6'>
                                <br>
                                <button id='submitBtn' type='submit' class='btn btn-primary' onclick='return confirmation()'>Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Confirm before submitting 
    function confirmation() {
        if (confirm('Are you sure?')) {
            document.getElementById('editFeeForm').submit();
        } else {
            return false;
        }
    }

    // This automatically fills up the year dropdown list and would select the current year
    var min = new Date().getFullYear() - 10;
    var max = new Date().getFullYear() + 10;
    var select = document.getElementById('year');
    var year = document.getElementById('hidden-year').value;

    if (year < min) {
        min = year;
    }

    for (var i = min; i <= max; i++) {
        var opt = document.createElement('option');
        opt.value = i;
        opt.innerHTML = i;
        if (year == opt.value) {
            opt.setAttribute('selected', '');
        }
        select.appendChild(opt);
    }
</script>
@endsection