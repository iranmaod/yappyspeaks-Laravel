<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\CategoryData;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Imports\ImportVariations;
use Maatwebsite\Excel\Facades\Excel;
class CategoryDataController extends Controller
{
    public function index(Request $request, $category_id = NULL)
    {
        if($category_id != NULL){
            $data = CategoryData::where('category_id',$category_id)->get();
        }else{
            $data = CategoryData::get();
        }
        if ($request->ajax()) {

            return DataTables::of($data)
            ->addColumn('category', function ($data) {
                $category = Category::where('id',$data->category_id)->value('name');
                return $category;
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
                <a href="' . route('category-data.edit', $data->id) . '" class="btn btn-outline-primary btn-sm">Edit</a>
                
                </div>
                <div>  <form action="' . route('category-data.destroy', $data->id) . '" method="POST">' . csrf_field() . '<input name="_method" type="hidden" value="DELETE"><button type="button" class="delete-btn btn btn-outline-danger btn-sm">Delete</button></form>
                </div></div>';
                    return $actions;
                })
                ->rawColumns(['category','status','actions'])
                ->make(true);
        }
        return view('admin.category_data.index');
    }
    public function viewVariations(Request $request, $category_id = NULL)
    {
        if($category_id != NULL){
            $data = CategoryData::where('category_id',$category_id)->get();
            $category = Category::find($category_id);
        }else{
            $data = CategoryData::get();
            $category = '';
        }
        $categories = Category::get();
        if ($request->ajax()) {

            return DataTables::of($data)
            ->addColumn('category', function ($data) {
                $category = Category::where('id',$data->category_id)->value('name');
                return $category;
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
                <a href="' . route('category-data.edit', $data->id) . '" class="btn btn-outline-primary btn-sm">Edit</a>
                
                </div>
                <div>  <form action="' . route('category-data.destroy', $data->id) . '" method="POST">' . csrf_field() . '<input name="_method" type="hidden" value="DELETE"><button type="button" class="delete-btn btn btn-outline-danger btn-sm">Delete</button></form>
                </div></div>';
                    return $actions;
                })
                ->rawColumns(['category','status','actions'])
                ->make(true);
        }
        return view('admin.category_data.variations',compact('category','categories'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('admin.category_data.edit',compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:500',
            'category_id' => 'required',
        ]);
         if ($request->has('status') && $request->status == 'on') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }
        $category_data = new CategoryData();
        $category_data->name = $request['name'];
        $category_data->description = $request['description'];
        $category_data->category_id = $request['category_id'];
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(public_path('category_data'),$filename);
            $category_data->image= $filename;
        }
        $category_data->status = $request->status;
        $category_data->save();
        return redirect()->route('category.variations')->with('success', 'Variation Added Successfully');
    }
    public function edit(string $id)
    {
        $categories = Category::get();
        $category = CategoryData::find($id);
        return view('admin.category_data.edit', compact('categories','category'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
        ]);
        if ($request->has('status') && $request->status == 'on') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }

        $category_data = CategoryData::find($id);
        $category_data->name = $request['name'];
        $category_data->description = $request['description'];
        $category_data->category_id = $request['category_id'];
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(public_path('category_data'),$filename);
            $category_data->image= $filename;
        }
        $category_data->status = $request->status;
        $category_data->save();
        return redirect()->route('category.variations')->with('success', 'Variation Updated Successfully');
    }
    public function destroy(string $id)
    {
        CategoryData::find($id)->delete();
        return back()->with('success', 'Variation Deleted Successfully');
    }
    public function addData(string $id)
    {
        $categories = Category::get();
        $category_id = Category::find($id);
        return view('admin.category_data.edit',compact('categories','category_id'));
    }
    public function ImportVar()
    {
        $categories = Category::get();
        return view('admin.category_data.import',compact('categories'));
    }
    public function Import(Request $request)
    {
        $request->validate([
            'file'=>'required',
        ]);
        $category = Category::find($request->category_id);
        try {
            Excel::import(new ImportVariations($category->id),request()->file('file'));
            return redirect()->route('category.variations')->with('success', 'Variations Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred during the import process. Please check the file format and try again.');
        }

    }
}
