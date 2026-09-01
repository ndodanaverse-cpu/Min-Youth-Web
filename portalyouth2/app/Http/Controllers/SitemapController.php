<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\News;
use App\Models\Opportunity;
use App\Models\Programme;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $entries = [
            [url('/'), now()->toDateString(), 'daily', '1.0'],
        ];

        foreach (News::published()->latest('published_at')->get() as $news) {
            $entries[] = [
                url('/news/'.$news->slug),
                $news->published_at?->toDateString(),
                'weekly',
                '0.8',
            ];
        }

        foreach (Programme::published()->get() as $programme) {
            $entries[] = [
                url('/programme/'.$programme->slug),
                $programme->published_at?->toDateString(),
                'weekly',
                '0.8',
            ];
        }

        foreach (Opportunity::published()->get() as $opportunity) {
            $entries[] = [
                url('/opportunity/'.$opportunity->slug),
                $opportunity->published_at?->toDateString(),
                'weekly',
                '0.8',
            ];
        }

        foreach (Campaign::published()->get() as $campaign) {
            $entries[] = [
                url('/campaign/'.$campaign->slug),
                $campaign->published_at?->toDateString(),
                'weekly',
                '0.7',
            ];
        }

        $entries[] = [url('/terms'), null, 'monthly', '0.3'];
        $entries[] = [url('/privacy'), null, 'monthly', '0.3'];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($entries as [$loc, $lastmod, $changefreq, $priority]) {
            $xml .= '  <url><loc>'.htmlspecialchars($loc, ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc>';
            if ($lastmod) {
                $xml .= '<lastmod>'.$lastmod.'</lastmod>';
            }
            $xml .= '<changefreq>'.$changefreq.'</changefreq><priority>'.$priority.'</priority></url>'."\n";
        }

        $xml .= '</urlset>'."\n";

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
