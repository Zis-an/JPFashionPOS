<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public function global_setting(){
        return view('admin.settings.global_setting');
    }
   public function update_global_setting(Request $request){
        if ($request->site_name){setSetting('site_name',$request->site_name);}
//        if ($request->currency){setSetting('currency',$request->currency);}
        toastr()->success(__('updated'));
        return redirect()->back();
   }
}
