@extends('layouts.admin')

@section('title', 'Ekspedisi')

@section('content')
    <div class="page-header">
        <h1>Layanan Ekspedisi</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <h2>Tambah Layanan Ekspedisi</h2>
        <form action="{{ route('admin.shipping.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="courier">Kurir / Ekspedisi</label>
                <input type="text" id="courier" name="courier" value="{{ old('courier') }}" placeholder="Contoh: JNE" required>
            </div>
            <div class="form-group">
                <label for="service">Layanan</label>
                <input type="text" id="service" name="service" value="{{ old('service') }}" placeholder="Contoh: REG" required>
            </div>
            <div class="form-group">
                <label for="eta">Estimasi (ETA)</label>
                <input type="text" id="eta" name="eta" value="{{ old('eta') }}" placeholder="Contoh: 2-3 hari">
            </div>
            <div class="form-group">
                <label for="cost">Tarif / Ongkir</label>
                <input type="number" id="cost" name="cost" min="0" step="100" value="{{ old('cost', 0) }}" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    Aktif
                </label>
            </div>
            <button type="submit">Tambah</button>
        </form>
    </div>

    <div class="card">
        <h2>Daftar Layanan Ekspedisi</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Kurir</th>
                        <th>Layanan</th>
                        <th>ETA</th>
                        <th>Tarif</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shippingServices as $item)
                        <tr>
                            <td>{{ $item->courier }}</td>
                            <td>{{ $item->service }}</td>
                            <td>{{ $item->eta ?? '-' }}</td>
                            <td>Rp {{ number_format($item->cost, 0, ',', '.') }}</td>
                            <td>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                            <td>
                                <form action="{{ route('admin.shipping.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus layanan ekspedisi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada layanan ekspedisi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection