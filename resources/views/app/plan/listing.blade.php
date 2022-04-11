<div class="max-w-screen-lg mx-auto">
    <x-page-header title="Plans">
        <x-button icon="plus" href="{{ route('app.plan.create') }}">
            New Plan
        </x-button>
    </x-page-header>

    <div class="grid gap-4 md:grid-cols-3">
        @forelse ($this->plans as $plan)
            <div class="border shadow rounded-md bg-white hover:border-theme">
                <a href="{{ route('app.plan.update', [$plan->id]) }}" class="block p-4">
                    <div class="grid gap-2">
                        <div class="flex justify-between gap-2">
                            <div>
                                <div class="font-semibold">{{ $plan->name }}</div>
                                @if ($plan->trial)
                                    <div class="text-sm font-medium text-gray-500">{{ $plan->trial }} Days Trial</div>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <x-badge>{{ $plan->is_active ? 'active' : 'inactive' }}</x-badge>
                            </div>
                        </div>
                        <div class="grid">
                            @foreach ($plan->prices as $price)
                                <div>
                                    <span class="font-medium text-gray-500">{{ $price->currency }}</span>
                                    <span class="font-semibold text-gray-800">{{ currency($price->amount) }}</span>
                                    <span class="font-medium text-gray-500">{{ str($price->recurring)->headline() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="md:col-span-3">
                <x-empty-state title="No plan found"/>
            </div>
        @endforelse
    </div>
</div>