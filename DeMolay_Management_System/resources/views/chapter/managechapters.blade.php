@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('content') 
<div class="container">

    <div class="row justify-content-center">
      
    <div class="card p-4">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>      
        @endif
        <div class="row justify-content-between m-2">
                <h2>{{__('Chapters')}}</h2>
            <a href="addchapter" class="btn btn-success">Add</a>
        </div>
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
        <table  class="table table-bordered table-striped data-table" data-order='[[ 1, "asc" ]]' data-page-length='25'>
            <thead> 
                <tr>
                    <th>ID</th> 
                    @if(Auth::user()->jurisdiction->id == 0)
                        <th>Jurisdiction</th>
                    @endif
                    <th>Name</th>  
                    <th>Location</th>
                    @if(Auth::user()->hasRole(['Admin', 'IT Admin', 'Executive Officer', 'Chapter Chairman', 'Chapter Advisor', 'Chapter Dad']))
                    <th></th>  
                    @endif
                </tr>
            </thead> 
            <tbody>
                @foreach ($chapters as $item)   
                    <tr>
                             <td>{{str_pad($item->id, 3, '0', STR_PAD_LEFT)}}</td>  
                             @if(Auth::user()->jurisdiction->id == 0)
                                <td>{{$item->jurisdictiondescription}}</td>
                             @endif
                             <td>{{$item->description}}</td> 
                             <td>{{$item->location}}</td> 
                             
                             @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('IT Admin') || Auth::user()->hasRole('Executive Officer'))
                             <td>
                            <a class="btn btn-primary" href="{{url('viewchapter').'/'.$item->id.'/'.$item->jurisdiction_id}}">Edit</a>
                <a class="btn btn-danger" href="{{url('deletechapter').'/'.$item->id.'/'.$item->jurisdiction_id}}" onclick="return confirm('Are you sure you want to delete this chapter?')">Delete</a> 
                        
                    </tr>
                    @endif
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