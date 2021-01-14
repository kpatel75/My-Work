@extends('layouts.app')

@section('content')  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-3">
    <form method="POST" action="updateitadmin">  
        @csrf
       
        <div class="">
            @if(session()->has('message'))
            <div class="alert alert-success">
                <h4>{{ session()->get('message') }}</h4>
            </div> 
            @endif
            @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
            @endif
            <h3>IT Admin Permission</h3>
        </div>
        <div class="form-group row">
            <label for="member" class="col-md-4 col-form-label text-md-right">Member Access:</label>
            <select id="member" name="member">
                <option id='membernone' value="none">None</option>
                <option id='memberread' value="read">Read</option>
                <option id='memberwrite' value="write">Write</option>
                <option id='memberreadwrite'value="readwrite">Read/Write</option>
            </select>
        </div>
        <div class="form-group row">
            <label for="jurisdiction" class="col-md-4 col-form-label text-md-right">Jurisdiction Access:</label>
            <select id="jurisdiction" name="jurisdiction">
                <option id='jurisdictionnone' value="none">None</option>
                <option id='jurisdictionread' value="read">Read</option>
                <option id='jurisdictionwrite' value="write">Write</option>
                <option id='jurisdictionreadwrite' value="readwrite" >Read/Write</option>
            </select>
        </div>
        <div class="form-group row">
            <label for="country" class="col-md-4 col-form-label text-md-right">Country Access:</label>
            <select id="country" name="country">
                <option id='countrynone' value="none">none</option>
                <option id='countryread' value="read">Read</option>
                <option id='countruwrite' value="write">Write</option>
                <option id='countryreadwrite' value="readwrite">Read/Write</option>
            </select>
        </div> 
        <div class="col-md-7 text-md-right">
            <button class="btn btn-primary" type="submit">Update</button> 
        </div> 

        <h3 style="padding-top: 20px; padding-bottom: 20px;">Manage Page Content</h3>
        <a href="{{ url('contacts')}}">Manage Contacts Page</a>

        
    </form> 
</div>
</div>
</div>
</div>
        <script>
            window.onload = selectMember; 
            function selectMember(e)
            {   
                //member
                @if ($permissions->member_write == 1 && $permissions->member_read == 0) 
                    document.getElementById('memberwrite').selected = true; 
                @elseif($permissions ->member_write == 0 && $permissions->member_read == 1)  
                    document.getElementById('memberread').selected = true; 
                @elseif($permissions->member_write == 1 && $permissions->member_read == 1) 
                    document.getElementById('memberreadwrite').selected = true;  
                @else 
                    document.getElementById('membernone').selected = true; 
                @endif   
                //jurisdiction
                @if($permissions->jurisdiction_write == 1 && $permissions->jurisdiction_read == 0)
                document.getElementById('jurisdictionwrite').selected = true; 
                @elseif($permissions->jurisdiction_write == 0 && $permissions->jurisdiction_read == 1) 
                document.getElementById('jurisdictionread').selected = true;   
                @elseif($permissions->jurisdiction_write == 1 && $permissions->jurisdiction_read == 1) 
                document.getElementById('jurisdictionreadwrite').selected = true; 
                @else 
                document.getElementById('jurisdictionnone').selected = true; 
                @endif 
                //country
                @if($permissions->country_write == 1 && $permissions->country_read == 0)
                document.getElementById('countrywrite').selected = true; 
                @elseif($permissions->country_write == 0 && $permissions->country_read == 1) 
                document.getElementById('countryread').selected = true;   
                @elseif($permissions->country_write == 1 && $permissions->country_read == 1) 
                document.getElementById('countryreadwrite').selected = true; 
                @else 
                document.getElementById('countrynone').selected = true; 
                @endif 


            }
        </script>
    

@endsection 