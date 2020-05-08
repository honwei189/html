<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 18/10/2019 19:14:05
 * @last modified     : 23/12/2019 21:40:07
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 * Declare table column (td)
 * 
 *
 * @package     html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0" 
 * @since       "1.0.0" 
 */
class col
{
    public $title;
    public $data_name;
    public $attr;
    public $options;
    public $width = 0;

    /**
     * Declare table column (td)
     *
     * @param string $title Column name
     * @param string $data_name Data name (from DB)  e.g: $data_name = "abc"  //map to $db_data['abc']
     * @param array $attr Table column's (td) attributes e.g:  [id="abc", "class" => "abc", "size" => "20"]
     * @param array $options
     * @param integer $width Table column's (td) width.  Default is percentage.  $width = 20 // means 20%
     * @return col
     */
    public function __construct($title_name = null, $data_name = null, $attr = null, $options = null, $width = null)
    {
        if (is_value($title_name)) {
            $this->title = $title_name;
        }

        if (is_value($data_name)) {
            $this->data_name = $data_name;
        }

        if (!is_null($attr)) {
            $this->attr = $attr;
        }

        if (!is_null($options)) {
            $this->options = $options;
        }

        if (!is_null($width)) {
            $this->width = $width;
        }

        return $this;
    }

    /**
     * Define CSS class for col (td)
     *
     * @param string $css_class
     * @return col
     */
    function class ($css_class)
    {
        $this->attr['class'] = $css_class;
        return $this;
    }

    /**
     * Set col (td) style.  e.g output:  <td style="background-Color: #000000;"></td>
     *
     * @param string $style
     * @return col
     */
    public function style($style)
    {
        $this->attr['style'] = $style;

        return $this;
    }

    /**
     * Set col (td) width.  Allows for integer or string.  e.g:  10 or 10% or 100px
     *
     * @param integer|string $length
     * @return col
     */
    public function width($length)
    {
        $this->attr['width'] = $length;
        $this->width         = $length;

        return $this;
    }
}

function col($title_name = null, $data_name = null, $attr = null, $options = null, $width = null){
    return new col($title_name, $data_name, $attr, $options, $width);
}
