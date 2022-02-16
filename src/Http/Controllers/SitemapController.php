<?php

namespace Jiannius\Atom\Http\Controllers;

use Jiannius\Atom\Models\Blog;
use Jiannius\Atom\Models\Page;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    /**
     * Index
     */
    public function index()
    {
        $sitemap = $this->getSitemap();

        foreach ($sitemap as $url => $changefreq) {
            $path = parse_url($url, PHP_URL_PATH);
            $priority = 1 - (substr_count($path, '/')/10);
            $sitemap[$url] = [
                'added' => time(),
                'lastmod' => now()->toAtomString(),
                'priority' => $priority,
                'changefreq' => $changefreq,
            ];
        }

        return response()
            ->view('atom::sitemap', compact('sitemap'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Get sitemap
     */
    public function getSitemap()
    {
        $sitemap = ['/' => 'monthly'];

        foreach (Blog::status('published')->latest()->take(500)->get() as $blog) {
            $sitemap[route('blogs', [$blog->slug])] = 'monthly';
        }

        foreach (Page::getSlugs() as $slug) {
            $sitemap[route('page', [$slug])] = 'monthly';
        }

        return $sitemap;
    }
}