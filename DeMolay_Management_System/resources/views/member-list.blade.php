@extends('layouts.app')

@section('content')

<div class="container table-responsive mt-5">
    <h2>Member List</h2>
    @if (isset($members) || count($member) <= 0)
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-success">
                    <th scope="col">Member ID</th>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $item)
                <tr>
                    <th scope="row">{{ sprintf('%05d', $item->id) }}</th>
                    <td>{{ $item->last_name }}, {{ $item->first_name }}</td>
                    <td><a href='{{ URL('/create-member-activity', ['id' => $item->id]) }}'>Add Activity</a></td>
                    <td><a href='{{ URL('/member-activity-list', ['id' => $item->id]) }}'>View Activities</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-danger" role="alert">Unable to find any members.</div>
    @endif
    <div class="d-flex justify-content-center">
            {!! $members->links() !!}
    </div>
</div>

@endsection