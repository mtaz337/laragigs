<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;


class ListingController extends Controller
{
    public function index(){
        return view('listings.index',[
            'listings'=> Listing::latest()->filter(request(['tag','search']))->paginate(6)
        ]);
    }

    public function show($id){
        if(is_numeric($id)){
            $listing = Listing::find($id);
            if($listing){
            return view('listings.show',[
              'listing' => $listing
            ]);
           }
           else{
               abort(404);
           }
         }
         else{
             abort(404);
        }
    }

    public function create(){
        return view('listings.create');
    }

    public function store (Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
      if($request->hasFile('logo')){
          $formFields['logo'] = $request->file('logo')->store('logos', 'public');
      }
        Listing::create($formFields);
        
       return redirect('/')->with('message','Job Posting Created Successfully!');
    }

    public function edit(Listing $listing){
     return view('listings.edit', ['listing' => $listing]);
    }

    public function update (Request $request, Listing $listing){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
      if($request->hasFile('logo')){
          $formFields['logo'] = $request->file('logo')->store('logos', 'public');
      }
        $listing->update($formFields);
        
       return back()->with('message','Job Posting Updated Successfully!');
    }

    public function destroy(Listing $listing){
     $listing->delete();
     return redirect('/')->with('message','Job Posting Deleted Successfully');
    }
}
