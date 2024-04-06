<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsenController extends Controller
{
    public function index()
    {
        $token = session()->get("token");

        if (!$token) {
            return redirect()->route("login_page");
        } else {
            $token = "Bearer " . session()->get("token");
        }

        try {
            $token = session()->get("token");

            $response = Http::withHeaders([
                "Authorization" => $token,
            ])->get(
                "http://devpresensi.bukittinggikota.go.id/api/checkin-today"
            );

            $data = $response->json();

            return view("absen.index", compact($data));
        } catch (Exception $err) {
            return redirect()
                ->route("absen")
                ->with("error", $err->getMessage());
        }
    }
}
