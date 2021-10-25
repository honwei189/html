<?php
/**
 * Description   : 
 * ---------
 * Created       : 2019-10-20 08:24:21 pm
 * Author        : Gordon Lim
 * Last Modified : 2021-10-25 09:31:46 pm
 * Modified By   : Gordon Lim
 * ---------
 * Changelog
 * 
 * Date & time           By                    Version   Comments
 * -------------------   -------------------   -------   ---------------------------------------------------------
 * 
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
            // $loader->alias('Html', \honwei189\Html::class);
            
            $loader->alias(Html::class, 'html'); // Html has been loaded by Laravel, this method may wrong and may not be needed anymore
            $loader->alias('htmls', Htmls::class); // Corret method and to register Htmls to boot loader and create alias
        });
    }

    /**
     * Load service on start-up
     *
     * @return void
     */
    public function boot()
    {
        // $this->app->singleton('Html', function () {
        //     return new \honwei189\Html;
        // });

        $this->app->make('honwei189\Html');
        $this->app->make('honwei189\Html\Htmls');
    }

    public function provides()
    {
        //return ['Html'];
    }
}
