<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Monitor;
use App\Models\MonitorCheck;
use App\Models\NodeMetric;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
final class OverviewController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $data=Cache::remember('overview:v1',15,function(){
            $latest=NodeMetric::query()->latest('recorded_at')->first();
            $checks=MonitorCheck::query()->where('checked_at','>=',now()->subDay());
            $total=(clone $checks)->count(); $up=(clone $checks)->where('status','up')->count();
            return ['uptime_percent'=>$total?round($up/$total*100,3):100,'requests_today'=>$total,'open_incidents'=>(clone $checks)->where('status','!=','up')->count(),'active_monitors'=>Monitor::query()->where('enabled',true)->count(),'resources'=>$latest,'generated_at'=>now()->toIso8601String()];
        });
        return response()->json(['data'=>$data]);
    }
}
