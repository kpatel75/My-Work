@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
@endsection
@section('content')
<style>
    tbody td, thead th {
        padding: 0.3rem 0.3rem;
        text-align: center;
        width: 10%;
    }
    tbody td:nth-child(2) {
        padding-right: 0.25rem;
        text-align: right;
        width: 10%
    }
    tbody td:nth-child(6), tbody td:nth-child(5) {
        width:15%;
    }
    tbody td:last-child{
        padding: 0rem .5rem 0rem .5rem;
    }
    .outstandings, .contributions {
        width:50%;
        margin: 0rem 25%;
    }
    .label-sponsor {
        margin: 0% 20%;
        font-weight: 600;
    }
    .right-btn {
        width: 23%;
    }
    .left-btn {
        width: 23%;
        margin-left: 20%;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>{{ $memberInfo->last_name }}, {{ $memberInfo->first_name }}</h3>
            <br>
            <div class='card'>
            <form method='POST' id='paymentForm' action='{{route('storePayment')}}'>
                    @csrf
                    <div class='card-header'>
                        Add New Payment
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
                                @foreach($errors->all() as $bad)
                                    <p>{{ $bad }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class='form-group'>
                            <label for='feeSelect'>{{__('Payment')}}</label>
                            <select class='form-control' id='select' name='select' oninput='outstanding()'>
                                <option value=''></option>
                                @foreach ($fees as $fee)
                                    @if ($fee->year == now()->year)
                                        <option value='{{ $fee->id }}' hidden-att='{{ number_format($fee->amount, 2) }}' @if (old('select') == $fee->id) selected @endif>{{ $fee->description }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class='form-row'>
                            <div class='label-sponsor'>{{__('Is this member getting sponsored or his fee being waived?')}}</div>
                            <input type='hidden' name='description' id='description' value=''>
                            <div class='form-check form-check-inline left-btn'>
                                <label class='radio'>
                                    <input type='radio' class='form-check-input' id='sponsorRadio' name='radio' value='Sponsored' {{ old('radio') == 'Sponsored' ? 'checked' : '' }} onclick='specialCases()' disabled> {{__('Sponsored')}}
                                </label>
                            </div>
                            <div class='form-check form-check-inline right-btn'>
                                <label class='radio'>
                                    <input type='radio' class='form-check-input' id='waiveRadio' name='radio' value='Fee Waived' {{ old('radio') == 'Fee Waived' ? 'checked' : '' }} onclick='specialCases()' disabled> {{__('Waived Fee')}}
                                </label>
                            </div>
                            <div class='form-check form-check-inline'>
                                <label class='radio'>
                                    <input type='radio' class='form-check-input' id='noRadio' name='radio' value='None' {{ old('radio') == 'None' ? 'checked' : '' }} onclick='specialCases()' disabled> {{__('No')}}
                                </label>
                            </div>
                        </div>
                        <div class='form-group' id='sponsor' hidden>
                            <label for='sponsorSelect'>Sponsor</label>
                            <select id='sponsorSelect' name='sponsorSelect' class='form-control @error('sponsorSelect') is-invalid @enderror' oninput='getSponsorName()'>
                                <option value=''></option>
                                @foreach ($sponsorInfo as $sponsor)
                                    <option value='{{ $sponsor->id }}'>{{ $sponsor->last_name }}, {{ $sponsor->first_name }}</option>
                                @endforeach
                            </select>
                            @error('sponsorSelect')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type='hidden' name='sponsor_last_name' id='sponsor_last_name' value=''>
                            <input type='hidden' name='sponsor_first_name' id='sponsor_first_name' value=''>
                        </div>
                        <div id='form-inputs'>
                            <input id='memberIdInput' name='member_Id' type='hidden' value='{{ $memberInfo->id }}'>
                            <input id='calculatedBill' name='calculatedBill' type='hidden' value=''>
                            <div class='form-group'>
                                <label for='paymentAmountInput'>{{ __('Amount Paid') }}</label>
                                <input id='paymentAmountInput' onkeyup='calculateOutstanding()' name='amount_paid' type='text' placeholder='0.00' class='form-control @error('amount_paid') is-invalid @enderror' value='{{ old('amount_paid') }}' disabled>
                                @error('amount_paid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class='form-group'>
                                <label for='paymentBilledInput'>{{ __('Amount Billed') }}</label>
                                <input id='paymentBilledInput' name='amount_billed' type='text' placeholder='0.00' class='form-control' value='{{ old('amount_billed') }}' readonly>
                            </div>
                            <div class='form-group'>
                                <label for='outstandingPaymentInput'>{{ __('Outstanding Amount') }}</label>
                                <input id='outstandingPaymentInput' name='outstanding_payemnt' type='text' placeholder='0.00' class='form-control' value='{{ old('outstanding_paymnet') }}' readonly>
                            </div>
                            <div class='form-group'>
                                <label for='paymentDateInput'>{{ __('Date') }}</label>
                                <input id='paymentDateInput' name='date' type='date' class='form-control' value='{{ old('date') }}' required autocomplete='date' disabled>
                            </div>
                        </div>
                    </div>
                    <div class='card-footer'>
                        <div class='form-row'>
                            <div class='col-md-6'>
                                <br>
                                <a class='btn btn-secondary' id='cancelBtn' href='{{ URL('/memberprofile', ['id' => $memberInfo->id])}}'>Cancel</a>
                            </div>
                            <div class='col-md-6'>
                                <br>
                                <button id='submitBtn' type='submit' class='btn btn-primary' onclick='return confirmation()'>Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <br>
        </div>
        <div class='col-md-12'>
        <h3>Transaction History</h3>
            <table class='table table-striped table-bordered table-responsive' data-order='[[ 0, "desc" ]]' width='100%' cellspacing='0' id='paymentsTable'>
                <thead>
                    <th>{{ __('Payment Id') }}</th>
                    <th>{{ __('Amount Paid') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Special Case') }}</th>
                    <th>{{ __('Sponsor') }}</th>
                    <th>{{ __('Added By') }}</th>
                    <th>{{ __('Date') }}</th>
                </thead>
                <tbody>
                    @foreach($paymentInfo as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>${{ number_format($item->amount_paid, 2, '.', ',') }}</td>
                            <td>{{ $item->description}}</td>
                            <td>{{ $item->special_case }}</td>
                            <td>@if($item->sponsor_id != null){{ $item->sponsor_last_name }}, {{ $item->sponsor_first_name }} @endif</td>
                            <td>{{ $item->last_name }}, {{ $item->first_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->payment_date)->format('Y/d/m') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <h3>Outstanding Bills</h3>
                <div class='alert alert-danger' id='outstandingError' hidden>{{ __('This member currently does not have any outstanding bills!') }}</div>
                <div class='outstandings'>
                    <table class='table table-bordered table-striped data-table table-sm' data-order='[[ 0, "desc" ]]' id='outstandingTable'>
                        <thead>
                            <tr>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Outstanding Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($outstanding as $out)
                                <tr>
                                    <td>{{ $out->description }}</td>
                                    <td name='outstanding' description='{{ $out->description }}'>
                                        @if (isset($out->outstanding))
                                            {{ '$'.number_format($out->amount - $out->paid, 2, '.', ',') }}
                                        @else
                                            {{ '$'.number_format($out->amount, 2, '.', ',') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style='text-align: center'>Total Outstanding</th>
                                <th style='text-align: right'></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript' charset="utf8" scr='https://code.jquery.com/jquery-3.5.1.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script>
    // Column Sort on Payment Table
    $(document).ready(function() {
        $('#paymentsTable').DataTable( {
            'paging': true,
            'language': {
                'emptyTable': 'No Information Found'
            }
        });   
    });

    // Column Sort on Outstanding Table and calculate total outstanding
    $(document).ready(function() {
        $('#outstandingTable').DataTable({
            'bLengthChange': false,
            'paging': false,
            'bInfo': false,
            'search': {
                'caseInsensitive': false
            },
            'language': {
                'emptyTable': 'No Information Found'
            },
            'footerCallback': function( row, data, start, end, display) {
                var api = this.api(), data;

                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ? i : 0;        
                };

                total = api.column( 1 ).data().reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                
                $( api.column( 1 ).footer() ).html(
                    '$'+total.toFixed(2)
                );
            }
        });   
    });
</script>
<script type='text/javascript'>
    window.onload = function() {
        var select = document.getElementById('select');
        var selected = select.options[select.selectedIndex];
        var amountInput = document.getElementById('paymentAmountInput');
        var dateInput = document.getElementById('paymentDateInput');
        var waivedBtn = document.getElementById('waiveRadio');
        var sponsorBtn = document.getElementById('sponsorRadio');
        var noBtn = document.getElementById('noRadio');
        var sponsorSelect = document.getElementById('sponsorSelect');
        var sponsorDiv = document.getElementById('sponsor');

        if (selected.value != '') {
            amountInput.removeAttribute('disabled');
            waivedBtn.removeAttribute('disabled');
            sponsorBtn.removeAttribute('disabled');
            noBtn.removeAttribute('disabled');
            dateInput.removeAttribute('disabled');
            if (sponsorBtn.hasAttribute('checked')) {
                sponsorDiv.removeAttribute('hidden');
            }
        }
    }

    // Confirm before submitting form
    function confirmation() {
        if (confirm('Are you sure you want to submit it?')) {
            document.getElementById('paymentForm').submit();
        } else {
            return false;
        }
    }

    // This function triggers when the payment dropdown detects an input
    // it re-enables the radio button, the amount input, and date input
    // Also assigns the outstanding input a value from the outstanding table
    function outstanding() {
        var amountInput = document.getElementById('paymentAmountInput');
        var billedInput = document.getElementById('paymentBilledInput');
        var dateInput = document.getElementById('paymentDateInput');
        var waivedBtn = document.getElementById('waiveRadio');
        var sponsorBtn = document.getElementById('sponsorRadio');
        var noBtn = document.getElementById('noRadio');
        var outstandingInput = document.getElementById('outstandingPaymentInput');
        var selected = document.getElementById('select');
        var outstanding = document.getElementsByName('outstanding');
        var e = selected.options[selected.selectedIndex];

        amountInput.removeAttribute('disabled');
        dateInput.removeAttribute('disabled');
        waivedBtn.removeAttribute('disabled');
        sponsorBtn.removeAttribute('disabled');
        noBtn.removeAttribute('disabled');

        billedInput.value = '';
        amountInput.value = '';
        outstandingInput.value = '';

        if (outstanding.length > 0) {
            outstanding.forEach(element => {
                var description = element.getAttribute('description');
                if (description == e.innerText) {
                    var outstandingAmount = parseFloat(element.innerHTML.replace('$', '')).toFixed(2);
                    billedInput.value = outstandingAmount;
                }
            })
        }
    }

    // Just gets the sponsor names from the dropdown list to hidden fields
    function getSponsorName() {
        var first_name = document.getElementById('sponsor_first_name');
        var last_name = document.getElementById('sponsor_last_name');
        var sponsor_select = document.getElementById('sponsorSelect');
        var e = sponsor_select.options[sponsor_select.selectedIndex];

        first_name.value = e.innerText.split(', ')[1];
        last_name.value = e.innerText.split(', ')[0];
    }

    // Calculates the outstanding from the amount being inputed and the outstanding input 
    function calculateOutstanding() {
        var amountPaid = document.getElementById('paymentAmountInput').value;
        var amountBilled = document.getElementById('paymentBilledInput').value;

        var outstandingPayment = amountBilled - amountPaid;
        if(outstandingPayment > 0) {
            document.getElementById('outstandingPaymentInput').value = (outstandingPayment).toFixed(2);
        } else {
            document.getElementById('outstandingPaymentInput').value = '';
        }
    }

    // Depending on what radio button is checked it would disable some fields
    // or shows a hidden input 
    function specialCases() {
        var amountInput = document.getElementById('paymentAmountInput');
        var billedInput = document.getElementById('paymentBilledInput');
        var sponsorSelect = document.getElementById('sponsor');
        var waivedBtn = document.getElementById('waiveRadio');
        var sponsorBtn = document.getElementById('sponsorRadio');
        var noBtn = document.getElementById('noRadio');
        
        if (waivedBtn.checked) {
            amountInput.setAttribute('readonly', '');
            if (!sponsorSelect.hasAttribute('hidden')) {
                sponsorSelect.setAttribute('hidden', '');
            }
            amountInput.value = billedInput.value;
            calculateOutstanding();
        } else if (sponsorBtn.checked) {
            sponsorSelect.removeAttribute('hidden');
            if (amountInput.hasAttribute('readonly')) {
                amountInput.removeAttribute('readonly');
            }
            calculateOutstanding();
        } else if (noBtn.checked) {
            if (amountInput.hasAttribute('readonly')) {
                amountInput.removeAttribute('readonly');
            }
            if (!sponsorSelect.hasAttribute('hidden')) {
                sponsorSelect.setAttribute('hidden', '');
            }
            calculateOutstanding();
        }
    }
</script>
@endsection