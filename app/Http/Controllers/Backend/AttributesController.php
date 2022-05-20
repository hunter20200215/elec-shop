<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class AttributesController extends Controller
{
    protected string $menu;
    public function __construct(){
        $this->menu = 'attributes';
    }

    public function index(){
        $attributes = Attribute::paginate(50);

        return view('admin.attributes.index', ['menu' => $this->menu, 'attributes' => $attributes]);
    }
    public function create(){
        return view('admin.attributes.create', ['menu' => $this->menu]);
    }
    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'show_on_search' => ['required'],
            'search_type' => ['required'],
        ]);

        Attribute::create($request->all());

        return redirect()->route('admin.attributes.index')->with('message', Lang::get('session_messages.Attribute successfully created!'));
    }
    public function edit(int $id){
        $attribute = Attribute::find($id);

        return view('admin.attributes.edit', ['menu' => $this->menu, 'attribute' => $attribute]);
    }
    public function update(Request $request, int $id){
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'show_on_search' => ['required'],
            'search_type' => ['required'],
        ]);

        $attribute = Attribute::find($id);
        $attribute->update($request->all());

        return redirect()->route('admin.attributes.index')->with('message', Lang::get('session_messages.Attribute successfully updated!'));
    }
    public function destroy(int $id){
        Attribute::destroy($id);

        return redirect()->route('admin.attributes.index')->with('message', Lang::get('session_messages.Attribute successfully deleted!'));
    }
}
