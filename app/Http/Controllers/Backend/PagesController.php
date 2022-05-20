<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'pages';
    }

    public function index(){
        $pages = Page::paginate(50);

        return view('admin.pages.index', ['pages' => $pages, 'menu' => $this->menu]);
    }

    public function create(){
        return view('admin.pages.create', ['menu' => $this->menu]);
    }
    public function store(Request $request){
        $request->validate([
            'title' => ['required', 'max:255', 'string', 'unique:pages'],
            'content' => ['required'],
        ]);

        $request->merge(['slug' => Str::slug($request['title'])]);
        $page = Page::create($request->all());

        if($request->background_image){
            list($filename, $extension) = $this->separateNameAndExtensionOfFile($request->background_image);

            $parts = explode('-', $filename);
            array_pop($parts);
            $filename = implode('-', $parts);
            $filename = "$filename-{$page->id}.$extension";

            Storage::move("temporary/pages/$request->background_image", "pages/$filename");
            $page->background_image = $request->background_image;
            $page->save();
        }

        return redirect()->route('admin.pages.index')->with('message', Lang::get('session_messages.Page successfully created!'));
    }
    public function edit(Page $page){
        return view('admin.pages.edit', ['menu' => $this->menu, 'page' => $page]);
    }
    public function update(Request $request, Page $page){
        $request->validate([
            'title' => ['required', 'max:255', 'string', "unique:pages,title,$page->id"],
            'content' => ['required'],
        ]);

        $request->merge(['slug' => Str::slug($request['title'])]);

        $page->update($request->all());

        return redirect()->route('admin.pages.index')->with('message', Lang::get('session_messages.Page successfully updated!'));
    }
    public function destroy(Page $page){
        $page->delete();

        return redirect()->route('admin.pages.index')->with('message', Lang::get('session_messages.Page successfully deleted!'));
    }
    public function change_background_image(Request $request){
        list($filename, $extension) = $this->separateNameAndExtensionOfFile($request->file->getClientOriginalName());
        if(!$request->page_id){
            $path = '/temporary/pages';
            $timestamp = Carbon::now()->timestamp;
            $filename = "$filename-$timestamp.$extension";
        }
        else{
            $path = '/pages';
            $filename = "$filename-{$request->page_id}.$extension";
            $page = Page::find($request->page_id);
            Storage::delete("/pages/$page->background_image");
            $page->background_image = $filename;
            $page->save();
        }

        Storage::putFileAs("$path", $request->file, $filename);

        return response(['url' => Storage::url("$path/$filename"), 'filename' => $filename]);
    }
    private function separateNameAndExtensionOfFile($original_name):array{
        $filename = pathinfo($original_name, PATHINFO_FILENAME);
        $extension = pathinfo($original_name, PATHINFO_EXTENSION);

        return [$filename, $extension];
    }
}
