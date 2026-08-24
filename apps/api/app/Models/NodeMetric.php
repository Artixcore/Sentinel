<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class NodeMetric extends Model
{
    public $timestamps = false;
    protected $fillable = ['node_id','cpu_percent','memory_percent','disk_percent','bandwidth_in_bytes','bandwidth_out_bytes','load_1m','recorded_at'];
    protected function casts(): array { return ['recorded_at'=>'datetime']; }
}
