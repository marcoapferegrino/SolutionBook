<?php namespace SolutionBook\Providers;

use Collective\Html\HtmlServiceProvider as CollectiveHtmlServideProvider;
use SolutionBook\Components\HtmlBuilder;


class HtmlServiceProvider extends CollectiveHtmlServideProvider
{
    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerHtmlBuilder()
    {
        $this->app->bindShared('html', function($app)
        {
            return new HtmlBuilder($app['url']);
        });
    }



}