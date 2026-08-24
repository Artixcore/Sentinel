<?php
use App\Http\Controllers\Api\MetricIngestController;
use App\Http\Controllers\Api\MonitorController;
use App\Http\Controllers\Api\OverviewController;
use Illuminate\Support\Facades\Route;
Route::prefix('v1')->middleware('throttle:api')->group(function(){
    Route::get('/health',fn()=>response()->json(['status'=>'ok','time'=>now()->toIso8601String()]));
    Route::get('/overview',OverviewController::class);
    Route::apiResource('monitors',MonitorController::class)->only(['index','store']);
    Route::post('/monitors/{monitor}/run',[MonitorController::class,'run']);
    Route::post('/ingest/node-metrics',MetricIngestController::class)->middleware('throttle:120,1');
});
