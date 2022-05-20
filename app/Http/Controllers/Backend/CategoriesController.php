<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Model_image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'categories';
    }

    public function index(){
        $categories = Category::paginate(50);

        return view('admin.categories.index', ['categories' => $categories, 'menu' => $this->menu]);
    }
    public function create(){
        return view('admin.categories.create', ['menu' => $this->menu]);
    }
    public function store(Request $request): RedirectResponse{
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $priority = Category::orderBy('priority', 'desc')->first()?->priority;

        $request->merge([
            'slug' => Str::slug($request['name']),
            'priority' => $priority ? $priority+1 : 1,
        ]);
        $category = Category::create($request->all());

        if($request->featured_image){
            $model_image = new Model_image;
            $model_image->model_name = get_class($category);
            $model_image->model_id = $category->id;
            $model_image->image_id = $request->featured_image;
            $model_image->type = 'featured';
            $model_image->save();
        }

        return redirect()->route('admin.categories.index')->with('message', Lang::get('session_messages.Category successfully created!'));
    }
    public function edit(int $id){
        $category = Category::find($id);

        return view('admin.categories.edit', ['category' => $category, 'menu' => $this->menu]);
    }
    public function update(Request $request, int $id): RedirectResponse{
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $category = Category::find($id);

        $request->merge(['slug' => Str::slug($request['name'])]);
        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('message', Lang::get('session_messages.Category successfully updated!'));
    }
    public function destroy(int $id): RedirectResponse{
        Category::destroy($id);
        return redirect()->route('admin.categories.index')->with('message', Lang::get('session_messages.Category successfully deleted!'));;
    }
}
