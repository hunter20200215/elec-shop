<?php

namespace App\Http\Controllers\Backend;

use App\Models\Image;
use App\Models\Model_image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    private string $menu;
    public function __construct(){
        $this->menu = 'media';
    }

    public function index(){
        return view("admin.media.index", ['menu' => $this->menu]);
    }
    public function load_gallery(){
        return response([
            'status' => 'success',
            'html'   =>  view('admin.media.media_gallery')->render()
        ]);
    }
    public function get_images(Request $request){
        $label_class = $request['label_class'];
        $page = $request['page'];
        $per_page = 8;
        $skip = ($page-1)*$per_page;

        $pages_num = ceil(Image::getNumberOfImages() / $per_page);
        $images = Image::getImagesPaginated($skip, $per_page);

        while($page > 1 && sizeof($images)==0){
            $page--;
            $skip = ($page-1)*$per_page;
            $images = Image::getImagesPaginated($skip, $per_page);
        }

        return response([
            'status' => 'success',
            'page' => $page,
            'html'   =>  view('admin.media.images_list', ['images' => $images, 'pages_num' => $pages_num, 'page' => $page, 'label_class' => $label_class])->render()
        ]);
    }
    public function store(Request $request){
        $file = $request->file;
        $fileFullName = $file->getClientOriginalName();
        $fileName = pathinfo($fileFullName , PATHINFO_FILENAME);
        $fileExtension = pathinfo($fileFullName , PATHINFO_EXTENSION);

        $image = Image::create([
            'file_full_name' => $fileFullName,
            'file_name' => $fileName,
            'file_type' => $fileExtension
        ]);

        Storage::putFileAs($image->getPath(), $file, $fileFullName);
        $image->makeImageDimensions($fileFullName, $fileExtension);

        return response(['status' => 'success']);
    }
    public function destroy($id){
        Model_image::where('image_id', $id)->delete();
        Storage::deleteDirectory(config('media.image.path') . "$id");
        Image::destroy($id);

        return response()->json(['success' => 'success']);
    }
    public function load_by_ids(Request $request){
        $images = Image::whereIn('id', $request->images)->get();
        foreach($images as $image){
            $data[] = ['id' => $image->id, 'src' => Storage::url($image->getDimensionPath($request->dimension))];
        }

        return response(['images' => $data]);

    }
}
