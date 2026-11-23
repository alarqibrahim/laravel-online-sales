@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="card">
    <div class="checkout-layout">
        @if($product->image)
            <img class="thumb" style="height:340px" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
        @else
            <div class="thumb" style="height:340px"></div>
        @endif

        <div>
            <div class="muted">{{ $product->category->name }} | {{ $product->sku }}</div>
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>
            <p class="price">Rp{{ number_format($product->price, 2, ',', '.') }}</p>
            <p>Stok tersedia: {{ $product->stock }}</p>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @auth
                @if(auth()->user()->role === 'customer')
                    @if($product->stock > 0)
                        @php($cartRoute = Route::has('cart.store') ? route('cart.store', $product) : (Route::has('cart.add') ? route('cart.add', $product) : null))
                        @if($cartRoute)
                            <form method="POST" action="{{ $cartRoute }}">
                                @csrf
                                <label>
                                    Jumlah
                                    <input class="input" style="max-width:120px" type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}">
                                </label>
                                <button type="submit" class="btn">Tambah ke Keranjang</button>
                            </form>
                        @endif
                    @else
                        <p class="badge cancelled">Stok habis. Cek kembali nanti.</p>
                    @endif
                @endif
            @else
                <p><a href="{{ route('login') }}">Login</a> untuk berbelanja.</p>
            @endauth
        </div>
    </div>
</div>
@endsection