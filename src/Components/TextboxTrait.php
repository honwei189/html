<?php
/*
 * Created       : 2019-10-14 07:05:50 pm
 * Author        : Gordon Lim <honwei189@gmail.com>
 * Last Modified : 2020-11-07 04:22:10 pm
 * Modified By   : Gordon Lim
 * ---------
 * Changelog
 *
 * Date & time           By                    Version   Comments
 * -------------------   -------------------   -------   ---------------------------------------------------------
 * 2020-11-07 04:20 pm   Gordon Lim            1.0.1     Rectified bootstrap - input group icon not displayed problem
 *
 */
namespace honwei189\Html\Components;

/**
 *
 * Generate HTML text input field
 *
 *
 * @package     Html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.1"
 */
trait TextboxTrait
{
    /**
     * Render input textbox with type = number and for currency amount use
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @return string
     */
    public function currency($name = "", $value = null, $attrs = null)
    {
        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        if (is_value($this->object_type)) {
            $this->object      = $this->object_type;
            $this->object_type = null;
        } else {
            $this->object = __METHOD__;
        }

        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        if (!$this->display_value_only) {
            $this->param['size']      = (isset($this->param['size']) && is_value($this->param['size']) ? "{$this->param['size']}" : "5");
            $this->param['maxlength'] = (isset($this->param['maxlength']) && is_value($this->param['maxlength']) ? "{$this->param['maxlength']}" : "15");
            $this->param['min']       = (isset($this->attr['min']) && is_value($this->attr['min']) ? "{$this->attr['min']}" : "0.00");
            $this->param['max']       = (isset($this->attr['max']) && is_value($this->attr['max']) ? "{$this->attr['max']}" : "1000000000.00");
            $this->param['step']      = (isset($this->attr['step']) && is_value($this->attr['step']) ? "{$this->attr['step']}" : "0.01");

            unset($this->attr['min']);
            unset($this->attr['max']);
            unset($this->attr['step']);

        }

        return $this->output_as($this->build_render($name, (!$this->display_value_only ? "<input type=\"number\"" . $this->build_obj_attr($name) . ">" : number_format((float) $this->param["value"], 2, ".", ","))));
    }

    /**
     * Render CSS bootstrap style input textbox with type = number and for currency amount use
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function currency_input_group($name = "", $value = null, $attrs = null, $icon_attrs = null)
    {
        if (is_null($icon_attrs)) {
            $icon_attrs['class'] = "input-group-addon";
        } else {
            if (isset($icon_attrs['class'])) {
                $icon_attrs['class'] = $icon_attrs['class'] . " input-group-addon";
            } else {
                $icon_attrs['class'] = "input-group-addon";
            }
        }

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fas fa-dollar-sign\"></i>", $icon_attrs) . "</div>";
        }

        return $this->set_object_type(__METHOD__)->currency($name, $value, $attrs);
    }

    /**
     * Render input textbox with type = date
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @return string
     */
    public function date($name = "", $value = null, $attrs = null)
    {
        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        if (is_value($this->object_type)) {
            $this->object      = $this->object_type;
            $this->object_type = null;
        } else {
            $this->object = __METHOD__;
        }

        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        if (!$this->display_value_only) {
            if (isset($this->param["class"])) {
                $this->param["class"] .= " date";
            } else {
                $this->param["class"] = "date";
            }
        }

        return $this->output_as($this->build_render($name, (!$this->display_value_only ? "<input type=\"text\"" . $this->build_obj_attr($name) . ">" : $this->param["value"])));
    }

    /**
     * Render CSS bootstrap style input textbox with type = date
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function date_input_group($name = "", $value = null, $attrs = null, $icon_attrs = null)
    {
        if (is_null($icon_attrs)) {
            $icon_attrs['class'] = "input-group-addon";
        } else {
            if (isset($icon_attrs['class'])) {
                $icon_attrs['class'] = $icon_attrs['class'] . " input-group-addon";
            } else {
                $icon_attrs['class'] = "input-group-addon";
            }
        }

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fa fa-calendar\"></i>", $icon_attrs) . "</div>";
        }

        return $this->set_object_type(__METHOD__)->date($name, $value, $attrs);
    }

    /**
     * Render input textbox with type = email
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @return string
     */
    public function email($name = "", $value = null, $attrs = null)
    {
        if (is_value($this->object_type)) {
            $this->object      = $this->object_type;
            $this->object_type = null;
        } else {
            $this->object = __METHOD__;
        }

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);
        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        return $this->output_as($this->build_render($name, (!$this->display_value_only ? "<input type=\"email\"" . $this->build_obj_attr($name) . ">" : $this->param["value"])));
    }

    /**
     * Render CSS bootstrap style input textbox with type = email
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function email_input_group($name = "", $value = null, $attrs = null, $icon_attrs = null)
    {
        if (is_null($icon_attrs)) {
            $icon_attrs['class'] = "input-group-addon";
        } else {
            if (isset($icon_attrs['class'])) {
                $icon_attrs['class'] = $icon_attrs['class'] . " input-group-addon";
            } else {
                $icon_attrs['class'] = "input-group-addon";
            }
        }

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fa fa-envelop\"></i>", $icon_attrs) . "</div>";
        }

        return $this->set_object_type(__METHOD__)->date($name, $value, $attrs);
    }

    /**
     * Render hidden field
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param string|array $attrs <input type="hidden"> attributes.  e.g:  class, id
     * @return string
     */
    public function hidden($name = "", $value = null, $attrs = null)
    {
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);
        $options      = "";
        if (is_array($attrs) && count($attrs) > 0) {
            foreach ($attrs as $k => $v) {
                if (!is_array($v)) {
                    $options .= " $k=\"$v\"";
                } else {
                    $options .= " $k=\"" . join(" ", $v) . "\"";
                }
            }
        } else {
            $options = $attrs;
        }

        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        return $this->output_as($this->build_render($name, "<input type=\"hidden\"" . (is_value($name) ? " name=\"$name\"" : "") . " value=\"" . $this->param["value"] . "\"$options>"));
    }

    /**
     * Render input textbox with type = number
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @return string
     */
    public function number($name = "", $value = null, $attrs = null)
    {
        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        if (is_value($this->object_type)) {
            $this->object      = $this->object_type;
            $this->object_type = null;
        } else {
            $this->object = __METHOD__;
        }

        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        if (!$this->display_value_only) {
            $this->param['size']      = (isset($this->param['size']) && is_value($this->param['size']) ? "{$this->param['size']}" : "5");
            $this->param['maxlength'] = (isset($this->param['maxlength']) && is_value($this->param['maxlength']) ? "{$this->param['maxlength']}" : "15");
            $this->param['min']       = (isset($this->attr['min']) && is_value($this->attr['min']) ? "{$this->attr['min']}" : "0");
            $this->param['max']       = (isset($this->attr['max']) && is_value($this->attr['max']) ? "{$this->attr['max']}" : "1000000000");
            $this->param['step']      = (isset($this->attr['step']) && is_value($this->attr['step']) ? "{$this->attr['step']}" : "1");

            unset($this->attr['min']);
            unset($this->attr['max']);
            unset($this->attr['step']);
        }

        return $this->output_as($this->build_render($name, (!$this->display_value_only ? "<input type=\"number\"" . $this->build_obj_attr($name) . ">" : number_format((int) $this->param["value"], 2))));
    }

    /**
     * Render CSS bootstrap style input textbox with type = number
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function number_input_group($name = "", $value = null, $attrs = null, $icon_attrs = null)
    {
        if (is_null($icon_attrs)) {
            $icon_attrs['class'] = "input-group-addon";
        } else {
            if (isset($icon_attrs['class'])) {
                $icon_attrs['class'] = $icon_attrs['class'] . " input-group-addon";
            } else {
                $icon_attrs['class'] = "input-group-addon";
            }
        }

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fas fa-sort-numeric-down\"></i>", $icon_attrs) . "</div>";
        }

        return $this->set_object_type(__METHOD__)->number($name, $value, $attrs);
    }

    /**
     * Render input textbox with type = password
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @return string
     */
    public function password($name = "", $value = null, $attrs = null)
    {
        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        if (is_value($this->object_type)) {
            $this->object      = $this->object_type;
            $this->object_type = null;
        } else {
            $this->object = __METHOD__;
        }

        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        return $this->output_as($this->build_render($name, (!$this->display_value_only ? "<input type=\"password\"" . $this->build_obj_attr($name) . ">" : $this->param["value"])));
    }

    /**
     * Render CSS bootstrap style input textbox with type = password
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function password_input_group($name = "", $value = null, $attrs = null, $icon_attrs = null)
    {
        if (is_null($icon_attrs)) {
            $icon_attrs['class'] = "input-group-addon";
        } else {
            if (isset($icon_attrs['class'])) {
                $icon_attrs['class'] = $icon_attrs['class'] . " input-group-addon";
            } else {
                $icon_attrs['class'] = "input-group-addon";
            }
        }

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fas fa-key\"></i>", $icon_attrs) . "</div>";
        }

        return $this->set_object_type(__METHOD__)->password($name, $value, $attrs);
    }

    /**
     * Render input textarea
     *
     * @param string $name Name of <textarea>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @return string
     */
    public function textarea($name = "", $value = null, $attrs = null)
    {
        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        if (is_value($this->object_type)) {
            $this->object      = $this->object_type;
            $this->object_type = null;
        } else {
            $this->object = __METHOD__;
        }

        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        return $this->output_as($this->build_render($name, (!$this->display_value_only ? "<textarea" . $this->build_obj_attr($name) . ">$value</textarea>" : nl2br($value))));
    }

    /**
     * Render input textbox with type = text
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @return string
     */
    public function textbox($name = "", $value = null, $attrs = null)
    {
        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        if (is_value($this->object_type)) {
            $this->object      = $this->object_type;
            $this->object_type = null;
        } else {
            $this->object = __METHOD__;
        }

        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        return $this->output_as($this->build_render($name, (!$this->display_value_only ? "<input type=\"text\"" . $this->build_obj_attr($name) . ">" : $this->param["value"])));
    }

    /**
     * Render CSS bootstrap style input textbox
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param array $attrs Input box attributes.  e.g:  class, id
     * @param string $icon_html Example:  $html->span($html->icon("fas fa-map-marked-alt")." Pick location", ["class"=>"input-group-addon getmap", "role"=>"button"])
     * @return string
     */
    public function textbox_input_group($name = "", $value = null, $attrs = null, $icon_html = "")
    {
        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = "$icon_html</div>";
        }

        if (is_array($attrs)) {
            $this->param($attrs);
        }

        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);
        if (!is_value($value)) {
            if (is_null($value)) {
                if (isset($this->dataset[$_name])) {
                    $this->param["value"] = $this->dataset[$_name];
                } else if (isset($this->param["value"])) {
                    $this->param["value"] = $this->tpl_code_to_text($value);
                }
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        return $this->set_object_type(__METHOD__)->output_as($this->build_render($name, (!$this->display_value_only ? "<input type=\"text\"" . $this->build_obj_attr($name) . ">" : $this->param["value"])));
    }
}
