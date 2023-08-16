<?php

namespace App\Http\Controllers\Admin;

use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    public function divisions(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $divisions = Division::where('name','like',"%$search%")->paginate(getPaginate());
        } else {
            $page_title = "All divisions";
            $divisions = Division::latest()->paginate(getPaginate());
        }
        $empty_message = 'No division found';
        return view('admin.location.divisions',compact('page_title','divisions','empty_message','search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:divisions',
        ]);
        $division = new Division();
        $division->name = $request->name;
        $division->slug = Str::slug($request->name);
        $division->status = $request->status ? 1 : 0;
        if($request->image){
            $division->image = uploadImage($request->image,'assets/images/location/','768x550');
        }
        $division->save();
        $notify[]=['success','Division Added successfully'];
        return back()->withNotify($notify);

    }

    public function update (Request $request,$id)
    {
        $request->validate([
            'name' => 'required|unique:divisions,name,'.$id,
        ]);
        $division = Division::findOrFail($id);
        $division->name = $request->name;
        $division->slug = Str::slug($request->name);
        $division->status = $request->status ? 1 : 0;
        if($request->image){
            $old = $division->image?? null;
            $division->image = uploadImage($request->image,'assets/images/location/','768x550',$old);
        }
        $division->save();
        $notify[]=['success','Division Updated successfully'];
        return back()->withNotify($notify);
    }
    
    

    
}
