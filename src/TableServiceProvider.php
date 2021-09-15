<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 20/10/2019 20:25:34
 * @last modified     : 23/12/2019 21:43:11
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */
namespace honwei189\Html;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 *
 * HTML table service provider (for Laravel)
 *
 *
 * @package     Html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0" 
 * @since       "1.0.0" 
 */
class TableServiceProvider extends ServiceProvider
{
    /**
     * Register service
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(table::class);

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Table', Table::class);
        });
    }

    /**
     * Load service on start-up
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('Table', function () {
            return new Table;
        });
    }

    public function provides()
    {
        //return ['table'];
    }
}
