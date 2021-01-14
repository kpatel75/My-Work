@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection
@section('content')
   <div class="container"> 
       <div class="panel"> 
        <div class="row justify-content-between">
            <h1 class="display-3">{{"$member->first_name $member->middle_name $member->last_name"}}
            @if($member->preferred_name != null)
            {{ "($member->preferred_name)" }}
            @endif
            </h1>
            @if(!(Auth::user()->hasRole('President') || Auth::user()->hasRole('Secretary') || Auth::user()->hasRole('Executive Officer')))
            @ITAdmin('member', 'write')   
                <a href="/memberprofile/{{ $member->id }}/edit" class="btn btn-success align-self-start">Edit Member Information</a>
            @endITAdmin
            @endif
        </div>
        <hr/>
        <div class="row justify-content-between mx-1">
          <div> 
        <h5><b>Date Of Birth:</b> {{$member->birthdate}}</h5> 
        @if($member->initiatory_date != null)
            <h5><b>Initiatory Degree Date:</b> {{$member->initiatory_date}}</h5>
        @endif
        @if($member->demolay_degree_date != null)
            <h5><b>Demolay Degree Date:</b> {{$member->demolay_degree_date}}</h5>
        @endif 
        @if($member->senior_demolay_date != null)
            <h5><b>Senior DeMolay Date:</b> {{$member->senior_demolay_date}}</h5>
        @endif 
        </div>
        <div>
            <h5><b>Position:</b> {{$position}}</h5>
            <h5><b>Status:</b> {{$member->status}}</h5>
        </div>
        </div>

        <hr/>
        <div class="row mx-1">
        <div class="panel panel-default "> 
            <div class="panel-heading">

                <h4><b>Address</b></h4> 
            </div> 
            <div class='panel-body'>
                {{$member->address}}<br/>
                {{$member->city}}, {{$member->province}} <br/>
                {{$member->country}}, {{$member->postal_code}}
            </div>
        </div>
        <hr/>
        <div class="panel panel-default"> 
            <div class="panel-heading">
                <h4><b>Contact Information</b></h4> 
            </div>
            <div class="panel-body">
            Email: <a href="mailto:{{$member->email}}">{{$member->email}}</a><br/>  
            @if($member->home_phone != null)
                Home Phone: <a href="tel:{{$member->home_phone}}">{{$member->home_phone}}</a>
            @endif
            <br/>
            @if($member->work_phone != null)
                Work Phone: <a href="tel:{{$member->work_phone}}">{{$member->work_phone}}</a>
            @endif
            <br/>
            @if($member->mobile_phone != null)
                Mobile Phone: <a href="tel:{{$member->mobile_phone}}">{{$member->mobile_phone}}</a>
            @endif
            </div>
        </div>
    </div> 
    <hr/>
        <div class="row justify-content-between mx-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><b>Parents/Guardians</b></h4> 
                </div> 
                <div class='panel-body'>
                    @if($member->father_name != null) 
                        Father: {{$member->father_name}} 
                        @if($member->father_senior_status != 0)
                            <span class="badge badge-info">Senior DeMolay</span>
                            <span class="badge badge-info">{{$member->father_senior_location}}</span>
                        @endif
                        @if($member->father_mason_status != 0)
                            <span class="badge badge-info">Mason</span>
                            <span class="badge badge-info">{{$member->father_mason_location}}</span>
                        @endif
                    @endif 
                    <br/>
                    @if($member->mother_name != null)
                        Mother: {{$member->mother_name}}
                        @if($member->mother_mason_other != null)
                        <span class="badge badge-info">Other Masonic</span> 
                        <span class="badge badge-info">{{$member->mother_mason_other}}</span>
                        @endif
                    @endif 
                    <br/>
                    @if($member->guardian_one_name != null)
                        Gaurdian: {{$member->guardian_one_name}} 
                        @if($member->guardian_one_senior_status != 0)
                        <span class="badge badge-info">Senior DeMolay</span>
                        <span class="badge badge-info">{{$member->guardian_one_senior_location}}</span>
                        @endif
                        @if($member->guardian_one_mason_status != 0)
                        <span class="badge badge-info">Mason</span> 
                        <span class="badge badge-info">{{$member->guardian_one_mason_location}}</span>
                        @endif
                        @if($member->guardian_one_mason_other != null)
                        <span class="badge badge-info">Other Masonic</span> 
                        <span class="badge badge-info">{{$member->guardian_one_mason_other}}</span>
                        @endif
                    @endif
                    <br/>
                    @if($member->guardian_two_name != null)
                        Gaurdian: {{$member->guardian_two_name}} 
                        @if($member->guardian_two_senior_status != 0)
                        <span class="badge badge-info">Senior DeMolay</span>
                        <span class="badge badge-info">{{$member->guardian_two_senior_location}}</span>
                        @endif
                        @if($member->guardian_two_mason_status != 0)
                        <span class="badge badge-info">Mason</span> 
                        <span class="badge badge-info">{{$member->guardian_two_mason_location}}</span>
                        @endif
                        @if($member->guardian_two_mason_other != null)
                        <span class="badge badge-info">Other Masonic</span> 
                        <span class="badge badge-info">{{$member->guardian_two_mason_other}}</span>
                        @endif
                    @endif 
                </div>
            </div>  
            <div>
                <div class="panel-heading">
                    <h4><b>Sponsor</b></h4>
                </div> 
                <div class="panel-body">
                    {{$member->sponsor_name}}
                </div>
            </div> 
        </div>
        @if($member->notes != null)
            <hr/>
            <div>
                <div class="panel-heading">
                    <h4><b>Notes</b></h4>
                </div>
                <div class="panel-body">
                    {{ $member->notes }}
                </div>
            </div>
        @endif
        <hr/> 
        <hr/>  
        @if(! ($position == 'Advisor')) 
        <div class="panel panel-default">
            <div class="panel-heading"> 
                <div class="row justify-content-between mx-1">
                    <h4><b>Merit Bars</b></h4>
                     <div>
                        <a href="{{url('meritbarrecord').'/'.$member->id}}" class="btn btn-primary">View Merit Bars</a>
                        @if(!(Auth::user()->hasRole('President') || Auth::user()->hasRole('Secretary') || Auth::user()->hasRole('Director At Large')))
                        <a href="{{url('addmeritbar').'/'.$member->id}}" class="btn btn-secondary">Add Merit Bars</a> 
                        @endif
                    </div>
                </div>
            </div> 
            <div class="panel-body">
                <div id="barchart_values" style="width: 900px; height: 300px;"></div>
            </div>
        </div> 
        <hr/>
        <div class="activities"> 
            <div class="row justify-content-between m-2">
                <h4><b>Activity History</b></h4> 
                <div>
                    <a href="{{url('merit-bar-record').'/'.$member->id}}" class="btn btn-primary">Check Merit Bar Eligibility</a>
                    <a href="{{url('member-activity-list').'/'.$member->id}}" class="btn btn-primary">View all</a>  
                    @if(!(Auth::user()->hasRole('President') || Auth::user()->hasRole('Secretary')))
                    <a href="{{url('create-member-activity').'/'.$member->id}}" class="btn btn-secondary">Add New</a>  
                    @endif
                </div>
            </div>
            
            <table class="table table-bordered table-striped data-table table-sm" data-order='[[ 0, "desc" ]]' data-page-length='5' width="100%" cellspacing="0">
                <thead>
                    <th class="th-sm">Activity Date</th> 
                    <th class="th-sm">Activity</th>   
                    <th class="th-sm">Description</th> 
                    
                </thead> 
                <tbody>
                @foreach($activities as $item) 
                    <tr>
                        <td>{{$item->date}}</td> 
                        <td>{{$item->activity}}</td>
                        <td>{{$item->note}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table> 
            
            
        </div> 
        <hr/>
        <div class="payments panel panel-default">
            <div class="row justify-content-between m-2">
                <h4><b>Payment History</b></h4> 
                <div> 
                    @if(!(Auth::user()->hasRole('President') || Auth::user()->hasRole('Secretary')))
                        <a href="{{url('payment').'/'.$member->id}}" class="btn btn-primary">Add Payment</a> 
                    @endif
                    <!--<a href="{{url('create-member-activity').'/'.$member->id}}" class="btn btn-secondary">Add New</a> -->
                </div>
            </div>
            <table class="table table-bordered table-striped data-table table-sm" data-order='[[ 0, "desc" ]]' data-page-length='5' width="100%" cellspacing="0">
                <thead> 
                    <th>Date</th>
                   <th>Payment Description</th> 
                   <th>Fee Amount</th> 
                   <th>Payment Amount</th> 
                   <th>Amount Outstanding</th>
                </thead> 
                <tbody>
                    @foreach($payments as $item)
                    <tr> 
                    <td>{{$item->payment_date}}</td>
                    <td>{{$item->description}}</td> 
                    <td>{{"$ ".number_format($item->amount, 2, ".", ",")}}</td> 
                    <td>{{"$ ".number_format($item->amount_paid, 2, ".", ",")}}</td>
                    <td>{{"$ ".number_format($item->amount_outstanding, 2, ".", ",")}}</td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
        </div> 
        @endif 
        @if($position == 'Advisor') 
            <div class="row justify-content-between mb-2 mx-1">
                <h4><b>Nominations</b></h4> 
                <a href="{{url('nominations').'/'.$member->id}}" class="btn btn-primary">Add Nomination</a>
            </div>
            <table class="table table-bordered table-striped data-table table-sm" data-order='[[ 0, "desc" ]]' data-page-length='5' width="100%" cellspacing="0">
                <thead>
                    <th>Date Awarded</th> 
                    <th>Award</th>
                </thead> 
                <tbody> 
                    
                    @foreach($nominations as $item)
                    <tr>
                        <td>{{$item->date_awarded}}</td>
                        <td>{{$item->description}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
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
        $('.dataTables_length').addClass('bs-select');
        });
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript"> 
    var meritbadges = <?php echo $meritbadges; ?>; 
    if (meritbadges == null) {
      

        console.log("No data"); 
        var div = document.getElementById("barchart_values");  
        div.setAttribute("class", "row justify-content-center align-items-center") 
        div.setAttribute("style", "color: grey")
        div.innerHTML = "<h2>No Data Found</h2>";
} 
else{
    meritbadges[0].push({role:'style'}); 
    for(var i = 1; i < meritbadges.length; i++)
    {   
        console.log(meritbadges[i][0]);
        if(meritbadges[i][1]==1)
        {
            meritbadges[i].push('stroke-color: black; stroke-width: 4; fill-color: white'); 
            
        }
        else if(meritbadges[i][1]==2)
        {
            meritbadges[i].push('red'); 
            
        }
        else if(meritbadges[i][1]==3)
        {
            meritbadges[i].push('blue'); 
            
        }
        else if(meritbadges[i][1]==4)
        {
            meritbadges[i].push('purple'); 
            
        }
        else
        {
            meritbadges[i].push('gold');
        }
    }

    console.log(meritbadges);
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable(meritbadges); 

      var view = new google.visualization.DataView(data);

      var options = {
        title: "Merit Bars Achieved",
        width: 600,
        height: 300,
        bar: {groupWidth: "65%"},
        legend: { position: "none" }, 
        isStacked: true, 
        hAxis: {
            minValue: 0,
            ticks: [0, 1, 2, 3, 4, 5]
        }

      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(data, options); 
    }
  }
  </script>
@endsection