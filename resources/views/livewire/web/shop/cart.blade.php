<x-drawer id="cart" header="Shopping Cart">
    <div x-data x-on:cart-open.window="$wire.setItems()">
        <div class="flex flex-col divide-y">
            @forelse ($items as $i => $item)
                @php $product = data_get($item, 'product') @endphp
                @php $variant = data_get($item, 'product_variant') @endphp
                <div class="p-4 flex gap-4 hover:bg-slate-100">
                    <div class="shrink-0 flex items-center justify-center">
                        <x-thumbnail :url="$product->image->url ?? $variant->image->url ?? null" size="80"/>
                    </div>

                    <div class="grow flex flex-col gap-2">
                        <div class="flex flex-col">
                            <x-link :label="$product->name" :href="route('web.product.view', [$product->slug])" text/>
                            @if ($variant) 
                                <div class="font-medium text-gray-500 truncate">{{ $variant->name }}</div>
                            @endif
                            <div class="font-medium text-gray-500 truncate">{{ currency(($variant ?? $product)->price) }}</div>
                        </div>
                        <div class="md:w-48">
                            <x-form.qty wire:model.debounce.500ms="items.{{ $i }}.qty" :label="false" uuid/>
                        </div>
                    </div>

                    <div class="shrink-0">
                        <x-close.delete
                            title="Remove From Cart"
                            message="Are you sure to remove this product from cart?"
                            callback="remove"
                            :params="$i"
                        />
                    </div>
                </div>
            @empty
                <x-empty-state title="No Items" subtitle="Your shopping cart is empty"/>
            @endforelse
        </div>

        @if ($items)
            <x-slot:foot>
                <div class="p-4 flex items-center justify-between gap-3 flex-wrap border-t">
                    <div class="shrink-0 text-lg font-semibold">{{ __('Subtotal') }}</div>
                    <div class="shrink-0 text-lg font-semibold">{{ currency(collect($items)->sum('amount')) }}</div>
                </div>

                <div class="bg-slate-100 p-4">
                    <div class="max-w-sm mx-auto">
                        <x-button icon="arrow-right" color="theme" block
                            label="Check Out"
                            :href="route('web.shop.checkout')"
                        />
                    </div>
                </div>
            </x-slot:foot>
        @endif
    </div>
</x-drawer>