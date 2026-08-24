<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up():void{
Schema::create('monitors',function(Blueprint $t){$t->id();$t->string('name');$t->text('url');$t->string('method',8)->default('GET');$t->unsignedSmallInteger('expected_status')->default(200);$t->unsignedInteger('interval_seconds')->default(60);$t->unsignedTinyInteger('timeout_seconds')->default(10);$t->boolean('enabled')->default(true)->index();$t->timestamp('last_checked_at')->nullable();$t->timestamps();});
Schema::create('monitor_checks',function(Blueprint $t){$t->id();$t->foreignId('monitor_id')->constrained()->cascadeOnDelete();$t->string('status',20)->index();$t->unsignedSmallInteger('status_code')->nullable();$t->unsignedInteger('latency_ms')->nullable();$t->text('error')->nullable();$t->timestamp('checked_at')->index();});
Schema::create('node_metrics',function(Blueprint $t){$t->id();$t->string('node_id')->index();$t->decimal('cpu_percent',5,2);$t->decimal('memory_percent',5,2);$t->decimal('disk_percent',5,2);$t->unsignedBigInteger('bandwidth_in_bytes');$t->unsignedBigInteger('bandwidth_out_bytes');$t->decimal('load_1m',8,3)->nullable();$t->timestamp('recorded_at')->index();});
}public function down():void{Schema::dropIfExists('node_metrics');Schema::dropIfExists('monitor_checks');Schema::dropIfExists('monitors');}};
