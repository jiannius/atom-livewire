<div
    x-data="{ value: @entangle($attributes->wire('model')->value()), show: false }"
    {{ $attributes }}
>
    <div x-bind:class="show && 'fixed inset-0 z-20 md:static'">
        <div x-show="show" class="absolute inset-0 bg-black opacity-50 md:hidden"></div>
        <div
            x-on:click="show = false"
            x-bind:class="show && 'absolute inset-0 px-6 pt-6 pb-16 md:static md:p-0'"
        >
            <div
                x-on:click.stop
                x-bind:class="show && 'divide-y bg-white rounded-md drop-shadow max-w-sm mx-auto md:bg-transparent md:divide-none md:drop-shadow-none'" 
                class="grid"
            >
                {{ $slot }}
            </div>
        </div>
    </div>
</div>