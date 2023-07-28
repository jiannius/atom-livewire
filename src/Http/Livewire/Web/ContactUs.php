<?php

namespace Jiannius\Atom\Http\Livewire\Web;

use Illuminate\Support\Facades\Notification;
use Jiannius\Atom\Component;
use Jiannius\Atom\Notifications\EnquiryNotification;
use Jiannius\Atom\Traits\Livewire\WithForm;

class ContactUs extends Component
{
    use WithForm;

    public $ref;
    public $enquiry;

    // validation
    protected function validation(): array
    {
        return [
            'enquiry.name' => ['required' => 'Your name is required.'],
            'enquiry.phone' => ['required' => 'Phone number is required.'],
            'enquiry.email' => ['required' => 'Email is required.'],
            'enquiry.message' => ['required' => 'Message is required.'],
        ];
    }

    // mount
    public function mount(): void
    {
        $this->ref = request()->query('ref');
        $this->enquiry = [
            'name' => null,
            'phone' => null,
            'email' => null,
            'message' => null,
        ];
    }

    // get contact property
    public function getContactProperty(): array
    {
        $contact = config('atom.static_site')
            ? config('atom.contact')
            : [
                'phone' => settings('phone'),
                'email' => settings('email'),
                'address' => settings('address'),
                'gmap_url' => settings('gmap_url'),
            ];

        return array_filter($contact);
    }

    // submit
    public function submit(): mixed
    {
        $this->validateForm();

        $mail = ['to' => null, 'params' => null];

        if (has_table('enquiries')) {
            $enquiry = model('enquiry')->create($this->enquiry);

            if ($this->ref) $enquiry->fill(['data' => ['ref' => $this->ref]])->save();

            $mail['to'] = settings('notify_to');
            $mail['params'] = $enquiry;
        }
        else {
            $mail['to'] = env('NOTIFY_TO');
            $mail['params'] = $this->enquiry;
        }

        if ($mail['to']) {
            Notification::route('mail', $mail['to'])->notify(new EnquiryNotification($mail['params']));
        }
        
        return to_route('web.thank.enquiry');
    }
}