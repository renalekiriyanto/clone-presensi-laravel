@extends('layouts.main')
@section('title', 'List Absen')
@section('container')
    <div class="container-sm">
        <div class="p-2 mb-3">
            <a class="btn btn-danger" href="">
                Logout
            </a>
        </div>
        <div class="p-2 mb-3">
            <a class="btn btn-success" href="">
                Absen Masuk
            </a>
            <a class="btn btn-danger" href="">
                Absen Pulang
            </a>
        </div>
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{session('error')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="list-group">
            @foreach($data as $item)
                <div class="card p-2 mb-2">
                    <h3>{{$item->date}}</h3>
                    @foreach($item->data as $item2)
                        <a href="#" class="card-item list-group-item list-group-item-action
                        @if ($item2['type'] === 'Masuk')
                            bg-success
                        @else
                            bg-danger
                        @endif
                        text-white mb-2" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{$item2['type']}}</h5>
                                <small>{{$item2['time']}}</small>
                            </div>
                            <p class="mb-1">Anda absen masuk menggunakan <b>
                                @if ($item2['sn'] === 'ENTRI_FROM_MOBILE')
                                    MOBILE
                                @else
                                    ALAT MESIN
                                @endif
                            </b></p>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
