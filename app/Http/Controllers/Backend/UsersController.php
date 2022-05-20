<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'users';
    }

    public function index(){
        $users = User::where('id', '>', 0);

        if(isset($_GET['signups'])){
            $users->role('customer');
            $this->menu = 'customers';
        }
        else $users->notRole('customer');

        $users = $users->paginate(10);

        return view('admin.users.index', ['users' => $users, 'menu' => $this->menu]);
    }
    public function create(){
        $roles = Role::all();

        return view('admin.users.create', ['roles' => $roles, 'menu' => $this->menu]);
    }
    public function store(Request $request): RedirectResponse{
        $request->validate([
            'full_name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->merge(['password' => bcrypt($request->password)]);

        $user = User::create($request->except('_token', 'password_confirmation', 'roles'));
        $user->syncRoles($request['roles']);

        return redirect()->route('admin.users.index')->with('message', Lang::get('session_messages.User successfully created!'));
    }
    public function edit(int $id){
        $user = User::find($id);
        $roles = Role::all();

        return view('admin.users.edit', ['user' => $user, 'roles' => $roles, 'menu' => $this->menu]);
    }
    public function update(Request $request, int $id): RedirectResponse{
        $request->validate([
            'full_name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'max:255', 'email', "unique:users,email,$id"],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user = User::find($id);
        if (!$request['password']) $user->update($request->except('password', 'password_confirmation', 'roles'));
        else {
            $request->merge(['password' => bcrypt($request->password)]);
            $user->update($request->except('roles'));
        }
        $user->syncRoles($request['roles']);

        return redirect()->route('admin.users.index')->with('message', Lang::get('session_messages.User successfully updated!'));
    }
    public function destroy(int $id): RedirectResponse{
        User::destroy($id);
        return redirect()->back()->with('message', Lang::get('session_messages.Category successfully deleted!'));
    }
}
