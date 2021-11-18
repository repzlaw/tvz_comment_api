<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\IpAddress;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\FailedAccess;

class IpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('X-Api-Key');
        $ips = IpAddress::pluck('ip_address')->toArray();
        $api_key = Configuration::where('key','api_key')->firstOrFail();
        
        if ((!in_array($request->ip(), $ips)) || $header !== $api_key->value) {

            if((!in_array($request->ip(), $ips))){
                $error = 'Access denied, IP is not whitelisted';
                $code = 401;
            } else if($header !== $api_key->value){
                $error = 'Access denied, Invalid API Key';
                $code = 402;
            }

            $failedaccess = FailedAccess::create([
                'ip_address'=>$request->ip(),
                'header_info' => json_encode($request->header()),
                'description' => $error,
                'status_code' => $code,
            ]);

            return response()->json(['result'=>'unauthorized access'],400);
        }

        return $next($request);
    }
}
