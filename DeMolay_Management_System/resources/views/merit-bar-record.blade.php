@extends('layouts.app')

@section('content')

<div class="container table-responsive mt-5">
        <h2>Merit Bar List</h2>
        @if (count($activityArr) > 0)
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th scope="col">Activity Type</th>
                        <th scope="col">White (1st Award)</th>
                        <th scope="col">Red (2nd Award)</th>
                        <th scope="col">Blue (3rd Award)</th>
                        <th scope="col">Purple (4th Award)</th>
                        <th scope="col">Gold (5th Award)</th>
                    </tr>
                </thead>
                <tbody>
                
                    @if(count($activityArr) > 0)
                        @foreach($activityArr as $key => $activity)
                            <tr>
                                <th scope="row">{{$key}}</td>
                                <td>{{ $activity['award1'] }}</td>
                                <td>{{ $activity['award2'] }}</td>
                                <td>{{ $activity['award3'] }}</td>
                                <td>{{ $activity['award4'] }}</td>
                                <td>{{ $activity['award5'] }}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        @else
            <br>
            <div class="alert alert-danger" role="alert">Unable to find any merit bar record's for this Member.</div>
        @endif
    </div>

@endsection