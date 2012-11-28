<?php

class RokCommon2ea65e3d17ec39a21418a60f431bcf0cServiceContainer extends RokCommon_Service_ContainerImpl
{
  protected $shared = array();

  public function __construct()
  {
    parent::__construct($this->getDefaultParameters());
  }

  protected function get_8876c6733ca9f4bd60e807a335eb87dc1Service()
  {
    if (isset($this->shared['_8876c6733ca9f4bd60e807a335eb87dc_1'])) return $this->shared['_8876c6733ca9f4bd60e807a335eb87dc_1'];

    $instance = new RokCommon_Cache_Driver_Joomla($this->getParameter('cache.group'), $this->getParameter('cache.lifetime'));

    return $this->shared['_8876c6733ca9f4bd60e807a335eb87dc_1'] = $instance;
  }

  protected function get_841efc705df563f9db06bc26da8516041Service()
  {
    if (isset($this->shared['_841efc705df563f9db06bc26da851604_1'])) return $this->shared['_841efc705df563f9db06bc26da851604_1'];

    $instance = new RokCommon_Cache_Driver_Joomla($this->getParameter('cache.group'), $this->getParameter('cache.lifetime'));

    return $this->shared['_841efc705df563f9db06bc26da851604_1'] = $instance;
  }

  protected function get_37ecd49a207c2e5a01796a2a20720a671Service()
  {
    if (isset($this->shared['_37ecd49a207c2e5a01796a2a20720a67_1'])) return $this->shared['_37ecd49a207c2e5a01796a2a20720a67_1'];

    $class = $this->getParameter('cache.driver.file.class');
    $instance = new $class($this->getParameter('cache.driver.file.lifetime'), $this->getParameter('cache.driver.file.path'));

    return $this->shared['_37ecd49a207c2e5a01796a2a20720a67_1'] = $instance;
  }

  protected function getLoggerService()
  {
    $class = $this->getParameter('logger.class');
    $instance = new $class($this->getParameter('logger.loglevels'), array('logger' => 'formattedtext', 'text_file' => 'rokcommon.php', 'text_file_no_php' => 0), 'RokCommon');

    return $instance;
  }

  protected function getHeaderService()
  {
    if (isset($this->shared['header'])) return $this->shared['header'];

    $class = $this->getParameter('header.class');
    $instance = new $class();

    return $this->shared['header'] = $instance;
  }

  protected function getI18nService()
  {
    if (isset($this->shared['i18n'])) return $this->shared['i18n'];

    $class = $this->getParameter('i18n.class');
    $instance = new $class();

    return $this->shared['i18n'] = $instance;
  }

  protected function getPlatforminfoService()
  {
    if (isset($this->shared['platforminfo'])) return $this->shared['platforminfo'];

    $class = $this->getParameter('platforminfo.class');
    $instance = new $class();

    return $this->shared['platforminfo'] = $instance;
  }

  protected function getCacheService()
  {
    if (isset($this->shared['cache'])) return $this->shared['cache'];

    $class = $this->getParameter('cache.class');
    $instance = new $class($this->getService('_8876c6733ca9f4bd60e807a335eb87dc_1'), $this->getParameter('cache.lifetime'));

    return $this->shared['cache'] = $instance;
  }

  protected function getDispatcherService()
  {
    if (isset($this->shared['dispatcher'])) return $this->shared['dispatcher'];

    $class = $this->getParameter('dispatcher.class');
    $instance = new $class();

    return $this->shared['dispatcher'] = $instance;
  }

  protected function getDoctrinePlatformService()
  {
    if (isset($this->shared['doctrine_platform'])) return $this->shared['doctrine_platform'];

    $class = $this->getParameter('doctrine.platform.class');
    $instance = new $class();

    return $this->shared['doctrine_platform'] = $instance;
  }

  protected function getRegistryConverterService()
  {
    if (isset($this->shared['registry_converter'])) return $this->shared['registry_converter'];

    $class = $this->getParameter('registry.converter.class');
    $instance = new $class();

    return $this->shared['registry_converter'] = $instance;
  }

  protected function getHtml_Renderer_SelectService()
  {
    if (isset($this->shared['html.renderer.select'])) return $this->shared['html.renderer.select'];

    $class = $this->getParameter('html.renderer.select.class');
    $instance = new $class();

    return $this->shared['html.renderer.select'] = $instance;
  }

  protected function getFormNamehandlerService()
  {
    if (isset($this->shared['form_namehandler'])) return $this->shared['form_namehandler'];

    $class = $this->getParameter('form.namehandler.class');
    $instance = new $class();

    return $this->shared['form_namehandler'] = $instance;
  }

  protected function getDefaultParameters()
  {
    return array(
      'doctrine' => array(
        'platform' => array(
          'class' => 'RokCommon_Doctrine_Platform_Joomla16',
        ),
      ),
      'platforminfo' => array(
        'class' => 'RokCommon_PlatformInfo_Joomla17',
      ),
      'i18n' => array(
        'class' => 'RokCommon_I18N_Joomla16',
      ),
      'header' => array(
        'class' => 'RokCommon_Header_Joomla',
      ),
      'logger' => array(
        'class' => 'RokCommon_Logger_Joomla17',
        'loglevels' => array(
          0 => 'INFO',
          1 => 'NOTICE',
          2 => 'WARNING',
          3 => 'ERROR',
          4 => 'FATAL',
        ),
      ),
      'dispatcher' => array(
        'class' => 'RokCommon_Dispatcher',
      ),
      'registry' => array(
        'converter' => array(
          'class' => 'RokCommon_Registry_Converter_Joomla17',
        ),
      ),
      'cache' => array(
        'class' => 'RokCommon_Cache_DefaultImpl',
        'lifetime' => '900',
        'driver' => array(
          'file' => array(
            'class' => 'RokCommon_Cache_Driver_File',
            'path' => '/cache',
            'lifetime' => '900',
          ),
        ),
        'group' => 'rokcommon',
      ),
      'html' => array(
        'renderer' => array(
          'select' => array(
            'service' => 'html.renderer.select',
            'class' => 'RokCommon_HTML_Select',
          ),
        ),
      ),
      'form' => array(
        'namehandler' => array(
          'class' => 'RokCommon_Form_NamingHandler_Joomla',
        ),
      ),
      'platform' => array(
        'name' => 'joomla',
        'displayname' => 'Joomla',
        'version' => '2.5.4',
        'root' => '/home/nhs2/public_html/GUTS/new_guts_site',
      ),
      'template' => array(
        'name' => 'rt_momentum',
        'path' => '/home/nhs2/public_html/GUTS/new_guts_site/templates/rt_momentum',
      ),
    );
  }
}
