@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-between m-2">
            <h2>{{__('Users')}}</h2>
        <a href="createuser" class="btn btn-success">Add User</a>
    </div>
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>      
        @endif
        @if(session()->has('message'))
        <div class="alert alert-success">
            <h4>{{ session()->get('message') }}</h4>
        </div> 
        @endif
        @if ($errors->has('email'))
        <div class="alert alert-danger">
            {{ $errors->first('email') }}
           
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-warning">
            {{ session()->get('error') }}
        </div>
        @endif
        <hr/>
        <table  class="table table-bordered table-striped data-table" data-order='[[ 0, "asc" ]]' data-page-length='25'> 
            <thead>  
                <th>Role</th> 
                <th>First Name</th> 
                <th>Last_Name</th> 
                <th>Email</th> 
                <th>Jurisdiction</th>
                <th>Chapter</th> 
                <th></th>
            </thead> 
            <tbody>
                @foreach($users as $item) 
                    @if($item->id != Auth::user()->id)
                    <tr>
                        <td>{{$item->role_name}}</td>
                        <td>{{$item->first_name}}</td>
                        <td>{{$item->last_name}}</td>
                        <td><a href="mailto:{{$item->email}}">{{$item->email}}</a></td>
                        <td>{{$item->jurisdiction}}</td>
                        <td>{{$item->chapter}}</td> 
                        <td><a href="{{url('updateuser').'/'.$item->id}}">Manage</a><br/><a href="{{url('deleteuser').'/'.$item->id}}" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></td>
                    </tr> 
                    @endif
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