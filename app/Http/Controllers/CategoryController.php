<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\CategoryData;
use App\Models\Background;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Category::get();
                    
        if ($request->ajax()) {

            return DataTables::of($data)
            ->addColumn('status', function ($data) {
                    $status = '<span class="badge badge-pill badge-soft-danger font-size-11">InActive</span>';
                    if ($data->status == 1) {
                        $status = '<span class="badge badge-pill badge-soft-success font-size-11">Active</span>';
                    }
                    return $status;
                })
                ->addColumn('image', function ($data) { 
                    if($data->image){
                        $url=asset("category_images/$data->image"); 
                        return $image = '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />'; 
                    }else{
                        return 'No Image';
                    }
    
                })
                ->addColumn('actions', function ($data) {

                    $actions = '<div class="d-flex btn-group-sm" role="group" aria-label="Basic example">
                    <div style="margin-right:10px;">
                <a href="' . route('category-data.add', $data->id) . '" class="btn btn-outline-primary btn-sm">Add '.$data->name.'</a>
                <a href="' . route('category.variations', $data->id) . '" class="btn btn-outline-success btn-sm">View Variations</a>
                <a href="' . route('backgrounds.add', $data->id) . '" class="btn btn-outline-primary btn-sm">Add Background</a>
                <a href="' . route('category.backgrounds', $data->id) . '" class="btn btn-outline-success btn-sm">View Background</a>
                </div><div class="d-flex btn-group-sm" role="group" aria-label="Basic example">
                    <div style="margin-right:10px;">
                <a href="' . route('category.edit', $data->id) . '" class="btn btn-outline-primary btn-sm">Edit</a>
                </div>
                <div>  <form action="' . route('category.destroy', $data->id) . '" method="POST">' . csrf_field() . '<input name="_method" type="hidden" value="DELETE"><button type="button" class="delete-btn btn btn-outline-danger btn-sm">Delete</button></form>
                </div></div>';
                    return $actions;
                })
                ->rawColumns(['image','status','actions'])
                ->make(true);
        }
        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.edit');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);
         if ($request->has('status') && $request->status == 'on') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }
        $category = new Category();
        $category->name = $request['name'];
        $category->slug = $request['slug'];
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,gif|dimensions:min_width=390,min_height=844,max_width=700,max_height=1280',
            ]);
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(public_path('category_images'),$filename);
            $category->image= $filename;
        }
        $category->status = $request->status;
        $category->save();
        return redirect()->route('categories.all')->with('success', 'Category Added Successfully');
    }
    public function edit(string $id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);
        if ($request->has('status') && $request->status == 'on') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }

        $category = Category::find($id);
        $category->name = $request['name'];
        $category->slug = $request['slug'];
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,gif|dimensions:min_width=390,min_height=844,max_width=700,max_height=1280',
            ]);
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(public_path('category_images'),$filename);
            $category->image= $filename;
        }
        $category->status = $request->status;
        $category->save();
        return redirect()->route('categories.all')->with('success', 'Category Updated Successfully');
    }
    public function destroy(string $id)
    {
        Category::find($id)->delete();

        //Delete all variations
        $variations = CategoryData::where('category_id',$id)->get();
        foreach ($variations as $var) {
            CategoryData::find($var->id)->delete();
        }
        
        //Delete all backgrounds
        $backgrounds = Background::where('category_id',$id)->get();
        foreach ($backgrounds as $bg) {
            Background::find($bg->id)->delete();
        }
        return back()->with('success', 'Category Deleted Successfully');
    }
}
