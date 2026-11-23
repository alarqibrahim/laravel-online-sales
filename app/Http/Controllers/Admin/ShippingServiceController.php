<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingServiceController extends Controller
{
    public function index(): View
    {
        $shippingServices = ShippingService::orderBy('courier')
            ->orderBy('service')
            ->get();

        return view('admin.shipping_services.index', compact('shippingServices'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'courier' => ['required', 'string', 'max:100'],
            'service' => ['required', 'string', 'max:100'],
            'eta' => ['nullable', 'string', 'max:100'],
            'cost' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        ShippingService::create($validated);

        return redirect()
            ->route('admin.shipping.index')
            ->with('success', 'Layanan ekspedisi berhasil ditambahkan.');
    }

    public function update(Request $request, ShippingService $shippingService): RedirectResponse
    {
        $validated = $request->validate([
            'courier' => ['required', 'string', 'max:100'],
            'service' => ['required', 'string', 'max:100'],
            'eta' => ['nullable', 'string', 'max:100'],
            'cost' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        $shippingService->update($validated);

        return redirect()
            ->route('admin.shipping.index')
            ->with('success', 'Layanan ekspedisi berhasil diperbarui.');
    }

    public function destroy(ShippingService $shippingService): RedirectResponse
    {
        $shippingService->delete();

        return redirect()
            ->route('admin.shipping.index')
            ->with('success', 'Layanan ekspedisi berhasil dihapus.');
    }
}