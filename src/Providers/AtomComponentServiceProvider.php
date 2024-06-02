<?php

namespace Jiannius\Atom\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AtomComponentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $components = [
            'icon',
            'link',
            'logo',
            'plan',
            'badge',
            'field',
            'group',
            'image',
            'input',
            'label',
            'popup',
            'anchor',
            'button',
            'inform',
            'inline',
            'loader',
            'slider',
            'divider',
            'heading',
            'spinner',
            'checkbox',
            'lightbox',
            'no-result',
            'file-card',
            'html-meta',
            'thumbnail',
            'breadcrumbs',
            'announcement',
            'media-object',
            'social-share',
            'contact-card',
            'button-social',
            'flip-countdown',
            'avatar-bullets',
            'whatsapp-bubble',
            'placeholder-bar',
            'email-verification',

            'layout.index',
            'layout.app.index',
            'layout.app.nav',

            'modal.index',
            'modal.page',
            'modal.drawer',

            'alert.index',
            'alert.errors',

            'close.index',
            'close.delete',

            'notify.alert',
            'notify.toast',
            'notify.confirm',
            
            'box.index',
            'box.flat',
            'box.fieldset',
            'box.trace',
            'box.row',
            'box.stat',
            'box.loading.index',
            'box.loading.placeholder',
            
            'dropdown.index',
            'dropdown.item',
            'dropdown.trash',
            'dropdown.delete',
            'dropdown.archive',
            'dropdown.restore',
            'dropdown.footprint',

            'editor.index',
            'editor.text',
            'editor.media',
            'editor.tools',
            'editor.table',
            'editor.bullet',
            'editor.actions',
            'editor.heading',
            'editor.dropdown',
            
            'table.index',
            'table.th',
            'table.tr',
            'table.td',
            'table.export',
            'table.heading',
            'table.filters',
            'table.toolbar',
            'table.trashed',
            'table.archived',
            'table.searchbar',
            'table.checkbox-actions',
            
            'sidenav.index',
            'sidenav.group',
            'sidenav.item',
            
            'form.index',
            'form.seo',
            'form.tags',
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
            'form.amount',
            'form.custom',
            'form.drawer',
            'form.number',
            'form.search',
            'form.country',
            'form.password',
            'form.richtext',
            'form.sortable',
            'form.textarea',
            'form.signature',
            'form.recaptcha',
            'form.permission',
            'form.checkbox-select',
            
            'form.file.index',
            'form.file.url',
            'form.file.dropzone',
            'form.file.uploader',
            'form.file.listing',
            
            'form.select.index',
            'form.select.enum',
            'form.select.email',
            'form.select.label',
            'form.select.state',
            'form.select.gender',
            'form.select.country',
            'form.select.currency',
            'form.select.nationality',
            
            'form.checkbox.index',
            'form.checkbox.privacy',
            'form.checkbox.multiple',            
            'form.checkbox.marketing',

            'form.date.index',
            'form.date.range',
            'form.date.time',
            'form.date.datetime',
        
            'tabs.index',
            'tabs.tab',
            'tabs.dropdown.index',
            'tabs.dropdown.item',

            'share.index',
            'share.social',

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

            'footer.index',
            'footer.pre',
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