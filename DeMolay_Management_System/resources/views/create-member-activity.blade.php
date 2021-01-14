@extends('layouts.app')

@section('content')
<style>
    @media only screen and (max-width: 767px) {
  .mybtn {
    padding-left: 0 !important;
  }
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Activity For') }} {{$memberInfo->last_name}} {{$memberInfo->first_name}} </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif                
                    <form method="POST" action="{{route('store')}}">
                        @csrf
                        <div class="form-group row">
                            <input id='memberid' name='memberid' type='hidden' value='{{$memberInfo->id}}'>
                            <input id='advisorid' name='advisor' type='hidden' value='{{ Auth::id() }}'>
                            <label for="activity" class="col-md-4 col-form-label text-md-right">{{ __('Activity Type') }}</label>
                            
                            <div class="col-md-6">
                            <select id="activity" name="type_of_activityid" onchange='unitsTextBox(this)' class="form-control @error('type_of_activityid') is-invalid @enderror" value="{{ old('type_of_activityid') }}" required autofocus>
                            <option value="">Choose a activity type</option>
                            @foreach($typeOfActivityList as $data)
                                <option value="{{$data->id}}">{{$data->activity}}</option>
                            @endforeach
                            </select>
                                @error('activity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="no_of_hour" class="col-md-4 col-form-label text-md-right">{{ __('Hour') }}</label>

                            <div class="col-md-6">
                            <input id="no_of_hour" type="text" disabled="disabled" class="form-control" name="no_of_hour" value="{{ old('no_of_hour') }}" autofocus>

                                @error('no_of_hour')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="point" class="col-md-4 col-form-label text-md-right">{{ __('Point') }}</label>

                            <div class="col-md-6">
                            <input id="point" type="text" disabled="disabled" class="form-control" name="point" value="{{ old('point') }}" autofocus>

                                @error('point')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mile" class="col-md-4 col-form-label text-md-right">{{ __('Kilometer') }}</label>

                            <div class="col-md-6">
                            <input id="mile" type="text" disabled="disabled" class="form-control" name="mile" value="{{ old('mile') }}" autofocus>

                                @error('mile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="note" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="note" id="note" cols="" rows="5" placeholder="Optional" autofocus></textarea>

                                @error('note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autofocus>

                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>       

                        <div class="form-group mybtn pl-3">
                            <button type="submit" class="btn btn-primary offset-md-4">{{ __('Submit') }}</button>
                            <a class='btn btn-secondary' role="button" href='{{ URL('/memberprofile', ['id' => $memberInfo->id])}}'>Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function unitsTextBox(val){
        var selectedValue = val.options[val.selectedIndex].value;
        var hourTextBox = document.getElementById('no_of_hour');
        var pointTextBox = document.getElementById('point');
        var mileTextBox = document.getElementById('mile');
        hourTextBox.disabled = selectedValue == 3 || selectedValue == 7 || selectedValue == 11 || selectedValue == 12 ? false : true;
        pointTextBox.disabled = selectedValue == 16 ? false : true;
        mileTextBox.disabled = selectedValue == 19 ? false : true;
        
        if(!hourTextBox.disabled || !pointTextBox.disabled || !mileTextBox.disabled)
            hourTextBox.focus();
            pointTextBox.focus();
            mileTextBox.focus();
    }
</script>
@endsection