<?php
namespace App\Services;
use App\Models\Monitor;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
final class WebsiteProbe
{
    public function run(Monitor $monitor): array
    {
        $start = hrtime(true);
        try {
            $response = Http::timeout($monitor->timeout_seconds)->withUserAgent('Artixcore-Sentinel/1.0')->send($monitor->method, $monitor->url);
            $latency = (int) round((hrtime(true)-$start)/1_000_000);
            return ['status'=>$response->status()===$monitor->expected_status?'up':'degraded','status_code'=>$response->status(),'latency_ms'=>$latency,'error'=>null];
        } catch (ConnectionException $e) {
            return ['status'=>'down','status_code'=>null,'latency_ms'=>(int) round((hrtime(true)-$start)/1_000_000),'error'=>mb_substr($e->getMessage(),0,1000)];
        }
    }
}
