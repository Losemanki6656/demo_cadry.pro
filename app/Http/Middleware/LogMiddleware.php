<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;
use Jenssegers\Agent\Facades\Agent;
use App\Models\UserEvent;
use App\Jobs\UserEventJob;

 use Illuminate\Foundation\Bus\DispatchesJobs;

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

        // $events = [];
        
        // $events[] = [
        //     'ipAddress' => $request->ip ?? null,
        //     'pathInfo' => $request->url(),
        //     'requestUri' => $request->getRequestUri(),
        //     'method' => $request->method(),
        //     'userAgent' => $request->header('User-Agent'),
        //     'content' => $request->getContent(),
        //     'user_id' => auth()->user()->id ?? null
        // ];
        
        // UserEvent::create($events[0]);

        // $agent = new Agent();

        // $job = new UserEventJob($request, $agent);

        // $this->dispatch( $job );

        return $response;
    }
}
