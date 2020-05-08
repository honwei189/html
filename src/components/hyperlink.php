<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 18/10/2019 20:57:02
 * @last modified     : 22/04/2020 15:13:03
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 *
 * Link action
 *
 *
 * @package     html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0" 
 * @since       "1.0.0" 
 */
trait hyperlink
{
    /**
     * Build hyperlink with DB data.   e.g:  <a href="url">DB_DATA_VALUE</a>
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param integer $data_index Data row number.  Set null if not get from dataset of the dataset is single dimension
     * @param string $data_name Data name (from DB.  Set as empty string if not get from dataset)  e.g: $data_name = "abc"  //map to $db_data['abc']
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return string
     */
    public function datalink($url, $data_index = null, $data_name = "", $attrs = null)
    {
        if (is_array($attrs)) {
            foreach ($attrs as $k => $v) {
                $attrs[$k] = $this->tpl_code_to_text($v, $data_index);
            }
        }

        $data_index = (int) $data_index;
        $html       = html();
        $html->param($attrs);

        $url = $this->tpl_code_to_text($url, $data_index);

        if (is_object($this->dataset[$data_index])) {
            $value = (is_value($this->dataset[$data_index]->$data_name) ? $this->dataset[$data_index]->$data_name : $data_name);
        } else {
            $value = (isset($this->dataset[$data_index][$data_name]) ? $this->dataset[$data_index][$data_name] : $data_name);
        }

        $html->param($this->attrs);

        return "<a href=\"$url\"" . $html->build_obj_attr() . ">" . $value . "</a>";
    }

    /**
     * Build icon hyperlink.   e.g:  <a href="url"><i class="icon"></i></a>
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param integer $data_index Data row number.  Set null if not get from dataset or the dataset is single dimension
     * @param string $name Icon tooltips title
     * @param string $icon Icon css class
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return string
     */
    public function iconlink($url, $data_index = null, $name, $icon, $attrs = null)
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

        $url = $this->tpl_code_to_text($url, $data_index);
        return $this->link($url, "<i class=\"$icon\" title=\"$name\"$options></i>", $attrs);
    }

    /**
     * Build round icon hyperlink.   e.g:  <a href="url"><i class="icon"></i></a>
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param integer $data_index Data row number.  Set null if not get from dataset or the dataset is single dimension
     * @param string $name Icon tooltips title
     * @param string $icon Icon css class
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return string
     */
    public function round_iconlink($url, $data_index = null, $name, $icon, $attrs = null)
    {
        // $this->param($attrs);
        // return $this->link($url, "<i class=\"$icon\" title=\"$name\"></i>");

        $url            = $this->tpl_code_to_text($url, $data_index);
        $attrs          = (object) $attrs;
        $attrs->title   = $name;
        $attrs->class   = "btn btn-default btn-icon btn-simple btn-icon-mini btn-circle" . (is_value($attrs->class) ? " {$attrs->class}" : "");
        $attrs->onclick = "location.href='$url';";

        return $this->button("", $this->icon($icon), (array) $attrs);
        // return html()->button("", html()->icon($icon), (array) $attrs);
    }

    /**
     * Alias of link()
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param string $value Data name (from DB)  e.g: $data_name = "abc"  //map to $db_data['abc']
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return string
     */
    public function textlink($url, $value, $attrs = null)
    {
        return $this->link($url, $value, $attrs);
    }

    /**
     * Build data type hyperlink with title and icon.  e.g:  <i class="icon"></i> <a href="url">Name</a>
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param integer $data_index Data row number.  Set null if not get from dataset or the dataset is single dimension
     * @param string $name Icon tooltips title
     * @param string $icon Icon css class
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return string
     */
    public function text_iconlink($url, $data_index = null, $name, $icon, $attrs = null)
    {
        return $this->datalink(
            $url,
            $data_index,
            $this->div(
                $this->div(
                    $this->i("", [
                        "class" => $icon,
                        "title" => $name,
                        "style" => "width: 20px !important;",
                    ]
                    ),
                    [
                        // "style" => "width: 20px !important; display:table-cell; vertical-align:middle;",
                        "style" => "width: 20% !important; float:left;"
                    ]
                ) .
                $this->div(
                    $name,
                    [
                        // "style" => "display:table-cell; vertical-align:middle;",
                        "style" => "width: 80% !important;",
                    ]
                )
            , ["class" => ""]),
            $attrs);
    }

    /**
     * Build hyperlink.   e.g:  <a href="url">Title</a>
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param string $value Data name (from DB)  e.g: $data_name = "abc"  //map to $db_data['abc']
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return string
     */
    public function link($url, $value, $attrs = null)
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

        $url = preg_replace("/\{\{(.*?)\}\}/si", "", $url);
        return "<a href=\"$url\"$options>$value</a>";
    }
}
