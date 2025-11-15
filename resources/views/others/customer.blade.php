@extends('layouts')

@section('title', 'Customers')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 70vh;">
    <div class="text-center">
        <i class="bi bi-exclamation-circle" style="font-size: 80px; color: #ff6b6b;"></i>
        <h2 class="mt-4">Maaf!</h2>
        <p class="lead">Fitur ini belum tersedia. Silakan kembali lagi nanti.</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
