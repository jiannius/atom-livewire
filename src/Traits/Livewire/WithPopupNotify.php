<?php

namespace Jiannius\Atom\Traits\Livewire;

trait WithPopupNotify
{
    public function popup($body, $type = 'toast', $alert = 'info')
    {
        $body = [
            'title' => is_string($body)
                ? null
                : __(data_get($body, 'title')),
            
            'message' => is_string($body)
                ? $body
                : __(data_get($body, 'message')),

            'type' => $alert,
            'reload' => is_string($body) ? false : data_get($body, 'reload'),
        ];

        $this->dispatchBrowserEvent($type, $body);
    }
}