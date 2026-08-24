<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Monitor extends Model
{
    protected $fillable = ['name','url','method','expected_status','interval_seconds','timeout_seconds','enabled','last_checked_at'];
    protected function casts(): array { return ['enabled'=>'boolean','last_checked_at'=>'datetime']; }
    public function checks(): HasMany { return $this->hasMany(MonitorCheck::class); }
}
