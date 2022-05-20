<?php

namespace App\Traits;

use App\Models\Model_image;

trait HasModelImage{
    public function model_images(){
        return $this->hasMany(Model_image::class, 'model_id', 'id')->where('model_name', get_class($this));
    }
    public function getImage($type){
        return $this->model_images->where('type', $type)->first();
    }
    public function getImages($type){
        return $this->model_images->where('type', $type);
    }
    public function getImageDimensionPath($type, $dimension): string{
        return self::getImage($type) ? self::getImage($type)->image->getDimensionPath($dimension) : '/imagePlaceholder.png';
    }
    public function getImagesDimensionPath($type, $dimension){
        $images = self::getImages($type);
        $images = $images->map(function($item, $key) use ($dimension){
           return $item->image->getDimensionPath($dimension);
        });

        return $images;
    }
}
