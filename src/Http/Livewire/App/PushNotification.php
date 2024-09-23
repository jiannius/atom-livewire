<?php

namespace Jiannius\Atom\Http\Livewire\App;

use Jiannius\Atom\Component;

class PushNotification extends Component
{
    public $tab = 'unread';
    public $page = 1;
    public $notifications = [];

    protected $listeners = [
        'showPushNotifications' => 'open',
    ];

    // updated tab
    public function updatedTab() : void
    {
        $this->reset('page');
        $this->getNotifications();
    }

    // open
    public function open() : void
    {
        $this->reset('tab', 'page', 'notifications');
        $this->getNotifications();
        $this->overlay();
    }

    // get notifications
    public function getNotifications() : void
    {
        $query = model('push-notification')
            ->with('sender')
            ->where('receiver_id', user('id'))
            ->status($this->tab)
            ->latest()
            ->toPage($this->page, 100);

        $result = collect($query->items())->map(fn($row) => [
            ...$row->toArray(),
            'href' => $row->href,
            'action' => $row->action,
            'timestamp' => $row->timestamp,
        ]);

        $this->notifications = $this->page === 1
            ? $result->toArray()
            : collect($this->notifications)->concat($result)->toArray();
    }

    // mark read
    public function read($id, $bool = true) : void
    {
        model('push-notification')->find($id)->read($bool);
        $this->remove($id);
    }

    // archive
    public function archive($id, $bool = true) : void
    {
        model('push-notification')->find($id)->archive($bool);
        $this->remove($id);
    }

    // remove
    public function remove($id) : void
    {
        $notifications = collect($this->notifications);
        $index = $notifications->where('id', $id)->keys()->first();
        $notifications->splice($index, 1);

        $this->notifications = $notifications->values()->all();
    }
}