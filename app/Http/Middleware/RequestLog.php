<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLog
{
    protected $start_execution;
    protected $stop_execution;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $this->start_execution = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->stop_execution = microtime(true);

        $this->log($request, $response);
    }

    protected function log($request, $response)
    {
        $duration = round(($this->stop_execution - $this->start_execution), 2);
        $url = $request->fullUrl();
        $method = $request->getMethod();
        $ip = $request->getClientIp();
        $status = $response->getStatusCode();
        $payload = json_encode($request->all());
        $receivedContent = $response->getContent();
        $log = "[AUDITOR_DASHBOARD] {$ip}  {$status} {$method} {$url} {$payload} {$receivedContent} {$duration}ms";

        Log::info($log);
        
    }
}
