@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
@endsection
@section('content')
<style>
    tbody td, thead th {
        padding: 0.25rem 0.25rem;
        text-align: center;
        width: 10%;
    }
    #addNew {
        margin-top: 1.2rem;
        margin-bottom: 1.2rem;
    }
</style>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            @if ($user->id != $role->id)
                <div class='card'>
                    <form method='POST' id='fee-form' action='{{route('storeFee')}}'>
                        @csrf
                        <div class='card-header'>
                            <div>Fees</div>
                        </div>
                        <div class='card-body'>
                                @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @endif
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            @if($errors->any())
                                <div class='alert alert-danger'>
                                    <ul>
                                        @foreach($errors->all() as $bad)
                                            <li>{{ $bad }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class='form-row'>
                                <label for='amount'>{{ __('Amount') }}</label>
                                <input id='amount' name='amount' type='text' value='{{ old('amount') }}' class='form-control @error('amount') is-invalid @enderror' required autocomplete='amount'>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class='form-group'>
                                <label for='dempolay'>{{__('Contribution to DeMolay')}}</label>
                                <input type='text' id='demolay' name='demolay' class='form-control @error('demolay') is-invalid @enderror' value='{{ old('demolay') }}' required autocomplete='demolay'>
                                @error('demolay')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class='form-group'>
                                <label for='chapter'>{{__('Contribution to Chapter')}}</label>
                                <input type='text' id='chapter' name='chapter' class='form-control @error('chapter') is-invalid @enderror' value='{{ old('chapter')}}' required autocomplete='chapter'>
                                @error('chapter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class='form-row'>
                                <label for='descriptionSelect'>{{ __('Description') }}</label>
                                <select id='descriptionSelect' name='descriptionSelect' class='form-control @error('descriptionSelect') is-invalid @enderror'>
                                    <option value=''>{{__('Select Description...')}}</option>
                                    @foreach ($descriptionInfo as $info) 
                                        <option value='{{ $info->id }}' {{ old('descriptionSelect') == $info->id ? 'selected' : ''}}>{{ $info->description }}</option>
                                    @endforeach
                                </select>
                                @error('descriptionSelect')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <button id='addNew' class='btn btn-primary'>{{__('Add New Description')}}</button>
                            </div>
                            <div class='form-row' id='descriptionDiv' hidden>
                                <label for='description'>{{__('New Description')}}</label>
                                <input id='description' name='description' value='{{ old('description') }}' class='form-control @error('description') is-invalid @enderror'>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class='form-row'>
                                <label for='year'>{{ __('Year') }}</label>
                                <select id='year' name='year' class='form-control'></select>
                            </div>
                        </div>
                        <div class='card-footer'>
                            <div class='form-row'>
                                <div class='col-md-6'>
                                    <br>
                                    <a class='btn btn-secondary' id='cancelBtn' href='{{ URL('/home') }}'>Cancel</a>
                                </div>
                                <div class='col-md-6'>
                                    <br>
                                    <button id='submitBtn' type='submit' class='btn btn-primary' onclick='return confirmation()'>Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
        <div class='col-md-12'>
            <br>
            <div>
                <h3>Fee History</h3>
                @if ($user->id == $role->id)
                    <a href='{{ URL('home') }}' class='btn btn-secondary'>Back</a>
                    <div class='from-group'>
                        <label>{{ __('Chapter') }}</label>
                        <select class='form-control col-md-6' id='select' onchange='showTable()'>
                            <option value=''>Select a chapter...</option>
                            @foreach ($chapters as $item)
                                <option value='{{ $item->id }}'>{{ $item->location }}</option>
                            @endforeach
                        </select>
                        <br>
                        <button class='btn btn-primary' name='showBtn' id='showBtn' onclick='showTable()'>Show Table</button>
                        <button class='btn btn-primary' name='hideBtn' id='hideBtn' onclick='hideTable()' hidden>Hide Table</button>
                        <button class='btn btn-primary' name='showAllBtn' id='showAllBtn' onclick='showTables()'>Show All Table</button>
                        <button class='btn btn-primary' name='hideAllBtn' id='hideAllBtn' onclick='hideTables()' hidden>Hide All Table</button>
                    </div>
                    <br>
                    @foreach ($chapters as $list)
                        <div name='table'class='table-responsive' hidden data-value='{{ $list->location }}'>
                            <h4>{{ $list->location }} Chapter</h4>
                            <table class='chapter-table table table-bordered table-striped data-table table-sm table-responsive' cellpadding='2' cellspacing='0' data-order='[[ 0, "desc" ]]' data-page-length='10' location='{{ $list->location }}'>
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Amount</th>
                                        <th>DeMolay Contribution</th>
                                        <th>Chapter Contribution</th>
                                        <th>Description</th>
                                        <th>Added By</th>
                                        <th>Edited By</th>
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody name='table-body'>
                                    @foreach ($chapterFees as $item)   
                                        @if ($list->id == $item->chapter_id)
                                            <tr name='chapter-rows'>
                                                <td>{{ $item->id }}</td>
                                                <td>${{ number_format($item->amount, 2, '.', ',') }}</td>
                                                <td>${{ number_format($item->demolay_contribution, 2, '.', ',') }}</td>
                                                <td>${{ number_format($item->chapter_contribution, 2, '.', ',') }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->last_name}} , {{ $item->first_name }}</td>
                                                @if(isset($item->edited_by_first_name) || isset($item->edited_by_last_name))
                                                    <td>{{ $item->edited_by_last_name}}, {{$item->edited_by_first_name}}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>{{ $item->year }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                        </div>
                        <br>
                    @endforeach
                @else
                    <div name='table'>
                        <table class='table table-bordered table-striped data-table table-sm table-responsive' data-order='[[ 0, "desc" ]]' data-page-length='10' id='table'>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Amount</th>
                                    <th>DeMolay Contribution</th>
                                    <th>Chapter Contribution</th>
                                    <th>Description</th>
                                    <th>Added By</th>
                                    <th>Recently Edited By</th>
                                    <th>Year</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody name='table-body'>
                                @foreach ($chapterFees as $item)   
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>${{ number_format($item->amount, 2, '.', ',') }}</td>
                                        <td>${{ number_format($item->demolay_contribution, 2, '.', ',') }}</td>
                                        <td>${{ number_format($item->chapter_contribution, 2, '.', ',') }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->last_name}} , {{ $item->first_name }}</td>
                                        @if(isset($item->edited_by_first_name) || isset($item->edited_by_last_name))
                                            <td>{{ $item->edited_by_last_name}}, {{$item->edited_by_first_name}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td>{{ $item->year }}</td>
                                        <td><a href='{{ URL('/editFee', ['id' => $item->id]) }}' class='btn btn-primary'>Edit</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type='text/javascript' charset="utf8" scr='https://code.jquery.com/jquery-3.5.1.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable( {
            'paging': true,
            'language': {
                'emptyTable': 'No Information Found'
            }
        });   
    });

    $(document).ready(function() {
        $('.chapter-table').DataTable( {
            'paging': true,
            'language': {
                'emptyTable': 'No Information Found'
            }
        })
    });

    // Confirm before submitting 
    function confirmation() {
        if (confirm('Are you sure you want to submit it?')) {
            document.getElementById('fee-form').submit();
        } else {
            return false;
        }
    }
    
    // This automatically fills up the year dropwdown list and selects the current year
    var min = new Date().getFullYear() - 10;
    var max = new Date().getFullYear() + 10;
    var select = document.getElementById('year');

    if (select != null) {
        for (var i = min; i <= max; i++) {
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = i;
            if (new Date().getFullYear() == opt.value) {
                opt.setAttribute('selected', '');
            }
            select.appendChild(opt);
        }
    }

    // This function is here to check if there is something inside the description input
    window.onload = function() {
        var descriptionDiv = document.getElementById('descriptionDiv');
        var select = document.getElementById('descriptionSelect');
        var descriptionInput = document.getElementById('description');
        var btn = document.getElementById('addNew');
        
        if (!descriptionInput.value == '') {
            select.setAttribute('disabled', '');
            descriptionDiv.removeAttribute('hidden', '');
            btn.innerText = 'Cancel';
            btn.removeAttribute('class');
            btn.setAttribute('class', 'btn btn-secondary');
        }
    }

    // This function just hides or un hides the description input
    document.getElementById('addNew').addEventListener('click', function(event) {
        event.preventDefault();
        var descriptionDiv = document.getElementById('descriptionDiv');
        var select = document.getElementById('descriptionSelect');
        var descriptionInput = document.getElementById('description');
        var btn = document.getElementById('addNew');
        
        if (btn.innerText == 'Add New Description') {
            select.setAttribute('disabled', '');
            descriptionDiv.removeAttribute('hidden');
            btn.innerText = 'Cancel';
            btn.removeAttribute('class');
            btn.setAttribute('class', 'btn btn-secondary');
        } else if (btn.innerText == 'Cancel') {
            btn.innerText = 'Add New Description';
            btn.removeAttribute('class');
            btn.setAttribute('class', 'btn btn-primary');
            select.removeAttribute('disabled');
            descriptionDiv.setAttribute('hidden', '');
            descriptionInput.value == '';
        }
    });

    // This function is for the executive officer
    // this would just show the current table selected in the chapter dropdown list
    function showTable() {
        var selected = document.getElementById('select');
        var e = selected.options[selected.selectedIndex];
        var tables = document.getElementsByName('table');
        var hideTable = document.getElementById('hideBtn');
        var showTable = document.getElementById('showBtn');
        var showBtn = document.getElementById('showAllBtn');
        var hideBtn = document.getElementById('hideAllBtn');
        
        hideTable.removeAttribute('hidden');
        showTable.setAttribute('hidden', '');

        if (e.value == '') {
            showTable.removeAttribute('hidden');
            hideTable.setAttribute('hidden', '');
        } 

        tables.forEach(element => {
            var data = element.getAttribute('data-value');
            if (e.text == data) {
                element.removeAttribute('hidden');
            }
        });
    }

    // This just hides the table that is selected on the dropdown list
    function hideTable() {
        var selected = document.getElementById('select');
        var e = selected.options[selected.selectedIndex];
        var tables = document.getElementsByName('table');
        var hideTable = document.getElementById('hideBtn');
        var showTable = document.getElementById('showBtn');
        var showBtn = document.getElementById('showAllBtn');
        var hideBtn = document.getElementById('hideAllBtn');

        showTable.removeAttribute('hidden');
        if (e.value == '') {
            showTable.setAttribute('hidden', '');
        } else {
            hideTable.setAttribute('hidden', '');
        }

        tables.forEach(element => {
            var data = element.getAttribute('data-value');
            if (e.text == data) {
                element.setAttribute('hidden', '');
            }
        });
    }

    // This would show all the tables
    function showTables() {
        var showBtn = document.getElementById('showAllBtn');
        var hideBtn = document.getElementById('hideAllBtn');
        var hideTable = document.getElementById('hideBtn');
        var showTable = document.getElementById('showBtn');
        var tables = document.getElementsByName('table');

        showBtn.setAttribute('hidden', '');
        hideBtn.removeAttribute('hidden');
        hideTable.removeAttribute('hidden');
        showTable.setAttribute('hidden', '');

        tables.forEach(element => {
            element.removeAttribute('hidden');
        });
    }

    // This would hide all the tables
    function hideTables() {
        var showBtn = document.getElementById('showAllBtn');
        var hideBtn = document.getElementById('hideAllBtn');
        var hideTable = document.getElementById('hideBtn');
        var showTable = document.getElementById('showBtn');
        var tables = document.getElementsByName('table');

        showBtn.removeAttribute('hidden');
        hideBtn.setAttribute('hidden', '');
        hideTable.setAttribute('hidden', '');
        showTable.removeAttribute('hidden');

        tables.forEach(element => {
            element.setAttribute('hidden', '');
        });
    }
</script>
@endsection