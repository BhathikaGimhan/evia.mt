<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function packages(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $packages = Package::where('name','like',"%$search%")->paginate(getPaginate());
        } else {
            $page_title = "All Packages";
            $packages = Package::latest()->paginate(getPaginate());
        }
        $empty_message = 'No Package found';
        return view('admin.packages',compact('page_title','packages','empty_message','search'));
    }

    public function store(Request $request)
    {
           $request->validate([
               'name' => 'required|unique:packages',
               'price' => 'required|numeric|min:0',
               'validity' => 'required|numeric|min:1'
           ]);

           $pkg = new Package();
           $pkg->name = $request->name;
           $pkg->price = $request->price;
           $pkg->validity = $request->validity;
           $pkg->status = $request->status ? 1 : 0;
           $pkg->save();
           $notify[]=['success','Package Added successfully'];
           return back()->withNotify($notify);
    }
    
    public function update(Request $request,$id)
    {
           $request->validate([
               'name' => 'required|unique:packages,name,'.$id,
               'price' => 'required|numeric|min:0',
               'validity' => 'required|numeric|min:1'
           ]);

           $pkg = Package::findOrFail($id);
           $pkg->name = $request->name;
           $pkg->price = $request->price;
           $pkg->validity = $request->validity;
           $pkg->status = $request->status ? 1 : 0;
           $pkg->save();
           $notify[]=['success','Package Updated successfully'];
           return back()->withNotify($notify);
    }
    
    
}
