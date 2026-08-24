<?php
namespace App\Jobs;
use App\Models\Monitor;
use App\Services\WebsiteProbe;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
final class RunWebsiteCheck implements ShouldQueue
{
    use Queueable;
    public function __construct(public int $monitorId) { $this->onQueue('monitoring'); }
    public function handle(WebsiteProbe $probe): void
    {
        $monitor=Monitor::query()->findOrFail($this->monitorId);
        $monitor->checks()->create([...$probe->run($monitor),'checked_at'=>now()]);
        $monitor->update(['last_checked_at'=>now()]);
    }
}
