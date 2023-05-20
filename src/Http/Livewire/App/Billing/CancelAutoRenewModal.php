<?php

namespace Jiannius\Atom\Http\Livewire\App\Billing;

use Livewire\Component;

class CancelAutoRenewModal extends Component
{
    public $subscriptions;
    public $stripeSubscriptionId;
    
    public $listeners = ['open'];

    /**
     * Open modal
     */
    public function open($id): void
    {
        $this->stripeSubscriptionId = data_get(
            model('plan_subscription')
                ->whereNotNull('data->stripe_subscription_id')
                ->find($id),
            'data.stripe_subscription_id'
        );

        $this->subscriptions = model('plan_subscription')
            ->where('data->stripe_subscription_id', $this->stripeSubscriptionId)
            ->get();

        $this->dispatchBrowserEvent('cancel-auto-renew-modal-open');
    }

    /**
     * Render
     */
    public function render(): mixed
    {
        return atom_view('app.billing.cancel-auto-renew-modal');
    }
}