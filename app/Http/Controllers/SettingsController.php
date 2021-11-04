<?php

namespace App\Http\Controllers;

use App\Models\IpAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Requests\StoreIpRequest;

class SettingsController extends Controller
{
    //settings view
    public function index(Request $request)
    {
        $api_key = Configuration::where('key','api_key')->first()->value;

        return view('admin.settings', compact('api_key'));
    }

    //save setting
    public function createIp(StoreIpRequest $request)
    {
        // dd($request->all());
        $setting = new IpAddress;
        $setting->ip_address = $request->ip_address;
        $setting->save();
        
        if ($setting) {
            return back()->with('message','Ip Address whitelisted successfully');
        }
    }

    //save security question
    public function editIp(StoreIpRequest $request)
    {
        $setting = IpAddress::findOrFail($request->ip_id);
        $setting->update([
            'ip_address'=>$request->ip_address,
        ]);

        return back()->with(['message'=>'IP saved successfully']);
    }

    //get all whitelisted ips
    public function ipAddress()
    {
        $ips = IpAddress::all();

        return view('admin.ip-address')->with(['ips'=>$ips]);
    }

    //generate api key
    public function generateAPIKey()
    {
        $api_key = Configuration::where('key','api_key')->firstOrFail();
        $uuid= ((string) Str::uuid());
        $api_key->update([
            'value'=>$uuid,
        ]);

        return back();
    }
}
