@extends('layouts.main')
@section('title', 'Absen Pulang')
@section('container')
    <div class="container-sm card p-2 mt-3">
        <a href="{{route('absen')}}">Back</a>
        <form action="{{route('absen.pulang.process')}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>Absen Pulang</h3>
            <div class="input-group">
                <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                <button class="btn btn-outline-success" type="submit" id="inputGroupFileAddon04">Absen Pulang</button>
            </div>
        </form>
    </div>
@endsection
