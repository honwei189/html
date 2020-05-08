<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 20/10/2019 20:24:21
 * @last modified     : 23/12/2019 21:42:52
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */
namespace honwei189\html;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 *
 * HTML service provider (for Laravel)
 *
 *
 * @package     html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0" 
 * @since       "1.0.0" 
 */
class htmlServiceProvider extends ServiceProvider
{
    /**
     * Register service
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(html::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('html', html::class);
        });
    }

    /**
     * Load service on start-up
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('html', function () {
            return new html;
        });
    }

    public function provides()
    {
        //return ['html'];
    }
}
