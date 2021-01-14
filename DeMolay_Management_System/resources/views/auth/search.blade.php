@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>Search Member</strong></div>
                <div class="card-body">
                </div>
            </div>

            <table class="table table-bordered table-striped data-table" data-order='[[ 0, "asc" ]]' data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Position</th>
                        <th scope="col">
                            <div>
                            <a href="{{ route('memberlistreport') }}" class="btn btn-success">View Report</a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr>
                        <td>{{$member->id}}</td>                      
                        <td>{{$member->first_name}}</td>
                        <td>{{$member->last_name}}</td>
                        <td>{{$member->email}}</td>
                        <td>{{ $member->position_name }}</td>
                        <td> <a href="{{url('memberprofile').'/'.$member->id}}" class="btn btn-success mr-2">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script> 
    $(document).ready( function () {
        $('.data-table').DataTable({
            processing: true, 
            //serverSide: true,
            retrieve: true
        });
        });
</script>
@endsection