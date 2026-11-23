@extends('layouts.app')

@section('title', $order->code)

@section('content')

<div class="container">

    {{-- Judul Halaman --}}
    <h1>Detail Pesanan {{ $order->code }}</h1>

    {{-- Informasi Pesanan --}}
    <div class="card">

        <h3>Informasi Pesanan</h3>

        <p>
            Status:
            <strong>{{ strtoupper($order->status) }}</strong>
        </p>

        <p>
            Penerima:
            {{ $order->recipient_name }}
        </p>

        <p>
            Nomor Telepon:
            {{ $order->phone }}
        </p>

        <p>
            Alamat:
            {{ $order->address }}
        </p>

        <p>
            Pengiriman:
            {{ $order->shipping_courier }}
            {{ $order->shipping_service }}
            - {{ $order->shipping_eta }}
        </p>

        <p>
            Tanggal Pesanan:
            {{ $order->ordered_at
                ? $order->ordered_at->format('d-m-Y H:i')
                : '-' }}
        </p>

    </div>

    {{-- Detail Produk --}}
    <h3>Produk yang Dipesan</h3>

    <div class="table-scroll">

        <table>

            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>

                @forelse($order->items as $item)

                    <tr>

                        <td>
                            {{ $item->product_name }}
                        </td>

                        <td>
                            Rp{{ number_format(
                                $item->price,
                                2,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td>
                            {{ $item->quantity }}
                        </td>

                        <td>
                            Rp{{ number_format(
                                $item->subtotal,
                                2,
                                ',',
                                '.'
                            ) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4">
                            Belum ada detail produk.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Ringkasan Pembayaran --}}
    <div class="card" style="margin-top: 16px;">

        <h3>Ringkasan Pembayaran</h3>

        <p>
            Subtotal:
            Rp{{ number_format($order->subtotal, 2, ',', '.') }}
        </p>

        <p>
            Ongkos Kirim:
            Rp{{ number_format($order->shipping_cost, 2, ',', '.') }}
        </p>

        <hr>

        <h3>
            Total Pembayaran:
            Rp{{ number_format($order->grand_total, 2, ',', '.') }}
        </h3>

    </div>

    {{-- Tombol Kembali --}}
    <div style="margin-top: 18px;">

        <a href="{{ route('orders.index') }}" class="btn">
            Kembali ke Pesanan Saya
        </a>

    </div>

</div>

@endsection
