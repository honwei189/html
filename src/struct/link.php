<?php
/*
 * @creator           : Gordon Lim <honwei189@gmail.com>
 * @created           : 18/10/2019 22:18:36
 * @last modified     : 23/12/2019 21:40:53
 * @last modified by  : Gordon Lim <honwei189@gmail.com>
 */

namespace honwei189\html;

/**
 *
 * Hyperlink declaration.  This is html()->datalink() data structure
 *
 *
 * @package     html
 * @subpackage  link/datalink
 * @author      Gordon Lim <honwei189@gmail.com>
 * @link        https://github.com/honwei189/html/
 * @link        https://appsw.dev
 * @link        https://justtest.app
 * @version     "1.0.0" 
 * @since       "1.0.0" 
 */

/**
 * Declare hyperlink type structure for column (td)
 */
class link
{
    public $attrs;
    public $keyvalue;
    public $url;

    /**
     * Declare datalink
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param string $data_name_or_value Data name (from DB)  e.g: $data_name = "abc"  //map to $db_data['abc']
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return link
     */
    public function __construct($url = null, $data_name_or_value = null, $attrs = null)
    {
        $this->url      = $url;
        $this->keyvalue = $data_name_or_value;
        $this->attrs    = $attrs;

        return $this;
    }
}

/**
 * Declare icon based hyperlink for column (td)
 */
class iconlink
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
     * @return iconlink
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

/**
 * Declare icon & text hyperlink for table
 */
class text_iconlink
{
    public $attrs;
    public $name;
    public $icon;
    public $url;

    /**
     * Declare datalink
     *
     * @param string $url URL.  If would like to passing db data into URL, use {{ YOUR_DB_TABLE_COLUMN_NAME }} e.g:  abc.php?id={{ id }}
     * @param string $name Icon Title
     * @param string $icon Icon Icon css class
     * @param array $attrs hyperlink attributes.  e.g:  class, id
     * @return iconlink
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

/**
 *
 * Hyperlink group set type structure for column (td)
 */
class linkgroup
{
    public $links;

    /**
     * Hyperlink group set
     *
     * e.g:
     *
     * new linkgroup(
     *     new link("/edit?id={{ id }}", "Edit"),
     *     new link("/delete?id={{ id }}", "Delete")
     * );
     *
     * or;
     *
     * new linkgroup(
     *     [
     *         new link("/edit?id={{ id }}", "Edit"),
     *         new link("/delete?id={{ id }}", "Delete")
     *     ]
     * );
     *
     * @param link|linkgroup $links
     * @return linkgroup
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

/**
 *
 * Hyperlink group menu type structure for column (td)
 */
class linkgroup_menu
{
    public $links;

    /**
     * Hyperlink group set
     *
     * e.g:
     *
     * new linkgroup_menu(
     *     new link("/edit?id={{ id }}", "Edit"),
     *     new link("/delete?id={{ id }}", "Delete")
     * );
     *
     * or;
     *
     * new linkgroup_menu(
     *     [
     *         new link("/edit?id={{ id }}", "Edit"),
     *         new link("/delete?id={{ id }}", "Delete")
     *     ]
     * );
     *
     * @param link|linkgroup $links
     * @return linkgroup_menu
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

/**
 * Declare round based icon link
 */
class round_iconlink
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
     * @return iconlink
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
