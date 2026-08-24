<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Jobs\RunWebsiteCheck;
use App\Models\Monitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
final class MonitorController extends Controller
{
    public function index(): JsonResponse { return response()->json(Monitor::query()->with(['checks'=>fn($q)=>$q->latest('checked_at')->limit(24)])->paginate(20)); }
    public function store(Request $request): JsonResponse { $monitor=Monitor::query()->create($request->validate(['name'=>'required|string|max:120','url'=>'required|url:http,https|max:2048','method'=>'sometimes|in:GET,HEAD','expected_status'=>'sometimes|integer|min:100|max:599','interval_seconds'=>'sometimes|integer|min:30|max:86400','timeout_seconds'=>'sometimes|integer|min:1|max:60'])); return response()->json(['data'=>$monitor],201); }
    public function run(Monitor $monitor): JsonResponse { RunWebsiteCheck::dispatch($monitor->id); return response()->json(['message'=>'Check queued'],202); }
}
