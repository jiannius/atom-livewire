<?php

namespace Jiannius\Atom\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AtomComponentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $components = [
            'seo',
            'icon',
            'logo',
            'alert',
            'badge',
            'image',
            'avatar',
            'loader',
            'drawer',
            'pricing',
            'statsbox',
            'checkbox',
            'shareable',
            'thumbnail',
            'cdn-scripts',
            'empty-state',
            'alpine-data',
            'breadcrumbs',
            'social-share',
            'announcements',
            'payment-gateway',
            'placeholder-bar',
            
            'lightbox.index',
            'lightbox.slide',

            'close.index',
            'close.delete',

            'admin-panel.index',
            'admin-panel.aside',
            
            'analytics.ga',
            'analytics.gtm',
            'analytics.fbpixel',

            'popup.index',
            'popup.alert',
            'popup.toast',
            'popup.confirm',
            
            'box.index',
            'box.row',
            
            'button.index',
            'button.submit',
            'button.delete',
            'button.trashed',
            'button.confirm',
            
            'dropdown.index',
            'dropdown.item',
            'dropdown.delete',
            
            'modal.index',
            'modal.row',
            
            'table.index',
            'table.th',
            'table.tr',
            'table.td',
            
            'sidenav.index',
            'sidenav.group',
            'sidenav.item',
            
            'form.index',
            'form.seo',
            'form.date',
            'form.file',
            'form.myic',
            'form.tags',
            'form.slug',
            'form.text',
            'form.agree',
            'form.color',
            'form.email',
            'form.field',
            'form.image',
            'form.items',
            'form.phone',
            'form.radio',
            'form.title',
            'form.amount',
            'form.number',
            'form.picker',
            'form.search',
            'form.select.index',
            'form.select.state',
            'form.select.gender',
            'form.select.country',
            'form.country',
            'form.checkbox',
            'form.currency',
            'form.password',
            'form.richtext',
            'form.sortable',
            'form.textarea',
            'form.recaptcha',
            'form.date-range',
            'form.checkbox-select',

            'page-header.index',
            'page-header.back',
        
            'input.text',
            'input.email',
            'input.field',

            'tab.index',
            'tab.item',
            'tab.dropdown.index',
            'tab.dropdown.item',

            'blog.index',
            'blog.card',

            'navbar.index',
            'navbar.auth',
            'navbar.item',
            'navbar.locale',
            'navbar.dropdown.index',
            'navbar.dropdown.item',
            'navbar.mobile.index',
            'navbar.mobile.item',
            'navbar.mobile.locale',

            'slider.index',
            'slider.slide',
            'slider.nav',

            'faq.index',
            'faq.item',

            'footer.index',
            'footer.pre',

            'builder.hero',
            'builder.testimonial',
        ];

        foreach ($components as $value) {
            $name = collect(explode('.', $value))
                ->map(fn($str) => str()->studly($str))
                ->join('\\');

            if (str($name)->is('*\Index')) $value = str($value)->replace('.index', '')->toString();

            $classname = 'Jiannius\Atom\Components\\'.$name;

            Blade::component($value, $classname);
        }
    }
}