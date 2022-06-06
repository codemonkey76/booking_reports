<?php

use App\Http\Controllers\ReportController;
use App\Http\Middleware\ValidateMailgun;
use Illuminate\Support\Facades\Route;

Route::middleware(ValidateMailgun::class)->post('/report', ReportController::class);


Route::get('/', function() {
   return "Hello World";
});
