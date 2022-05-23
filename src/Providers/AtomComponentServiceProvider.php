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
            'tabs',
            'card',
            'icon',
            'logo',
            'alert',
            'badge',
            'image',
            'modal',
            'avatar',
            'loader',
            'notify',
            'drawer',
            'statsbox',
            'checkbox',
            'file-card',
            'back-button',
            'empty-state',
            'alpine-data',
            'page-header',
            'breadcrumbs',
            'social-share',
            'payment-gateway',

            'script.vendor',
            'script.alpine.index',
            'script.alpine.sidenav',
            'script.alpine.table.th',
            'script.alpine.form.ic',
            'script.alpine.form.tags',
            'script.alpine.form.image',
            'script.alpine.form.title',
            'script.alpine.form.amount',
            'script.alpine.form.richtext',
            
            'admin-panel.index',
            'admin-panel.aside',
            
            'analytics.ga',
            'analytics.gtm',
            'analytics.fbpixel',

            'box.index',
            'box.item',
            
            'button.index',
            'button.create',
            'button.submit',
            'button.delete',

            'dropdown.index',
            'dropdown.item',
            
            'table.index',
            'table.th',
            'table.tr',
            'table.td',

            'sidenav.index',
            'sidenav.group',
            'sidenav.item',

            'form.index',
            'form.ic',
            'form.seo',
            'form.date',
            'form.file',
            'form.tags',
            'form.slug',
            'form.text',
            'form.agree',
            'form.email',
            'form.field',
            'form.image',
            'form.phone',
            'form.radio',
            'form.state',
            'form.title',
            'form.amount',
            'form.errors',
            'form.gender',
            'form.number',
            'form.picker',
            'form.select',
            'form.country',
            'form.checkbox',
            'form.currency',
            'form.password',
            'form.richtext',
            'form.sortable',
            'form.textarea',
            'form.date-range',
        
            'input.text',
            'input.email',
            'input.field',
            'input.search',

            'blog.index',
            'blog.card',

            'navbar.index',
            'navbar.item',
            'navbar.locale',
            'navbar.dropdown.index',
            'navbar.dropdown.item',

            'footer.index',
            'footer.pre',
        
            'builder.faq',
            'builder.hero',
            'builder.slider',
            'builder.pricing',
            'builder.testimonial',
            'builder.announcements',
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