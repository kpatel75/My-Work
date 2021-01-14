<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\User;
use App\Models\Role;
use App\Models\Fee;
use App\Models\FeeDescription;

// Validation Rules
use App\Rules\GreaterThanFeeAmountC;
use App\Rules\LessThanFeeAmountC;
use App\Rules\GreaterThanFeeAmountD;
use App\Rules\LessThanFeeAmountD;
use App\Rules\EqualsYearAndDescriptionSelect;
use App\Rules\EqualsYearAndDescription;

class FeeController extends Controller
{
    //Gets all the fee history
    public function getChapterFees() {
        // added_by = users id
        // eddited_by = users id
        // this takes in the current users jurisdiction id and chapter to find which chapter they are a part of 
        $chapterFees = DB::table('fees')
                    ->select('fees.id', 'fee_descriptions.description', 'fees.amount', 'users.first_name', 'users.last_name', 'fees.edited_by_first_name', 
                    'fees.edited_by_last_name', 'fees.year', 'fees.demolay_contribution', 'fees.chapter_contribution')
                    ->leftjoin('users', 'users.id', '=', 'fees.added_by')
                    ->leftJoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                    ->where([
                        ['fees.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                        ['fees.chapter_id', '=', Auth::user()->chapter_id]])
                    ->orderBy('fees.id', 'desc')
                    ->get();
        // gets the description from description table
        $descriptionInfo = DB::table('fee_descriptions')
                            ->select('fee_descriptions.id', 'fee_descriptions.description')
                            ->where([
                                ['fee_descriptions.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                                ['fee_descriptions.chapter_id', '=', Auth::user()->chapter_id]])
                            ->orderBy('description', 'asc')
                            ->get();
        // find the role id in the users
        $user = User::find(Auth::user()->id)->roles()->get()->first();
        // finds the role id with the role name of Executive Officer
        $role = Role::where('role_name', 'Executive Officer')->get()->first();
        // checks if there is any user that has been queried
        if ($user) {
            // checks if the current user that is logged has a role of an executive officer
            if ($user->id === $role->id) {
                // queries the chapters using the executives jurisdiction
                $chapters = DB::table('chapters')
                            ->select('id', 'location')
                            ->where('jurisdiction_id', '=', Auth::user()->jurisdiction_id)
                            ->get();
                // queries all the fees in the excutives jurisdiction
                $chapterFees = DB::table('fees')
                                ->select('fees.id', 'fee_descriptions.description', 'fees.chapter_id', 'fees.amount', 'users.first_name', 'users.last_name', 'fees.edited_by_first_name', 
                                'fees.edited_by_last_name', 'fees.year' , 'fees.demolay_contribution', 'fees.chapter_contribution')
                                ->leftjoin('users', 'users.id', '=', 'fees.added_by')
                                ->leftJoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                                ->where('fees.jurisdiction_id', '=', Auth::user()->jurisdiction_id)
                                ->orderBy('fees.id', 'desc')
                                ->get();
                return view('fees',['chapterFees' => $chapterFees, 'chapters' => $chapters, 'role' => $role, 'user' => $user, 'descriptionInfo' => $descriptionInfo]);
            }
        }
        return view('/fees',['chapterFees' => $chapterFees, 'role' => $role, 'user' => $user, 'descriptionInfo' => $descriptionInfo]);
    }

    //Store the fee to the database
    public function storeFee(Request $request) {
        $this->validate($request, [
            'amount' => ['required', 'numeric'],
            'descriptionSelect' => [
                'required_without:description', 
                new EqualsYearAndDescriptionSelect($request->input('year'))],
            'description' => [
                'required_without:descriptionSelect', 'max:50',
                new EqualsYearAndDescription($request->input('year'))],
            'year' => 'required',
            'chapter' => [
                'bail', 'required', 'numeric',
                new GreaterThanFeeAmountC($request->input('amount'), $request->input('demolay')),
                new LessThanFeeAmountC($request->input('amount'), $request->input('demolay'))],
            'demolay' => [
                'bail', 'required', 'numeric',
                new GreaterThanFeeAmountD($request->input('amount'), $request->input('chapter')),
                new LessThanFeeAmountD($request->input('amount'), $request->input('chapter'))]
        ]);

        $fee = new Fee();
        $fee->amount = $request->input('amount');
        // checks to see if the description input has a value
        if ($request->input('description') == '') {
            $fee->description_id = $request->input('descriptionSelect');
        } else {
            $feeDesc = new FeeDescription();
            $feeDesc->description = $request->input('description');
            $feeDesc->jurisdiction_id = Auth::user()->jurisdiction_id;
            $feeDesc->chapter_id = Auth::user()->chapter_id;
            $feeDesc->save();
            $fee->description_id = FeeDescription::where([
                                                        ['description', $request->input('description')],
                                                        ['jurisdiction_id', Auth::user()->jurisdiction_id],
                                                        ['chapter_id', Auth::user()->chapter_id]])
                                                    ->pluck('id')
                                                    ->first();
        }
        $fee->chapter_id = Auth::user()->chapter_id;
        $fee->jurisdiction_id = Auth::user()->jurisdiction_id;
        $fee->demolay_contribution = $request->input('demolay');
        $fee->chapter_contribution = $request->input('chapter');
        $fee->added_by = Auth::user()->id;
        $fee->year = $request->input('year');
        $fee->save(); 

        LogActivity::log('Create', "Create fee for jurisdiction: $fee->jurisdiction_id and chapter: $fee->chapter_id with id: $fee->id");
        
        return redirect()->back()->with('success', 'The fee has been added.');
    }

    // used to get the data for the edit fee page
    public function getFeeInfo($id) {
        $feeInfo = DB::table('fees')
                    ->select('fees.id', 'fees.amount', 'fee_descriptions.description', 'fees.year', 
                    'users.first_name', 'users.last_name', 'fees.edited_by_id', 'fees.edited_by_first_name', 
                    'fees.edited_by_last_name', 'fees.demolay_contribution', 'fees.chapter_contribution')
                    ->leftjoin('payments', 'payments.fee_id', '=', 'fees.id')
                    ->leftjoin('users', 'fees.added_by', '=', 'users.id', 'AND', 'fees.edited_by_id', '=', 'users.id')
                    ->leftJoin('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                    ->where('fees.id', $id)
                    ->get()
                    ->first();
        $descriptionInfo = DB::table('fee_descriptions')
                    ->select('fee_descriptions.id', 'fee_descriptions.description')
                    ->where([
                        ['fee_descriptions.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                        ['fee_descriptions.chapter_id', '=', Auth::user()->chapter_id]])
                    ->orderBy('description', 'asc')
                    ->get();
        return view('editFee', ['feeInfo' => $feeInfo, 'descriptionInfo' => $descriptionInfo]);
    }

    // used for updating a row in the fee table
    public function updateFee(Request $request) {
        $this->validate($request, [
            'amount' => ['required', 'numeric'],
            'year' => 'required',
            'chapter' => [
                'bail', 'required', 'numeric',
                new GreaterThanFeeAmountC($request->input('amount'), $request->input('demolay')),
                new LessThanFeeAmountC($request->input('amount'), $request->input('demolay'))],
            'demolay' => [
                'bail', 'required', 'numeric',
                new GreaterThanFeeAmountD($request->input('amount'), $request->input('chapter')),
                new LessThanFeeAmountD($request->input('amount'), $request->input('chapter'))]
        ]);

        $fee = Fee::find($request->input('id'));
        $fee->amount = $request->input('amount');
        $fee->chapter_id = Auth::user()->chapter_id;
        $fee->jurisdiction_id = Auth::user()->jurisdiction_id;
        $fee->demolay_contribution = $request->input('demolay');
        $fee->chapter_contribution = $request->input('chapter');
        $fee->added_by = Auth::user()->id;
        $fee->year = $request->input('year');
        $fee->edited_by_id = Auth::user()->id;
        $fee->edited_by_first_name = Auth::user()->first_name;
        $fee->edited_by_last_name = Auth::user()->last_name;
        $fee->save();
        
        LogActivity::log('Update', "Update fee for jurisdiction: $fee->jurisdiction_id and chapter: $fee->chapter_id with id: $fee->id");

        return redirect()->action([FeeController::class, 'getChapterFees'])->with('success', 'The fee has been edited successfully!');
    }

    // Gets the all the id and description to display in a list
    public function getFeeDescription() {
        $feeDescription = DB::table('fee_descriptions')
                            ->select('id', 'description')
                            ->where([
                                ['fee_descriptions.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                                ['fee_descriptions.chapter_id', '=', Auth::user()->chapter_id]])
                            ->get();
        return view('feedescription', ['feeDescription' => $feeDescription]);
    }

    // Deletes 

    // Get a specific description info
    public function getDescriptionInfo($id) {
        $desc = DB::table('fee_descriptions')
                    ->select('id', 'description')
                    ->where([
                        ['fee_descriptions.id', '=', $id],
                        ['fee_descriptions.jurisdiction_id', '=', Auth::user()->jurisdiction_id],
                        ['fee_descriptions.chapter_id', '=', Auth::user()->chapter_id]])
                    ->get()
                    ->first();

        return view('editfeedescription', ['desc' => $desc]);
    }

    // Edits the current description
    public function updateDescription(Request $request) {
        $this->validate($request, [
            'description' => 'required|max:50'
        ]);
        
        FeeDescription::where('id', '=', $request->input('id'))
                        ->where('chapter_id', '=', Auth::user()->chapter_id)
                        ->where('jurisdiction_id', '=', Auth::user()->jurisdiction_id)
                        ->update(['description' => $request->input('description')]);
        

        return redirect()->action([FeeController::class, 'getFeeDescription'])->with('success', 'The description has been successfully edited.');
    }
}
