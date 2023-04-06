<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;
use Jenssegers\Agent\Facades\Agent;
use App\Models\UserEvent;

class LogMiddleware 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    // private $logger;

    // public function __construct(Logger $logger) 
    // {
    //     $this->logger = $logger;
    // }

    public function handle(Request $request, Closure $next)
    {
        // return $next($request);

        $response = $next($request);

        $events = [];
        $data = \Location::get($request->ip()); 

        $events[] = [
            'browser' => Agent::browser(),
            'version' => Agent::version(Agent::browser()),
            'platform' => Agent::platform(),
            'ipAddress' => $request->ip ?? null,
            'countryName' =>  $data->countryName ?? null,
            'countryCode' => $data->countryCode ?? null,
            'regionCode' => $data->regionCode ?? null,
            'regionName' => $data->regionName ?? null,
            'cityName' => $data->cityName ?? null,
            'latitude' => $data->latitude ?? null,
            'longitude' => $data->longitude ?? null,
            'areaCode' => $data->areaCode ?? null,
            'timezone' => $data->timezone ?? null,
            'pathInfo' => $request->url(),
            'requestUri' => $request->getRequestUri(),
            'method' => $request->method(),
            // 'userAgent' => $request->header('User-Agent'),
            'content' => $request->getContent(),
            'header' => Agent::match('regexp'),
            'device' => Agent::device(),
            'user_id' => auth()->user()->id ?? null
        ];
        
        UserEvent::create($events[0]);
                
        return $response;
    }
}
