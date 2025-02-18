<?php

namespace Spatie\GoogleFonts;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Fonts implements Htmlable
{
    protected string $googleFontsUrl;
    protected string $localizedUrl;
    protected string $localizedCss;
    protected bool $preferInline = false;

    public function __construct(
        $googleFontsUrl = 'default',
        $localizedUrl = '',
        $localizedCss = '',
        $preferInline = false
    ) {
        $this->googleFontsUrl = $googleFontsUrl;
        $this->localizedUrl = $localizedUrl;
        $this->localizedCss = $localizedCss;
        $this->preferInline = $preferInline;
    }

    public function inline(): HtmlString
    {
        if (! $this->localizedCss) {
            return $this->fallback();
        }

        return new HtmlString(<<<HTML
            <style>{$this->localizedCss}</style>
        HTML);
    }

    public function link(): HtmlString
    {
        if (! $this->localizedUrl) {
            return $this->fallback();
        }

        return new HtmlString(<<<HTML
            <link href="{$this->localizedUrl}" rel="stylesheet" type="text/css">
        HTML);
    }

    public function fallback(): HtmlString
    {
        return new HtmlString(<<<HTML
            <link href="{$this->googleFontsUrl}" rel="stylesheet" type="text/css">
        HTML);
    }

    public function toHtml(): HtmlString
    {
        return $this->preferInline ? $this->inline() : $this->link();
    }
}
