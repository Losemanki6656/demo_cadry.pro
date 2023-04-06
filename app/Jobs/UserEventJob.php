<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserEvent;

class UserEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $agent;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $agent)
    {
       $this->request = $request;
       $this->agent = $agent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $events = [];
        $data = \Location::get($this->request->ip()); 

        $events[] = [
            'browser' => $this->agent->browser(),
            'version' => $this->agent->version($this->agent->browser()),
            'platform' => $this->agent->platform(),
            'ipAddress' => $this->request->ip ?? null,
            'countryName' =>  $data->countryName ?? null,
            'countryCode' => $data->countryCode ?? null,
            'regionCode' => $data->regionCode ?? null,
            'regionName' => $data->regionName ?? null,
            'cityName' => $data->cityName ?? null,
            'latitude' => $data->latitude ?? null,
            'longitude' => $data->longitude ?? null,
            'areaCode' => $data->areaCode ?? null,
            'timezone' => $data->timezone ?? null,
            'pathInfo' => $this->request->url(),
            'requestUri' => $this->request->getRequestUri(),
            'method' => $this->request->method(),
            // 'userAgent' => $this->request->header('User-Agent'),
            'content' => $this->request->getContent(),
            'header' => $this->agent->match('regexp'),
            'device' => $this->agent->device(),
            'user_id' => auth()->user()->id ?? null
        ];
        
        UserEvent::create($events[0]);
    }
}
