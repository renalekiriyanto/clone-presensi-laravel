@extends('layouts.main')
@section('title', 'List Absen')
@section('container')
    <div class="container-sm">
        <ul class="list-group">
            @foreach ($data as $item)
                <li class="list-group-item">An item</li>
            @endforeach
        </ul>
    </div>
@endsection
