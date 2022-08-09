<?php

namespace Jiannius\Atom\Http\Livewire\App\SiteSettings\PaymentGateway;

use Livewire\Component;

class Stripe extends Component
{
    public $settings;

    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'settings.stripe_public_key' => 'required',
            'settings.stripe_secret_key' => 'required',
            'settings.stripe_webhook_signing_secret' => 'nullable',
        ];
    }

    /**
     * Validation messages
     */
    protected function messages()
    {
        return [
            'settings.stripe_public_key.required' => __('Public key is required.'),
            'settings.stripe_secret_key.required' => __('Secret key is required.'),
        ];
    }

    /**
     * Mount
     */
    public function mount()
    {
        model('site_setting')->group('stripe')->get()->each(function($setting) {
            $this->settings[$setting->name] = $setting->value;
        });
    }

    /**
     * Submit
     */
    public function submit()
    {
        $this->resetValidation();
        $this->validate();
        $this->emitUp('submit', $this->settings);
    }

    /**
     * Render
     */
    public function render()
    {
        return view('atom::app.site-settings.payment-gateway.stripe');
    }
}