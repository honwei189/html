<?php
/*
 * Created       : 2019-10-14 07:05:08 pm
 * Author        : Gordon Lim <honwei189@gmail.com>
 * Last Modified : 2020-11-07 04:21:55 pm
 * Modified By   : Gordon Lim
 * ---------
 * Changelog
 *
 * Date & time           By                    Version   Comments
 * -------------------   -------------------   -------   ---------------------------------------------------------
 * 2020-11-07 04:18 pm   Gordon Lim            1.0.1     Rectified bootstrap - input group icon not displayed problem
 *
 */

namespace honwei189\Html\Components;

/**
 *
 * Generate HTML radio button
 *
 *
 * @package     Html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/Html/
 * @version     "1.0.1"
 */
trait RadioTrait
{
    /**
     * Render radio button
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Radio button attributes.  e.g:  class, id
     * @param array $radio_list Radio list.  ["A1" => "Menu A", "A2" => "Menu B"].  This is to replace using data()
     * @return string
     */
    public function radio($name, $default_value = "", array $attrs = null, array $radio_list = null)
    {
        $data    = PHP_EOL;
        $default = "";
        $text    = "";
        $value   = "";
        $_name   = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        if (is_array($radio_list)) {
            $this->data($radio_list);
        }

        if (is_value($this->object_type)) {
            $this->object      = $this->object_type;
            $this->object_type = null;
        } else {
            $this->object = __METHOD__;
        }

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
                        $data = $this->prepend['before'] . $text . ($this->prepend['after'] ?? "") . PHP_EOL;
                        break;
                    } else {
                        $data = "";
                    }
                } else {
                    $data .= $this->prepend['before'] . "\t<input type=\"radio\"" . $this->build_obj_attr($name) . " data-label=\"" . addslashes($text) . "\" value=\"$value\"$default> $text" . ($this->prepend['after'] ?? "") . PHP_EOL;
                }
            }

            unset($keys);
        } else {
            $data .= $this->prepend['before'] . "\t<input type=\"radio\"" . $this->build_obj_attr($name) . " data-label=\"" . addslashes($text) . "\" value=\"\"$default> $text" . ($this->prepend['after'] ?? "") . PHP_EOL;
        }

        return $this->output_as($this->build_render($name, $data));
    }

    /**
     * Render CSS bootstrap style radio button
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Radio button attributes.  e.g:  class, id
     * @param string $icon_html Example:  $html->span($html->icon("fas fa-map-marked-alt")." Pick location", ["class"=>"input-group-addon getmap", "role"=>"button"])
     * @param array $radio_list Radio list.  ["A1" => "Menu A", "A2" => "Menu B"].  This is to replace using data()
     * @return string
     */
    public function radio_input_group($name = "", $value = "", array $attrs = null, $icon_html = "", array $radio_list = null)
    {
        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = "$icon_html</div>";
        }

        return $this->set_object_type(__METHOD__)->radio($name, $value, $attrs, $radio_list);
    }
}
