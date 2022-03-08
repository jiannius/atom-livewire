<div class="grid gap-4">
    <div class="grid gap-1">
        <div class="text-3xl font-bold">
            You account setup is completed. Thank you for signing up with us
        </div>
    
        <div class="text-gray-500 font-medium">
            We are so excited to have you as our newest friend!
        </div>
    </div>

    <div>
        <x-button href="{{ Route::has('app.home') ? route('app.home') : route('home') }}" size="md" icon="home-alt">
            Back to Home
        </x-button>
    </div>
</div>
