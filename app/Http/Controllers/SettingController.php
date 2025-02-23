<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Auth\Request\UpdateUser;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;
use Illuminate\Validation\ValidationException;
use Kreait\Firebase\Exception\InvalidArgumentException;
use Kreait\Firebase\Exception\Auth\EmailExists;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Exception\FirebaseException;

use DB;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     *
     */
    protected $auth;
    protected $database;
    public function __construct(FirebaseAuth $auth)
    {
        $this->middleware('auth');
        $this->auth = $auth;
        $this->database = app('firebase.database');
    }

    // public function admobList()
    // {
    //     $admob = $this->auth->listAdmob();
    //     return view('dashboard.setting.admobList', compact('admob'));
    // }

    public function admobList()
    {

        $database = app('firebase.database');
        $admob = $database->getReference('admob')->getvalue();
        // echo '<pre>';print_r($admob); die();
        // $you = auth()->user();
        return view('dashboard.setting.admobList', compact('admob'));
    }

  	public function edit()
    {
        $database = app('firebase.database');
        $admob = $database->getReference('admob')->getvalue();
        return view('dashboard.setting.admobEditForm', compact('admob'));
    }

    public function update(Request $request)
    {
    	$database = app('firebase.database');
        $validatedData = $request->validate([
            'id' => 'required|min:1|max:256',
        ]);
        
        $id = $_REQUEST['id'];

        $updates = [ 'admob/id' =>$id];
		$database->getReference()->update($updates);
        
        $request->session()->flash('message', 'Successfully updated user');
        return redirect()->route('admob-list');
    }
    
    public function setting()
    {
        $database = app('firebase.database');
        $admob = $database->getReference('admob')->getvalue();
        return view('dashboard.setting.setting', compact('admob'));
    }
    
    public function status_on_off_ajax(Request $request)
  	{
  		$database = app('firebase.database');
		$status = $_REQUEST['status'];
		if($status == "on")
		{
			$val = "off";
		}
		else
		{
			$val = "on";
		}
        $updates = [ 'admob/status' =>$val];
		$database->getReference()->update($updates);
		return response()->json(['success'=>$val]);
  	}
  	
  	public function setting_update(Request $request)
    {
     
        $app_name = $request->app_name;
        $app_color = $request->app_color;
        
        $image = $request->file('app_logo'); //image file from frontend 
        
        if(!empty($image)){
            $name = $image->getClientOriginalName();
            $storage_path = 'notificationImage/';  
            $localfolder = public_path('app_logo') .'/';
            $extension = $image->getClientOriginalExtension();  
            $file      = $name;
            
            DB::update('update general_settings set s_value = ? where s_key = ?', [$name, "app_logo"]);
            
            if ($image->move($localfolder, $file)) {
                echo 'success';  
            }
        }
        
        if (!empty($app_name)) {
            $app_name = $request->app_name;
            
            DB::update('update general_settings set s_value = ? where s_key = ?', [$app_name, "app_name"]);
        }
        
        if (!empty($app_color)) {
            $color = $request->app_color;
            
            $color_a = str_replace("#", "", $color);
            
            $app_color = '0XFF' . $color_a;
            
            DB::update('update general_settings set s_value = ? where s_key = ?', [$app_color, "app_color"]);
        }

        return redirect('setting');
    }
    
}
