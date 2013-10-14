<?php

class MageLine_RedisCache_Model_Observer {

    const CACHE_TYPE = 'mageline_rediscache_data';

    public function cleanCache(Varien_Event_Observer $observer) {
        try {
            $options = array();
            $options['server'] = Mage::getStoreConfig('mageline_rediscache/servers/redis_data_server_ip', Mage::app()->getStore()->getId());
            $options['port'] = Mage::getStoreConfig('mageline_rediscache/servers/redis_data_server_port', Mage::app()->getStore()->getId());
            $cmCache = new Cm_Cache_Backend_Redis($options);
            $cmCache->clean();
			$this->_getSession()->addSuccess(Mage::helper('adminhtml')->__("The Redis cache has been flushed."));
        } catch (Exception $e) {
			$this->_getSession()->addError(Mage::helper('adminhtml')->__($e->getMessage()));
        }
        return $this;
    }

    public function cleanCacheByType(Varien_Event_Observer $observer) {
        $type = $observer->getEvent()->getType();
        if ($type == self::CACHE_TYPE) {
            try {
                $options = array();
                $options['server'] = Mage::getStoreConfig('mageline_rediscache/servers/redis_data_server_ip', Mage::app()->getStore()->getId());
                $options['port'] = Mage::getStoreConfig('mageline_rediscache/servers/redis_data_server_port', Mage::app()->getStore()->getId());
                $cmCache = new Cm_Cache_Backend_Redis($options);
                $cmCache->clean();
				$this->_getSession()->addSuccess(Mage::helper('adminhtml')->__("The Redis cache has been flushed."));
            } catch (Exception $e) {
               	$this->_getSession()->addError(Mage::helper('adminhtml')->__($e->getMessage()));
            }
        }
        return $this;
    }

    protected function _getSession() {
        return Mage::getSingleton('adminhtml/session');
    }

}