<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 14/10/2019 19:05:08
 * @last modified     : 20/04/2020 16:41:53
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\Html\Components;

/**
 *
 * Generate HTML DIV
 *
 *
 * @package     Html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0"
 * @since       "1.0.0"
 */
trait DivTrait
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

        if (!is_string($text) && is_callable($text)) {
            ob_start();
            echo $text();
            $text = ob_get_contents();
            ob_end_clean();
        }

        return "<div$options>$text</div>";
    }
}
