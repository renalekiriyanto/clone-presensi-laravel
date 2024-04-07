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
        return view("auth.login");
    }

    public function login(Request $r)
    {
        set_time_limit(30000);
        $data_valid = $r->validate([
            "userinfo_id" => "required|string|max:255",
            "password" => "required|string|max:255",
        ]);

        try {
            $res = Http::post(
                "http://devpresensi.bukittinggikota.go.id/api/login",
                [
                    "userinfo_id" => $r->userinfo_id,
                    "password" => $r->password,
                ]
            );

            $data = $res->json();

            session(["token" => $data["token"]]);
            session(['userinfo_id' => $r->userinfo_id]);

            return view("absen.index");
        } catch (Exception $err) {
            return redirect()
                ->route("login_page")
                ->with("error", $err->getMessage());
        }
    }

    public function logout(Request $r){
        session()->forget('token');
        return redirect()->route('login_page')->with('success', 'Berhasil Logout!');
    }
}
