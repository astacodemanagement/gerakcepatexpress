@extends('layouts.app')

@section('content')
<section class="content">
    <div class="error-page">
        <h2 class="headline text-danger">403</h2>
        <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Akses ditolak</h3>
        <p>
        Anda tidak bisa mengakses halaman ini.
        Sementara itu, Anda dapat kembali ke halaman <a href="{{ route('dashboard') }}">dashboard</a>
        </p>
        </div>
    </div>
    
    </section>
@endsection