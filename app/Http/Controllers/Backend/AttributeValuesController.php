<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Attribute_value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class AttributeValuesController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'attribute_values';
    }

    public function index(int $attribute_id){
        $attribute_values = Attribute_value::where('attribute_id', $attribute_id)->paginate(10);
        $attribute = Attribute::find($attribute_id);

        return view('admin.attribute_values.index', ['menu' => $this->menu, 'attribute_values' => $attribute_values, 'attribute' => $attribute]);
    }
    public function create($attribute_id){
        return view('admin.attribute_values.create', ['attribute_id' => $attribute_id, 'menu' => $this->menu]);
    }
    public function store($attribute_id, Request $request){
        $request->validate([
            'value' => ['required', 'max:255', 'string'],
        ]);

        $request->merge(['attribute_id' => $attribute_id]);
        Attribute_value::create($request->all());

        return redirect()->route('admin.attribute_values.index', ['attribute_id' => $request->attribute_id])->with('message', Lang::get('session_messages.Attribute value successfully created!'));
    }
    public function edit($attribute_id, $id){
        $attribute_value = Attribute_value::find($id);

        return view('admin.attribute_values.edit', ['attribute_id' => $attribute_id, 'attribute_value' => $attribute_value, 'menu' => $this->menu]);
    }
    public function update($attribute_id, $id, Request $request){
        $request->validate([
            'value' => ['required', 'max:255', 'string'],
            'color' => ['starts_with:rgba', 'nullable'],
        ]);

        $attribute_value = Attribute_value::find($id);
        $attribute_value->update($request->except('attribute_id'));

        return redirect()->route('admin.attribute_values.index', ['attribute_id' => $attribute_id])->with('message', Lang::get('session_messages.Attribute value successfully updated!'));
    }
    public function destroy($attribute_id, $id){
        Attribute_value::destroy($id);

        return redirect()->route('admin.attribute_values.index', ['attribute_id' => $attribute_id])->with('message', Lang::get('session_messages.Attribute value successfully deleted!'));
    }
}
