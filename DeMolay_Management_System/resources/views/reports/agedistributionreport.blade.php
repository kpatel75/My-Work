@extends('layouts.app')

@section('content')

<head>


</head>


<div class="container">
<a style="font-size: 18px;" href="{{ url('/home') }}">Go Back</a>
    <h2 class="text-center">Age Distribution</h2>
    <div class="d-flex justify-content-end">
        <a class="btn btn-primary" href="{{ route('agedistributionreportpdf') }}">Export to PDF</a>
        &nbsp;
    </div>

    <table style="margin-top:10px;" class="table table-bordered">
        <thead>
            <tr style="font-size: 12px;" class="table-danger">
                <th></th>
                <th>age: under 10 </th>
                <th>age: 10 </th>
                <th>age: 11 </th>
                <th>age: 12 </th>
                <th>age: 13 </th>
                <th>age: 14 </th>
                <th>age: 15 </th>
                <th>age: 16 </th>
                <th>age: 17 </th>
                <th>age: 18 </th>
                <th>age: 19 </th>
                <th>age: 20 </th>
                <th>age: 21 </th>
                <th>age: over 21 </th>
            </tr>
        </thead>
        <tbody>
            @if(Auth::user()->chapter_id == null)
            @else
            <tr>
                @foreach($chapter_name ?? '' as $cname)
                <th>{{ $cname->description }}</th>
                @endforeach
                <th>{{ $c8 }}</th>
                <th>{{ $c10 }}</th>
                <th>{{ $c11 }}</th>
                <th>{{ $c12 }}</th>
                <th>{{ $c13 }}</th>
                <th>{{ $c14 }}</th>
                <th>{{ $c15 }}</th>
                <th>{{ $c16 }}</th>
                <th>{{ $c17 }}</th>
                <th>{{ $c18 }}</th>
                <th>{{ $c19 }}</th>
                <th>{{ $c20 }}</th>
                <th>{{ $c21 }}</th>
                <th>{{ $c22 }}</th>
            </tr>
            @endif
            @if(Auth::user()->jurisdiction_id == 0)
            @else
            <tr>
                @foreach($jurisdiction_name ?? '' as $jname)
                <th>{{ $jname->description }}</th>
                @endforeach
                <th>{{ $j8 }}</th>
                <th>{{ $j10 }}</th>
                <th>{{ $j11 }}</th>
                <th>{{ $j12 }}</th>
                <th>{{ $j13 }}</th>
                <th>{{ $j14 }}</th>
                <th>{{ $j15 }}</th>
                <th>{{ $j16 }}</th>
                <th>{{ $j17 }}</th>
                <th>{{ $j18 }}</th>
                <th>{{ $j19 }}</th>
                <th>{{ $j20 }}</th>
                <th>{{ $j21 }}</th>
                <th>{{ $j22 }}</th>
            </tr>
            @endif
            <tr>
                <th>Canada</th>
                <th>{{ $co8 }}</th>
                <th>{{ $co10 }}</th>
                <th>{{ $co11 }}</th>
                <th>{{ $co12 }}</th>
                <th>{{ $co13 }}</th>
                <th>{{ $co14 }}</th>
                <th>{{ $co15 }}</th>
                <th>{{ $co16 }}</th>
                <th>{{ $co17 }}</th>
                <th>{{ $co18 }}</th>
                <th>{{ $co19 }}</th>
                <th>{{ $co20 }}</th>
                <th>{{ $co21 }}</th>
                <th>{{ $co22 }}</th>
            </tr>

        </tbody>
    </table>
</div>

@endsection