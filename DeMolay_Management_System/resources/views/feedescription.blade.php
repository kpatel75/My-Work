@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
@endsection
@section('content')
<style>
    thead th, tbody td {
        text-align: center;
    }
    a:first-child {
        margin-right: 0.8rem;
    } 
    td:last-child {
        width: 45%;
    }
</style>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-5'>
            <h3>Fee Descriptions</h3>
            <div class='card'>
                <div class='card-header'>List of Descriptions</div>
                <div class='card-body'>
                    <table class='table table-bordered table-striped data-table table-sm' data-order='[[ 0, "desc" ]]' data-page-length='10' id='table'>
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feeDescription as $desc)
                                <tr>
                                    <td>{{ $desc->description }}</td>
                                    <td>
                                        <a href='{{ URL('/editfeedescription', ['id' => $desc->id]) }}' class='btn btn-primary'>Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript' charset="utf8" scr='https://code.jquery.com/jquery-3.5.1.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            'bLengthChange': false,
            'paging': true,
            'language': {
                'emptyTable': 'No Information Found'
            }
        });   
    });
</script>
@endsection