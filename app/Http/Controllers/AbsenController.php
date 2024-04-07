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
        try {
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
        } catch (RequestException $e) {
            if($e->getCode() == 28){
                $retryCount = 3;
                $retryDelay = 1000;

                for ($i = 0; $i < $retryCount; $i++) {
                    try {
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
                        break;
                    } catch (RequestException $e) {
                        // Handle request exception
                        if ($i == $retryCount - 1) {
                            // If this is the last retry attempt, throw the exception
                            throw $e;
                        } else {
                            // If there are more retries remaining, wait before retrying
                            usleep($retryDelay * 1000); // Convert milliseconds to microseconds
                        }
                    }
                }

            }
        }
    }

    public function absenMasuk()
    {
        return view('absen.absen_masuk');
    }

    public function absenMasukProcess(Request $r){
        $data_valid = $r->validate([
            'photo' => 'required'
        ]);
        $token = session('token');

        if(!$token){
            return redirect()->route('login_page')->with('error', 'Anda Harus Login!');
        }

        $token = 'Bearer '.$token;

        try{
            $lat = '-0.3136807';
            $lng = '100.3730727';
            $type = 1;

            $response = Http::withHeaders([
                'Authorization' => $token
            ])
            ->post('http://devpresensi.bukittinggikota.go.id/api/checkin', [
                'lat' => $lat,
                'lng' => $lng,
                'type' => $type,
                'user_id' => session('userinfo_id'),
                'photo' => $r->photo
            ]);

            $data = $response->json();

            if($data->hasil == 3){
                return redirect()->route('absen')->with('error', 'Gagal Absen');
            }elseif ($data->hasil == 2) {
                return redirect()->route('absen')->with('error', 'Sudah Absen');
            } else {
                return redirect()->route('absen')->with('success', 'Berhasil Absen Masuk');
            }
        }catch(Exception $err){
            return redirect()->route('absen')->with('error', $err->getMessage());
        }
    }

    public function absenPulang()
    {
        return view('absen.absen_pulang');
    }

    public function absenPulangProcess(Request $r){
        $data_valid = $r->validate([
            'photo' => 'required'
        ]);
        $token = session('token');

        if(!$token){
            return redirect()->route('login_page')->with('error', 'Anda Harus Login!');
        }

        $token = 'Bearer '.$token;

        try{
            $lat = '-0.3136807';
            $lng = '100.3730727';
            $type = 4;

            $response = Http::withHeaders([
                'Authorization' => $token
            ])
            ->post('http://devpresensi.bukittinggikota.go.id/api/checkin', [
                'lat' => $lat,
                'lng' => $lng,
                'type' => $type,
                'user_id' => session('userinfo_id'),
                'photo' => $r->photo
            ]);

            $data = $response->json();

            if($data->hasil == 3){
                return redirect()->route('absen')->with('error', 'Gagal Absen');
            }elseif ($data->hasil == 2) {
                return redirect()->route('absen')->with('error', 'Sudah Absen');
            } else {
                return redirect()->route('absen')->with('success', 'Berhasil Absen Masuk');
            }
        }catch(Exception $err){
            return redirect()->route('absen')->with('error', $err->getMessage());
        }
    }
}
