<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
    
        $stripeSettings=Setting::where('key','stripe_credentials')->first();
        $data['stripe']=json_decode($stripeSettings->value);
        $data['stripeId']=$stripeSettings->id;
        
        return view('app.settings.index',$data);
    }

    public function saveStripeCredentials(Request $request){
        
        $ruquestData=$request->only('stripe_publishable_key','stripe_secret_key');
        
        $stripe=isset($request->stripe_id)?Setting::find($request->stripe_id):new Setting();
        $stripe->key='stripe_credentials';
        $stripe->value=json_encode($ruquestData);
        $stripe->save();
        
        return redirect()->back();
    
    }
    
}
