<?php
/*
 * @description       :
 * @version           : "1.0.1" 04/03/2020 11:00:08 added alter(), and enhanced build_from_json_render() - To support alter attributes from JSON
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 14/10/2019 18:54:38
 * @last modified     : 04/03/2020 11:13:38
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

use \honwei189\flayer as flayer;

/**
 *
 * Generate HTML
 *
 * Usage :
 *
 * html()->action($action)
 * html()->build()->hidden();
 * html()->build()->label_only(true);
 * html()->build()->label_data_only(true);
 * textbox()->render()
 * textbox()->generate()
 * textbox()->build()
 * textbox()->out()
 *
 * html()->build(
 *
 * )
 *
 * html("id")->size(20)->value()->text("name");
 *
 * html()
 *  ->label("First name")
 *  ->param(["size" => 50, "maxlength" => 150])
 *  ->attr("required")
 *  ->text("user_first_name", $value)
 *
 * html()->build([
 *  html()->label("First name")->param(["size" => 50, "maxlength" => 150])->attr("required")->text("user_first_name", $value),
 *  html()->label("Email address")->hidden(false)->attr("required")->email("user_email", $value)
 * ]);
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
class html
{
    public $dataset             = [];
    public $parent_this         = null;
    private $alter              = null;
    private $attr               = [];
    private $class              = [];
    private $data               = null;
    private $db                 = null;
    private $display_value_only = false;
    private $html_template      = null;
    private $html_style         = null;
    private $is_use             = false;
    private $json               = null;
    private $label              = null;
    private $maxlength          = null;
    private $name               = null;
    private $object             = null;
    private $object_id          = null;
    private $output_type        = null;
    private $param              = [];
    private $placeholder        = null;
    private $prepend            = ["before" => "", "after" => ""];
    private $preset             = null;
    private $size               = null;
    private $style_class        = null;
    private $style_id           = null;
    private $title              = null;

    use button, checkbox, div, hyperlink, li, radio, select, span, textbox, view;

    public function __construct()
    {
    }

    public function __clone()
    {
        return $this;
    }

    public function __destruct()
    {
        $this->attr               = [];
        $this->build              = false;
        $this->class              = [];
        $this->data               = null;
        $this->dataset            = [];
        $this->db                 = null;
        $this->display_value_only = false;
        $this->html_template      = null;
        $this->html_style         = null;
        $this->is_use             = false;
        $this->json               = null;
        $this->label              = null;
        $this->maxlength          = null;
        $this->name               = null;
        $this->object             = null;
        $this->object_id          = null;
        $this->output_type        = null;
        $this->param              = [];
        $this->parent_this        = null;
        $this->placeholder        = null;
        $this->prepend            = ["before" => "", "after" => ""];
        $this->preset             = null;
        $this->size               = null;
        $this->style_class        = null;
        $this->style_id           = null;
        $this->title              = null;
    }

    /**
     * Define form form element.  E.g:  required autofocus    <input type="text" name="abc" required autofocus>
     *
     * @param string|array $attr e.g:  required autofocus
     * @return html
     */
    public function attr($attr)
    {
        if (is_array($attr) && count($attr) == 0) {
            $this->attr = [];
        } else if (is_array($attr) && count($attr) > 0) {
            $this->attr = array_merge($this->attr, $attr);
        } else if (is_value($attr)) {
            $this->attr[] = $attr;
        }

        return $this;
    }

    /**
     * Build all form elements object under same group set and sharing same settings / parameters
     *
     * @param object $obj e.g:  $html->build( function() use (&$html) {
     *  print_r($html);
     * });
     *
     * @return array|json|string
     */
    public function build($obj = null)
    {
        $this->build = true;

        if (is_callable($obj)) {
            $obj($this);
        } else {
            switch ($this->output_type) {
                case "array":
                    return $this->json;
                    break;

                case "json":
                    return json_encode($this->json);
                    break;

                default:
                    if (!is_null($this->json)) {
                        $this->build_from_json();
                    }
                    break;
            }
        }
    }

    /**
     * Set form element object's CSS class.  e.g:  <input type="text" class="abc">
     *
     * @param string|array $class CSS class name
     * @return html
     */
    function class ($class)
    {
        if (is_array($class) && count($class) > 0) {
            $this->class = array_merge($this->class, $class);
        } else if (\is_value($class)) {
            $this->class[] = $class;
        }

        return $this;
    }

    /**
     * Dafault dataset of form element (textbox, checkbox, select and etc..)  e.g: dataset will be dropdown menu's options value : <select><option value="A">AAA</option></select>
     *
     * @param array $data
     * @return html
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Dafault dataset of form element (textbox, checkbox, select and etc..)  e.g: dataset will be dropdown menu's options value : <select><option value="A">AAA</option></select>
     *
     * @param array $data
     * @return html
     */
    public function dataset($data)
    {
        $this->dataset = $data;
        return $this;
    }

    /**
     * Form element's default value.  Load from DB, based on the form element name and data name, automatically apply to textbox, checkbox and etc...
     *
     * @param array $data
     * @return html
     */
    function default($data) {
        return $this->dataset($data);
    }

    /**
     * Build HTML FORM with JSON
     *
     * example:
     *
     *     $html = new html;
     *     $html->bootstrap_style("vertical");
     *     $html->default(["test" => "Testing from default", "chk" => "SSM", "cat" => "002"]);
     *     $html->preset("textbox", ["class" => "chars_remind"]);
     *     $html->preset(["checkbox", "radio"], ["class" => "i-checks"]);
     *
     *     $a = new stdClass();
     *     $a->input = "textbox";
     *     $a->title="Test";
     *     $a->name="test";
     *     $a->default = "AAA";
     *     $a->placeholder = "ABV";
     *     $a->size=150;
     *     $a->param = ["class" => "aaa"];
     *
     *     $b = new stdClass();
     *     $b->input = "checkbox";
     *     $b->title="Checkbox";
     *     $b->name="chk[]";
     *     $b->data = ["SSM" => "SSM", "EPC" => "EPC"];
     *     $b->param = ["class" => "bbb"];
     *
     *     $c = new stdClass();
     *     $c->input = "type_select";
     *     $c->title="Type select";
     *     $c->name="cat";
     *     $c->db_type_name="biz_cat";
     *     $c->optional=false;
     *     $c->param = ["class" => "ccc"];
     *
     *     $d = new stdClass();
     *     $d->input = "select";
     *     $d->title="DB select";
     *     $d->name="cat";
     *     $d->db_sql="select id, name from opt_banks";
     *     $d->optional=false;
     *     $d->param = ["class" => "ddd"];
     *
     *     $html->fromJSON(json_encode([$a, $b, $c, $d]))->build();
     *
     * @param string $json
     * @return html
     */
    public function fromJSON($json)
    {
        if (is_value($json)) {
            $data = json_decode($json);

            if (json_last_error() === JSON_ERROR_NONE || json_last_error() === 0) {
                $this->json = $data;
            }

            unset($data);
        } else {
            $this->json = null;
        }

        return $this;
    }

    public function group()
    {

    }

    /**
     * Label title of the form element.  e.g:  My Email Address
     *
     * @param string $label
     * @return mixed
     */
    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    public function map($input_name, $key_name = null)
    {

    }

    public function margin()
    {

    }

    /**
     * Max length of the form element.  e.g:  <input type="text" maxlength="20">
     *
     * @param integer $length
     * @return mixed
     */
    public function max($length)
    {
        return $this->maxlength($length);
    }

    /**
     * Max length of the form element.  e.g:  <input type="text" maxlength="20">
     *
     * @param integer $length
     * @return mixed
     */
    public function maxlength($length)
    {
        $this->maxlength          = (int) $length;
        $this->param['maxlength'] = $this->maxlength;
        return $this;
    }

    /**
     * Return object only without directly output (echo / print)
     *
     * @param boolean $bool true = Do not directly output
     * @return html
     */
    public function no_output($bool = true)
    {
        $this->build = !$bool;

        return $this;
    }

    /**
     * Generate object only (without others html).  e.g:  output - <input type="hidden" name="aaa">
     *
     * @return html
     */
    public function only()
    {
        $this->html_style    = "";
        $this->html_template = "";

        return $this;
    }

    /**
     * Define form form element's parameters.  E.g:  class="abc" size="20" maxlength="20"    <input type="text" name="abc" class="abc" size="20" maxlength="20">
     *
     * @param string|array $param e.g:  [id="abc", "class" => "abc", "size" => "20"]
     * @return html
     */
    public function param($param)
    {
        if (is_array($param) && count($param) == 0) {
            $this->param = [];
        } else if (is_array($param) && count($param) > 0) {
            foreach ($param as $k => $v) {
                if (isset($this->param[$k])) {
                    $this->param[$k] .= " $v";
                } else {
                    $this->param[$k] = $v;
                }
            }
        } else if (is_value($param)) {
            $this->param[] = $param;
        }

        return $this;
    }

    /**
     * Textbox's placeholder
     *
     * @param string $text
     * @return mixed
     */
    public function placeholder($text)
    {
        $this->placeholder = $text;

        return $this;
    }

    /**
     * Append something before and after the form element.  e.g: before = "My name", after = ", Hello~".  Output: My name <input type="text">, Hello~
     *
     * @param string $before
     * @param string $end
     * @return mixed
     */
    public function prepend($before, $end = null)
    {
        $this->prepend['before'] = $before;
        $this->prepend['end']    = $end;

        return $this;
    }

    /**
     * Pre-define each form form element's attributes and parameters.  e.g:  $this->preset("textbox", ["class" => "abc"]);
     *
     * Means that all textbox will apply class="abc".  e.g:  <input type="text" name="aaa" class="abc">   <input type="text" name="bbb" class="abc">
     *
     * @param string|array $html_object textbox, checkbox, select, radio, hidden, textarea.  Can multiple.  e.g:  $this->preset(["textbox", "checkbox", "select"], ["class" => "abc"]);
     * @param array $attr e.g:  [id="abc", "class" => "abc", "size" => "20"]
     * @return html
     */
    public function preset($html_object, $attr)
    {
        if (!is_object($this->preset)) {
            $this->preset = new \stdClass();
        }

        if (is_array($html_object)) {
            foreach ($html_object as $v) {
                $this->preset->$v = (object) $attr;
            }
        } else {
            $this->preset->$html_object = (object) $attr;
        }
    }

    /**
     * Form element size.  e.g:  <input type="text" size="20">
     *
     * @param integer $length
     * @return mixed
     */
    public function size($length)
    {
        $this->size          = (int) $length;
        $this->param['size'] = $this->size;

        return $this;
    }

    /**
     * Display text
     *
     * @param string $text
     * @return html
     */
    public function text($text)
    {
        $this->title = "";
        return $this->build_render("", $text);
    }

    /**
     * Label title of the element.  e.g:  My Email Address
     *
     * @param string $title
     * @return html
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Build HTML form and output as ARRAY
     *
     * example:
     *
     * $html->toArray()->build(function () use (&$html) {
     *     $html->title("Name")->max(200)->textbox("name");
     *     $html->title("Email")->max(100)->textbox("email");
     * });
     *
     * print_r($html->build());
     *
     * or;
     *
     * print_r($html->toArray()->title("Name")->max(200)->textbox("name"));
     *
     * or;
     *
     * $html->toArray();
     * $html->title("Name")->max(200)->textbox("name");
     * $html->title("Email")->max(100)->textbox("email");
     *
     * print_r($html->build());
     *
     * @return html
     */
    public function toArray()
    {
        $this->output_type = "array";

        return $this;
    }

    /**
     * Build HTML form and output as JSON format
     *
     * example:
     *
     * $html->toJSON()->build(function () use (&$html) {
     *     $html->title("Name")->max(200)->textbox("name");
     *     $html->title("Email")->max(100)->textbox("email");
     * });
     *
     * print_r(json_decode($html->build()));
     *
     * or;
     *
     * print_r(json_decode($html->toJSON()->title("Name")->max(200)->textbox("name")));
     *
     * or;
     *
     * $html->toJSON();
     * $html->title("Name")->max(200)->textbox("name");
     * $html->title("Email")->max(100)->textbox("email");
     *
     * print_r(json_encode($html->build()));
     *
     * @return html
     */
    public function toJSON()
    {
        $this->output_type = "json";

        return $this;
    }

    /**
     * Convert template code to text / data from DB
     *
     * @param string $text
     * @param integer $data_index Number rows of data fetch from DB
     * @return string
     */
    public function tpl_code_to_text($text, $data_index = null)
    {
        if (!is_null($data_index)) {
            $data_index = (int) $data_index;
        }

        preg_match_all("/\{\{(.*?)\}\}/si", $text, $reg);
        if (isset($reg[1]) && count($reg[1]) > 0) {
            foreach ($reg[1] as $k => $v) {
                $v = trim($v);
                if (isset($this->dataset[$data_index]) && is_object($this->dataset[$data_index])) {
                    if (is_null($data_index)) {
                        $text = str_replace($reg[0][$k], $this->dataset->$v, $text);
                    } else {
                        $text = str_replace($reg[0][$k], $this->dataset[$data_index]->$v, $text);
                    }
                } else {
                    if (is_null($data_index)) {
                        $text = str_replace($reg[0][$k], (isset($this->dataset[$v]) ? $this->dataset[$v] : ""), $text);
                    } else {
                        $text = str_replace($reg[0][$k], (isset($this->dataset[$data_index][$v]) ? $this->dataset[$data_index][$v] : ""), $text);
                    }
                }
            }
        }

        unset($reg);
        return $text;
    }

    public function resources($type, $url)
    {

    }

    /**
     * Make it using standalone environment.  All settings not affect others same build() form elements.
     * e.g:  $a = new html();
     *
     * $b->build(function() use (&$b){
     *     $b->use($a)->title("AAA")->size(100)->placeholder("AAA")->textbox("aaa");  //output: AAA <input type="text" name="aaa" placeholder="AAA">
     *     $b->use($a)->title("BBB")->textbox("bbb"); // above element, size and placeholder not affect to this.  output: BBB <input type="text" name="bbb">
     * });
     *
     *
     * @param object $object
     * @return html
     */
    function use ($object) {
        $this->is_use = false;

        if (is_object($object)) {
            $object->parent_this = $this;
            return clone $object;
        }

        return $object;
    }

    /**
     * Set form element's default value.  e.g:  <input type="text" value="aaa">
     *
     * @param string $value
     * @return html
     */
    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Display data value only (without form element.  e.g:  textbox, checkbox)
     * @return html
     */
    public function value_only()
    {
        $this->display_value_only = true;

        return $this;
    }

    public function with($html_tag_name)
    {
        $args = func_get_args();
        $args = array_shift($args);

        return call_user_func_array(array($this, $html_tag_name), $args);
    }

    #########################################

    /**
     * Build HTML INPUT ELEMENTS from JSON
     *
     */
    private function build_from_json()
    {
        // JSON is valid
        if (isset($this->json) && is_array($this->json) && count($this->json) > 0) {
            foreach ($this->json as $v) {
                $this->build_from_json_render($v);
            }
        } else {
            $this->build_from_json_render($this->json);
        }
    }

    /**
     * Rendering HTML INPUT ELEMENTS
     *
     */
    private function build_from_json_render($attrs)
    {
        $_            = $this->use($this);
        $display_only = false;

        if (isset($this->alter) && is_array($this->alter) && count($this->alter) > 0) {
            foreach ($this->alter as $k => $v) {
                if ($k == $attrs->name) {
                    if (isset($v) && is_array($v) && count($v) > 0) {
                        foreach ($v as $alter_k => $alter_v) {
                            if ($alter_k == "value_only") {
                                if ((bool) $alter_v) {
                                    $display_only = true;
                                    $_->value_only();
                                }
                            }

                            if ($alter_k == "text") {
                                $alter_v = $this->tpl_code_to_text($alter_v);
                            }

                            if (isset($attrs->$alter_k)) {
                                $attrs->$alter_k = $alter_v;
                            } else {
                                $attrs->$alter_k = $alter_v;
                            }
                        }
                    }
                    break;
                }
            }
        }

        if (isset($attrs->attr)) {
            $_->attr((array) $attrs->attr);
        }

        if (isset($attrs->class)) {
            $_->attr((array) $attrs->class);
        }

        if (isset($attrs->data)) {
            $_->data((array) $attrs->data);
        }

        if (isset($attrs->label)) {
            $_->label($attrs->label);
        }

        if (isset($attrs->max)) {
            $_->max($attrs->max);
        }

        if (isset($attrs->maxlength)) {
            $_->maxlength($attrs->maxlength);
        }

        if (!isset($attrs->optional)) {
            $attrs->optional = false;
        }

        if (isset($attrs->param)) {
            $_->param((array) $attrs->param);
        }

        if (isset($attrs->placeholder)) {
            $_->placeholder($attrs->placeholder);
        }

        if (isset($attrs->prepend)) {
            if (strpos($attrs->input, "_input_group") === false) {
                $_->prepend($attrs->prepend);
            }
        }

        if (isset($attrs->size)) {
            $_->size($attrs->size);
        }

        if (isset($attrs->title)) {
            $_->title($attrs->title);
        }

        if (isset($attrs->text)) {
            $_->text($attrs->text);
        }

        if (isset($attrs->value)) {
            $_->value($attrs->value);
        }

        if (!$display_only) {
            if (isset($attrs->input)) {
                $input = $attrs->input;

                if (isset($attrs->db_sql)) {
                    if (!flayer::exists("fdo")) {
                        error("honwei189\\fdo is not loaded.", "example:<br><br>\$app = new honwei189\\flayer;<br>\$app->bind(\"honwei189\\fdo\\fdo\");
                        <br>\$app->fdo()->connect(honwei189\config::get(\"database\", \"mysql\"));");
                    } else {
                        $this->db = flayer::fdo();

                        if (is_object($this->db)) {
                            $_->data($this->db->query($attrs->db_sql));
                        }
                    }
                }

                switch ($input) {
                    case "custom":
                        $_->custom($attrs->name, (isset($attrs->default) ? $attrs->default : null), (array) $attrs->param);
                        break;

                    case "select":
                        $_->select($attrs->name, (isset($attrs->default) ? $attrs->default : null), $attrs->optional);
                        break;

                    default:
                        if (strpos($input, "_input_group") !== false) {
                            $_->$input($attrs->name, (isset($attrs->default) ? $attrs->default : null), (isset($attrs->prepend->after) ? preg_replace("/<\/div>$/si", "", $attrs->prepend->after) : ""));
                        } else {
                            $_->$input($attrs->name, (isset($attrs->default) ? $attrs->default : null));
                        }
                        break;
                }
            }
        }
    }

    /**
     * Build form element's attributes
     *
     * @param string $name Name of form element.  e.g:  $html->textbox("aaa");
     * @return html
     */
    private function build_obj_attr($name = null)
    {
        $attrs  = [];
        $class  = [];
        $params = [];

        $obj = str_replace("html::", "", $this->object);

        if (isset($this->param['attr']) && is_value($this->preset->$obj->attr)) {
            if (isset($this->preset->$obj->attr)) {
                $this->param['attr'] = trim($this->preset->$obj->attr . " " . $this->param['attr']);
            } else {
                $this->param['attr'] = trim($this->param['attr']);
            }

        } else if (isset($this->preset->$obj->attr) && is_value($this->preset->$obj->attr)) {
            $this->param['attr'] = trim($this->preset->$obj->attr);
        }

        if (isset($this->param['class']) && is_value($this->param['class'])) {
            if (isset($this->preset->$obj->class)) {
                $this->param['class'] = trim($this->preset->$obj->class . " " . $this->param['class']);
            } else {
                // $this->preset->$obj->class = null;
                $this->param['class'] = trim($this->param['class']);
            }
        } else if (isset($this->preset->$obj->class) && is_value($this->preset->$obj->class)) {
            $this->param['class'] = trim($this->preset->$obj->class);
        }

        if (isset($this->param['class'])) {
            $this->param['class'] = implode(" ", array_unique(explode(" ", $this->param['class'])));

            if ($this->html_style == "bootstrap") {
                if (strpos($this->param['class'], "form-control") !== false) {
                    $this->param['class'] = $this->param['class'];
                } else {
                    switch ($obj) {
                        case "button":
                        case "checkbox":
                        case "radio":
                        case "reset":
                        case "select":
                        case "submit":
                            break;

                        default:
                            $this->param['class'] = "form-control " . $this->param['class'];
                            break;
                    }
                }

                $this->param['class'] = trim(str_unique($this->param['class']));}
        } else {
            if ($this->html_style == "bootstrap") {
                switch ($obj) {
                    case "button":
                    case "checkbox":
                    case "radio":
                    case "reset":
                    case "select":
                    case "submit":
                        break;

                    default:
                        $this->param['class'] = "form-control";
                        break;
                }
            }
        }

        // if ($this->html_style == "bootstrap") {
        //     if (isset($this->param['class'])) {
        //         if (strpos($this->param['class'], "form-control") !== false) {
        //             $this->param['class'] = $this->param['class'];
        //         } else {
        //             $this->param['class'] = "form-control " . $this->param['class'];
        //         }
        //     } else {
        //         $this->param['class'] = "form-control";
        //     }

        //     $this->param['class'] = trim(str_unique($this->param['class']));
        // }

        if (is_array($this->attr) && count($this->attr) > 0) {
            foreach ($this->attr as $k => $v) {
                if (is_value($v)) {
                    $attrs[] = " " . $v;
                }
            }
        } else {
            if (!is_array($this->attr) && is_value($this->attr)) {
                $attrs[] = $this->attr;
            }
        }

        if (is_array($this->class) && count($this->class) > 0) {
            foreach ($this->class as $v) {
                $class[] = "$v";
            }

            $class = join(" ", $class);
        } else {
            if (!is_array($this->class) && is_value($this->class)) {
                $class = $this->class;
            } else {
                $class = "";
            }
        }

        if (is_value($class)) {
            if (isset($this->param['class'])) {
                $this->param['class'] = "$class " . $this->param['class'];
            } else {
                $this->param['class'] = $class;
            }

            $class = "";
        }

        if (is_array($this->param) && count($this->param) > 0) {
            foreach ($this->param as $k => $v) {
                $params[] = " $k=\"$v\"";
            }
        } else {
            if (!is_array($this->param) && is_value($this->param)) {
                $params[] = $this->param;
            }
        }

        // $this->attr  = null;
        // $this->class = null;
        // $this->param = null;

        return
        (is_string($name) && is_value($name) ? " name=\"$name\"" : "") . "" .
        (\is_value($this->placeholder) ? " placeholder=\"" . $this->placeholder . "\"" : "") .
        join("", $params) .
        join("", $attrs);
    }

    /**
     * Rendering / generate form element.  output:  <input type="text" name="aaa">
     *
     * @param string $name Name of form element.  e.g:  $html->textbox("aaa");
     * @param string $obj HTML object
     * @return html
     */
    private function build_render($name, $obj)
    {
        $this->name = $name;

        if ($this->output_type == "json") {
            return $obj;
        }

        $input_obj = str_replace("html::", "", $this->object);

        if ($input_obj == "custom" || $input_obj == "hidden") {
            if ($this->build) {
                unset($input_obj);
                echo $obj;
                return;
            } else {
                unset($input_obj);
                return $obj;
            }
        }

        if ($this->html_style == "bootstrap") {
            $tpl = $this->html_template;

            if (!is_value($this->title)) {
                $tpl = preg_replace("#<label.*?>([^<]+)</label>\n#", "", $tpl);
            } else {
                $tpl = str_replace("{{ title }}", $this->title, $tpl);
            }

            if ($input_obj == "checkbox" && $this->display_value_only) {
                if (strpos($this->prepend['before'], "<li") !== false) {
                    $obj = "<ol>$obj</ol>";
                }

                // $this->prepend = ["before" => "", "after" => ""];
            }

            if (strpos($input_obj, "_input_group") !== false) {
                $obj = $this->prepend['before'] . $obj . $this->prepend['after'];
                // $this->prepend = ["before" => "", "after" => ""];
            }

            if (is_value($this->style_class)) {
                $tpl = str_replace("{{ style_class }}", $this->style_class, $tpl);
            } else {
                $tpl = str_replace(" class=\"{{ style_class }}\"", "", $tpl);
            }

            if (is_value($this->style_id)) {
                $tpl = str_replace("{{ id }}", $this->style_id, $tpl);
            } else {
                $tpl = str_replace(" id=\"{{ id }}\"", "", $tpl);
            }

            $tpl = str_replace("{{ input_name }}", $name, $tpl);
            $tpl = str_replace("{{ input }}", ($this->display_value_only ? $this->div((!is_value($obj) ? "&nbsp;" : $obj)) : $obj), $tpl);

            $this->title = null;

            // if ($this->object != "radio") {
            //     $tpl = $this->prepend['before'] . $tpl . $this->prepend['after'];
            // }

            unset($input_obj);

            if ($this->build) {
                echo $tpl;
            } else {
                return $tpl;
            }
        } else {
            $this->title = null;

            if ($input_obj != "radio") {
                $obj = $this->prepend['before'] . $obj . $this->prepend['after'];
            } else if ($input_obj == "checkbox" && $this->display_value_only) {
                if (strpos($this->prepend['before'], "<li") !== false) {
                    $obj = "<ol>$obj</ol>";
                }

                // $this->prepend = ["before" => "", "after" => ""];
            }

            unset($input_obj);

            if ($this->build) {
                echo $obj;
            } else {
                return $obj;
            }
        }
    }

    /**
     * Return as JSON, return as HTML INPUT ELEMENTS (e.g: <input type="text" name="abc"> ) or render / print the HTML INPUT ELEMENTS directly
     * @param mixed $obj
     * @return mixed
     */
    private function output_as($obj)
    {
        if ($this->output_type == "array" || $this->output_type == "json") {
            $_               = new \stdClass;
            $_->attr         = $this->attr;
            $_->data         = $this->data;
            $_->db_type_name = "";
            $_->db_sql       = "";
            $_->id           = $this->object_id;
            $_->input        = str_replace("html::", "", $this->object);
            $_->label        = $this->label;
            $_->maxlength    = $this->maxlength;
            $_->name         = $this->name;
            $_->param        = $this->param;
            $_->optional     = "";
            $_->prepend      = $this->prepend;
            $_->size         = $this->size;
            $_->text         = $this->text;
            $_->title        = $this->title;
            $_->value        = $this->value;

            // $_->class = $this->class;

            if (isset($_->param['size'])) {
                unset($_->param['size']);
            }

            if (isset($_->param['maxlength'])) {
                unset($_->param['maxlength']);
            }

            if (isset($_->param['placeholder'])) {
                unset($_->param['placeholder']);
            }

            if (isset($_->param['value'])) {
                unset($_->param['value']);
            }

            if (!is_null($this->parent_this)) {
                $this->parent_this->json[] = $_;
            } else {
                $this->json[] = $_;
            }

            unset($_);

            $this->reset_element();
            if ($this->output_type == "json") {
                return json_encode(end($this->json));
            } else {
                return end($this->json);
            }
        } else {
            $this->reset_element();
            return $obj;
        }
    }

    /**
     * Clear / Reset HTML input elements parameters
     *
     * @return html
     */
    private function reset_element()
    {
        $this->alter       = null;
        $this->attr        = [];
        $this->class       = [];
        $this->data        = null;
        $this->label       = null;
        $this->maxlength   = null;
        $this->name        = null;
        $this->object_id   = null;
        $this->param       = [];
        $this->placeholder = null;
        $this->prepend     = ["before" => "", "after" => ""];
        $this->style_class = null;
        $this->style_id    = null;
        $this->size        = null;
        $this->title       = null;

        return $this;
    }
}

function html()
{
    return (new \honwei189\html\html);
}
