@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

<h1>Detail penjualan</h1>

<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">kasir: {{ $sale->user->name}}</h5>
    <h6 class="card-subtitle mb-2 text-muted">Tanggal Transaksi : {{ $sale->created_at->translatedFormat('d-m-Y h:i:s')}}</h6>
    <p class="card-text">total pembayaran : Rp.{{ number_format($sale->total_pembayaran)}}</p>
  </div>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Foto</th>
      <th scope="col">Nama</th>
      <th scope="col">Harga</th>
    </tr>
  </thead>
  <tbody>
    <?php $i =1; ?>
     @foreach($sale->itemPenjualan as $item)
    <tr>
    <th scope="row">{{$i++; }}</th>
      <td>
        <img src="{{ asset('storage/'.$item->produk->foto) }}" width="100">
       <td>{{ $item->produk->nama }}</td>
       <td>Rp.{{ number_format($item->produk->harga_jual) }}</td>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection