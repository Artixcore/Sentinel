<?php
use Illuminate\Support\Facades\Route;
Route::get('/',fn()=>response()->json(['service'=>'Artixcore Sentinel API','version'=>'1.0.0']));
