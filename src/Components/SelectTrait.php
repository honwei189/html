<?php
/*
 * Created       : 2019-10-14 07:05:30 pm
 * Author        : Gordon Lim <honwei189@gmail.com>
 * Last Modified : 2020-11-07 04:21:49 pm
 * Modified By   : Gordon Lim
 * ---------
 * Changelog
 *
 * Date & time           By                    Version   Comments
 * -------------------   -------------------   -------   ---------------------------------------------------------
 * 2020-11-07 04:19 pm   Gordon Lim            1.0.2     Rectified bootstrap - input group icon not displayed problem
 * 2020-03-05 07:16 pm   Gordon Lim            1.0.1     Rectified in value_only MODE, data not displayed problem
 *
 */

namespace honwei189\Html\Components;

/**
 *
 * Generate HTML dropdown select box
 *
 *
 * @package     Html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.2"
 * @since       "1.0.1" Rectified in value_only MODE, data not displayed problem
 */
trait SelectTrait
{
    /**
     * Render drop down menu
     *
     * e.g:
     *
     * $html->data(["M" => "Male", "F" => "Female"])->select("gender", "M", ["class" => "form-select"], null, true);
     *
     * or;
     *
     * $html->select("gender", "M", ["class" => "form-select"], ["M" => "Male", "F" => "Female"]);
     *
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Select attributes.  e.g:  class, id
     * @param array $options_data <option></option> list.  ["A1" => "Menu A", "A2" => "Menu B"].  This is to replace using data()
     * @param boolean $optional_option True = auto generate <option></option>
     * @return string
     */
    public function select($name, $default_value = "", array $attrs = null, array $options_data = null, $optional_option = false)
    {
        $data  = PHP_EOL;
        $text  = "";
        $value = "";
        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);
        $obj   = "";
        $a_obj = null;

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        if (is_array($options_data)) {
            $this->data($options_data);
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
                    if (is_value($v)) {
                        $value = $k;
                        $text  = $v;
                    } else {
                        $value = "";
                        $text  = "";
                    }
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

                        if (isset($this->dataset[$_name])) {
                            if (is_array($this->dataset[$_name])) {
                                $_ = $this->dataset[$_name];
                            } else {
                                $_ = json_decode($this->dataset[$_name], true);
                            }
                        } else {
                            $_ = $default_value;
                        }

                        if (is_array($_)) {
                            foreach ($_ as $v) {
                                if ($v == $value) {
                                    $default = " selected";
                                }
                            }
                        }

                        unset($_);
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

                if (isset($this->dataset[$_name])) {
                    if (is_array($this->dataset[$_name])) {
                        $_v = $this->dataset[$_name];
                    } else {
                        $_v = json_decode($this->dataset[$_name], true);
                    }
                } else {
                    $_v = $obj;
                }

                foreach ($this->data as $k => $v) {
                    if (is_array($v)) {
                        $_ = array_values($v);

                        if (trim($_[0]) == trim($obj)) {
                            $obj = trim($_[1]);
                        }

                        if (is_array($_v)) {
                            foreach ($_v as $val) {
                                if ($val == $_[0]) {
                                    $a_obj[] = trim($_[1]);
                                }
                            }
                        }
                    } else {
                        if (trim($k) == trim($obj)) {
                            $obj = trim($v);
                        }

                        if (is_array($_v)) {
                            foreach ($_v as $val) {
                                if ($val == $_[0]) {
                                    $a_obj[] = trim($_[1]);
                                }
                            }
                        }
                    }
                }

                unset($_v);
            }
        }

        if (is_array($a_obj)) {
            $obj = implode(", ", (is_value($obj) ? array_merge([$obj], $a_obj) : $a_obj));
        }

        return $this->output_as($this->build_render($name, $obj));

    }

    /**
     * Render drop down select menu with iCON ( bootstrap pattern )
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Select attributes.  e.g:  class, id
     * @param array $options_data <option></option> list.  ["A1" => "Menu A", "A2" => "Menu B"].  This is to replace using data()
     * @param string $icon_html Example:  $html->span($html->icon("fas fa-map-marked-alt")." Pick location", ["class"=>"input-group-addon getmap", "role"=>"button"])
     * @param boolean $optional_option True = auto generate <option></option>
     * @return string
     */
    public function select_input_group($name = "", $value = "", array $attrs = null, array $options_data = null, $icon_html = "", $optional_option = false)
    {
        $this->prepend['before'] = "<div class=\"input-group\">";
        $this->prepend['after']  = "$icon_html</div>";

        return $this->set_object_type(__METHOD__)->output_as($this->select($name, $value, $attrs, $options_data, $optional_option));
    }
}
