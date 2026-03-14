<div>
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
        <div>
            <h4 class="font-poppins fw-bold mb-0">Inventory Management</h4>
            <small class="text-muted">{{ $product->name }}</small>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bg-white rounded-3 border p-4">
                @if($product->is_variable)
                    <h6 class="font-poppins fw-bold mb-4">Variant Stock Levels</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr style="background:#F8FAFC">
                                    <th class="small text-uppercase text-muted">Variant</th>
                                    <th class="small text-uppercase text-muted">SKU</th>
                                    <th class="small text-uppercase text-muted">Quick Adjust</th>
                                    <th class="small text-uppercase text-muted">Stock</th>
                                    <th class="small text-uppercase text-muted">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->allVariants as $variant)
                                    <tr>
                                        <td>
                                            <div class="fw-600">{{ $variant->label ?: 'Variant ' . $variant->id }}</div>
                                            <div class="small text-muted">+${{ number_format($variant->price_modifier, 2) }}</div>
                                        </td>
                                        <td class="small text-muted">{{ $variant->sku ?? '—' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1">
                                                <button wire:click="adjustVariantStock({{ $variant->id }}, -10)" class="btn btn-sm btn-outline-danger px-2">−10</button>
                                                <button wire:click="adjustVariantStock({{ $variant->id }}, -1)" class="btn btn-sm btn-outline-secondary px-2">−1</button>
                                                <button wire:click="adjustVariantStock({{ $variant->id }}, 1)" class="btn btn-sm btn-outline-secondary px-2">+1</button>
                                                <button wire:click="adjustVariantStock({{ $variant->id }}, 10)" class="btn btn-sm btn-outline-success px-2">+10</button>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" wire:model="variantStocks.{{ $variant->id }}" class="form-control form-control-sm" style="width:80px" min="0">
                                        </td>
                                        <td>
                                            @php $qty = $variantStocks[$variant->id] ?? 0; @endphp
                                            <span class="stock-badge {{ $qty <= 0 ? 'out-stock' : ($qty <= 5 ? 'low-stock' : 'in-stock') }}">
                                                {{ $qty <= 0 ? 'Out' : ($qty <= 5 ? 'Low' : 'OK') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-top">
                                    <td colspan="3" class="fw-bold">Total Stock</td>
                                    <td colspan="2" class="fw-bold">{{ array_sum($variantStocks) }} units</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <h6 class="font-poppins fw-bold mb-4">Stock Level</h6>
                    <div class="row align-items-center g-3">
                        <div class="col-md-4">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" wire:model="simpleStock" class="form-control form-control-lg" min="0">
                        </div>
                        <div class="col-md-4 pt-3">
                            <div class="d-flex gap-2">
                                <button wire:click="$set('simpleStock', {{ max(0, $simpleStock - 10) }})" class="btn btn-outline-danger">−10</button>
                                <button wire:click="$set('simpleStock', {{ max(0, $simpleStock - 1) }})" class="btn btn-outline-secondary">−1</button>
                                <button wire:click="$set('simpleStock', {{ $simpleStock + 1 }})" class="btn btn-outline-secondary">+1</button>
                                <button wire:click="$set('simpleStock', {{ $simpleStock + 10 }})" class="btn btn-outline-success">+10</button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-4 pt-3 border-top">
                    <button wire:click="save" class="btn btn-primary px-5">Save Inventory</button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white rounded-3 border p-4">
                <img src="{{ $product->primary_image_url }}" class="rounded-3 w-100 mb-3" style="height:180px;object-fit:cover">
                <h6 class="font-poppins fw-bold">{{ $product->name }}</h6>
                <div class="small text-muted mb-1">SKU: {{ $product->sku ?? '—' }}</div>
                <div class="small text-muted mb-3">Price: ${{ number_format($product->effective_price, 2) }}</div>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary w-100 btn-sm">Edit Product</a>
            </div>
        </div>
    </div>
</div>
