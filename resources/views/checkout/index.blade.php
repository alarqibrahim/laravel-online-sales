@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<h1>Checkout</h1>

<div class="checkout-layout">

    {{-- Form Checkout --}}
    <div class="card">

        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <input
                type="hidden"
                name="checkout_token"
                value="{{ $checkoutToken }}"
            >

            {{-- Nama Penerima --}}
            <label>
                Nama Penerima

                <input
                    class="input"
                    type="text"
                    name="recipient_name"
                    value="{{ old('recipient_name', auth()->user()->name) }}"
                    required
                >
            </label>

            {{-- Nomor Telepon --}}
            <label>
                No. Telepon

                <input
                    class="input"
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                >
            </label>

            {{-- Alamat --}}
            <label>
                Alamat

                <textarea
                    class="input"
                    rows="4"
                    name="address"
                    required
                >{{ old('address') }}</textarea>
            </label>

            {{-- Pilihan Ekspedisi --}}
            <label>
                Ekspedisi

                <select
                    class="input"
                    name="shipping_service_id"
                    required
                >
                    <option value="">Pilih ekspedisi</option>

                    @foreach($shippingServices as $service)
                        <option
                            value="{{ $service->id }}"
                            data-cost="{{ $service->cost }}"
                            @selected(old('shipping_service_id') == $service->id)
                        >
                            {{ $service->courier }}
                            - {{ $service->service }}
                            ({{ $service->eta }})
                            - Rp{{ number_format($service->cost, 2, ',', '.') }}
                        </option>
                    @endforeach

                </select>
            </label>

            {{-- Tombol Pesanan --}}
            <button
                type="submit"
                class="btn"
                @disabled($shippingServices->isEmpty())
            >
                Buat Pesanan
            </button>

            @if($shippingServices->isEmpty())
                <p class="validation-error">
                    Belum ada layanan pengiriman aktif.
                    Hubungi admin sebelum checkout.
                </p>
            @endif

        </form>

    </div>

    {{-- Ringkasan Pesanan --}}
    <div class="card">

        <h3>Ringkasan</h3>

        @foreach($items as $item)

            <p>
                {{ $item['product']->name }}
                x {{ $item['quantity'] }}

                = Rp{{ number_format($item['lineTotal'], 2, ',', '.') }}
            </p>

        @endforeach

        <hr>

        {{-- Subtotal --}}
        <div data-subtotal="{{ $subtotal }}">

            <strong>
                Subtotal Rp{{ number_format($subtotal, 2, ',', '.') }}
            </strong>

        </div>

        {{-- Ongkos Kirim --}}
        <div class="summary-line">

            <span>Ongkos kirim</span>

            <strong data-shipping-total>
                Pilih ekspedisi
            </strong>

        </div>

        {{-- Total Pesanan --}}
        <div class="summary-total" data-order-total></div>

        <p class="muted">
            Ongkir ditambahkan sesuai ekspedisi yang dipilih.
        </p>

    </div>

</div>

@endsection
