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
        <div class="card-header">
            <h2>{{__('Jurisdictions')}}</h2>
        </div>
        
        <table class="table table-bordered table-striped data-table" data-order='[[ 0, "asc" ]]' data-page-length='25'>
            <thead> 
                <th>ID</th>
                <th>Name</th>  
                <th></th>
            </thead> 
            <tbody>
               <p style="display: none;">{{ $k=0}}</p>
                @for($i = 0; $i < $size + 1; $i++)   
                    <tr>
                         @if($jurisdictions[$k]->id == $i)
                             <td>{{$jurisdictions[$k]->id}}</td> 
                             <td>{{$jurisdictions[$k]->description}}</td> 
                            @if(!Auth::user()->hasRole('Board Member'))
                    <td><a class="btn btn-primary" href="{{url('viewjurisdiction').'/'.$jurisdictions[$k]->id}}">View</a>
                <a class="btn btn-danger" href="{{url('deleteJurisdiction').'/'.$jurisdictions[$k]->id}}" onclick="return confirm('Are you sure you want to delete this jurisdiction?')">Delete</a> 
                        @endif
                            </td> 
                             <p style="display: none;">{{$k++}}</p>
                        @else
                            <td>{{$k}}</td> 
                            <td style="color: red">No Jurisdiction Assigned</td>
                            @if(!Auth::user()->hasRole('Board Member'))
                                <td><a class="btn btn-secondary" href="{{url('viewjurisdiction').'/'.$k}}">Add</button></td> 
                            @endif
                            
                         @endif
                        
                    </tr>
                @endfor  
                @if(!(Auth::user()->hasRole('Board Member'))) 
                    <p style="display: none;">{{$k++}}</p>
                    <tr>
                        <td></td>
                        <td>Add New Jurisdiction</td> 
                        <td><a class="btn btn-secondary" href="{{url('viewjurisdiction').'/'.($k)}}">Add</button></td> 
                    </tr> 
                @endif
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