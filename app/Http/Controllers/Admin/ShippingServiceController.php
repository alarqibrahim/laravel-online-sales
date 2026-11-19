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
        $shippingServices = ShippingService::orderBy('courier')->orderBy('service')->get();

        return view('admin.shipping_services.index', compact('shippingServices'));
    }

    public function create(): View
    {
        return view('admin.shipping_services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'courier' => ['required', 'string', 'max:80'],
            'service' => ['required', 'string', 'max:80'],
            'eta' => ['nullable', 'string', 'max:60'],
            'cost' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        ShippingService::create($validated);

        return redirect()
            ->route('admin.shipping.index')
            ->with('success', 'Layanan ekspedisi berhasil ditambahkan.');
    }

    public function edit(ShippingService $shippingService): View
    {
        return view('admin.shipping_services.edit', compact('shippingService'));
    }

    public function update(Request $request, ShippingService $shippingService): RedirectResponse
    {
        $validated = $request->validate([
            'courier' => ['required', 'string', 'max:80'],
            'service' => ['required', 'string', 'max:80'],
            'eta' => ['nullable', 'string', 'max:60'],
            'cost' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
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