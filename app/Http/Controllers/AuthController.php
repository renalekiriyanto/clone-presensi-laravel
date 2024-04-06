<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Termwind\Components\Dd;

class AuthController extends Controller
{
    public function index()
    {
        $token = session("token");

        if ($token) {
            return redirect()->route("absen");
        }

        return view("auth.login");
    }

    public function login(Request $r)
    {
        $data_validate = $r->validate([
            "userinfo_id" => "required|string|max:255",
            "password" => "required|string|max:255",
        ]);

        try {
            $response = Http::post(
                "http://devpresensi.bukittinggikota.go.id/api/login",
                $data_validate
            );

            $data = $response->json();

            session(["token" => $data["token"]]);

            return redirect()->route("absen");
        } catch (Exception $err) {
            return redirect()
                ->route("login_page")
                ->with("error", $err->getMessage());
        }
    }
}
