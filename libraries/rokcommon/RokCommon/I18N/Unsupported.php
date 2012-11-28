<?php
 /**
  * @version   $Id: Unsupported.php 48519 2012-02-03 23:18:52Z btowles $
  * @author    RocketTheme http://www.rockettheme.com
  * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

class RokCommon_I18N_Unsupported implements RokCommon_I18N
{

    /**
	 * javascript strings
	 */
	protected static $strings=array();

    /**
     * @param  $string
     * @return string
     */
    public function translateFormatted($string)
    {
        return $string;
    }

    /**
     * @param  $count
     * @param  $string
     * @return string
     */
    public function translatePlural($string, $count)
    {
        return $string;
    }

    /**
     * @param  $string
     * @return string
     */
    public function translate($string)
    {
        return $string;
    }
	
}
	