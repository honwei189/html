<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 14/10/2019 19:05:26
 * @last modified     : 24/12/2019 22:52:58
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
 * @link        https://appsw.dev
 * @link        https://justtest.app
 * @version     "1.0.1"
 * @since       "1.0.1"
 */
class table extends html
{
    private $allow_table_over_width          = false;
    private $auto_typesetting_over_width_col = false;
    private $cols                            = [];
    private $current_dataset_idx             = 0;
    private $hide_over_width_col             = false;
    private $screen_size                     = 842;
    private $screen_size_type                = "px";
    private $output                          = true;
    private $table_class                     = "table";
    private $table_id                        = "";
    private $table_responsive                = false;
    private $table_height                    = 100;
    private $table_tr_class                  = null;
    private $table_tr_id                     = false;
    private $table_tr_id_format              = "";
    private $table_width                     = 99.8;
    private $width                           = [];

    public function __construct()
    {}

    public function __destruct()
    {
        $this->allow_table_over_width          = false;
        $this->auto_typesetting_over_width_col = false;
        $this->cols                            = [];
        $this->current_dataset_idx             = 0;
        $this->hide_over_width_col             = false;
        $this->screen_size                     = 842;
        $this->screen_size_type                = "px";
        $this->output                          = true;
        $this->table_class                     = "";
        $this->table_id                        = "";
        $this->table_responsive                = false;
        $this->table_height                    = 100;
        $this->table_tr_class                  = false;
        $this->table_tr_id                     = false;
        $this->table_tr_id_format              = "";
        $this->table_width                     = 99.8;
        $this->width                           = [];
    }

    /**
     * Allow or disallow table width over screen size 100%.
     *
     * If $bool = true, will set default to "table-responsive"
     *
     * @param boolean $bool
     * @return table
     */
    public function allow_overwidth($bool = true)
    {
        $this->allow_table_over_width = $bool;
        $this->table_responsive       = $bool;
        return $this;
    }

    /**
     * Enable / disable auto ajust and reposition over width table columns
     *
     * @param bool $bool
     * @return table
     */
    public function auto_typesetting_over_width_col($bool = true)
    {
        $this->auto_typesetting_over_width_col = $bool;
        $this->allow_table_over_width          = !$bool;
        $this->hide_over_width_col             = !$bool;
        $this->table_responsive                = !$bool;
        return $this;
    }

    /**
     * Set css class for table
     *
     * @param string $css_class
     * @return table
     */
    function class ($css_class)
    {
        $this->table_class = $css_class;

        return $this;
    }

    /**
     * Declare table column (td)
     *
     * @param string $title Column name
     * @param string $data_name Data name (from DB)  e.g: $data_name = "abc"  //map to $db_data['abc']
     * @param array $attr Table column's (td) attributes e.g:  [id="abc", "class" => "abc", "size" => "20"]
     * @param array $options
     * @return table
     */
    public function cols($title_name, $data_name = null, $attr = null, $options = null)
    {
        $i                         = (int) count($this->cols) + 1;
        $this->cols[$i]->title     = $title_name;
        $this->cols[$i]->data_name = $data_name;
        $this->cols[$i]->attr      = $attr;
        $this->cols[$i]->options   = $options;

        if (is_array($attr)) {
            $this->cols[$i]->width = $this->parse_col_width($attr);
        } else {
            $this->cols[$i]->width = 0;
        }

        $this->width[] = $this->cols[$i]->width;
        return $this;
    }

    /**
     * Group set.  Define all table columns together
     *
     * Structure :
     *
     * col {
     *     string   title;
     *     string   data_name;
     *     array    attr;
     *     mixed    options;
     *     integer  width = 0;
     * }
     *
     * $table->colgroup([
     *     new class extends col
     *     {
     *        var $title     = "No.";
     *        var $data_name = "seq";
     *        var $attr      = [
     *            "width" => "5%",
     *            "class" => "nosort",
     *        ];
     *        var $width = 5;
     *     },
     *     new col("Company name", "name"),
     *     (new col("Reg. No", "reg_no"))->width(10),
     *     new col("Branch", "branch_name", ["width" => "10%"]),
     *     new col("Folder owner", "fol_owner", ["width" => "25%"]),
     *     new col("Company status", "active_stat", ["width" => "10%"]),
     *     new col("Actions", "action", ["width" => "8%"]),
     * ]);
     *
     * $table->print();
     *
     * @param col $col col() object
     * @return table
     */
    public function colgroup($col)
    {
        if (is_array($col)) {
            foreach ($col as $v) {
                if (is_array($v->attr)) {
                    $v->width = $this->parse_col_width($v->attr);
                } else {
                    $v->width = 0;
                }

                $this->cols[]  = $v;
                $this->width[] = $v->width;
            }
        }

        return $this;
    }

    /**
     * Data from DB and generate and print out <tbody><tr></tr></tbody>
     *
     * @param array|object $data
     * @return table
     */
    public function dataset($data)
    {
        parent::dataset($data);
        // $this->data = $data;
        return $this;
    }

    /**
     * Set table height.  Default is "%", but can self-defined.  e.g:  $height = "90vh"
     *
     * Applicable for using allow_overwidth() and table-responsive
     *
     * @param integer|string $height
     * @return table
     */
    public function height($height)
    {
        $this->table_height = $height;

        return $this;
    }

    /**
     * Enable / disable hide over width (total printed columns 100%) column
     *
     * @param boolean $bool
     * @return table
     */
    public function hide_over_width_col($bool)
    {
        $this->hide_over_width_col = $bool;

        return $this;
    }

    /**
     * Set id for table
     *
     * @param string $id
     * @return table
     */
    public function id($id)
    {
        $this->table_id = $id;

        return $this;
    }

    /**
     * Generate / rendering table
     *
     * @return table
     */
    function print() {
        $displayed_cols = [];
        $hidden_cols    = [];
        $total_width    = array_sum($this->width);

        if ($total_width < 100) {
            $width = $this->table_width;
        }

        if ($this->hide_over_width_col) {
            $width = $this->table_width;
        } else {
            if ($this->allow_table_over_width) {
                if ($total_width > 100) {
                    $width = $total_width;
                }
            } else {
                $width = $this->table_width;
            }
        }

        if ($this->auto_typesetting_over_width_col) {
            $width = $this->table_width;
        }

        if ($this->table_responsive) {
            $this->output($this->css("
                @media (max-width: 767px) {
                    .table-responsive{
                        overflow-x: auto;
                        overflow-y: auto;
                    }
                }
                @media (min-width: 767px) {
                    .table-responsive{
                        overflow: inherit !important; /* Sometimes needs !important */
                    }
                }

                // .table-responsive .dropdown-menu {
                //     position: relative;
                // }

                table > .dropdown-menu {
                    position: absolute;
                }
            "));

            $this->output("<div class=\"table-responsive\" style=\"overflow:auto !important; height: " . (is_numeric($this->table_height) ? $this->table_height . "%" : $this->table_height) . " !important;\">");
        }

        $this->output("\n\t<table " . (is_value($this->table_id) ? "id=\"" . $this->table_id . "\" " : "") . "class=\"" . $this->table_class . "\" style=\"" . ($this->allow_table_over_width ? "width: auto !important; min-" : "") . "width: $width%;\" cellpadding=\"0\" cellspacing=\"0\">\n\t\t<colgroup>");

        $total_width = 0;
        foreach ($this->cols as $v) {
            $attr = "";
            $total_width += $v->width;
            $skip = false;

            if (!$this->allow_table_over_width && $this->hide_over_width_col && $total_width > 100) {
                $skip = true;
            }

            if ($this->auto_typesetting_over_width_col && $total_width > 100) {
                $skip = true;
            }

            if (is_object($v->data_name)) {
                $action_name = substr(strrchr(get_class($v->data_name), "\\"), 1);

                if ($action_name == "linkgroup" || $action_name == "linkgroup_menu") {
                    $skip = false;
                }
            }

            if (!$skip) {
                if (is_array($v->attr)) {
                    foreach ($v->attr as $attr_k => $attr_v) {
                        if ($attr_k == "width") {
                            if (isset($v->attr['style'])) {
                                // echo preg_replace("/width(:| :| : |: )([0-9]{0,5})[%|px]/si", "width: $attr_v", $v->attr['style']);

                                if (!contains($v->attr['style'], "width")) {
                                    if (is_int($attr_v)) {
                                        $attr_v .= "%";
                                    }

                                    $attr .= " style=\"width: $attr_v;\"";
                                }
                            } else {
                                if (is_int($attr_v)) {
                                    $attr_v .= "%";
                                }

                                $attr .= " style=\"width: $attr_v;\"";
                            }
                        }
                    }
                }

                if (isset($v->attr['type']) && $v->attr['type'] == "longtext") {
                    $hidden_cols[] = $v;
                } else {
                    $this->output("\n\t\t\t<col$attr>");
                    $displayed_cols[] = $v;
                }
            } else {
                $hidden_cols[] = $v;
            }
        }

        $this->output("\n\t\t</colgroup>");

        $this->output("\n\t\t<thead>");

        $this->output("\n\t\t\t<tr>");
        $total_width = 0;
        foreach ($displayed_cols as $v) {
            $attr = "";
            if (is_array($v->attr)) {
                foreach ($v->attr as $attr_k => $attr_v) {
                    if ($attr_k != "width") {
                        $attr .= " $attr_k=\"$attr_v\"";
                    }
                }
            }
            $this->output("\n\t\t\t\t<td$attr>" . $v->title . "</td>");

        }
        $this->output("\n\t\t\t</tr>");
        $this->output("\n\t\t</thead>");

        $this->output("\n\t\t<tbody>");

        $total_displayed_col = count($displayed_cols);

        foreach ($this->dataset as $k => $v) {
            $this->output("\n\t\t\t<tr" . ($this->table_tr_id ? " id=\"" . $this->get_table_tr_id($k) . "\"" : "") . ($this->table_tr_class ? " class=\"" . $this->get_table_tr_class($k) . "\"" : "") . ">");
            foreach ($displayed_cols as $col) {
                $attr = "";
                if (is_array($col->attr)) {
                    foreach ($col->attr as $attr_k => $attr_v) {
                        if ($attr_k != "width") {
                            $attr .= " $attr_k=\"" . $this->tpl_code_to_text($attr_v, $k) . "\"";
                        }
                    }
                }

                $value = trim($this->col_data_process($k, $v, $col));
                $this->output("\n\t\t\t\t<td$attr>" . $value . "</td>");
            }

            $this->output("\n\t\t\t</tr>");

            if ($this->auto_typesetting_over_width_col) {
                for ($i = 0; $max = count($hidden_cols), $i < $max; $i++) {
                    $this->output("\n\t\t\t<tr" . ($this->table_tr_id ? " id=\"" . $this->get_table_tr_id($k) . "\"" : "") . ($this->table_tr_class ? " class=\"" . $this->get_table_tr_class($k) . "\"" : "") . ">");

                    // if (is_object($hidden_cols[$i]->data_name)) {
                    //     $action_name = substr(strrchr(get_class($hidden_cols[$i]->data_name), "\\"), 1);

                    //     if ($action_name == "link") {
                    //         $value = $this->datalink($hidden_cols[$i]->data_name->url, $k, $hidden_cols[$i]->data_name->keyvalue);
                    //     } else if ($action_name == "linkgroup" || $action_name == "linkgroup_menu") {
                    //         $value = "";
                    //     } else {
                    //         $value = "";
                    //     }
                    //     // $value = $hidden_cols[$i]->data_name();
                    // } else {
                    //     if (is_object($v)) {
                    //         $data_name = $hidden_cols[$i]->data_name;
                    //         $value     = (is_value($v->$data_name) ? $v->$data_name : "");
                    //         unset($data_name);
                    //     } else {
                    //         $value = (isset($v[$hidden_cols[$i]->data_name]) ? $v[$hidden_cols[$i]->data_name] : "");
                    //     }
                    // }

                    // $value = trim(nl2br($value));

                    $attr = " style=\"border-top: none;\"";
                    if (is_array($hidden_cols[$i]->attr)) {
                        foreach ($hidden_cols[$i]->attr as $attr_k => $attr_v) {
                            if ($attr_k != "width") {
                                if ($attr_k == "style") {
                                    $attr .= " $attr_k=\"border-top: none; $attr_v\"";
                                } else {
                                    $attr .= " $attr_k=\"$attr_v\"";
                                }
                            }
                        }
                    }

                    $value = trim($this->col_data_process($k, $v, $hidden_cols[$i]));

                    if (in_array("display_if_value_exists", $hidden_cols[$i]->attr)) {
                        if (is_value($value)) {
                            $this->output("\n\t\t\t\t<td colspan=\"" . $total_displayed_col . "\"$attr>" . $this->div($this->div("<b>" . $hidden_cols[$i]->title . "</b> : ", ["class" => "col-sm-1 text-right"]) . $this->div($value, ["class" => "col-sm-11"]), ["class" => "row"]) . "</td>");
                        }
                    } else {
                        $this->output("\n\t\t\t\t<td colspan=\"" . $total_displayed_col . "\"$attr>" . $this->div($this->div("<b>" . $hidden_cols[$i]->title . "</b> : ", ["class" => "col-sm-1 text-right"]) . $this->div($value, ["class" => "col-sm-11"]), ["class" => "row"]) . "</td>");
                    }

                    $this->output("\n\t\t\t</tr>");
                }
            }
        }

        $this->output("\n\t\t</tbody>");

        $this->output("\n\t</table>" . PHP_EOL);

        if ($this->table_responsive) {
            $this->output("\n</div>" . PHP_EOL);
            // $this->div($output, ["class" => "table-responsive"]);
        }

        $displayed_cols = null;
        $hidden_cols    = null;
        $this->dataset  = [];
    }

    /**
     * To declare tbody's tr with ID
     *
     * @param string $id_format If passing empty, will using default method to generate ID.  If passing as {{ DATASET_KEY_NAME }}, will use dataset[$i][KEY_NAME] value as id
     * @return table
     */
    public function set_table_tr_id($id_format)
    {
        if (is_value($id_format)) {
            $this->table_tr_id = true;
        } else {
            $this->table_tr_id = false;
        }

        $this->table_tr_id_format = $id_format;

        return $this;
    }

    /**
     * To declare tbody's tr with class
     *
     * @param string $css_class
     * @return table
     */
    public function set_tr_class($css_class)
    {
        $this->table_tr_class = $css_class;
    }

    /**
     * Alias of set_table_tr_id($id_format)
     *
     * @param string $id_format
     * @return table
     */
    public function set_tr_id($id_format)
    {
        return $this->set_table_tr_id($id_format);
    }

    public function style()
    {

    }

    public function visible()
    {

    }

    /**
     * Set table width
     *
     * @param integer $width
     * @return table
     */
    public function width($width)
    {
        $this->table_width = (float) $width;

        return $this;
    }

    /**
     * tbody's TD data process.  To display data from dataset
     *
     * @param integer $idx
     * @param array $data
     * @param col $col
     * @return string
     */
    private function col_data_process($idx, $data, $col)
    {
        $value = "";

        $this->current_dataset_idx = $idx;

        if ($col->data_name == "seq") {
            if (is_object($data)) {
                $seq = $col->data_name;
                if ((int) $data->$seq > 0) {
                    return (int) $data->$seq;
                }
            } elseif (is_array($data)) {
                if (isset($col->data) && isset($data[$col->data])) {
                    return $data[$col->data];
                }
            }
            return $idx + 1;
        }

        if (is_object($col->data_name)) {
            if (get_class($col->data_name) == "Closure") {
                $return_func     = $col->data_name;
                $_col            = clone $col;
                $_col->data_name = $return_func($data);
                unset($return_func);

                if (is_string($_col->data_name)) {
                    return $_col->data_name;
                } else {
                    // return $this->col_obj_to_text($_col, $idx);
                    return $this->col_data_process($idx, $data, $_col);
                }
            } else {
                return $this->col_obj_to_text($col, $idx);
            }
        } else if (is_array($col->data_name)) {
            $_ = [];
            foreach ($col->data_name as $v) {
                $_[] = $v;
            }

            $value = "\n\t\t\t\t\t " . join("\n\t\t\t\t\t ", $_) . "\n\t\t\t\t";
            unset($_);
        } else {
            if (is_object($data)) {
                $col_name = $col->data_name;
                $value    = $data->$col_name;
                unset($col_name);
            } else {
                if (isset($data[$col->data_name])) {
                    $is_date = function ($str_dt) {
                        $date = \DateTime::createFromFormat("Y-m-d", $str_dt);
                        return $date && \DateTime::getLastErrors()["warning_count"] == 0 && \DateTime::getLastErrors()["error_count"] == 0;
                    };

                    $is_date_time = function ($str_dt) {
                        $date = \DateTime::createFromFormat("Y-m-d H:i:s", $str_dt);
                        return $date && \DateTime::getLastErrors()["warning_count"] == 0 && \DateTime::getLastErrors()["error_count"] == 0;
                    };

                    if ((bool) $is_date($data[$col->data_name])) {
                        $value = auto_date($data[$col->data_name]);
                    } else if ((bool) $is_date_time($data[$col->data_name])) {
                        $value = date("d/m/Y h:i a", strtotime($data[$col->data_name]));
                    } else if (is_float($data[$col->data_name])) {
                        $value = number_format($data[$col->data_name], 2, ".", ",");
                    } else {
                        $value = $data[$col->data_name];
                    }
                } else {
                    $value = "";
                }
            }

            $value = nl2br($value);
        }

        return $value;
    }

    /**
     * Covert TD's col object (link, iconlink, round_iconlink, text_iconlink, linkgroup, linkgroup_menu) to text
     *
     * @param col $col
     * @param integer $idx
     * @return string
     */
    private function col_obj_to_text(col $col, $idx)
    {
        $action_name = substr(strrchr(get_class($col->data_name), "\\"), 1);
        $value       = "";
        if ($action_name == "") {
            $action_name = get_class($col->data_name);
        }

        switch ($action_name) {
            case "link":
                $value = $this->datalink($col->data_name->url, $idx, $col->data_name->keyvalue);
                break;

            case "iconlink":
            case "round_iconlink":
            case "text_iconlink":
                $value = $this->$action_name(
                    $col->data_name->url,
                    $idx,
                    $col->data_name->name,
                    $col->data_name->icon,
                    $col->data_name->attrs
                );
                break;

            case "linkgroup":
            case "linkgroup_menu":
                $value = "";

                if (is_array($col->data_name->links) && count($col->data_name->links) > 0) {
                    $_                = [];
                    $total_data_count = count($col->data_name->links);

                    for ($i = 0; $i < $total_data_count; ++$i) {
                        $_name = substr(strrchr(get_class($col->data_name->links[$i]), "\\"), 1);
                        if ($_name == "") {
                            $_name = get_class($col->data_name->links[$i]);
                        }

                        switch ($_name) {
                            case "iconlink":
                            case "round_iconlink":
                            case "text_iconlink":
                                $_[] = $this->$_name(
                                    $col->data_name->links[$i]->url,
                                    $idx,
                                    $col->data_name->links[$i]->name,
                                    $col->data_name->links[$i]->icon,
                                    $col->data_name->links[$i]->attrs
                                );
                                break;

                            default:
                                $_[] = $this->datalink(
                                    $col->data_name->links[$i]->url,
                                    $idx,
                                    $col->data_name->links[$i]->keyvalue
                                );
                                break;
                        }
                    }

                    unset($total_data_count);

                    if ($action_name == "linkgroup") {
                        $value = "\n\t\t\t\t\t " . join("\n\t\t\t\t\t ", $_) . "\n\t\t\t\t";
                    } else if ($action_name == "linkgroup_menu") {
                        $value = "\n\t\t\t\t" . $this->button_menu($_, ["menu" => "navbar-left pull-right"]) . "\n\t\t\t\t";

                        // $value = "\n\t\t\t\t\t\t <li>" . join("</li>\n\t\t\t\t\t\t <li>", $_) . "</li>\t\t\t\t";

                        // $btn = "\n\t\t\t\t\t<button data-toggle=\"dropdown\" class=\"btn btn-default dropdown-toggle\" data-boundary=\"window\" aria-expanded=\"false\">";
                        // $btn .= "\n\t\t\t\t\t\t<i class=\"fas fa-ellipsis-v fa-1x\"></i>";
                        // $btn .= "\n\t\t\t\t\t</button>" . PHP_EOL;
                        // $ul = "\t\t\t\t\t<ul class=\"dropdown-menu navbar-left pull-right\">";
                        // $ul .= $value;
                        // $ul .= "\n\t\t\t\t\t</ul>\n\t\t\t\t";
                        // $value = "\n\t\t\t\t" . $this->div($btn . $ul, ["class" => "btn-group"]) . "\n\t\t\t\t";
                    }

                    unset($_);
                }

                unset($_name);
                break;

            default:
                $value = "";
                break;
        }

        return $value;
    }

    /**
     * Generate tr's class
     *
     * @param integer $data_index   Row number (dataset index no.) of data from dataset
     * @return string
     */
    private function get_table_tr_class($data_index = 0)
    {
        if (is_callable($this->table_tr_class)) {
            $fn = $this->table_tr_class;
            return $fn($this->dataset[$data_index]);
        } else if (is_value($this->table_tr_class)) {
            return $this->table_tr_class;
        }
    }

    /**
     * Generate tr's ID
     *
     * @param integer $data_index   Row number (dataset index no.) of data from dataset
     * @return string
     */
    private function get_table_tr_id($data_index = 0)
    {
        if ($this->table_tr_id) {
            if (!is_value($this->table_tr_id_format)) {
                $length    = 20;
                $id_format = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
            } else {
                $id_format = $this->tpl_code_to_text($this->table_tr_id_format, $data_index);
            }

            return $id_format;
        } else {
            return "";
        }
    }

    /**
     * Return or print text to screen
     *
     * @param string $str   Text for return or print
     * @return string
     */
    public function output($str)
    {
        if ($this->output) {
            echo $str;
        } else {
            return $str;
        }
    }

    /**
     * Get width from td attributes
     *
     * @param array $attr
     * @return table
     */
    private function parse_col_width($attr)
    {
        if (is_array($attr)) {
            foreach ($attr as $attr_k => $attr_v) {
                if (is_string($attr_k) && $attr_k == "style") {
                    preg_match_all("/width(:| :| : |: )([0-9]{0,5})%/si", $attr_v, $reg);
                    if (isset($reg[2][0])) {
                        return (int) $reg[2][0];
                    }

                    unset($reg);

                    preg_match_all("/width(:| :| : |: )([0-9]{0,5})px/si", $attr_v, $reg);
                    if (isset($reg[2][0])) {
                        return ((int) $reg[2][0] / $this->screen_size) * 100;
                    }

                    unset($reg);
                } else if (is_string($attr_k) && $attr_k == "width") {
                    return (int) $attr_v;
                }
            }
        }
    }
}

function table()
{
    return new table;
}
