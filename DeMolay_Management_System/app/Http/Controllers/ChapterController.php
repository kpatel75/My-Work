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
use App\Models\Chapter;
use App\Models\Member; 
use App\Models\User; 

class ChapterController extends Controller
{
    //Initialized the manage chapter page
    public function index()
    {
        $jurisdiction = Auth::user()->jurisdiction->id;  
        if($jurisdiction == 0)
        {
            $displayJurisdictions = Jurisdiction::all(); 
        }
        else 
        {
            $displayJurisdictions = $jurisdiction; 
        } 

        
        return view('chapter.addchapter', ['jurisdiction'=>$displayJurisdictions]); 
    } 

    public function initAddChapter()
    {
        $jurisdiction = Auth::user()->jurisdiction->id;  
        if($jurisdiction == 0)
        {
            $displayJurisdictions = Jurisdiction::all(); 
        }
        else 
        {
            $displayJurisdictions = Jurisdiction::where('id', Auth::user()->jurisdiction->id)->get(); 
        } 
        
        //print($displayJurisdictions);
        return view('chapter.addchapter', ['jurisdictions'=>$displayJurisdictions]); 
    }

    public function updateChapter(Request $req)
    {
        DB::beginTransaction(); 
        try{
        DB::update('update chapters set description = ?, location = ? where id = ? and jurisdiction_id = ?', [$req->description, $req->location, $req->id, $req->jurisdiction]);
        $message = 'Chapter updated successfully.';  
        LogActivity::log("Update", "Update Chapter $req->description in jurisdiction $req->jurisdiction");
        DB::commit(); 
        } 
        catch(Exception $e) 
        {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        } 
        $message = 'Chapter updated successfully.'; 
        return redirect('managechapters')->with('success', $message);
    }
    //recieves request and based on information provided either creates or updates a chapter
    public function createChapter(Request $req)
    {       
       $message = ""; 
       //null id means a chapter is being created
        //if($req->id == null)
        //{   
            $id = DB::table('chapters')->where('jurisdiction_id', $req->jurisdiction)->max('id'); 
            //print($req->id);   
           $chapterExists = DB::table('chapters')->where('id',  ltrim(strval($req->id), '0'))->where('jurisdiction_id', $req->jurisdiction)->count();
           // print("Exists: $chapterExists");
           if($chapterExists > 0)
           {
               return back()->with('error', 'A chapter with the same id already exists in that jurisdiction. Try chapter id of: '.$id);
           }
           else
           {
            DB::beginTransaction(); 
            //create new chapter
            try{ 
                $chapter = new Chapter(); 
                $chapter->id = $req->id;  
                $chapter->location = $req->location; 
                $chapter->description = $req->description; 
                $chapter->jurisdiction_id = $req->jurisdiction; 
                $chapter->save(); 
                LogActivity::log("Create", " Create chapter $chapter->description");
                DB::commit(); 
            } 
            catch(Exception $e) 
            {
                DB::rollback();
                return redirect()->back()->with('error', $e->getMessage());
            } 
            $message = 'Chapter added successfully.'; 
            return redirect('managechapters')->with('success', $message);
        }
      //  } 
        //else
        //{   
            //update existing chapter
           /* DB::beginTransaction(); 
            try{
            DB::update('update chapters set description = ?, location = ? where id = ? and jurisdiction_id = ?', [$req->description, $req->location, $req->id, $req->jurisdiction]);
            $message = 'Chapter updated successfully.';  
            LogActivity::log("Update", "Update Chapter $req->description in jurisdiction $req->jurisdiction");
            DB::commit(); 
            } 
            catch(Exception $e) 
            {
                DB::rollback();
                return redirect()->back()->with('error', $e->getMessage());
            } 
            */
            
       // } 
        
        //return success message
       
    }  

    //returns list of chapters 
    //optional parameter for jurisdiction. If passed will narrow chapters by jurisdictions else will return all chapters
    public function listChapters($jurisdiction = null)
    {   
        
        if(Auth::user()->chapter != NULL)
        {   
            $chapters = Chapter::where('id', Auth::user()->chapter_id)->where('jurisdiction_id', Auth::user()->jurisdiction_id)
            ->pluck('description', 'id');
            return response()->json($chapters);;
        } 
        else  
        {
            
            $chapters = Chapter::where('jurisdiction_id', $jurisdiction)
            ->pluck('description', 'id'); 
           

        return response()->json($chapters);
        }
    } 

    public function initChapterManagement()
    {   
        //gets jurisdiction the user belongs to. if users do not belong 
        //to canada jurisdiction they can only view chapters in their jurisdiction
        $jurisdiction = Auth::user()->Jurisdiction->id; 
        
        if($jurisdiction == 0)
        {
            $jurisdiction = Jurisdiction::all();  
            $chapters = DB::table('chapters')->join('jurisdictions', 'chapters.jurisdiction_id', '=', 'jurisdictions.id')
            ->select('chapters.*', 'jurisdictions.description as jurisdictiondescription')
            ->get(); 

            
        }
        else
        {
            $chapters = Chapter::where('jurisdiction_id', $jurisdiction)->get(); 
        }
        //print(Auth::user());
        return view('chapter.managechapters', ['chapters'=>$chapters]); 
    }

    //Gets information on a specific chapter
    //Chapters have composite primary key so need jurisdiction id and chapter id to find correct chapter
    public function viewChapterUpdate($id = null, $jurisdiction = null)
    {   
        $jurisdictions = Auth::user()->jurisdiction->id;   
        $chapterView = null;
        if($id == null && $jurisdiction == null)
        { 
            
            $chapterView = new Chapter();
            
            if($jurisdiction != 0)
            { 
                $chapterView->jurisdiction_id = $jurisdiction; 
            }
            
        }
        else
        {
            $chapterView = DB::table('chapters')->where('id', $id)->where('jurisdiction_id', $jurisdiction)->first();   
        }
        
        //people that belong to a jurisdiction of 0 can see all jurisdictions
        if($jurisdictions == 0)
        {
            $displayJurisdictions = Jurisdiction::all(); 
        }
        else 
        {
            $displayJurisdictions = DB::table('jurisdictions')->where('id', $jurisdictions)->get();
        }  

        $id = DB::table('chapters')->where('jurisdiction_id', $jurisdiction)->max('id'); 

        return view('chapter.updatechapter', ['jurisdiction'=>$displayJurisdictions, 'chapter'=>$chapterView]);


    }

    //delete chapter from jurisdiction
     //Chapters have composite primary key so need jurisdiction id and chapter id to find correct chapter
    public function deleteChapter($id, $jurisdiction)
    {   
        //DB::update('update users set chapter_id=null where chapter_id = ?', [$id]); 
        //find out if members are in jurisdiction
        $members = Member::where('chapter_id', $id)->where('jurisdiction_id', $jurisdiction)->count(); 

        if($members > 0)
        {
            return back()->with('error', 'Members are still assigned to this chapter. Please reassign them before deleting this chapter.');
        }

        $users = User::where('chapter_id', $id)->where('jurisdiction_id', $jurisdiction)->count(); 
        if($users > 0)
        {
            return back()->with('error', 'Users are still assigned to this chapter. Please reassign them before deleting this chapter.');
        }

        $deleteChapter = DB::table('chapters')->where('id',$id)->where('jurisdiction_id', $jurisdiction)->first();
        DB::table('chapters')->where('id',$id)->where('jurisdiction_id', $jurisdiction)->delete(); 
        //log activity in db table
        LogActivity::log('Delete', "Delete chapter $deleteChapter->description in jurisdiction $jurisdiction");
       
        return redirect()->back()->with('success', 'Successfully deleted chapter');
    }

}
