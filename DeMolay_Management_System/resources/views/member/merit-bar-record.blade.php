@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection
@section('content')
    <div class="container">
        <a class="btn btn-secondary" href="{{url('memberprofile').'/'.$id}}">Back</a>
        @if(session()->has('message'))
        <div class="alert alert-success">
            <h4>{{ session()->get('message') }}</h4>
        </div> 
        @endif
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
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
        <div>   
            <div class="row justify-content-between">
            <h1>Merit Bar Records History</h1>
            <a href="{{url('addmeritbar').'/'.$id}}" class="btn btn-success align-self-start">Add</a>
            </div>
            <table class="table table-bordered table-striped data-table table-sm" data-order='[[ 0, "desc" ]]' data-page-length='10' width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Activity</th> 
                        <th>Merit Bar</th> 
                        <th>Date Achieved</th> 
                        <th></th>
                     </tr>
                    </thead> 
                    <tbody>
                        @foreach ($records as $item)
                        <tr>
                        <td>{{$item->activity}}</td>
                        <td>{{$item->description}}</td> 
                        <td>{{$item->date_achieved}}</td>
                        <td><a href="{{url('deletemeritbarrecord').'/'.$item->member_id.'/'.$item->activity_id.'/'.$item->merit_bar_id}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this merit bar?')">Delete</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </thead>
            </table>


        </div>
    </div>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script> 
    $(document).ready( function () {
        $('.data-table').DataTable({
            processing: true, 
            "lengthChange": false,
            "pagingType": "simple",
            //serverSide: true,
            retrieve: true,
            "language": {
                "emptyTable": "No Information Found"
    }
        });
    }); 
</script>
@endsection