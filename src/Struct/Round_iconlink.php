<?php
/**
 * Created       : 2021-09-14 09:47:17 am
 * Author        : Gordon Lim
 * Last Modified : 2021-09-14 09:51:24 am
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
 * Declare round based icon link
 *
 *
 * @package     Html
 * @subpackage  link/datalink
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0"
 * @since       "1.0.0"
 */
class Round_iconlink
{
    public $attrs;
    public $name;
    public $icon;
    public $url;

    /**
     * Declare icon based hyperlink for table
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param string $name Icon Title
     * @param string $icon Icon Icon css class
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return Iconlink
     */
    public function __construct($url = null, $name = null, $icon, $attrs = null)
    {
        $this->url   = $url;
        $this->name  = $name;
        $this->icon  = $icon;
        $this->attrs = $attrs;

        return $this;
    }
}
