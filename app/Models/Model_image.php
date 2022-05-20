<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Model_image extends Model
{
    protected $fillable = [
        'id', 'model_id', 'model_name', 'image_id', 'type', 'status'
    ];

    protected $with = ['image'];

    public function image(){
        return $this->belongsTo(Image::class);
    }
}
