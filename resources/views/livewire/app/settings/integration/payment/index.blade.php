<div class="w-full">
    <x-page-header title="Payment Integration"/>
    
    <x-box>
        <div class="grid divide-y">
            @foreach (config('atom.payment_gateway') as $item)
                <div class="grid divide-y">
                    <a 
                        wire:click="$set('provider', @js($provider === $item ? null : $item))"
                        class="p-4 flex items-center gap-2 hover:bg-slate-100"
                    >
                        <div class="grow font-semibold">
                            {{ str()->headline($item) }}
                        </div>
        
                        <div class="shrink-0 flex">
                            <x-icon name="chevron-down" size="14px"/>
                        </div>
                    </a>
    
                    @if ($provider === $item)
                        @livewire(atom_lw('app.settings.integration.payment.'.$item), key($item))
                    @endif
                </div>
            @endforeach
        </div>
    </x-box>
</div>
