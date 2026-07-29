@extends('layouts.app')

@section('title','Detail Produk')

@section('content')

@include('layouts.navbar')

<h1>Halaman Detail Produk</h1>

<div class="card" style="width: 18rem;">
  <img src="{{ asset('storage/' . $produk->foto) }}" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"> Nama Produk  :{{ $produk->nama}}</h5>
    <p class="card-text">   Harga dasar  :{{ $produk->harga_beli}}</p>
    <p class="card-text">   Harga jual   :{{ $produk->harga_jual}}</p>
    <p class="card-text">   Stok         :{{ $produk->stok}}</p>
    <p class="card-text">  Nama Pengimput  :{{ $produk->user->name}}</p>
    <a href="{{ route('produk.index') }}" class="btn btn-primary">Kembali</a>
  </div>
</div>
@endsection