<?php

define_route()->prefix('page')->as('page.')->group(function () {
    define_route('listing',  'App\Page\Listing')->name('listing');
    define_route('{pageId}', 'App\Page\Update')->name('update');
});
