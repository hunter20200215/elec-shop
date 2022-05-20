<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'roles';
    }

    public function index(){
        $roles = Role::paginate(10);

        return view('admin.roles.index', ['roles' => $roles, 'menu' => $this->menu]);
    }
    public function create(){
        $permissions = Permission::all();

        return view('admin.roles.create', ['permissions' => $permissions, 'menu' => $this->menu]);
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|unique:roles',
            'display_name' => 'required|unique:roles',
        ]);

        $role = Role::create($request->except('permissions'));
        $role->syncPermissions($request['permissions']);

        return redirect()->route('admin.roles.index')->with('message', Lang::get('session_messages.Role successfully added!'));
    }
    public function edit($id){
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('admin.roles.edit', ['permissions' => $permissions, 'role' => $role, 'menu' => $this->menu]);
    }
    public function update(Request $request, $id){
        $role = Role::find($id);
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'display_name' => 'required|unique:roles,display_name,' . $role->id
        ]);

        $role->update($request->except(['_token', 'permissions']));
        $role->syncPermissions($request['permissions']);

        return redirect()->route('admin.roles.index')->with('message', Lang::get('session_messages.Role successfully updated!'));
    }
    public function destroy($id){
        if(is_object(User::role(Role::find($id))->first())){
            return redirect()->route('admin.roles.index')->with('error', Lang::get('session_messages.Role can not be deleted because a user with that role exists!'));
        }

        Role::destroy($id);

        return redirect()->route('admin.roles.index')->with('message', Lang::get('session_messages.Role successfully deleted!'));
    }
}
