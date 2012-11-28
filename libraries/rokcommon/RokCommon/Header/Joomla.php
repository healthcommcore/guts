<?php
 /**
  * @version   $Id: Joomla.php 48519 2012-02-03 23:18:52Z btowles $
  * @author    RocketTheme http://www.rockettheme.com
  * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */
 
class RokCommon_Header_Joomla implements RokCommon_Header_Interface
{
    /**
     * @var \JDocument
     */
    protected $document;

    /**
     *
     */
    public function __construct()
    {
        $this->document =& JFactory::getDocument();
    }
    /**
     * @param $file
     */
    public function addScript($file)
    {
        $this->document->addScript($file);
    }

    /**
     * @param $text
     */
    public function addInlineScript($text)
    {
        $this->document->addScriptDeclaration($text);
    }

    /**
     * @param $file
     */
    public function addStyle($file)
    {
        $this->document->addStyleSheet($file);
    }

    /**
     * @param $text
     */
    public function addInlineStyle($text)
    {
        $this->document->addScriptDeclaration($text);
    }

}
