<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Payment;
use App\Models\Position;
use App\Models\Member;

// Validation Rules
use App\Rules\PaidGreaterThanBilled;
use App\Rules\CheckDate;

class PaymentController extends Controller
{
    //Gets all the payment history of a specific member, it passes the member_id
    public function getMemberPaymentInfo($id){
        // This query is used to fill up the transaction history
        $paymentInfo = DB::table('payments')
                            ->select('payments.id', 'payments.fee_id', 'payments.amount_paid', 'payments.amount_outstanding',
                             'fees.amount' , 'payments.payment_date', 'fee_descriptions.description', 'payments.advisor_id', 
                             'users.first_name', 'users.last_name', 'payments.special_case', 'payments.sponsor_first_name', 
                             'payments.sponsor_last_name', 'payments.sponsor_id')
                            ->leftJoin('users', 'payments.advisor_id', '=', 'users.id')
                            ->leftJoin('fees', 'payments.fee_id', '=', 'fees.id')
                            ->leftJoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                            ->where('payments.member_id', $id)
                            ->get();
        // gets the members basic info
        $memberInfo = DB::table('members')
                            ->selectRaw('id, first_name, last_name, position_id, date_format(created_at, "%Y") as year')
                            ->where('id', $id)
                            ->get()
                            ->first();
        // gets the id of the role in the member role table
        $roleInfo = Position::where('position_name', '=', 'Prospect')->get()->first();
        // Disabling only_full_group_by for the outstanding table query and the fee select
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        // this query is used to fill in the select in the payment blade
        $feeInfo = DB::table('fees')
                        ->selectRaw('fees.id, fees.amount, fee_descriptions.description, fees.year')
                        ->leftJoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                        ->leftJoin('payments', 'fees.id', '=', 'payments.fee_id')
                        ->groupBy('fee_descriptions.description')
                        ->where([
                            ['fees.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                            ['fees.chapter_id', '=', Auth::user()->chapter_id]])
                        ->get();
        // gets any payment that has been made by the member in the users jurisdiction and chapter
        $outstandingPayments= DB::table('fees')
                            ->selectRaw('sum(fees.amount - payments.amount_paid) as "outstanding",
                            sum(payments.amount_paid) as "paid", fees.amount as "amount", fee_descriptions.description, payments.member_id, 
                            date_format(fees.year, "%Y") as year')
                            ->leftJoin('payments', 'fees.id', '=', 'payments.fee_id')
                            ->leftJoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                            ->groupBy('fee_descriptions.description', 'payments.member_id')
                            ->where([
                                ['fees.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                                ['fees.chapter_id', '=', Auth::user()->chapter_id],
                                ['payments.member_id' , '=', $id]])
                            ->get();
        // gets all the fees in the users juristiction and chapter
        $outstandingInfo = DB::table('fees')
                                ->selectRaw('sum(fees.amount) as "amount", fee_descriptions.description, max(fees.year) as "year"')
                                ->leftJoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                                ->groupBy('fee_descriptions.description', 'fees.year')
                                ->where([
                                    ['fees.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                                    ['fees.chapter_id', '=', Auth::user()->chapter_id]])
                                ->get();
        // Colection of possible registration/sign-up descriptions
        $descriptionInfo = ['sign-up', 'sign-up fee', 'registration', 'registration fee', 'enrollement',
                                            'enrollement fee', 'appilication', 'application fee'];
        // this is the logic to fill in the outstanding bills table
        $fees = new Collection;
        $outstanding = new Collection();
        foreach ($outstandingInfo as $info) {
            //checks to see if the member is a prospect or not
            if ($memberInfo->position_id != $roleInfo->id) {
                // check to see if there have been payments made
                if ($outstandingPayments->where('description', $info->description)->count() != 0) {
                    foreach ($outstandingPayments as $payment) {
                        if ($payment->year == $memberInfo->year) {
                            if ($payment->description == $info->description) {
                                if ($payment->amount != $payment->paid)  {
                                    $outstanding->push($payment);
                                    foreach ($feeInfo as $fInfo) {
                                        if ($fInfo->description == $info->description) {
                                            $fees->push($fInfo);
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if (!in_array(strtolower($info->description), $descriptionInfo)) {
                        if ($info->year == now()->year) {
                            if ($outstanding->where('description', $info->description)->count() == 0) {
                                $outstanding->push($info);
                                foreach ($feeInfo as $fInfo) {
                                    if ($fInfo->description == $info->description) {
                                        $fees->push($fInfo);
                                    }
                                }
                            }
                        }
                    }
                } 
            } else {
                // this block of code triggers when the member role is a prospect
                // this if statement if to check if the member has partially paid the sign-up fee
                if ($outstandingPayments->count() > 0) {
                    foreach ($outstandingPayments as $payment) {
                        if ($payment->description == $info->description) {
                            if ($payment->amount != $payment->paid) {
                                $outstanding->push($payment);
                                foreach ($feeInfo as $fee) {
                                    if ($fee->description == $info->description) {
                                        if ($fee->year == now()->year || $payment->outstanding != 0) {
                                            $fees->push($fee);
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    foreach ($descriptionInfo as $dInfo) {
                        if ($info->year == $memberInfo->year) {
                            if ($dInfo == strtolower($info->description)) {
                                $outstanding->push($info);
                                foreach ($feeInfo as $fInfo) {
                                    if (strtolower($fInfo->description) == $dInfo) {
                                        $fees->push($fInfo);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // Reenable only_full_group_by after the outstanding table query and the fee select
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        // this query is used to query the database for all the demolay who are in the same jurisdiction as the current
        //  logged in user
        $sponsorInfo = DB::table('users')
                    ->select('id', 'first_name', 'last_name')
                    ->where([
                        ['jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                        ['chapter_id', '=', Auth::user()->chapter_id]])
                    ->get();

        return view('payment', ['paymentInfo' => $paymentInfo, 'memberInfo' => $memberInfo, 
                    'sponsorInfo' => $sponsorInfo, 'roleInfo' => $roleInfo, 'outstanding' => $outstanding, 
                    'fees' => $fees, 'outstandingPayments' => $outstandingPayments]);
    }

    // Stores the new payment to the database
    public function storePayment(Request $request) {
        $this->validate($request, [
            'amount_paid' => ['bail', 'required', new PaidGreaterThanBilled($request->input('amount_billed')), 'numeric'],
            'sponsorSelect' => ['bail', 'required_if:radio,sponsored'],
            'outstanding_payment' => 'numeric',
            'date' => ['bail', 'required', new CheckDate()]
        ]);

        $payment = new Payment();
        $payment->amount_paid = $request->input('amount_paid');
        $payment->fee_id = $request->input('select');
        $payment->special_case = $request->input('radio');
        // used to figure out if the member is being sponsored by someone
        if ($request->input('radio') == 'Sponsored') {
            $payment->sponsor_id = $request->input('sponsorSelect');
            $payment->sponsor_first_name = $request->input('sponsor_first_name');
            $payment->sponsor_last_name = $request->input('sponsor_last_name');
        }
        $payment->amount_outstanding = $request->input('outstanding_payemnt');
        $payment->member_id = $request->input('member_Id');
        $payment->advisor_id = Auth::id();
        $payment->payment_date = $request->input('date');
        $payment->save();

        LogActivity::log('Create', "Create payment for member $request->member_id for amount: $payment->amount_paid", $payment->member_id); 
        // Colection of possible registration descriptions
        $descriptionInfo = new Collection(['sign-up', 'sign-up fee', 'registration', 'registration fee', 'enrollement',
                                        'enrollement fee', 'appilication', 'application fee', 'annual', 'annual fee']);
        // Disabling only_full_group_by for the outstanding payments query
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        // gets any payment that has been made by the member in the users jurisdiction and chapter
        $outstandingPayments= DB::table('fees')
                                    ->selectRaw('sum(fees.amount - payments.amount_paid) as "outstanding",
                                    sum(payments.amount_paid) as "paid", fees.amount as "amount", fee_descriptions.description, payments.member_id, 
                                    date_format(fees.year, "%Y") as year')
                                    ->leftJoin('payments', 'fees.id', '=', 'payments.fee_id')
                                    ->leftJoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                                    ->groupBy('fee_descriptions.description', 'payments.member_id')
                                    ->where([
                                        ['fees.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                                        ['fees.chapter_id', '=', Auth::user()->chapter_id],
                                        ['payments.member_id' , '=', $request->input('member_Id')]])
                                    ->get();
        // Reenable only_full_group_by after the payments query
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        // gets the members basic info
        $memberInfo = DB::table('members')
                        ->selectRaw('id, first_name, last_name, position_id, date_format(created_at, "%Y") as year')
                        ->where('id', $request->input('member_Id'))
                        ->get()
                        ->first();
        // gets the id of the role in the member role table
        $roleInfo = Position::where('position_name', '=', 'Prospect')->get()->first();

        // this block of code is for finding out if the current member has complete paying the sign-up fee
        // and promote prospect 
        $message = '';
        if ($memberInfo->position_id == $roleInfo->id) {
            foreach ($outstandingPayments as $payment) {
                foreach ($descriptionInfo as $dInfo) {
                    if (strtolower($payment->description) == $dInfo) {
                        if ($payment->amount == $payment->paid) {
                            $temp2 = Member::find($request->input('member_Id'));
                            $temp2->position_id = Position::where('position_name', 'Member')->pluck('id')->first();
                            $temp2->save();
                            $message = $memberInfo->last_name.', '.$memberInfo->first_name.
                                        ' has been promoted from a prospect to a member.';
                        }
                    }
                }
            }
        }

        if ($message != '') {
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->with('success', 'The payment has been successfully added!');
        }
    }
}
