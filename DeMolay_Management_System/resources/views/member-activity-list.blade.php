@extends('layouts.app')

@section('content')
    <div class="container table-responsive mt-5">
        <h2>Activity List</h2>
        @if (count($activityInfo) > 0)
            <table class="table table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">Activity ID</th>
                        <th scope="col">Activity Type</th>
                        <th scope="col">Hour</th>
                        <th scope="col">Point</th>
                        <th scope="col">Mile</th>
                        <th scope="col">Note</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activityInfo as $data)
                    <tr>
                        <td scope="row">{{ $data->type_of_activityid }}</td>
                        <td>{{ $data->activity }}</td>
                        <td>{{ $data->no_of_hour }}</td>
                        <td>{{ $data->point }}</td>
                        <td>{{ $data->mile }}</td>
                        <td>{{ $data->note }}</td>
                        <td>{{ $data->last_name }}, {{ $data->first_name }}</td>
                        <td>{{ $data->date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <br>
            <div class="alert alert-danger" role="alert">Unable to find any activities for this Member.</div>
        @endif
        <div class="d-flex justify-content-center">
            {!! $activityInfo->links() !!}
        </div>

        <div class="form-group mybtn offset-md-5">
            <a class='btn btn-primary' role="button" href='{{ URL('/memberprofile', ['id' => $memberInfo->id])}}'>Cancel</a>
        </div>

    </div>
@endsection
