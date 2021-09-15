<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 20/10/2019 20:24:21
 * @last modified     : 23/12/2019 21:42:52
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */
namespace honwei189\Html;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 *
 * HTML service provider (for Laravel)
 *
 *
 * @package     Html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/Html/
 * @version     "1.0.0" 
 * @since       "1.0.0" 
 */
class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Register service
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(Html::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Html', Html::class);
        });
    }

    /**
     * Load service on start-up
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('Html', function () {
            return new Html;
        });
    }

    public function provides()
    {
        //return ['Html'];
    }
}
