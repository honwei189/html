<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 14/10/2019 19:05:16
 * @last modified     : 23/04/2020 15:17:36
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 *
 * Generate HTML template
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
trait view
{
    /**
     * Define bootstrap form body template
     *
     * @param boolean|string $form_layout horizontal or vertical.  If $form_layout = false, means that to off bootstrap style
     * @param string $class CSS class name
     * @return string
     */
    public function bootstrap_style($form_layout = "horizontal", $class = [])
    {
        if ($form_layout == false) {
            $this->html_style    = "";
            $this->html_template = "";

            return $this;
        }

        $this->html_style = "bootstrap";

        switch ($form_layout) {
            case "horizontal":
            default:
                $this->html_template = "
                <div id=\"{{ id }}\" class=\"form-group{{ style_class }}\">
                    <label class=\"control-label" . (isset($class[0]) ? " " . $class[0] : " col-sm-2") . "\" for=\"{{ input_name }}\">{{ title }}:</label>
                    <div class=\"" . ($this->display_value_only ? "p-t-7" : "") . (isset($class[1]) ? " " . $class[1] : " col-sm-10") . "\">
                        {{ input }}
                    </div>
                </div>
                ";
                break;

            case "vertical":
                $this->html_template = "
                <div id=\"{{ id }}\" class=\"form-group{{ style_class }}\">
                    <label for=\"{{ input_name }}\">{{ title }}:</label>
                    {{ input }}
                </div>
                ";
                break;
        }
    }

    /**
     * Render HTML tag.  e.g:  $html->custom("strong", "My name", ["class" => "text-danger"]);
     *
     * @param string $html_tag_name Any HTML tag name.  e.g: button, base, img, div, i, strong and etc...
     * @param string $text Text contents to display within the HTML tag
     * @param array $attrs <HTML_TAG_NAME> attributes.  e.g:  class, id
     * @return string
     */
    public function custom($html_tag_name, $text = "", $attrs = null)
    {
        $this->object = __METHOD__;

        $options = "";
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

        $this->param = $attrs;
        $this->value = $text;

        return $this->output_as($this->build_render($html_tag_name, "<$html_tag_name" . $options . ">$text</$html_tag_name>"));
    }

    /**
     * Write CSS style
     *
     * @param string $css
     * @return string
     */
    public function css($css)
    {
        return "<style>$css</style>" . PHP_EOL;
    }

    /**
     * Render HTML - <i></i>
     *
     * @param string $text
     * @param array $attrs <i> attributes.  e.g:  class, id
     * @return string
     */
    public function i($text, $attrs = null)
    {
        $options = "";
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

        return "<i$options>$text</i>";
    }

    /**
     * CSS icon
     *
     * @param string $css_class
     * @param array $attrs <i> attributes.  e.g:  class, id
     * @return string
     */
    public function icon($css_class, $attrs = null)
    {
        $this->param($attrs);
        return "<i class=\"$css_class\"" . $this->build_obj_attr() . "></i>";
    }

    /**
     * Image
     * 
     * @param string $url Image URL
     * @param string $title Image title
     * @param integer $width Resize image width.  Default = 0 (use original size)
     * @param array $attrs <img> attributes.  e.g:  class, id
     * @return html 
     */
    public function image($url, $title, $width = 0, $attrs = null)
    {
        $options = "";
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

        $url = $this->tpl_code_to_text($url, null);

        return $this->output_as($this->build_render("", "<img src=\"$url\"" . $options . " title=\"$title\" alt=\"$title\"".($width > 0 ? " width=\"$width\"" : "").">"));
    }

    /**
     * Define parent DIV class
     *
     * @param string $class
     * @return html
     */
    public function style_class($class)
    {
        $this->style_class = $class;

        return $this;
    }

    /**
     * Define parent DIV id
     *
     * @param string $id
     * @return html
     */
    public function style_id($id)
    {
        $this->style_id = $id;

        return $this;
    }

    /**
     * Output text
     *
     * @param string $text
     * @return string
     */
    public function text($text, $type = null)
    {
        $this->object = __METHOD__;
        $text = nl2br($this->value_format($this->tpl_code_to_text($text), $type));

        if ($this->html_style == "bootstrap") {
            return $this->output_as($this->build_render("", $this->div($text)));
        } else {
            echo $text;
        }
    }

    /**
     * Render HTML - <u></u>
     *
     * @param string $text
     * @param array $attrs <u> attributes.  e.g:  class, id
     * @return string
     */
    public function u($text, $attrs = null)
    {
        $options = "";
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

        return "<i$options>$text</HTML_TAG_NAME>";
    }

}
