<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix("login")->group(function () {
    Route::get("/", [AuthController::class, "index"])->name("login_page");
    Route::post("/", [AuthController::class, "login"])->name("login");
});

Route::prefix("absen")->group(function () {
    Route::get("/", [AbsenController::class, "index"])->name("absen");
});
