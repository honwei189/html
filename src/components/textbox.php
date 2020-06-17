<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 14/10/2019 19:05:50
 * @last modified     : 17/06/2020 19:06:00
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 *
 * Generate HTML text input field
 *
 *
 * @package     html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0"
 * @since       "1.0.0"
 */
trait textbox
{
    /**
     * Render input textbox with type = number and for currency amount use
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @return string
     */
    public function currency($name = "", $value = "")
    {
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (!is_value($value)) {
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
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
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function currency_input_group($name = "", $value = "", $icon_attrs = null)
    {
        $this->object = __METHOD__;

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fas fa-dollar-sign\"></i>", $icon_attrs) . "</div>";
        }

        return $this->currency($name, $value);
    }

    /**
     * Render input textbox with type = date
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @return string
     */
    public function date($name = "", $value = "")
    {
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (!is_value($value)) {
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
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
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function date_input_group($name = "", $value = "", $icon_attrs = null)
    {
        $this->object = __METHOD__;

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fa fa-calendar\"></i>", $icon_attrs) . "</div>";
        }

        return $this->date($name, $value);
    }

    public function email($name = "", $value = "")
    {
        $this->object = __METHOD__;

        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);
        if (!is_value($value)) {
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
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
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function email_input_group($name = "", $value = "", $icon_attrs = null)
    {
        $this->object = __METHOD__;

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fa fa-envelop\"></i>", $icon_attrs) . "</div>";
        }

        return $this->date($name, $value);
    }

    /**
     * Render hidden field
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @param string|array $attrs <input type="hidden"> attributes.  e.g:  class, id
     * @return string
     */
    public function hidden($name = "", $value = "", $attrs = null)
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
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
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
     * @return string
     */
    public function number($name = "", $value = "")
    {
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (!is_value($value)) {
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
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
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function number_input_group($name = "", $value = "", $icon_attrs = null)
    {
        $this->object = __METHOD__;

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fas fa-sort-numeric-down\"></i>", $icon_attrs) . "</div>";
        }

        return $this->number($name, $value);
    }

    /**
     * Render input textbox with type = password
     *
     * @param string $name Name of <input>
     * @param string $value Default value
     * @return string
     */
    public function password($name = "", $value = "")
    {
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (!is_value($value)) {
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
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
     * @param string $icon_attrs <input> attributes.  e.g:  class, id
     * @return string
     */
    public function password_input_group($name = "", $value = "", $icon_attrs = null)
    {
        $this->object = __METHOD__;

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = $this->span("<i class=\"fas fa-key\"></i>", $icon_attrs) . "</div>";
        }

        return $this->password($name, $value);
    }

    /**
     * Render input textarea
     *
     * @param string $name Name of <textarea>
     * @param string $value Default value
     * @return string
     */
    public function textarea($name = "", $value = "")
    {
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (!is_value($value)) {
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
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
     * @return string
     */
    public function textbox($name = "", $value = "")
    {
        $this->object = __METHOD__;
        $_name        = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);

        if (!is_value($value)) {
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
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
     * @param string $icon_html Example:  $html->span($html->icon("fas fa-map-marked-alt")." Pick location", ["class"=>"input-group-addon getmap", "role"=>"button"])
     * @return string
     */
    public function textbox_input_group($name = "", $value = "", $icon_html = "")
    {
        $this->object = __METHOD__;

        if (!$this->display_value_only) {
            $this->prepend['before'] = "<div class=\"input-group\">";
            $this->prepend['after']  = "$icon_html</div>";
        }

        $_name = preg_replace("#\[.*?\]|(\[\]+)#", "", $name);
        if (!is_value($value)) {
            if (isset($this->dataset[$_name])) {
                $this->param["value"] = $this->dataset[$_name];
            } else if (isset($this->param["value"])) {
                $this->param["value"] = $this->tpl_code_to_text($value);
            }
        } else {
            $this->param["value"] = $this->tpl_code_to_text($value);
        }

        return $this->output_as($this->build_render($name, (!$this->display_value_only ? "<input type=\"text\"" . $this->build_obj_attr($name) . ">" : $this->param["value"])));
    }
}
