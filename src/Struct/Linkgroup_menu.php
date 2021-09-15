<?php
/**
 * Created       : 2021-09-14 09:47:17 am
 * Author        : Gordon Lim
 * Last Modified : 2021-09-14 09:52:03 am
 * Modified By   : Gordon Lim
 * ---------
 * Changelog
 *
 * Date & time           By                    Version   Comments
 * -------------------   -------------------   -------   ---------------------------------------------------------
 *
 */

namespace honwei189\Html\Struct;

/**
 *
 * Hyperlink group menu type structure for column (td)
 *
 *
 * @package     Html
 * @subpackage  link/datalink
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0"
 * @since       "1.0.0"
 */
class Linkgroup_menu
{
    public $links;

    /**
     * Hyperlink group set
     *
     * e.g:
     *
     * new Linkgroup_menu(
     *     new link("/edit?id={{ id }}", "Edit"),
     *     new link("/delete?id={{ id }}", "Delete")
     * );
     *
     * or;
     *
     * new Linkgroup_menu(
     *     [
     *         new link("/edit?id={{ id }}", "Edit"),
     *         new link("/delete?id={{ id }}", "Delete")
     *     ]
     * );
     *
     * @param Link|Linkgroup $links
     * @return Linkgroup_menu
     */
    public function __construct($links = null)
    {
        if (is_null($links) || is_object($links)) {
            $args = func_get_args();
            foreach ($args as $index => $arg) {
                $this->links[] = $arg;
            }

            unset($args);
            return $this->links;
        } else if (is_array($links)) {
            return $this->links = $links;
        }
    }
}
