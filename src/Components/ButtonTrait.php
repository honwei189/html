<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 21/10/2019 16:45:38
 * @last modified     : 22/04/2020 15:13:32
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\Html\Components;

/**
 *
 * Generate HTML Button
 *
 *
 * @package     Html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0"
 * @since       "1.0.0"
 */
trait ButtonTrait
{
    /**
     * Create HTML button
     *
     * @param string $name Button name
     * @param string $text Button text
     * @param array $attrs Button attributes.  e.g:  class, id
     * @return string
     */
    public function button($name = "", $text = "", array $attrs = null)
    {
        $this->object = __METHOD__;
        // $options = "";
        // if (is_array($attrs) && count($attrs) > 0) {
        //     foreach ($attrs as $k => $v) {
        //         if (!is_array($v)) {
        //             $options .= " $k=\"$v\"";
        //         } else {
        //             $options .= " $k=\"" . join(" ", $v) . "\"";
        //         }
        //     }
        // } else {
        //     $options = $attrs;
        // }

        $attr        = (object) $attrs;
        $attr->class = "btn" . (isset($attr->class) && is_value($attr->class) ? " {$attr->class}" : "") . (isset($this->param['class']) && is_value($this->param['class']) ? " {$this->param['class']}" : "");
        $this->param = (array) $attr;
        unset($attr);

        $obj = "<button type=\"Button\"" . $this->build_obj_attr($name) . ">$text</button>";

        if ($this->build) {
            echo $obj;
        } else {
            return $obj;
        }
    }

    /**
     * Build button with ICON
     *
     * @param string $name Name of Button
     * @param string $text Button text
     * @param string $icon Icon css class
     * @param array $attrs Button attributes.  e.g:  class, id
     * @return string
     */
    public function Button_icon($name = "", $text = "", $icon, array $attrs = null)
    {
        return $this->button($name, $this->icon($icon) . " " . $text, $attrs);
    }

    public function button_group()
    {

    }

    /**
     * Create HTML button menu
     *
     * @param array $items Menu list
     * @param array $attrs Button attributes.  e.g:  class, id
     * @return string
     */
    public function button_menu($items, array $attrs = null)
    {
        $this->object             = __METHOD__;
        $attrs                    = (object) $attrs;
        $attrs->class             = "btn-default dropdown-toggle" . (isset($attrs->class) && is_value($attrs->class) ? " {$attrs->class}" : "");
        $attrs->{"data-toggle"}   = "dropdown";
        $attrs->{"data-boundary"} = "window";
        $attrs->{"aria-expanded"} = "false";
        $menu_pos                 = "";

        if (is_value($attrs->menu)) {
            $menu_pos = " " . $attrs->menu;
            unset($attrs->menu);
        }

        // $btn = $this->button(PHP_EOL . "\t\t" . $this->icon("fas fa-ellipsis-v fa-1x") . PHP_EOL, (array) $attrs);
        // $ul  = $this->ul($items, ["class" => "dropdown-menu navbar-left pull-right"]);

        // return "\n\t\t\t\t" . $this->div($btn . $ul, ["class" => "btn-group"]) . "\n\t\t\t\t";

        $btn = "\n\t\t\t\t\t" . $this->button("", "\n\t\t\t\t\t\t" . $this->icon("fa fa-ellipsis-v fa-1x") . "\n\t\t\t\t\t", (array) $attrs) . PHP_EOL;
        $ul  = "\t\t\t\t\t" . $this->ul($items, ["class" => "dropdown-menu$menu_pos"]) . "\n\t\t\t\t";

        return "\n\t\t\t\t" . $this->div($btn . $ul, ["class" => "btn-group"]) . "\n\t\t\t\t";
    }

    /**
     * Create HTML submitButton
     *
     * @param string $name Button name
     * @param string $text Button text
     * @param array $attrs Button attributes.  e.g:  class, id
     * @return string
     */
    public function submit_button($name = "", $text, array $attrs = null)
    {
        $this->object = __METHOD__;
        // $options = "";
        // if (is_array($attrs) && count($attrs) > 0) {
        //     foreach ($attrs as $k => $v) {
        //         if (!is_array($v)) {
        //             $options .= " $k=\"$v\"";
        //         } else {
        //             $options .= " $k=\"" . join(" ", $v) . "\"";
        //         }
        //     }
        // } else {
        //     $options = $attrs;
        // }

        $attr        = (object) $this->param;
        $attr->class = "btn btn-default dropdown-toggle" . (isset($attrs['class']) && is_value($attrs['class']) ? " {$attrs['class']}" : "");
        $this->param = (array) $attr;
        unset($attr);

        $obj = "<button type=\"submit\"" . $this->build_obj_attr($name) . ">$text</button>";

        if ($this->build) {
            echo $obj;
        } else {
            return $obj;
        }
    }

    /**
     * Build submit button with ICON
     *
     * @param string $name Name of button
     * @param string $text Button text
     * @param string $icon Icon css class
     * @param array $attrs Button attributes.  e.g:  class, id
     * @return string
     */
    public function submit_button_icon($name = "", $text = "", $icon, array $attrs = null)
    {
        return $this->submit_button($name, $this->icon($icon) . " " . $text, $attrs);
    }

    /**
     * Create HTML reset button
     *
     * @param string $name Button name
     * @param string $text Button text
     * @param array $attrs Button attributes.  e.g:  class, id
     * @return string
     */
    public function reset_button($name = "", $text, array $attrs = null)
    {
        $this->object = __METHOD__;
        // $options = "";
        // if (is_array($attrs) && count($attrs) > 0) {
        //     foreach ($attrs as $k => $v) {
        //         if (!is_array($v)) {
        //             $options .= " $k=\"$v\"";
        //         } else {
        //             $options .= " $k=\"" . join(" ", $v) . "\"";
        //         }
        //     }
        // } else {
        //     $options = $attrs;
        // }

        $attr        = (object) $this->param;
        $attr->class = "btn btn-default dropdown-toggle" . (isset($attrs['class']) && is_value($attrs['class']) ? " {$attrs['class']}" : "");
        $this->param = (array) $attr;
        unset($attr);

        $obj = "<button type=\"reset\"" . $this->build_obj_attr($name) . ">$text</button>";

        if ($this->build) {
            echo $obj;
        } else {
            return $obj;
        }
    }

    /**
     * Build reset button with ICON
     *
     * @param string $name Name of button
     * @param string $text Button text
     * @param string $icon Icon css class
     * @param array $attrs Button attributes.  e.g:  class, id
     * @return string
     */
    public function reset_button_icon($name = "", $text = "", $icon, array $attrs = null)
    {
        return $this->reset_button($name, $this->icon($icon) . " " . $text, $attrs);
    }
}
