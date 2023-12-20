<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\CategoryData;
use App\Models\Background;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $categories = Category::count('id');
        $variations = CategoryData::count('id');
        $backgrounds = Background::count('id');
        return view('admin.dashboard',compact('categories','variations','backgrounds'));
    }
    public function setting()
    {
        $user = Auth::user();
        return view('admin.setting', compact('user'));
    }
    public function editSetting(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
        ]);
        if (isset($request->password)) {
            $request->validate([
                'password' => 'required|confirmed|min:6'
            ]);
        }
        $id = Auth::id();
        $user = User::find($id);
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(public_path('profile'),$filename);
            $user->image= $filename;
        }
        $user->name = $request->name;
        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->update();
        return redirect()->route('dashboard')->with('success', 'Setting Updated Successfully');
    }
    public function syncDevice()
    {
        $dynamicContent = 'http://127.0.0.1:8000/' . uniqid();
        return view('admin.sync_device', compact('dynamicContent'));
    }
}
