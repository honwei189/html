<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 14/10/2019 19:05:09
 * @last modified     : 15/06/2020 19:49:00
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 *
 * Generate HTML dropdown select box
 *
 *
 * @package     html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.1" 05/03/2020 19:16:32 Rectified in value_only MODE, data not displayed problem
 * @since       "1.0.0"
 */
trait select
{
    /**
     * Render drop down menu
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param boolean $optional_option True = auto generate <option></option>
     * @return string
     */
    public function select($name, $default_value = "", $optional_option = false)
    {
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);
        $data         = PHP_EOL;
        $text         = "";
        $value        = "";
        $obj          = "";

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
                    $default = " selected";
                } else if (isset($this->dataset[$_name]) && is_array($this->dataset[$_name])) {
                    if (in_array($value, $this->dataset[$_name])) {
                        $default = " checked";
                    } else {
                        $default = "";
                    }
                } else {
                    if (is_value($default_value) && $default_value == $value) {
                        $default = " selected";
                    } else {
                        $default = "";
                    }
                }

                if ($this->display_value_only && $default == " selected") {
                    $obj = $text . PHP_EOL;
                    break;
                } else {
                    if (is_value($value)) {
                        $data .= "\t<option value=\"$value\"$default>$text</option>" . PHP_EOL;
                    }
                }
            }

            unset($keys);
        }

        if (!$this->display_value_only) {

            if ($optional_option) {
                $data = "<option></option>" . PHP_EOL . $data;
            }

            $obj = "<select" . $this->build_obj_attr($name) . ">$data</select>";
        } else {
            if (isset($this->dataset[$name])) {
                $obj = $this->dataset[$name];
            } else {
                $obj = $default_value;
            }

            if (is_array($this->data) && count($this->data) > 0) {
                foreach ($this->data as $k => $v) {
                    if (is_array($v)) {
                        $_ = array_values($v);

                        if (trim($_[0]) == trim($obj)) {
                            $obj = trim($_[1]);
                        }
                    } else {
                        if (trim($k) == trim($obj)) {
                            $obj = trim($v);
                        }
                    }
                }
            }

        }

        return $this->output_as($this->build_render($name, $obj));
    }

    /**
     * Render drop down select menu with iCON ( bootstrap pattern )
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param string $icon_html Example:  $html->span($html->icon("fas fa-map-marked-alt")." Pick location", ["class"=>"input-group-addon getmap", "role"=>"button"])
     * @param boolean $optional_option True = auto generate <option></option>
     * @return string
     */
    public function select_input_group($name = "", $value = "", $icon_html = "", $optional_option = false)
    {
        $this->object            = __METHOD__;
        $this->prepend['before'] = "<div class=\"input-group\">";
        $this->prepend['after']  = "$icon_html</div>";

        return $this->output_as($this->select($name, $value, $optional_option));
    }
}
