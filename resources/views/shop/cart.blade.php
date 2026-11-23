@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <h1>Keranjang Belanja</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (count($items) > 0)
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $row)
                    @php($p = $row['product'])
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td>{{ $p->stock }}</td>
                        <td>
                            <form action="{{ route('cart.update', $p) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="qty" value="{{ $row['qty'] }}" min="1">
                                <button type="submit">Ubah</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($row['subtotal'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $p) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong></p>
        <a href="{{ route('shop.index') }}">Lanjut Belanja</a>
    @else
        <p>Keranjang masih kosong.</p>
        <a href="{{ route('shop.index') }}">Belanja Sekarang</a>
    @endif
@endsection