<div>
    <x-button.social-login
        size="md"
        divider="OR"
        divider-position="bottom"
    />

    <div class="flex flex-col gap-4">
        <x-form>
            <x-form.group>
                <div class="text-2xl font-bold text-gray-600">
                    {{ __('Create your account') }}
                </div>
            
                <x-form.text wire:model.defer="inputs.name" label="Your Name" autofocus/>
                <x-form.email wire:model.defer="inputs.email" label="Login Email"/>
                <x-form.password wire:model.defer="inputs.password" label="Login Password"/>
            
                <div class="grid gap-2">
                    <x-form.agree tnc wire:model="inputs.agree_tnc"/>
                    <x-form.agree marketing wire:model="inputs.agree_marketing"/>
                </div>
            </x-form.group>
    
            <x-slot:foot>
                <x-button.submit size="md" label="Create Account" block/>
            </x-slot:foot>
        </x-form>
        
        <div class="text-center">
            {{ __('Have an account?') }}
            <a href="{{ route('login') }}">
                {{ __('Sign In') }}
            </a>
        </div>
    </div>
</div>

