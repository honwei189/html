<?php
/**
 * Description   : Utilities function for honwei189\html
 * ---------
 * Created       : 2021-09-14 11:41:49 am
 * Author        : Gordon Lim
 * Last Modified : 2021-09-14 11:45:35 am
 * Modified By   : Gordon Lim
 * ---------
 * Changelog
 *
 * Date & time           By                    Version   Comments
 * -------------------   -------------------   -------   ---------------------------------------------------------
 *
 */

/**
 * Quick creates instance of honwei189\Html\Struct\Col
 * 
 * @param string $title_name 
 * @param mixed $data_name 
 * @param mixed $attr 
 * @param mixed $options 
 * @param int $width 
 * @return honwei189\Html\Struct\Col 
 */
function col($title_name = null, $data_name = null, $attr = null, $options = null, $width = null)
{
    return new honwei189\Html\Struct\Col($title_name, $data_name, $attr, $options, $width);
}

/**
 * Quick creates instance of honwei189\Html
 * 
 * @return honwei189\Html 
 */
function html()
{
    return (new honwei189\Html);
}

/**
 * Quick creates instance of honwei189\Html\Table
 * 
 * @return honwei189\Html\Table 
 */
function table()
{
    return (new honwei189\Html\Table);
}
