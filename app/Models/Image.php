<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;


class Image extends Model{

    protected $fillable = ['file_name', 'file_full_name', 'file_type'];

    public function makeImageDimensions($fileName, $extension){
        $dimensions=config('media.image.dimensions');
        $original = Storage::get($this->getPath() . '/' . $fileName);
        foreach ($dimensions as $key => $dimension){
            switch($dimension['resize']){
                case 'crop':
                    $image = InterventionImage::make($original)->crop($dimension['w'], $dimension['h']);
                    break;
                case 'fit':
                    $image = InterventionImage::make($original)->fit($dimension['w'], $dimension['h']);
                    break;
                case 'aspect_ratio':
                    $image = InterventionImage::make($original)->resize($dimension['w'], null, function ($constraint) {$constraint->aspectRatio();});
                    break;
                default:
                    if($dimension['w']>0 && $dimension['h']>0) $image = InterventionImage::make($original)->resize($dimension['w'], $dimension['h']);
                    if($dimension['w']==0) $image = InterventionImage::make($original)->heighten($dimension['h']);
                    if($dimension['h']==0) $image = InterventionImage::make($original)->widen($dimension['w']);
            }

            Storage::put($this->getDimensionPath($key), (string)$image->encode($extension));
        }
    }

    public function getPath(){
        return config('media.image.path') . $this->id;
    }
    public function getDimensionPath($dimension = ''){
        $suffix = '';
        if($dimension != '') $suffix = '_' . $dimension;

        return $this->getPath() . '/' . $this->file_name . $suffix . '.' . $this->file_type;
    }
    public static function getNumberOfImages(){
        return Image::where('id', '>', 0)->count();
    }
    public static function getImagesPaginated($skip, $take){
        return Image::orderby('id', 'desc')->skip($skip)->take($take)->get();
    }
}
