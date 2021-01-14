@extends('layouts.app')

@section('content')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> 

    <div class="container">
    <a style="font-size: 18px;" href="{{ url('/home') }}">Go Back</a>
        <h2 class="text-center">List of Members</h2>

        <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ route('memberlistpdf') }}">Export to PDF</a>
            &nbsp;
            <a href="{{ route('export_excel.excel') }}" class="btn btn-success">Export to Excel</a>
        </div>
        @foreach($jurisdiction_name ?? '' as $jname)
        <h4>Jurisdiction: {{ $jname->description }}</h4>
        @endforeach
        @if($chapter_name=="NONE")
        @else
        @foreach($chapter_name ?? '' as $cname)
        <h4>Chapter: {{ $cname->description }}</h4>
        @endforeach
        @endif

        <table id="memberlist" class="table table-bordered data-table">
            <thead>
                <tr class="table-danger">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Goes By</th>
                    <th scope="col">Home Phone</th>
                    <th scope="col">Cell Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Position</th>
                </tr>
            </thead>
            <tbody>
                @foreach($member_data ?? '' as $data)
                <tr>
                    <th scope="row">{{ $data->id }}</th>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->goes_by }}</td>
                    <td>{{ $data->home_phone }}</td>
                    <td>{{ $data->mobile_phone }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->position }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @foreach($jurisdiction_count ?? '' as $jcount)
        <h4>Jurisdiction Count: {{ $jcount->count }}</h4>
        @endforeach
        @if($chapter_count=="NONE")
        @else
        @foreach($chapter_count ?? '' as $ccount)
        <h4>Chapter Count: {{ $ccount->count }}</h4>
        @endforeach
        @endif

    </div>

    
    <script type='text/javascript' charset="utf8" scr='https://code.jquery.com/jquery-3.5.1.js'></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

    <script>
    $(document).ready( function () {
    $('#memberlist').DataTable({
        paging: false,
        bFilter:false,
        "bSort": true,
        "bInfo" : false,
        "autoWidth": false,
        'bLengthChange': false,
        'language': {
                'emptyTable': 'No Information Found'
            }
        });   
    });
    </script>
@endsection
