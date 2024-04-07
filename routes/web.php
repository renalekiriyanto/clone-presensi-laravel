<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix("login")->group(function () {
    Route::get("/", [AuthController::class, "index"])->name("login_page");
    Route::post("/", [AuthController::class, "login"])->name("login");
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix("absen")->group(function () {
    Route::get("/", [AbsenController::class, "index"])->name("absen");
    Route::get("/masuk", [AbsenController::class, "absenMasuk"])->name("absen.masuk");
    Route::post("/masuk", [AbsenController::class, "absenMasukProcess"])->name("absen.masuk.process");
    Route::get("/pulang", [AbsenController::class, "absenPulang"])->name("absen.pulang");
    Route::post("/pulang", [AbsenController::class, "absenPulangProcess"])->name("absen.pulang.process");
});
