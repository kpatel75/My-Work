<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use App\Models\UserRole;
use App\Models\Jurisdiction;
use App\Models\Chapter;
use App\Models\Position;

use Exception;
use App\Helpers\LogActivity;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;


class EditMemberController extends Controller
{
    public function index()
    {
        $members = Member::all();

        return view('member.memberprofile', ['members' => $members]);
    }

    public function show(Member $member)
    {
        //getting the logged in user's jurisdiction and chapter information
        $jurisdictionid = Auth::user()->jurisdiction->id ?? '';
        $chapterid = Auth::user()->chapter->id ?? '';

        $jurisdictions = Jurisdiction::all();
        $chapters = Chapter::all();
        
        //getting positions from the positions table
        $positions = Position::all();

        return view('member.show_member', ['member' => $member,'chapters' => $chapters, 'jurisdictions' => $jurisdictions, 'positions' => $positions]);
    }

    public function edit(Member $member)
    {
        //getting the logged in user's jurisdiction and chapter information
        $jurisdictionid = Auth::user()->jurisdiction->id ?? '';
        $chapterid = Auth::user()->chapter->id ?? '';

        //if the user is part of the Canada jurisdiction, all chapters and jurisdictions are fetched
        if($jurisdictionid == 0)
        {
            $jurisdictions = Jurisdiction::all();
            $chapters = Chapter::all();
        }
        //if the user is not part of the Canada jurisdiction, only the user's jurisdictions and chapters will appear
        else
        {
            $jurisdictions = Jurisdiction::all()->where('id', '=', $jurisdictionid);
            $chapters = Chapter::all()->where('id', '=', $chapterid)->where('jurisdiction_id', '=', $jurisdictionid);
        }
        $positions = Position::all();


        return view('member.edit_member',['member' => $member,'chapters' => $chapters, 'jurisdictions' => $jurisdictions, 'positions' => $positions]);
    }

    public function update(Member $member)
    {
        //validation on all the form inputs
        $input = request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['max:30'],
            'preferred_name' => ['max:255'],
            'father_name' => ['string', 'nullable', 'max:255'],
            'mother_name' => ['string', 'nullable', 'max:255'],
            'guardian_one_name' => ['string', 'nullable', 'max:255'],
            'guardian_two_name' => ['string', 'nullable', 'max:255'],
            'birthdate' => ['required', 'date', 'before_or_equal:-9 years', 'date_format:Y-m-d'],
            'address' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:7', 'regex:/^[ABCDEFGHIJKLMNOPQRSTUVWXYZ]{1}\d{1}[A-Z]{1}\s\d{1}[A-Z]{1}\d{1}$/'],
            'home_phone' => ['max:12', 'regex:/[1-9][0-9][0-9][-][0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]/'],
            'work_phone' => ['max:12', 'regex:/[1-9][0-9][0-9][-][0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]/', 'nullable'],
            'mobile_phone' => ['max:12', 'regex:/[1-9][0-9][0-9][-][0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]/', 'nullable'],
            'country' => ['required', 'string', 'max:255'],
            'jurisdiction_id' => ['required', 'int'],
            'chapter_id' => ['required', 'int'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'father_senior_location' =>['string', 'nullable', 'max:255'],
            'father_mason_location' =>['string', 'nullable', 'max:255'],
            'mother_mason_other' =>['string', 'nullable', 'max:255'],
            'guardian_one_senior_location' =>['string', 'nullable', 'max:255'],
            'guardian_one_mason_location' =>['string', 'nullable', 'max:255'],
            'guardian_one_mason_other' =>['string', 'nullable', 'max:255'],
            'guardian_two_senior_location' =>['string', 'nullable', 'max:255'],
            'guardian_two_mason_location' =>['string', 'nullable', 'max:255'],
            'guardian_two_mason_other' =>['string', 'nullable', 'max:255'],
            'sponsor_id' =>['required', 'int', 'max:99999'],
            'sponsor_name' =>['required', 'string', 'max:255'],
            'status' =>['required'],
            'position_id' =>['required'],
            'initiatory_date' =>['date',  'before_or_equal:' . date('Y-m-d'), 'date_format:Y-m-d', 'nullable'],
            'senior_demolay_date' =>['date', 'before_or_equal:' . date('Y-m-d'), 'date_format:Y-m-d', 'nullable'],
            'demolay_degree_date' =>['date', 'before_or_equal:' . date('Y-m-d'), 'date_format:Y-m-d', 'nullable'],
            'notes' =>['string', 'max:255', 'nullable']
        ],

        //custom messages for error messages for certain errors
        [
            'home_phone.regex' => 'Home phone number must be in the format 123-456-7890.',
            'work_phone.regex' => 'Work phone number must be in the format 123-456-7890.',
            'mobile_phone.regex' => 'Mobile phone number must be in the format 123-456-7890.',
            'postal_code.regex' => 'Postal code must be in the format A1A 1A1.',
            'initiatory_date.before_or_equal' => 'Initiatory date cannot be in the future.',
            'senior_demolay_date.before_or_equal' => 'Senior DeMolay date cannot be in the future.',
            'birthdate.before_or_equal' => 'Member must be at least 9 years old (Before ' . date('Y-m-d', strtotime("-9 years")) . ')',
            'sponsor_id.int' => 'Please enter the Sponsor\'s five digit ID.'
        ]);

        //many if/else to deal with checkboxs within the form. if form sends checkbox info, then it is checked, if not then it is not checked
        if (request()->has('father_senior_status')) {
            $father_senior_status = true;
        }
        else{
            $father_senior_status = false;
        }

        if (request()->has('father_mason_status')) {
            $father_mason_status = true;
        }
        else{
            $father_mason_status = false;
        }

        if (request()->has('guardian_one_senior_status')) {
            $guardian_one_senior_status = true;
        }
        else{
            $guardian_one_senior_status = false;
        }

        if (request()->has('guardian_one_mason_status')) {
            $guardian_one_mason_status = true;
        }
        else{
            $guardian_one_mason_status = false;
        }

        if (request()->has('guardian_two_senior_status')) {
            $guardian_two_senior_status = true;
        }
        else{
            $guardian_two_senior_status = false;
        }

        if (request()->has('guardian_two_mason_status')) {
            $guardian_two_mason_status = true;
        }
        else{
            $guardian_two_mason_status = false;
        }

        DB::beginTransaction();

        try{
            //update the member's information with the inputted data
            $member->first_name = $input['first_name'];
            $member->last_name = $input['last_name'];
            $member->middle_name = $input['middle_name'];
            $member->preferred_name = $input['preferred_name'];
            $member->address = $input['address'];
            $member->email = $input['email'];
            $member->father_name = $input['father_name'];
            $member->mother_name = $input['mother_name'];
            $member->birthdate = $input['birthdate'];
            $member->province = $input['province'];
            $member->city = $input['city'];
            $member->postal_code = $input['postal_code'];
            $member->country = $input['country'];
            $member->jurisdiction_id = $input['jurisdiction_id'];
            $member->chapter_id = $input['chapter_id'];
            $member->father_senior_status = $father_senior_status;
            $member->father_mason_status = $father_mason_status;
            $member->guardian_one_name = $input['guardian_one_name'];
            $member->guardian_two_name = $input['guardian_two_name'];
            $member->guardian_one_senior_status = $guardian_one_senior_status;
            $member->guardian_one_mason_status = $guardian_one_mason_status;
            $member->guardian_two_senior_status = $guardian_two_senior_status;
            $member->guardian_two_mason_status = $guardian_two_mason_status;
            $member->father_senior_location = $input['father_senior_location'];
            $member->father_mason_location = $input['father_mason_location'];
            $member->mother_mason_other = $input['mother_mason_other'];
            $member->guardian_one_senior_location = $input['guardian_one_senior_location'];
            $member->guardian_one_mason_location = $input['guardian_one_mason_location'];
            $member->guardian_one_mason_other = $input['guardian_one_mason_other'];
            $member->guardian_two_senior_location = $input['guardian_two_senior_location'];
            $member->guardian_two_mason_location = $input['guardian_two_mason_location'];
            $member->guardian_two_mason_other = $input['guardian_two_mason_other'];
            $member->sponsor_id = $input['sponsor_id'];
            $member->sponsor_name = $input['sponsor_name'];
            $member->home_phone = $input['home_phone'];
            $member->work_phone = $input['work_phone'];
            $member->mobile_phone = $input['mobile_phone'];
            $member->position_id = $input['position_id'];
            $member->status = $input['status'];
            $member->notes = $input['notes'];
            $member->initiatory_date = $input['initiatory_date'];
            $member->senior_demolay_date = $input['senior_demolay_date'];
            $member->demolay_degree_date = $input['demolay_degree_date'];

            //attempt to save
            $member->save();

            //sending jurisdiction,chapter, and positions information to the success page
            $jurisdictionid = $input['jurisdiction_id'];
            $chapterid = $input['chapter_id'];
            $jurisdictions = Jurisdiction::all()->where('id', '=', $jurisdictionid);
            $chapters = Chapter::all()->where('id', '=', $chapterid)->where('jurisdiction_id', '=', $jurisdictionid);
            $positions = Position::all();

            //logs this transaction into the log table
            LogActivity::log('Update', "Update member $member->first_name $member->last_name", $member->id); 
        }
        //if there are errors, rollback and get messages
        catch(exception $e){
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        DB::commit();

        return view('member.show_member', ['member' => $member,'chapters' => $chapters, 'jurisdictions' => $jurisdictions, 'positions' => $positions])->with('success', 'Member successfully changed!');
    }
}
