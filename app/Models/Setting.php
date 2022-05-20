<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'logo', 'mobile', 'email', 'shipping'
    ];

    public function getLogoAttribute(){
        return config('media.settings_path') .  $this->attributes['logo'];
    }
}
