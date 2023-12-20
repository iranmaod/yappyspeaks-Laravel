<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Background;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BackgroundManagementController extends Controller
{
    public function viewBackgrounds(Request $request, $category_id = NULL)
    {
        if($category_id != NULL){
            $data = Background::where('category_id',$category_id)->get();
            $category = Category::find($category_id);
        }else{
            $data = Background::get();
            $category = '';
        }
        $categories = Category::get();
        if ($request->ajax()) {

            return DataTables::of($data)
            ->addColumn('category', function ($data) {
                $category = Category::where('id',$data->category_id)->value('name');
                return $category;
            })
            ->addColumn('image', function ($data) { 
                if($data->bg_image){
                    $url=asset("bg_images/$data->bg_image"); 
                    return $image = '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
                }else{
                    return 'No Image';
                }
                 
            })
            ->addColumn('status', function ($data) {
                    $status = '<span class="badge badge-pill badge-soft-danger font-size-11">InActive</span>';
                    if ($data->status == 1) {
                        $status = '<span class="badge badge-pill badge-soft-success font-size-11">Active</span>';
                    }
                    return $status;
                })
                ->addColumn('actions', function ($data) {

                    $actions = '<div class="d-flex btn-group-sm" role="group" aria-label="Basic example">
                    <div style="margin-right:10px;">
                <a href="' . route('background.edit', $data->id) . '" class="btn btn-outline-primary btn-sm">Edit</a>
                
                </div>
                <div>  <form action="' . route('background.destroy', $data->id) . '" method="POST">' . csrf_field() . '<input name="_method" type="hidden" value="DELETE"><button type="button" class="delete-btn btn btn-outline-danger btn-sm">Delete</button></form>
                </div></div>';
                    return $actions;
                })
                ->rawColumns(['category','image','status','actions'])
                ->make(true);
        }
        return view('admin.background.index',compact('category','categories'));
    }
    public function create()
    {
        $categories = Category::get();
        return view('admin.background.edit',compact('categories'));
    }
    public function store(Request $request)
    {
        if($request['type_id'] == 1){
            $request->validate([
                'bg_color' => 'required',
            ]);
        }
        else if($request['type_id'] == 2){
            $request->validate([
                'bg_image' => 'required|image|mimes:jpeg,png,gif|dimensions:min_width=390,min_height=844,max_width=700,max_height=1280',
            ]);
        }
        if ($request->has('status') && $request->status == 'on') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }
        $category_data = new Background();
        $category_data->category_id = $request['category_id'];
        if($request['type_id'] == 1){
            $category_data->bg_color = $request['bg_color'];
        }
        else if ($request['type_id'] == 2){
            if($request->hasFile('bg_image')){
                $file = $request->file('bg_image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move(public_path('bg_images'),$filename);
                $category_data->bg_image= $filename;
            }
        }
        $category_data->bg_type = $request['type_id'];
        $category_data->status = $request->status;
        $category_data->save();
        return redirect()->route('category.backgrounds')->with('success', 'Background Added Successfully');
    }
    public function edit(string $id)
    {
        $categories = Category::get();
        $category = Background::find($id);
        // dd($category);
        return view('admin.background.edit', compact('categories','category'));
    }
    public function update(Request $request, string $id)
    {
        if ($request->has('status') && $request->status == 'on') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }

        $category_data = Background::find($id);
        $category_data->category_id = $request['category_id'];
        if($request['type_id'] == 1){
            $category_data->bg_color = $request['bg_color'];
            $category_data->bg_image= '';
        }
        else if ($request['type_id'] == 2){
            if($request->hasFile('bg_image')){
                $request->validate([
                    'bg_image' => 'required|image|mimes:jpeg,png,gif|dimensions:min_width=390,min_height=844,max_width=700,max_height=1280',
                ]);
                $file = $request->file('bg_image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move(public_path('bg_images'),$filename);
                $category_data->bg_image= $filename;
            }
            $category_data->bg_color = '';
        }
        $category_data->bg_type = $request['type_id'];
        $category_data->status = $request->status;
        $category_data->save();
        return redirect()->route('category.backgrounds')->with('success', 'Background Updated Successfully');
    }
    public function destroy(string $id)
    {
        Background::find($id)->delete();
        return back()->with('success', 'Background Deleted Successfully');
    }
    public function addBg(string $id)
    {
        $categories = Category::get();
        $category_id = Category::find($id);
        return view('admin.background.edit',compact('categories','category_id'));
    }
}
