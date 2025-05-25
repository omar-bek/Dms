<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DepartmentsController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request){
        $this->authorize('departments');
        $this->authorize('all_departments');
        if(Auth::user()->role_id != 2 ){
            $departments = Department::whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })->paginate();
            return view('admin.departments.all_departments' , compact('departments'));

        }
        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {
            $this->authorize('delete_department');
            Department::whereIn('id', $ids)->delete();
            return back()->with('success', __('dashboard.deleted_successfully'));
        }
        $departments = Department::paginate();
        return view('admin.departments.all_departments' , compact('departments'));
    }
    public function create(){
        $this->authorize('create_department');

        $users = User::all();
        
        return view('admin.departments.create' , compact('users'));

    }
    public function store(Request $request){
        $this->authorize('create_department');

        $request->validate([
            'name' => "required",
        ]);
        $is_create = Department::create(['name' => $request->name]);
        if ($request->has('users')) {
            $is_create->users()->sync($request->users);
        }
        return redirect()->route('all_departments')->with('success' , __("dashboard.created_successfully"));
    }
    public function edit($id){
        $this->authorize('edit_department');
        $department = Department::find($id);
        $users = User::all();
        
        return view('admin.departments.edit' , compact('users' , 'department'));

    }
    public function update(Request $request , $id){
        $this->authorize('edit_department');

   
        $deparment = Department::find($id);
        $deparment->update([
            'name' => $request->name
        ]);
        if ($request->has('users')) {
            $deparment->users()->sync($request->users);
        }
        return redirect()->route('all_departments')->with('success' , __("dashboard.created_successfully"));
    }
    public function show($id){
        $this->authorize('show_department');
        
        $department = Department::findOrFail($id);
        $users = $department->users;
        return view('admin.departments.show' , compact('department' , 'users'));
    }
    public function destroy($id)
    {
        $this->authorize('delete_department');

        $department = Department::find($id);
            $department->delete();

        return redirect()->route('all_departments')->with('success' , "Deleted Successfully");
    }
}
