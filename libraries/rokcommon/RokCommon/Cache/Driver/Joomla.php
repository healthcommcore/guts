<?php
 /**
  * @version   $Id: Joomla.php 48519 2012-02-03 23:18:52Z btowles $
  * @author    RocketTheme http://www.rockettheme.com
  * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */


class RokCommon_Cache_Driver_Joomla implements RokCommon_Cache_Driver
{
    const DEFAULT_LIFETIME = 900;
    /**
     * @var JCache
     */
    protected $cache = null;

    protected $lifeTime = self::DEFAULT_LIFETIME;

    public function __construct($groupName, $lifeTime = self::DEFAULT_LIFETIME)
    {
        $this->lifeTime = $lifeTime;

        $this->cache = & JFactory :: getCache($groupName, 'output');
        $this->cache->setCaching(true);
        $this->cache->setLifeTime($this->lifeTime);
    }

    /**
     * Check if cache data exists
     *
     * @param string $groupName Name of group
     * @param string $identifier Identifier
     * @return boolean
     */
    public function exists($groupName, $identifier)
    {
        $value = $this->cache->get($identifier, $groupName);
        return ($value !== false )? true: false;
    }

    /**
     * Gets last modification time of specified cache data
     *
     * @param string $groupName Name of group
     * @param string $identifier Identifier
     * @return int
     */
    public function modificationTime($groupName, $identifier)
    {
        return 0;
    }

    /**
     * Clears all cache generated by this class with this driver
     *
     * @return boolean
     */
    public function clearAllCache()
    {
        return false;
    }

    /**
     * Clears cache of specified group
     *
     * @param string $groupName Name of group
     * @return boolean
     */
    public function clearGroupCache($groupName)
    {
        return $this->cache->clean($groupName);
    }

    /**
     * Clears cache of specified identifier of group
     *
     * @param string $groupName Name of group
     * @param string $identifier Identifier
     * @return boolean
     */
    public function clearCache($groupName, $identifier)
    {
        return $this->cache->remove($identifier, $groupName);
    }

    /**
     * Gets data from cache
     *
     * @param string $groupName Name of group
     * @param string $identifier Identifier of data
     * @return mixed
     */
    public function get($groupName, $identifier)
    {
        return unserialize($this->cache->get($identifier));
    }

    /**
     * Sets data to cache
     *
     * @param string $groupName Name of group of cache
     * @param string $identifier Identifier of data
     * @param mixed $data Data
     * @return boolean
     */
    public function set($groupName, $identifier, $data)
    {
        return $this->cache->store(serialize($data), $identifier);
    }

    /**
     * Sets the lifetime of the cache
     *
     * @abstract
     * @param  int $lifeTime Lifetime of the cache
     * @return void
     */
    public function setLifeTime($lifeTime)
    {
        $this->lifeTime = $lifeTime;
        $this->cache->setLifeTime($this->lifeTime);
    }

}