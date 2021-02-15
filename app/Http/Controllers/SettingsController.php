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
            $data['home_hero'] = Setting::get('home_hero');
            $data['dashboard_banner_image'] = Setting::getv('dashboard_banner_image');
            $data['dashboard_banner_title'] = Setting::getv('dashboard_banner_title');
            $data['dashboard_banner_subtitle'] = Setting::getv('dashboard_banner_subtitle');
            return view('admin.contents.settings-banner', $data);
        }else{
            $banner = '';
            switch($request->type){
                case 'dashboard': 
                    if($request->hasFile('image')){
                        if($request->file('image')->isValid()){
                            // Get image file
                            $image = $request->file('image');
            
                            // Make a image name based on user name and current timestamp
                            $name = Str::slug($request->input('title')).'_'.time();
            
                            $extension = $request->image->extension();
            
                            $request->image->storeAs('/public/banners', $name.".".$extension);
                            $url = Storage::url('banners/'.$name.".".$extension);
            
                            Setting::set('dashboard_banner_image', $url);
                        }
                    }

                    Setting::set('dashboard_banner_title',$request->title);
                    Setting::set('dashboard_banner_subtitle',$request->subtitle);
                break;
                case 'home': 
                    if($request->hasFile('image')){
                        if($request->file('image')->isValid()){
                            // Get image file
                            $image = $request->file('image');
            
                            // Make a image name based on user name and current timestamp
                            $name = Str::slug($request->input('title')).'_'.time();
            
                            $extension = $request->image->extension();
            
                            $request->image->storeAs('/public/banners', $name.".".$extension);
                            $url = Storage::url('banners/'.$name.".".$extension);
            
                            Setting::set('home_hero', $url);
                        }
                    }
                break;
            }
            
            return response()->json(array('success' => true, 'msg' => 'Successfully updated.'));
        }
    }
}
