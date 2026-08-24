<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MonitorCheck extends Model
{
    public $timestamps = false;
    protected $fillable = ['monitor_id','status','status_code','latency_ms','error','checked_at'];
    protected function casts(): array { return ['checked_at'=>'datetime']; }
}
