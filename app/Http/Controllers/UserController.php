<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Addresses;
use Jenssegers\Agent\Agent;

class UserController extends Controller
{
    public function vue(Request $request){
        // dd($request->ip());
        // $agent = new Agent();
        // dd($agent->ip());

        return view('vue');
    }

    public function save_user(Request $request){

        $data = $request->validate([
            'first_name' => 'required|string|min:1|max:100',
            'last_name' => 'required|string|min:1|max:100',
            'email' => 'required|email|unique:users|min:1|max:100',
            'phone' => 'required|numeric|unique:users|digits_between:10,15',
            'dob_day' => 'required|numeric|digits_between:1,2',
            'dob_month' => 'required|numeric|digits_between:1,2',
            'dob_year' => 'required|numeric|digits_between:1,4',
        ]);
        $agent = new Agent();
        $data['browser'] = $agent->browser();
        $data['browser'] = $data['browser'].' '. $agent->version($data['browser']);
        $data['device'] = $agent->platform();
        $data['ip'] = $request->ip();
        $data['user_agent'] = $request->header('User-Agent');
        if(User::create($data)){
            return response()->json([
                'status' => 'success',
            ]);
        }
    }

    public function get_address($email){

        
        $user = User::where('email',$email)->with('addresses')->first();
        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }

    public function save_address(Request $request){

        // return request()->all();
        $data = $request->validate([
            'address_line_1' => 'required',
            'address_line_1.*' => 'required',
            'address_line_2' => 'required',
            'address_line_2.*' => 'required',
            'address_line_3' => 'required',
            'address_line_3.*' => 'required',
        ]);
        $user = User::where('email',$request->email)->first();
        $del = Addresses::where('user_id',$user->id)->delete();
        for ($i=0; $i < count($data['address_line_1']); $i++) { 
            $d['user_id'] = $user->id;
            $d['address_line_1'] = $data['address_line_1'][$i];
            $d['address_line_2'] = $data['address_line_2'][$i];
            $d['address_line_3'] = $data['address_line_3'][$i];
            Addresses::create($d);
        }

        return response()->json([
            'status' => 'success',
        ]);
    }
}
