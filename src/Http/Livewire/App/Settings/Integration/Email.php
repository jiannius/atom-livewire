<?php

namespace Jiannius\Atom\Http\Livewire\App\Settings\Integration;

use Jiannius\Atom\Traits\Livewire\WithForm;
use Jiannius\Atom\Traits\Livewire\WithPopupNotify;
use Livewire\Component;

class Email extends Component
{
    use WithForm;
    use WithPopupNotify;
    
    public $settings;

    /**
     * Validation
     */
    protected function validation(): array
    {
        return [
            'settings.notify_from' => ['required' => 'Notification from email address is required.'],
            'settings.notify_to' => ['required' => 'Notification to email address is required.'],
            'settings.mailer' => ['required' => 'Email provider is required.'],
            'settings.smtp_host' => ['required_if:settings.mailer,smtp' => 'SMTP host is required.'],
            'settings.smtp_port' => ['required_if:settings.mailer,smtp' => 'SMTP port number is required.'],
            'settings.smtp_username' => ['required_if:settings.mailer,smtp' => 'SMTP username is required.'],
            'settings.smtp_password' => ['required_if:settings.mailer,smtp' => 'SMTP password is required.'],
            'settings.mailgun_domain' => ['required_if:settings.mailer,mailgun' => 'Mailgun domain is required.'],
            'settings.mailgun_secret' => ['required_if:settings.mailer,mailgun' => 'Mailgun secret is required.'],
        ];
    }

    /**
     * Mount
     */
    public function mount(): void
    {
        foreach ([
            'notify_from',
            'notify_to',
            'mailer',
            'smtp_host',
            'smtp_port',
            'smtp_username',
            'smtp_password',
            'mailgun_domain',
            'mailgun_secret',
        ] as $key) {
            $this->fill(['settings.'.$key => settings($key)]);
        }
    }

    /**
     * Submit
     */
    public function submit(): void
    {
        $this->validateForm();

        settings($this->settings);
        
        $this->popup('Email Integration Updated.');
    }

    /**
     * Render
     */
    public function render(): mixed
    {
        return atom_view('app.settings.integration.email');
    }
}