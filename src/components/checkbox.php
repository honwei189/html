<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 14/10/2019 19:05:08
 * @last modified     : 23/12/2019 21:32:57
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 *
 * Generate HTML checkbox
 *
 *
 * @package     html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @link        https://appsw.dev
 * @link        https://justtest.app
 * @version     "1.0.0" 
 * @since       "1.0.0" 
 */
trait checkbox
{
    /**
     * Render checkbox
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @return string
     */
    public function checkbox($name, $default_value = "")
    {
        $data         = PHP_EOL;
        $default      = "";
        $text         = "";
        $value        = "";
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (is_array($this->data) && count($this->data) > 0) {
            $keys = [];
            foreach ($this->data as $k => $v) {
                $value = "";
                $text  = "";

                if (is_array($v)) {
                    $keys  = array_keys($v);
                    $value = $v[$keys[0]];
                    $text  = $v[$keys[1]];
                } else {
                    $value = $k;
                    $text  = $v;
                }

                if (isset($this->dataset[$_name]) && $this->dataset[$_name] == $value) {
                    $default = " checked";
                } else if (isset($this->dataset[$_name]) && is_array($this->dataset[$_name])) {
                    if (in_array($value, $this->dataset[$_name])) {
                        $default = " checked";
                    } else {
                        $default = "";
                    }
                } else {
                    if (is_value($default_value) && $default_value == $value) {
                        $default = " checked";
                    } else {
                        $default = "";
                    }
                }

                if ($this->display_value_only) {
                    if ($default == " checked") {
                        $data .= $this->prepend['before'] . $text . $this->prepend['end'] . PHP_EOL;
                    } else {
                        $data = "";
                    }
                } else {
                    $data .= $this->prepend['before'] . "\t<input type=\"checkbox\"" . $this->build_obj_attr($name) . " data-label=\"" . addslashes($text) . "\" value=\"$value\"$default> $text" . $this->prepend['end'] . PHP_EOL;
                }
            }

            unset($keys);
        } else {
            $data .= $this->prepend['before'] . "\t<input type=\"checkbox\"" . $this->build_obj_attr($name) . " data-label=\"" . addslashes($text) . "\" value=\"\"$default> $text" . $this->prepend['end'] . PHP_EOL;
        }

        return $this->output_as($this->build_render($name, $data));
    }

    /**
     * Render CSS bootstrap style input checkbox
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param string $icon_html Example:  $html->span($html->icon("fas fa-map-marked-alt")." Pick location", ["class"=>"input-group-addon getmap", "role"=>"button"])
     * @return string
     */
    public function checkbox_input_group($name = "", $value = "", $icon_html = "")
    {
        $this->object = __METHOD__;

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = "$icon_html</div>";
        }

        return $this->checkbox($name, $value);
    }
}
