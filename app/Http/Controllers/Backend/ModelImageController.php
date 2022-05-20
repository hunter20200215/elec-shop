<?php

namespace App\Http\Controllers\Backend;

use App\Models\Model_image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ModelImageController extends Controller{
    private $model_namespace = "App\\Models\\";
    public function store(Request $request){
        $request = $request->data;
        $class = $this->model_namespace . $request['class_name'];
        $object = $class::withoutGlobalScopes()->find($request['model_id']);
        if($request['number_of_images'] == 1){
            $existing_image = Model_image::where('model_id', $object->id)->where('type', $request['type'])->first();
            if(is_object($existing_image)) $existing_image->delete();
        }
        $images = [];
        foreach($request['images'] as $image){
            $model_image = new Model_image;
            $model_image->model_name = get_class($object);
            $model_image->model_id = $object->id;
            $model_image->image_id = $image;
            $model_image->type = $request['type'];
            $model_image->save();
            array_push($images, [
                    'id' => $model_image->id,
                    'src' => Storage::url($model_image->image->getDimensionPath($request['dimension'])),
                    'largeSrc' => Storage::url($model_image->image->getDimensionPath('l'))
                ]);
        }

        return response(['images' => $images]);
    }
    public function destroy(Request $request){
        Model_image::destroy($request->id);

        return response([]);
    }
}
