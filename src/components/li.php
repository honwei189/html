<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 21/10/2019 19:00:58
 * @last modified     : 23/12/2019 21:35:10
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 *
 * Generate HTML LI
 *
 *
 * @package     html
 * @subpackage
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0" 
 * @since       "1.0.0" 
 */
trait li
{
    /**
     * Render HTML's LI
     *
     * @param string $text Text contents
     * @param array $attrs <i> attributes.  e.g:  class, id
     * @return string
     */
    public function li($text, $attrs = null)
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

        return "<li$options>$text</li>";
    }

    /**
     * Render HTML's OL
     *
     * @param string $text Text contents
     * @param array $attrs <i> attributes.  e.g:  class, id
     * @return string
     */
    public function ol($text, $attrs = null)
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

        if (is_array($text)) {
            $_ = [];
            foreach ($text as $v) {
                if (strpos($v, "<li") !== false) {
                    $_[] = $v;
                } else {
                    $_[] = $this->li($v);
                }
            }

            $text = join(PHP_EOL, $_);
            unset($_);
        }

        return "<ol$options>$text</ol>";
    }

    /**
     * Render HTML's UL
     *
     * @param string $text Text contents
     * @param array $attrs <i> attributes.  e.g:  class, id
     * @return string
     */
    public function ul($text, $attrs = null)
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

        if (is_array($text)) {
            $_ = [];
            foreach ($text as $v) {
                if (strpos($v, "<li") !== false) {
                    $_[] = $v;
                } else {
                    $_[] = $this->li($v);
                }
            }

            $text = join(PHP_EOL, $_);
            unset($_);
        }

        return "<ul$options>$text</ul>";
    }
}
