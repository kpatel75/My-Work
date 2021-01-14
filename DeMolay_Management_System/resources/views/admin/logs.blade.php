@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection
@section('content')  
    <div class="container">
        <h1>Activity Logs</h1> 
        <table class="table table-bordered table-striped data-table" data-order='[[ 0, "asc" ]]' data-page-length='25'>
            <thead>
                <tr>
                    <th>Date</th> 
                    <th>Action</th> 
                    <th>Log Message</th> 
                    <th>URL</th> 
                    <th>Member Affected</th> 
                    <th>User ID</th> 
                    <th>User First Name</th>
                    <th>User Last Name</th>
                </tr>
            </thead> 
            <tbody>
                @foreach($logitems as $item)
                    <tr>
                        <td>{{$item->created_at}}</td> 
                        <td>{{$item->action}}</td> 
                        <td>{{$item->activity}}</td> 
                        <td>{{$item->url}}</td> 
                        <td><a href="{{url('memberprofile').'/'.$item->affected_member_id}}">@if($item->affected_member_id != null){{str_pad($item->affected_member_id, 5, "0", STR_PAD_LEFT ) }}@endif</a></td> 
                        <td>{{$item->user_id}}</td> 
                        <td>{{$item->user_first_name}}</td>
                        <td>{{$item->user_last_name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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