<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FormBuilder;

class SubCategoryController extends Controller
{
    public function allSubCategories(Request $request,$id)
    {
        $cat  = Category::findOrFail($id);
        if($request->search){
            $search = $request->search;
            $page_title = "Search Result of '$search'";
            $subCategories = SubCategory::where('category_id',$id)->where('name','LIKE',"%$search%")->paginate(15);
        } else {
            $page_title = 'Sub Categories of '.$cat->name;
            $subCategories = SubCategory::where('category_id',$id)->latest()->paginate(15);
        }
       
        $empty_message = 'No Sub Categories available';
        return view('admin.category.subcategories',compact('page_title','empty_message','subCategories','cat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sub_categories',
            'type' => 'required|in:1,2',
           
        ]);

        $category = new SubCategory();
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->slug = Str::slug($request->name);
        $category->type = $request->type == 1 ? 1:2;
        $category->status = $request->status ? 1:0;
        $category->save();
        $notify[]=['success','Sub Category Created Successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|unique:sub_categories,name,'.$id,
            'type' => 'required|in:1,2',
            
        ]);

        $category = SubCategory::findOrFail($id);
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->slug = Str::slug($request->name);
        $category->type = $request->type == 1 ? 1:2;
        $category->status = $request->status ? 1:0;
        $category->save();
        $notify[]=['success','Sub Category Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function fields($id)
    {
        $subCategory = SubCategory::FindOrFail($id);
        $page_title = "Fields of $subCategory->name";
        return view('admin.category.fields',compact('page_title','subCategory'));
    }

    public function addFields(Request $request)
    {

       $request->validate([
           'type'=> 'required|in:1,2,3,4',
           'label' => 'required',
           'placeholder' => 'required_if:type,1,4',
           'option' => 'required_if:type,2,3'
       ],
       [
        'option.required_if'=> 'Options are required while input type is Select-box or Check-box',
        'placeholder.required_if' => 'Placeholder is required while input type is Input text or Textarea' 
       ]); 
       
       $subCategory = SubCategory::findOrFail($request->subcategory_id)->existingFields();
       $fieldname = Str::slug($request->label,'_');
       if(in_array($fieldname ,$subCategory)){
           $notify[]=['error','Sorry this field is already exists in this subcategory'];
           return back()->withNotify($notify);
       }

       $fields = new FormBuilder();
       $fields->type = $request->type;
       $fields->subcategory_id = $request->subcategory_id;
       $fields->label = $request->label;
       $fields->placeholder = $request->placeholder;
       $fields->name = $fieldname;
       $fields->required = $request->required ? 1:0;
       $fields->as_filter = $request->filter ? 1:0;
       

       if($request->type == 2 || $request->type == 3){
           foreach($request->option as $option){
            $fieldsOptions[] = ucwords($option);
           }
           $fields->options = $fieldsOptions;
       }

       $fields->save();
       $notify[]=['success','Fields added successfully'];
       return back()->withNotify($notify);
    }

    public function removeField($id)
    {
        FormBuilder::findOrFail($id)->delete();
        $notify[]=['success','Field has been removed'];
        return back()->withNotify($notify);
    }

    public function editField($id)
    {
        $page_title = 'Edit Fields';
        $field = FormBuilder::findOrFail($id);
        return view('admin.category.editFields',compact('page_title','field'));
    }

    public function updateField(Request $request,$id)
    {

        $request->validate([
            'label' => 'required',
            'placeholder' => 'required_if:type,1,4',
            'option' => 'required_if:type,2,3'
        ],
        [
            'option.required_if'=> 'Options are required while input type is Selectbox or Checkbox',
            'placeholder.required_if' => 'Placeholder is required while input type is Input text or Textarea' 
        ]); 
        
        $field = FormBuilder::findOrFail($id);
        $subCategory = SubCategory::findOrFail($field->subcategory->id)->existingFields($field->id);
        $fieldname = Str::slug($request->label,'_');
        
        if(in_array($fieldname ,$subCategory)){
            $notify[]=['error','Sorry this field is already exists in this subcategory'];
            return back()->withNotify($notify);
        }
        
       
        $field->label = $request->label;
        $field->placeholder = $request->placeholder;
        $field->name = $fieldname;
        $field->required = $request->required ? 1:0;
        $field->as_filter = $request->filter ? 1:0;

        if($request->type == 2 || $request->type == 3){
            foreach($request->option as $option){
             $fieldOptions[] =  ucwords($option);
            }
            $field->options = $fieldOptions;
        }
 
        $field->save();
        $notify[]=['success','Field updated successfully'];
        return back()->withNotify($notify);
    }
    
    
    
    
    
}
