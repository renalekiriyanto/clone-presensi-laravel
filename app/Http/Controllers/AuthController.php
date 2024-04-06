<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $data_validate = $r->validate([
            'userinfo_id' => 'required|string|max:255',
            'password' => 'required|string|max:255'
        ]);

        try {
            $response = Http::post('http://devpresensi.bukittinggikota.go.id/api/login', $data_validate);

            $data = $response->json();

            return response()->json($data);
        } catch (Exception $err) {
            return response()->json($err->getMessage());
        }
    }
}
