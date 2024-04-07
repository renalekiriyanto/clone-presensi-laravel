<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Can;
use Termwind\Components\Dd;

class AbsenController extends Controller
{
    public function index()
    {
        set_time_limit(30000);
        $token = session("token");

        if (!$token) {
            return view("login_page")->with("error", "Anda Belum Login");
        }

        $token = "Bearer " . $token;
        $response = Http::withHeaders([
            "Authorization" => $token,
        ])->get("http://devpresensi.bukittinggikota.go.id/api/checkin-today");

        $response_result = $response->json();
        $data = collect([]);
        foreach ($response_result as $item) {
            $data_find = $data->where("date", $item["tgl"])->first();
            if ($data_find) {
                $data_find->data[] = [
                    "type" => $item["checktype"],
                    "time" => Carbon::parse($item["checktime"])->format(
                        "H:i:s"
                    ),
                    "sn" => $item["SN"],
                ];
            } else {
                $data->push(
                    (object) [
                        "date" => $item["tgl"],
                        "data" => [
                            [
                                "type" => $item["checktype"],
                                "time" => Carbon::parse(
                                    $item["checktime"]
                                )->format("H:i:s"),
                                "sn" => $item["SN"],
                            ],
                        ],
                    ]
                );
            }
        }
        return view("absen.index", [
            "data" => $data,
        ]);
    }
}
