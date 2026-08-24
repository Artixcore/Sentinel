<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\NodeMetric;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
final class MetricIngestController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        abort_unless(hash_equals((string)config('services.sentinel.ingest_token'),(string)$request->bearerToken()),401);
        $data=$request->validate(['node_id'=>'required|string|max:120','cpu_percent'=>'required|numeric|between:0,100','memory_percent'=>'required|numeric|between:0,100','disk_percent'=>'required|numeric|between:0,100','bandwidth_in_bytes'=>'required|integer|min:0','bandwidth_out_bytes'=>'required|integer|min:0','load_1m'=>'nullable|numeric|min:0','recorded_at'=>'nullable|date']);
        return response()->json(['data'=>NodeMetric::query()->create([...$data,'recorded_at'=>$data['recorded_at']??now()])],202);
    }
}
