@extends('layouts.app')

@section('content')

<div class="container">
<a style="font-size: 18px;" href="{{ url('/home') }}">Go Back</a>
    <h2 class="text-center">Activity Distribution</h2>

    <div class="d-flex justify-content-end">
        <a class="btn btn-primary" href="{{ route('activitydistributionreportpdf') }}">Export to PDF</a>
        &nbsp;
    </div>

    <table style="margin-top:10px;" class="table table-bordered">
        <thead >
            <tr class="table-danger">
                <th></th>
                @foreach($activity_list ?? '' as $aname)
                    <th><SPAN STYLE="writing-mode: vertical-lr;
                     -ms-writing-mode: tb-rl;
                     transform: rotate(185deg);">{{ $aname->activity }}</SPAN></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if(Auth::user()->chapter_id == null)
            @else
            <tr>
                @foreach($chapter_name ?? '' as $cname)
                    <th>{{ $cname->description }}</th>
                @endforeach
                @foreach($chapter_list ?? '' as $ccount)
                    <th>{{ $ccount }}</th>
                @endforeach

            </tr>
            @endif
            @if(Auth::user()->jurisdiction_id == 0)
            @else
            <tr>
                 @foreach($jurisdiction_name ?? '' as $jname)
                    <th>{{ $jname->description }}</th>
                @endforeach
                @foreach($jurisdiction_list ?? '' as $jcount)
                    <th>{{ $jcount }}</th>
                @endforeach

            </tr>
            @endif
            <tr>
                <th>Canada</th>
                @foreach($country_list ?? '' as $cocount)
                    <th>{{ $cocount }}</th>
                @endforeach
            </tr>

        </tbody>
    </table>
</div>

@endsection