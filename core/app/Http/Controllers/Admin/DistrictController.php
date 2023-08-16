<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
{
    public function districts(Request $request,$id)
    {
        $search = $request->search;
        $division = Division::findOrFail($id);
        if($search){
            $page_title = "Search Result of $search";
            $districts = District::where('division_id',$id)->where('name','like',"%$search%")->paginate(getPaginate());
        } else {
            $page_title = "All district of $division->name";
            $districts = District::where('division_id',$id)->latest()->paginate(getPaginate());
        }
        $empty_message = 'No district found';
        return view('admin.location.districts',compact('page_title','districts','empty_message','search','division'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:districts',
        ]);
        $district = new District();
        $district->division_id = $request->division_id;
        $district->name = $request->name;
        $district->slug = Str::slug($request->name);
        $district->status = $request->status ? 1 : 0;
        $district->save();
        $notify[]=['success','District Added successfully'];
        return back()->withNotify($notify);

    }

    public function update (Request $request,$id)
    {
        $request->validate([
            'name' => 'required|unique:districts,name,'.$id,
        ]);
        $district = District::findOrFail($id);
        $district->name = $request->name;
        $district->slug = Str::slug($request->name);
        $district->status = $request->status ? 1 : 0;
        $district->save();
        $notify[]=['success','District Updated successfully'];
        return back()->withNotify($notify);
    }
    
}
