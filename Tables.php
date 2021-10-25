<?php
/**
/**
 * Description   : 
 * ---------
 * Created       : 2021-10-25 09:32:22 pm
 * Author        : Gordon Lim
 * Last Modified : 2021-10-25 09:36:07 pm
 * Modified By   : Gordon Lim
 * ---------
 * Changelog
 * 
 * Date & time           By                    Version   Comments
 * -------------------   -------------------   -------   ---------------------------------------------------------
 * 
*/

namespace honwei189\Html;

/**
 * HTML table collective with static model.  Applicable for Laravel -- model or anyone would like to use static class to execute Html
 *
 * Example :
 *
 * echo tables::colgroup([cols($title_name, $data_name)])->output(); // Laravel
 * 
 * echo honwei189\Html\Tables::colgroup([cols($title_name, $data_name)])->output();
 * 
 *
 * @package     Html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0"
 * @since       "1.0.0"
 */
class Tables
{
    private static $instance;

    public function __call($name, $arguments)
    {
        if (isset($this->_methods[$name])) {
            return $this->_methods[$name];
        }

        if ($this->$name ?? false) {
            return $this->$name;
        }

        return self::call($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::call($name, $arguments);
    }

    public function __get($name)
    {
        return ($this->$name ?? self::call("__get", [$name]));
    }

    public function __set($name, $val)
    {
        self::call("__set", [$name, $val]);
    }
    private static function call($name, $arguments = [])
    {
        if (!is_array($arguments)) {
            $arguments = [$arguments];
        }

        return call_user_func_array(array(self::load_instance(), $name), $arguments);
    }

    private static function call_vars($k, $v)
    {
        return self::load_instance()->$k = $v;
    }

    private static function load_instance()
    {
        if (!self::$instance) {
            self::$instance = new \honwei189\Html\Table;
        }
        
        return self::$instance;
    }
}
