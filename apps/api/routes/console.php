<?php
use App\Jobs\RunWebsiteCheck;
use App\Models\Monitor;
use Illuminate\Support\Facades\Schedule;
Schedule::call(function(){ Monitor::query()->where('enabled',true)->each(function(Monitor $monitor){ if(!$monitor->last_checked_at || $monitor->last_checked_at->addSeconds($monitor->interval_seconds)->isPast()) RunWebsiteCheck::dispatch($monitor->id); }); })->everyMinute()->withoutOverlapping();
