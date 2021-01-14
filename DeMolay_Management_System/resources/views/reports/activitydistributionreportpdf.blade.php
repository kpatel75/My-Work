
<style>
table, th, td {
  border: 1px solid black;
}
table {
  width: 100%;
  border-collapse: collapse;
}

</style>

    <h2 style="text-align:center;">Activity Distribution</h2>

    <table style="margin-top:10px">
        <thead >
            <tr style="background-color: #F7C6C5;">
                <th></th>
                @foreach($activity_list ?? '' as $aname)
                    <th style="font-size: 10px;">{{ $aname->activity }}</th>
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
