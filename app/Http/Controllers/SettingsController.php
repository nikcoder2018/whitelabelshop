<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use App\Setting;
class SettingsController extends Controller
{
    public function header(Request $request){

        if($request->method() == 'GET'){
            $data['header_scripts'] = Setting::where('name', 'header_scripts')->first()->value;

            return view('admin.contents.settings-header', $data);
        }else{
            $header = Setting::where('name', 'header_scripts')->first();
            $header->value = $request->header_scripts;
            $header->save();

            if($header)
                return response()->json(array('success' => true, 'msg' => 'Successfully updated.'));
        }
        

    }
    public function footer(Request $request){       
        if($request->method() == 'GET'){
            $data['footer_scripts'] = Setting::where('name', 'footer_scripts')->first()->value;
            return view('admin.contents.settings-footer', $data);
        }else{
            $footer = Setting::where('name', 'footer_scripts')->first();
            $footer->value = $request->footer_scripts;
            if($footer)
                return response()->json(array('success' => true, 'msg' => 'Successfully updated.'));
        }

    }
    public function banner(Request $request){
        if($request->method() == 'GET'){
            $data['home_hero'] = Setting::where('name', 'home_hero')->first()->value;
            $data['dashboard_banner'] = Setting::where('name', 'dashboard_banner')->first()->value;
            return view('admin.contents.settings-banner', $data);
        }else{
            $banner = '';
            switch($request->type){
                case 'dashboard': 
                    $banner = Setting::where('name', 'dashboard_banner')->first();
                break;
                case 'home': 
                    $banner = Setting::where('name', 'home_hero')->first();
                break;
            }
            
            if($request->hasFile('image')){
                if($request->file('image')->isValid()){
                    // Get image file
                    $image = $request->file('image');
    
                    // Make a image name based on user name and current timestamp
                    $name = Str::slug($request->input('title')).'_'.time();
    
                    $extension = $request->image->extension();
    
                    $request->image->storeAs('/public/banners', $name.".".$extension);
                    $url = Storage::url('banners/'.$name.".".$extension);
    
                    $banner->value = $url;
                    $banner->save();
                }
            }

            $banner->save();

            if($banner)
                return response()->json(array('success' => true, 'msg' => 'Successfully updated.'));
        }
    }
}
