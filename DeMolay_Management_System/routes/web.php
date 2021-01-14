<?php


use App\Http\Controllers\RegisterUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgeDistributionReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UpdateEmail;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeeController;
use Laravel\Fortify\Contracts\UpdatesUserEmail; 
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller as ControllersController;
use App\Http\Controllers\ExcelMemberListController;
use App\Http\Controllers\JurisdictionController;
use App\Http\Controllers\ListOfMemberReportController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MeritBarRecordController;
use App\Http\Controllers\NominationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 

Route::get('/', function () {
    return view('auth.login');
});

Route::get("test", [TestController::class, 'index']); 

Route::get('/home', [DashboardController::class, 'membersByAge']) ->middleware(['auth']); //middleware is required for authorized/logged in users.  


/*Route::get('/register', function(){
    return view('auth.register');
}) ->middleware(['auth']);*/ 

//Change Email Routes
Route::get('/changeEmail', function () {
    return view('changeemail');
})->middleware(['auth']);

Route::post('updateEmail', [UpdateEmail::class, 'updateEmail'])->middleware(['auth']);

//Contact page routes
Route::resource('contacts', ContactController::class);

//Middleware Groups for specified roles  
//Authenticated Users
    //Secretary role/superuser -> for Secretary
    Route::group(['middleware'=>['role:secretary', 'role:president']], function() { 
        
    });  

    //President role -> president and board of directors
    Route::group(['middleware'=>['role:president']], function() { 
    
    }); 

    //Executive role -> executive officer
    Route::group(['middleware'=>['role:Executive']], function() { 
    
       /* Route::get('test', function(){
            return view('test');
        }) ->middleware(['auth']);*/
    });  

    //route for laravel 8
Route::get('/changePassword',[changePasswordController::class, 'index'])->name('changePassword')->middleware(['auth']);
Route::post('/changePassword',[changePasswordController::class, 'changePassword'])->name('changePassword')->middleware(['auth']); 

//Payments
Route::get('/payment/{id}', [PaymentController::class, 'getMemberPaymentInfo'])->middleware(['auth']);
Route::post('/payment', [PaymentController::class, 'storePayment'])->name('storePayment')->middleware(['auth']);
//Member Fees
Route::get('/fees', [FeeController::class, 'getChapterFees'])->middleware('auth');
Route::post('/fees', [FeeController::class, 'storeFee'])->name('storeFee')->middleware('auth');
//Editing Fees
Route::get('/editFee/{id}', [FeeController::class, 'getFeeInfo'])->middleware('auth');
Route::post('/editFee', [FeeController::class, 'updateFee'])->name('updateFee')->middleware('auth');
//Fee Description
Route::get('/feedescription', [FeeController::class, 'getFeeDescription'])->middleware('auth');
Route::get('/editfeedescription/{id}', [FeeController::class, 'getDescriptionInfo'])->middleware('auth');
Route::post('/editfeedescription', [FeeController::class, 'updateDescription'])->name('updateDescription')->middleware('auth');

//Create Member
Route::get('/create-member', 'App\Http\Controllers\CreateMemberController@index')->middleware(['auth', 'checkit:member,write', 'role:Chapter Chairman|Chapter Advisor|Chapter Dad|Admin|IT Admin' ]);;
Route::post('/create-member', 'App\Http\Controllers\CreateMemberController@create')->middleware(['auth', 'checkit:member,write', 'role:Chapter Chairman|Chapter Advisor|Chapter Dad|Admin|IT Admin']);;

//edit member
Route::get('/memberprofile/{member}/edit', 'App\Http\Controllers\EditMemberController@edit')->middleware(['auth', 'checkit:member,write', 'role:Chapter Chairman|Chapter Advisor|Chapter Dad|Admin|IT Admin']);
Route::patch('/memberprofile/{member}/show', 'App\Http\Controllers\EditMemberController@update')->middleware(['auth', 'checkit:member,write', 'role:Chapter Chairman|Chapter Advisor|Chapter Dad|Admin|IT Admin']);
Route::get('/memberprofile/{member}/show', 'App\Http\Controllers\EditMemberController@show')->middleware(['auth', 'checkit:member,write', 'role:Chapter Chairman|Chapter Advisor|Chapter Dad|Admin|IT Admin']);

//route for Member Activity
Route::get('/member-activity-list/{id}', 'App\Http\Controllers\MemberActivityController@displayMemberActivity')->middleware(['auth', 'role:Chapter Chairman|Chapter Advisor|Executive Officer|Secretary|Admin|IT Admin']);
Route::get('/member-list', 'App\Http\Controllers\MemberActivityController@listOfMembers')->middleware(['auth']);
Route::get('/create-member-activity/{id}', 'App\Http\Controllers\MemberActivityController@getMemberActivity')->middleware(['auth', 'checkit:member,write', 'role:Chapter Chairman|Executive Officer|Chapter Advisor|Chapter Dad|Admin|IT Admin']);
Route::post('/create-member-activity', 'App\Http\Controllers\MemberActivityController@create')->name('store')->middleware(['auth', 'checkit:member,write', 'role:Chapter Chairman|Executive Officer|Chapter Advisor|Chapter Dad|Admin|IT Admin']);

//route for Activity Category
Route::get('/type-of-activity', 'App\Http\Controllers\TypeOfActivityController@index')->middleware(['auth']);
Route::post('/type-of-activity', 'App\Http\Controllers\TypeOfActivityController@create')->middleware(['auth']);

//route for Meri Bar Record
Route::get('/merit-bar-record/{id}', 'App\Http\Controllers\MeritBarController@displayMemberMeritBar')->middleware(['auth']);
//Route::post('/type-of-activity', 'App\Http\Controllers\TypeOfActivityController@create')->middleware(['auth']);

    //Chapter role -> Chapter Chairman, Chapter Dad
    Route::group(['middleware'=>['role:chapter']], function() { 
        Route::get('chapterreport', [ReportingController::class, 'index'])->name('chapterreport')->middleware(['auth']);  
    Route::get('reportchapters', function(){
        return view('reports.chapterreport');
    })->middleware(['auth', ]); 
    Route::get('reports/chapter/payment', [ReportingController::class, 'getPaymentInformation'])->name('reports.chapter.payment')->middleware(['auth', 'role:Chapter Chairman|Chapter Advisor|Executive Officer|Secretary|Admin|IT Admin']); 
    });  

    //Routes to register new member internally  
    Route::group(['middleware'=>['createuser']], function(){
    
        //gets roles that authenticated user can create
        Route::get('createuser', [RegisterUser::class, 'getRegisterRoles'])->name('registrationroles')->middleware(['auth']);
        //gets view for registrationj form
        Route::get('registeruser', function() { 
            return view('registeruser');
        })->middleware(['auth']);
        //sends data to CreateUser Controller
        Route::post('adduser', [RegisterUser::class, 'registerUser'])->middleware(['auth']);  

       // Route::get('getchapters/{jurisdiction}', [ChapterController::class, 'listChapters'])->name('getchapters')->middleware(['auth']); 

       
    }); 

    //list chapters
    Route::get('getchapters/{jurisdiction}', [ChapterController::class, 'listChapters'])->name('getchapters')->middleware(['auth']); 
    
    //add new chapter
    Route::get('chapter', [ChapterController::class, 'index'])->middleware(['auth', 'checkit:chapter,write', 'role:Executive Officer|Secretary|Admin|IT Admin']);

    Route::post('addchaptercommit', [ChapterController::class, 'createChapter'])->middleware(['auth', 'checkit:chapter,write', 'role:Executive Officer|Secretary|Admin|IT Admin']); 

    Route::get('addchapterpage', function(){
        return view('chapter.addchapter');
    })->middleware(['auth', 'checkit:chapter,write', 'role:Executive Officer|Secretary|Admin|IT Admin']); 

    Route::get('managechapters', [ChapterController::class, 'initChapterManagement'])->middleware(['auth', 'checkit:chapter, read', 'role:Executive Officer|Secretary|Admin|IT Admin']); 


    Route::get('viewchapter/{id?}/{jurisdiction?}', [ChapterController::class, 'viewChapterUpdate'])->middleware(['auth', 'role:Executive Officer|Board Member|President|Secretary|Admin|IT Admin|Director At Large', 'checkit:jurisdiction, write'])->middleware(['auth', 'role:Executive Officer|Board Member|President|Secretary|Admin|IT Admin|Director At Large', 'checkit:jurisdiction, write']);; 

    Route::get('addchapter', [ChapterController::class, 'initAddChapter']);

    Route::POST('commitchapterupdate', [ChapterController::class, 'updateChapter'])->middleware(['auth']); 

    Route::get('deletechapter/{id}/{jursidiction}', [ChapterController::class, 'deleteChapter'])->middleware(['auth', 'role:Executive Officer|Secretary|Admin|IT Admin|Director At Large|President']);

    Route::get('getchapters/{jurisdiction?}', [ChapterController::class, 'listChapters'])->name('getchapters')->middleware(['auth', 'role:Executive Officer|Secretary|Admin|IT Admin|Director At Large|President']);
    

    //Manage It Admin
    Route::get('manageitadmin', function(){
        return view('admin.manageitadmin');
    })->middleware(['auth', 'role:admin']);
    
    Route::get('itadminmanagement', [AdminController::class, 'index'])->name('itadminmanagement')->middleware(['auth', 'role:admin']); 

    Route::post('updateitadmin', [AdminController::class, 'updateItAdmin'])->middleware(['auth', 'role:admin']);  

    //jurisdictions 
    Route::get('managejurisdictions', [JurisdictionController::class, 'index'])->middleware(['auth', 'checkit:jurisdiction, read', 'role:Admin|IT Admin|Secretary|President|Board Member|Director At Large']); 

    Route::get('viewjurisdiction/{id}', [JurisdictionController::class, 'initUpdatePage'])->middleware(['auth', 'checkit:jurisdiction, write', 'role:Admin|IT Admin|Secretary|President|Secretary|Director At Large']);

    Route::post('viewjurisdiction/updatejurisdiction', [JurisdictionController::class, 'updateJurisdiction'])->name('viewjurisdiction')->middleware(['auth', 'checkit:jurisdiction, write', 'role:Admin|IT Admin|Secretary|President|Director At Large']); 


    Route::get('deleteJurisdiction/{id}', [JurisdictionController::class, 'deleteJurisdiction'])->middleware(['auth', 'checkit:jurisdiction, write', 'role:Admin|IT Admin|President|Secretary|Director At Large']);

    

    //reports 
    Route::get('chapterreport', [ReportingController::class, 'index'])->name('chapterreport')->middleware(['auth']);  
    Route::get('reportchapters', function(){
        return view('reports.chapterreport');

    }); 
    Route::get('reports/chapter/payment', [ReportingController::class, 'getPaymentInformation'])->name('reports.chapter.payment')->middleware(['auth']); 

    // Search Member / Member List
    Route::get('search', [SearchController::class, 'search'])->name('search')->middleware(['auth', 'checkit:member, read', 'role:Admin|IT Admin|President|Secretary|Executive Officer|Chapter Advisor|Chapter Dad|Chapter Chairman|Director At Large']);
    
    Route::get('reports/chapter/payment', [ReportingController::class, 'getPaymentInformation'])->name('reports.chapter.payment')->middleware(['auth']);  

    //member profile 
    Route::get('memberprofile/{id}', [MemberController::class, 'getMemberProfileInformation'])->middleware(['auth', 'role:Chapter Advisor|Chapter Chairman|Executive Officer|Admin|IT Admin|President|Secretary|Director At Large', 'checkit:member, read']);




//Reports
    Route::get('/search/excel', [ExcelMemberListController::class, 'excel'])->name('export_excel.excel');
    Route::get('memberlistreport', [ListOfMemberReportController::class, 'index'])->name('memberlistreport');
    Route::get('memberlistreportpdf', [ListOfMemberReportController::class, 'createPDF'])->name('memberlistpdf');

    Route::get('agedistributionreport', [AgeDistributionReportController::class, 'index'])->name('agedistributionreport');
    Route::get('agedistributionreportpdf', [AgeDistributionReportController::class, 'createPDF'])->name('agedistributionreportpdf');

    Route::get('activitydistributionreport', 'App\Http\Controllers\ActivityDistributionReportController@index')->name('activitydistributionreport');
    Route::get('activitydistributionreportpdf', 'App\Http\Controllers\ActivityDistributionReportController@createPDF')->name('activitydistributionreportpdf');

  //Merit Bar Records 
    Route::get('meritbarrecord/{id}', [MeritBarRecordController::class, 'loadPage'])->middleware(['auth', 'checkit:member, read', 'role:Admin|IT Admin|President|Secretary|Executive Officer|Chapter Advisor|Chapter Dad|Chapter Chairman|Director At Large']); 
    Route::get('addmeritbar/{id}', [MeritBarRecordController::class, 'addRecordPage'])->middleware(['auth', 'checkit:member, write', 'role:Admin|IT Admin|President|Secretary|Executive Officer|Chapter Advisor|Chapter Dad|Chapter Chairman|Director At Large']); 
    Route::post('addmeritbarrecord', [MeritBarRecordController::class, 'addMeritBar'])->name('addmeritbarrecord')->middleware(['auth', 'role:Admin|IT Admin|Executive Officer|Chapter Advisor|Chapter Dad|Chapter Chairman', 'checkit:member, write']); 
//route to add meritbar 
    Route::get('confirmmeritbar/{memberid}/{typeofactivityid}/{meritbarid}', [MeritBarRecordController::class, 'recordCalculatedMeritBar'])->middleware(['auth', 'role:Admin|IT Admin|Executive Officer|Chapter Advisor|Chapter Dad|Chapter Chairman', 'checkit:member, write']);

//activity logs for admin 
    Route::get('activitylog', [LogActivityController::class, 'index'])->middleware(['auth', 'role:Admin|IT Admin']); 
//nominations
    Route::get('nominations/{id?}', [NominationController::class, 'index'])->middleware(['auth']); 
    Route::POST('autocomplete', [NominationController::class, 'findMember'])->name('autocomplete')->middleware(['auth']); 
    Route::post('savenomination', [NominationController::class, 'addNomination'])->middleware(['auth']);

    Route::get('deletemeritbarrecord/{member_id}/{activity_id}/{merit_bar_id}', [MeritBarRecordController::class, 'deleteMeritBarRecord'])->middleware(['auth', 'checkit:member, write']); 

    //manage users 
    Route::get('manageusers', [UserController::class, 'displayUsers'])->middleware(['auth', 'createuser']); 
    Route::get('updateuser/{id}', [UserController::class, 'initManageUser'])->middleware(['auth']); 
    Route::POST('commituserupdate', [UserController::class, 'updateUser'])->middleware(['auth']); 
    Route::get('deleteuser/{id}', [UserController::class, 'deleteUser'])->middleware(['auth', 'createuser']);

