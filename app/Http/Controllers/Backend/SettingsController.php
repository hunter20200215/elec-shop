<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    private $menu;
    public function __construct(){
        $this->menu = 'settings';
    }

    public function index(){
        $setting = Setting::first();

        return view('admin.settings.index', ['setting' => $setting, 'menu' => $this->menu]);
    }
    public function update(Request $request): RedirectResponse{
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'max:255', 'email'],
            'mobile' => ['required', 'max:255', 'string']
        ]);

        $setting = Setting::first();
        $setting->update($request->except('_token'));

        return redirect()->route('admin.settings.index')->with('message', Lang::get('session_messages.Settings successfully updated!'));
    }
    public function logo_upload(Request $request){
        $file = $request->file;
        $fileFullName = $file->getClientOriginalName();
        Storage::putFileAs(config('media.settings_path'), $file, $fileFullName);

        $setting = Setting::first();
        Storage::delete($setting->logo);

        $setting->logo = $fileFullName;
        $setting->save();

        return response(['logo' => Storage::url($setting->logo)]);
    }
}
