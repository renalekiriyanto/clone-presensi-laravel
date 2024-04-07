@extends('layouts.main')
@section('title', 'Absen Masuk')
@section('container')
    <div class="container-sm card p-2 mt-3">
        <a href="{{route('absen')}}">Back</a>
        <form action="{{route('absen.masuk.process')}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>Absen Masuk</h3>
            <div class="input-group">
                <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                <button class="btn btn-outline-success" type="submit" id="inputGroupFileAddon04">Absen Masuk</button>
            </div>
        </form>
    </div>
@endsection
