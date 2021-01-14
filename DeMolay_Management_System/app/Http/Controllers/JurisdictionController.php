<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;  
use Exception;

//Validation
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests; 

//Models
use App\Models\Jurisdiction; 
use App\Models\Country;  
use App\Models\User;  


class JurisdictionController extends Controller
{
    //  

    public function index()
    {
        $jurisdictions = Jurisdiction::all();  
        
        $size = $jurisdictions[count($jurisdictions)-1]->id;  
       
        $user = User::where('id', Auth::user()->id); 

        return view('jurisdiction.addjurisdiction', ['jurisdictions'=>$jurisdictions, 'size'=>$size]); 
    }

    //add jurisdiction to jurisdiction table
    public function CreateJurisdiction(Request $req)
    {   
        DB::beginTransaction(); 

        try{ 
            //initialize new jurisdiction
            $jurisdiction = new Jurisdiction();  
            $jurisdiction->id = $req->id; 
            $jurisdiction->location = $req->location; 
            $jurisdiction->description = $req->description; 
            $jurisdiction->country_id = $req->jurisdiction_id; 
            $jurisdiction->save();  
            DB::commit(); 

            //log creation of jurisdiction
            LogActivity::log('Create', "Create jurisdiction $req->description with id: $req->id");
        } 
        catch(Exception $e) 
        {   
            //catch exceptions
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'User Successfully Added.');
    } 

    //this function gets jurisdiction information for a given id number
    public function getJursidiction(int $id)
    {
        DB::table('jurisdictions')->where('id', $id)->first(); 
        
    } 

    //this function returns the update page for
    public function initUpdatePage($id = null)
    {
        $countries = Country::all();   
        print($id);
        if($id == null)
        {   
            $id = DB::table('jurisdictions')->max('id');
            $jurisdiction = new Jurisdiction();
            $jurisdiction->id = $id;
        }
        else
        {
           // $jurisdiction = DB::table('jurisdictions')->where('id', $id)->first(); 
            
            
           /* if($jurisdiction == null)
            {*/
                $jurisdiction = Jurisdiction::find($id); 
                if($jurisdiction == null)
                {
                    $jurisdiction = new Jurisdiction(); 
                    $jurisdiction->id = $id;
                }
              //  $jurisdiction = new Jurisdiction(); 
                //$jurisdiction->id = $id;
            //} 
        }
        return view('jurisdiction.updatejurisdiction', ['countries'=>$countries, 'jurisdiction'=>$jurisdiction]);
    } 

    public function updateJurisdiction(Request $req)
    {   
        //Check of country
        if($req->country == null)
        {
            return back()->withInput()->with('error', 'Please select a country for this jurisdiction');
        }
        //If jurisdiction exists update jurisdiction else create a new jurisdiction
        if(Jurisdiction::where('id',$req->id)->count()!= 0) 
        {
            DB::update('update jurisdictions set description = ?, country_id = ? where id = ?', [$req->description, $req->country, $req->id]);  

            //log update
            LogActivity::log('Create', "Update jurisdiction $req->description with id: $req->id");
         
        }
        else
        {
            $jurisdiction = new Jurisdiction(); 
            $jurisdiction->id = $req->id; 
            $jurisdiction->description = $req->description; 
            $jurisdiction->country_id = $req->country; 
            $jurisdiction->save(); 
            // create new jurisdiction
            LogActivity::log('Create', "Create jurisdiction $req->description with id: $req->id");
            
        }
        return redirect('managejurisdictions')->with('success', 'Successfully updated jurisdictions');
    } 
    //This function will delete a jurisdiction 
    public function deleteJurisdiction($id)
    {   
        $deleteJur = DB::table('jurisdictions')->where('id',$id)->first();
        DB::table('jurisdictions')->where('id',$id)->delete(); 
        //log jurisdiction delete
        LogActivity::log('Delete', "Delete jurisdiction $deleteJur->description with id: $deleteJur->id");
        //return success message
        return redirect()->back()->with('success', 'Successfully deleted jurisdictions');
    }
    
}
