<?php
/**
 * Created       : 2019-10-18 10:18:36 pm
 * Author        : Gordon Lim
 * Last Modified : 2021-09-14 09:51:29 am
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
 * Hyperlink declaration.  This is html()->datalink() data structure.
 * 
 * Declare hyperlink type structure for column (td)
 *
 *
 * @package     Html
 * @subpackage  link/datalink
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @version     "1.0.0"
 * @since       "1.0.0"
 */
class Link
{
    public $attrs;
    public $keyvalue;
    public $url;

    /**
     * Declare datalink
     *
     * @param string|null $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param string|null $data_name_or_value Data name (from DB)  e.g: $data_name = "abc"  //map to $db_data['abc']
     * @param array|null $attrs hyperlink attributes.  e.g:  class, id
     * @return Link
     */
    public function __construct(?string $url = null, ?string $data_name_or_value = null, ?string $attrs = null)
    {
        $this->url      = $url;
        $this->keyvalue = $data_name_or_value;
        $this->attrs    = $attrs;

        return $this;
    }
}
