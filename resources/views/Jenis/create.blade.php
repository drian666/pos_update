@extends('layouts.app')

@section('title', 'Tambah Jenis')

@section('content')
    @include('layouts.navbar')

    <style>
        .btn-black {
            background-color: #000;
            border-color: #000;
            color: #fff;
        }

        .btn-black:hover {
            background-color: #222;
            border-color: #222;
            color: #fff;
        }
    </style>

    <div class="container py-4" style="max-width: 640px;">
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Tambah Jenis</h1>
            <p class="text-muted small mb-0">Buat kategori / jenis produk baru</p>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('jenis.store') }}" method="POST">
                    @csrf
                    @include('jenis._form')
                </form>
            </div>
        </div>
    </div>
@endsection
