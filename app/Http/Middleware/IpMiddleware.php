<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\IpAddress;
use Illuminate\Http\Request;
use App\Models\Configuration;

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
        $header = $request->header('api_key');
        $ips = IpAddress::pluck('ip_address')->toArray();
        $api_key = Configuration::where('key','api_key')->firstOrFail();
        
        if ((!in_array($request->ip(), $ips)) || $header !== $api_key->value) {
                return response()->json(['result'=>'unauthorized access']);
        }
        return $next($request);
    }
}
