<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 14/10/2019 19:05:08
 * @last modified     : 23/12/2019 21:33:58
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 *
 * Generate HTML DIV
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
trait div
{
    /**
     * Render DIV
     *
     * @param string $text Text contents
     * @param array $attrs <div> attributes.  e.g:  class, id
     * @return string
     */
    public function div($text, $attrs = null)
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

        return "<div$options>$text</div>";
    }
}
