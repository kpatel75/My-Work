<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Contact;
use App\Helpers\LogActivity;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = DB::table('contacts')->get();

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email'
        ]);

        $contact = new Contact([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'url' => $request->get('url')
        ]);
        $contact->save(); 
        //Added for logging purposes
        LogActivity::log('Create', "Create contact $request->name");
        return redirect('/contacts')->with('success', 'Contact saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function edit($id)
    {
        $contact = Contact::find($id);
        return view('contacts.edit', compact('contact'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email'
        ]);

        $contact = Contact::find($id);
        $contact->name =  $request->get('name');
        $contact->email = $request->get('email');
        $contact->url = $request->get('url');
        $contact->save(); 
        //for logging purposes
        LogActivity::log('Update', "Update contact $request->name");
        return redirect('/contacts')->with('success', 'Contact updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        //for logging purposes
        LogActivity::log('Delete', "Delete contact $contact->name");
        return redirect('/contacts')->with('success', 'Contact deleted!');
    }
}