<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listing
    public function index() {
        return view('listings.index', [
            'listings'=>Listing::latest()->filter(request(['tag','search']))->paginate(4)
        ]);

    }


    //show listing form
    public function create(){
        return view ('listings.create');
    }

    //store data from the create form 
    public function store(Request $request)
{
    $formField = $request->validate([
        'title' => 'required',
        'company' => ['required', Rule::unique('listings', 'company')],
        'location' => 'required',
        'email' => ['required', 'email'],
        'website' => 'required',
        'tags' => 'required',
        'description' => 'required',
    ]);

    $user = auth()->user();

    // Handle logo image upload
    if ($request->hasFile('logo')) {
        $imagePath = $request->file('logo')->store('logos', 'public');
        $formField['logo'] = $imagePath;
    }

    // Create the listing associated with the user
    $user->listings()->create($formField);

    return redirect('/')->with('message', 'Listing Created Successfully!!!');
}

    //show single listing
    public function show(listing $listing) {
        return view ('listings.show', [
            'listing' => $listing
        ]);

    }

    //show Edit listing form 
    public function edit(listing $listing) {
        return view ('listings.edit', [
            'listing' => $listing
        ]);

    }

    //update the  data from the edit form 
    public function update(Request $request, Listing $listing){

        //make sure logged in user is the owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unathorized Action');
        };

        $formField = $request->validate([
            'title'=>'required',
            'company'=>'required',
            'location'=>'required',
            'email'=> ['required', 'email'],
            'website'=>'required',
            'tags'=>'required',
            'description'=>'required'

        ]);


        if($request->hasFile('logo')) {
            $formField ['logo'] = $request->file('logo')->store('logos', 'public');
        }


        $listing->update($formField);
        return back()->with('message', 'Listing updated Successfully!!!');
    }

    //Delete Listing
    public function destroy(Listing $listing) {
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unathorized Action');
        };
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!!!');

    }
    

    public function manage() {
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
    
    




    
}
//common resource routes
// index - show all listing
// show - Show single listing
// create - show form to create a new Listing
// store - store new Listing
// edit - show form to edit a list
// update - update a listing
// destroy - delete a list

