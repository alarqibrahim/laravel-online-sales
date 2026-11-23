@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<div class="container">

    <h1>Pesanan Saya</h1>

    {{-- Tabel Daftar Pesanan --}}
    <div class="table-scroll">

        <table>

            <thead>
                <tr>
                    <th>Kode Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($orders as $order)

                    <tr>

                        {{-- Kode Pesanan --}}
                        <td>
                            {{ $order->code }}
                        </td>

                        {{-- Tanggal Pesanan --}}
                        <td>
                            {{ $order->ordered_at
                                ? $order->ordered_at->format('d-m-Y H:i')
                                : '-' }}
                        </td>

                        {{-- Total Pembayaran --}}
                        <td>
                            Rp{{ number_format(
                                $order->grand_total,
                                2,
                                ',',
                                '.'
                            ) }}
                        </td>

                        {{-- Status Pesanan --}}
                        <td>
                            {{ strtoupper($order->status) }}
                        </td>

                        {{-- Detail Pesanan --}}
                        <td>
                            <a href="{{ route('orders.show', $order) }}">
                                Detail
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5">
                            Belum ada pesanan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Navigasi Halaman --}}
    <div style="margin-top: 18px;">
        {{ $orders->links() }}
    </div>

</div>

@endsection
