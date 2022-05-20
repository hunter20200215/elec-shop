<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'permissions';
    }

    public function index(){
        $permissions = Permission::paginate(10);

        return view('admin.permissions.index', ['menu' => $this->menu, 'permissions' => $permissions]);
    }
    public function create(){
        return view('admin.permissions.create', ['menu' => $this->menu]);
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|unique:permissions',
            'display_name' => 'required|unique:permissions',
        ]);

        Permission::create($request->all());

        return redirect()->route('admin.permissions.index')->with('message', Lang::get('session_messages.Permission successfully added!'));
    }
    public function edit($id){
        $permission = Permission::find($id);

        return view('admin.permissions.edit', ['menu' => $this->menu,  'permission' => $permission]);
    }
    public function update($id, Request $request){
        $request->validate([
            'name' => ['required', "unique:permissions,name,$id"],
            'display_name' => ['required', "unique:permissions,display_name,$id"]
        ]);

        $permission = Permission::find($id);
        $permission->update($request->except(['_token']));

        return redirect()->route('admin.permissions.index')->with('message', Lang::get('session_messages.Permission successfully updated!'));
    }
    public function destroy($id){
        Permission::destroy($id);

        return redirect()->route('admin.permissions.index')->with('message', Lang::get('session_messages.Permission successfully deleted!'));
    }
}
