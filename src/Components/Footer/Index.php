<?php

namespace Jiannius\Atom\Components\Footer;

use Illuminate\View\Component;

class Index extends Component
{
    public $dark;
    public $color;
    public $legals;
    public $company;
    public $socials;
    public $whatsapp;
    public $briefs;

    /**
     * Contructor
     * 
     * @return void
     */
    public function __construct(
        $dark = false,
        $briefs = null,
        $company = [],
        $socials = null,
        $whatsapp = null,
        $siteSettings = true
    ) {
        $this->dark = $dark;
        $this->color = (object)[
            'text' => $dark ? 'text-gray-100' : 'text-gray-800',
        ];

        // default values
        $default = $this->getDefaultValues($siteSettings);

        $this->briefs = $briefs ?? $default->briefs;

        $this->company = [
            'name' => isset($company['name']) ? $company['name'] : $default->company,
            'phone' => isset($company['phone']) ? $company['phone'] : $default->phone,
            'email' => isset($company['email']) ? $company['email'] : $default->email,
            'address' => isset($company['address']) ? $company['address'] : $default->address,
        ];

        $this->socials = $socials ?? $default->socials;
        $this->whatsapp = $whatsapp ?? $default->whatsapp;
        $this->legals = $this->getLegals();
    }

    /**
     * Get default values
     */
    public function getDefaultValues($useSiteSettings = true)
    {
        if (config('atom.static_site')) {
            return (object)[
                'company' => config('atom.company.name'),
                'phone' => config('atom.company.phone'),
                'email' => config('atom.company.email'),
                'address' => config('atom.company.address'),
                'briefs' => config('atom.company.briefs'),
                'socials' => config('atom.company.social_media'),
                'whatsapp' => config('atom.company.whatsapp'),
            ];
        }
        else if ($useSiteSettings) {
            return model('site_setting')->getContactInfo();
        }

        return (object)[];
    }

    /**
     * Get legals
     */
    public function getLegals()
    {
        if (config('atom.static_site')) return null;
        if (!enabled_module('pages')) return null;

        return model('page')->whereIn('name', [
            'Privacy',
            'Terms',
            'Disclaimer',
        ])->get()->map(fn($page) => [
            'label' => $page->title,
            'href' => route('page', [$page->slug]),
        ]);
    }

    /**
     * Render component
     * 
     * @return Response
     */
    public function render()
    {
        return view('atom::components.footer.index');
    }
}