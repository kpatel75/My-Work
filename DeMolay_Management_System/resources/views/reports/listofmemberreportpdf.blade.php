

<style>
table, th, td {
  border: 1px solid black;
}
table {
  width: 100%;
  border-collapse: collapse;
}
.id{
    width: 130px;
}

</style>

<div class="container">
        <h2 style="text-align:center;">List of Members</h2>

        @foreach($jurisdiction_name ?? '' as $jname)
        <h4>Jurisdiction: {{ $jname->description }}</h4>
        @endforeach
        @if($chapter_name=="NONE")
        @else
        @foreach($chapter_name ?? '' as $cname)
        <h4>Chapter: {{ $cname->description }}</h4>
        @endforeach
        @endif

        <table style="text-align:center" class="table table-bordered">
            <thead>
                <tr style="background-color: #F7C6C5;" class="table-header">
                    <th class="id" scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Goes By</th>
                    <th scope="col">Home Phone</th>
                    <th scope="col">Cell Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Positon</th>
                </tr>
            </thead>
            <tbody>
                @foreach($member_data ?? '' as $data)
                <tr">
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