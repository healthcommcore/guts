<?php
/**
 * @version   $Id: Service.php 50531 2012-03-05 23:08:26Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 *
 */
class RokCommon_Service extends RokCommon_Service_Container_Builder
{
	/**
	 * @var bool
	 */
	protected static $developmentMode = false;
	/**
	 * @var RokCommon_Service_Container[]
	 */
	protected static $instance = array();

	/**
	 * @var string
	 */
	protected static $last_checksum = null;

	/**
	 * @var string[]
	 */
	protected static $config_files = array();

	protected static $tmp_file_dir;

	/**
	 * @static
	 * @return RokCommon_Service_Container
	 */
	public static function getContainer()
	{
		$config_files = self::getConfigFiles();
		$checksum     = md5(implode('', $config_files) . RokCommon_Platform::getInstance()->getPlatformId());

		if (!isset(self::$instance[$checksum]) || ($checksum != self::$last_checksum)) {
			self::$last_checksum = $checksum;
			$name                = 'RokCommon' . self::$last_checksum . 'ServiceContainer';
			$file                = self::$tmp_file_dir . '/' . $name . '.php';

			if (file_exists($file) && !self::$developmentMode && false) {
				require_once $file;
				self::$instance[$checksum] = new $name();
			} else {
				// build the service container dynamically
				self::$instance[$checksum] = new self;

				// set up the loader
				$loader = new RokCommon_Service_Container_Loader_File_Xml(self::$instance[$checksum]);

				// get and load the platform specific base container file
				$platform = RokCommon_PlatformFactory::getCurrent();
				foreach ($platform->getLoaderChecks() as $platform_check) {
					$platform_file = ROKCOMMON_ROOT_PATH . '/config/' . $platform_check . '.xml';
					if (file_exists($platform_file)) {
						$loader->load($platform_file);
						//array_unshift($config_files, $platform_file);
						break;
					}
				}

				// populate the platform specific parameters
				/** @var $platforminfo RokCommon_PlatformInfo */
				$platforminfo = self::$instance[$checksum]->platforminfo;
				$platforminfo->setPlatformParameters(self::$instance[$checksum]);

				// load any other defined container config files
				$loader->load($config_files);

				//write the container file to php for speed.
				if (is_writeable(dirname($file))) {
					$dumper = new RokCommon_Service_Container_Dumper_Php(self::$instance[$checksum]);
					file_put_contents($file, $dumper->dump(array('class' => $name)));
				} else {
					// TODO log that we are unable to write to the temp dir
				}
			}
		}
		return self::$instance[$checksum];
	}

	/**
	 * @static
	 *
	 * @param string    $path

	 */
	public static function addConfigFile($path)
	{
		self::$config_files[] = $path;
	}

	/**
	 * @static
	 * @return string[]
	 */
	protected static function getConfigFiles()
	{
		$ret = array();
		ksort(self::$config_files, SORT_NUMERIC);
		$iterator = new RecursiveArrayIterator(self::$config_files);
		foreach ($iterator as $path) {
			if (is_file($path)) {
				$ret[] = $path;
			}
		}
		return $ret;
	}

	/**
	 * @param boolean $developmentMode
	 */
	public static function setDevelopmentMode($developmentMode)
	{
		self::$developmentMode = $developmentMode;
	}

	/**
	 * @return boolean
	 */
	public static function getDevelopmentMode()
	{
		return self::$developmentMode;
	}

	public static function setTempFileDir($path)
	{
		if (is_dir($path) && is_writable($path)) {
			self::$tmp_file_dir = $path;
		}
	}
}

RokCommon_Service::setTempFileDir(sys_get_temp_dir());
