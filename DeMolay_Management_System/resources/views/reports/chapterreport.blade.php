@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section('content')
<div class="container">

    <form type="POST" action="updatechapterpayment">
        @csrf 
        <input type="radio" id="payment" name="payment-option" value="payments" checked> 
        <label for="payment">Transaction History</label>
        <input type="radio" id="member" name="payment-option" value="members">
        <label for="member">Member Information</label>
    </form>

    <div id="transactiondatatable">
    <!--Datatable-->
    <table id="transactiondatatable" class="table table-bordered table-striped data-table" data-order='[[ 1, "asc" ]]' data-page-length='25'> 
       
    <thead> 
            <tr>
                <th>First Name</th> 
                <th>Last Name</th>
                <th>Payment Amount</th> 
                <th>Description</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody> 
            @foreach($paymentInformation as $item)
            <tr>
                <td>{{$item->first_name}}</td>
                <td>{{$item->last_name}}</td>
                <td class="text-right">${{$item->amount_payed}}</td>
                <td>{{$item->description}}</td>
                <td>{{$item->payment_date}}</td>
            </tr> 
            @endforeach
        </tbody> 
        
    </table>
</div>

<div id="membersdatatable">
    <table id="" class="table table-bordered table-striped data-table" data-order='[[ 1, "asc" ]]' data-page-length='25'> 
        
        <thead> 
                <tr>
                    <th>First Name</th> 
                    <th>Last Name</th>
                    <th>Payment Amount</th> 
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody> 
                @foreach($groupedPaymentInformation as $item)
                <tr>
                    <td>{{$item->first_name}}</td>
                    <td>{{$item->last_name}}</td>
                    <td class="text-right">${{$item->amount_payed}}</td>
                    <td>{{$item->payment_date}}</td>
                </tr> 
                @endforeach
            </tbody> 
            
        </table>
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

    /*$(document).ready( function () {
        $('.data-table').DataTable({
            processing: true, 
            serverSide: true,
            retrieve: true, 
            ajax:"/reports/chapter/payment", 
            "columns": [
                {data: 'first_name', name:'First Name'}, 
                {data: "last_name", name:'Last Name'}, 
                {data: "amount_payed", name:'Amount Paid'}, 
                {data: "description", name: 'Description'}, 
                {data: "payment_date", name: 'Payment Date'}
            ], 
            order: [[ 1, 'desc' ]],
            pageLength: 100, 
            searching: false, 
            paging: false
        });
       
    });*/

   /* $(function () {
    let dtOverrideGlobals = {
        processing: true,
        serverSide: true,
        retrieve: true,
        ajax: "{{ route('reports.chapter.payment') }}",
            columns: [
                {"data": "first_name"}, 
                {"data": "last_name"}, 
                {"data": "amount_payed"}, 
                {"data": "description"}, 
                {"data": "payment_date"}
            ],
            order: [[ 1, 'desc' ]],
            pageLength: 100,
    };
    $('#datatable').DataTable(dtOverrideGlobals);
});*/ 

   //let radiochange = document.getElementsByName('payment-option');  
    let radiochangep = document.getElementById("payment"); 
    let radiochangem = document.getElementById("member"); 

    radiochangem.onchange = changedata;  
    radiochangep.onchange = changedata2;
    
    function changedata(e)
    {   
        let payments = document.getElementById('transactiondatatable'); 
        let members = document.getElementById('membersdatatable');  

        console.log(radiochangep.checked)
        console.log(radiochangem.checked)
        
            if(radiochangem.checked == true)
                { 
                    payments.hidden = true;
                    members.hidden = false;
                }

            
       
    }

     
    function changedata2(e)
    {   
        let payments = document.getElementById('transactiondatatable'); 
        let members = document.getElementById('membersdatatable');  

        console.log(radiochangep.checked)
        console.log(radiochangem.checked)
        
            if(radiochangep.checked == true)
                { 
                    payments.hidden=false; 
                    members.hidden=true;
                }

            
    
    }
</script>

@endsection 