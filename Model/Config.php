<?php
/**
 * KiwiCommerce
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please contact us https://kiwicommerce.co.uk/contacts.
 *
 * @category   KiwiCommerce
 * @package    MageOS_AdminActivityLog
 * @copyright  Copyright (C) 2018 Kiwi Commerce Ltd (https://kiwicommerce.co.uk/)
 * @license    https://kiwicommerce.co.uk/magento2-extension-license/
 */

namespace MageOS\AdminActivityLog\Model;

use Magento\Framework\Phrase;
use MageOS\AdminActivityLog\Model\Config\Data;

/**
 * Class Config
 * @package MageOS\AdminActivityLog\Model
 */
class Config
{
    /**
     * Merged adminactivity.xml config
     * @var array
     */
    private $xmlConfig;

    /**
     * Translated and sorted labels
     * @var array
     */
    private $labels = [];

    /**
     * Config constructor.
     * @param Config\Data $dataStorage
     */
    public function __construct(
        Data $dataStorage
    ) {
        $this->xmlConfig = $dataStorage->get('config');
    }

    /**
     * Get all action labels translated and sorted ASC
     * @return array
     */
    public function getActions()
    {
        if (!$this->labels && isset($this->xmlConfig['actions'])) {
            foreach ($this->xmlConfig['actions'] as $id => $label) {
                $this->labels[$id] = __($label);
            }
            asort($this->labels);
        }
        return $this->labels;
    }

    /**
     * List of all full actions
     * @return array
     */
    public function getControllerActions()
    {
        $actions = [];
        foreach ($this->xmlConfig as $module => $config) {
            if (isset($config['actions'])) {
                $actions = array_merge($actions, array_keys($config['actions']));
            }
        }
        return $actions;
    }

    /**
     * Get logging action translated label
     * @param string $action
     * @return Phrase|string
     */
    public function getActionLabel($action)
    {
        if (isset($this->xmlConfig['actions'])
            && array_key_exists(
                $action,
                $this->xmlConfig['actions']
            )
        ) {
            return __($this->xmlConfig['actions'][$action]);
        }

        return $action;
    }

    /**
     * Get event by action
     * @param $action
     * @return bool
     */
    public function getEventByAction($action)
    {
        foreach ($this->xmlConfig as $module => $config) {
            if (isset($config['actions']) && array_key_exists($action, $config['actions'])) {
                return $config['actions'][$action];
            }
        }

        return false;
    }

    /**
     * Return Model class name
     * @param $module
     * @return string
     */
    public function getEventModel($module)
    {
        if (!array_key_exists($module, $this->xmlConfig)) {
            return false;
        }
        return $this->xmlConfig[$module]['model'];
    }

    /**
     * Return model label name
     * @param $module
     * @return bool
     */
    public function getActivityModuleName($module)
    {
        if (!array_key_exists($module, $this->xmlConfig)) {
            return false;
        }

        return $this->xmlConfig[$module]['label'];
    }

    /**
     * Return model class name
     * @param $module
     * @return string
     */
    public function getTrackFieldModel($module)
    {
        if (!array_key_exists($module, $this->xmlConfig)) {
            return false;
        }

        return $this->xmlConfig[$module]['config']['trackfield'];
    }

    /**
     * Return module constant
     * @param $module
     * @return bool
     */
    public function getActivityModuleConstant($module)
    {
        if (!array_key_exists($module, $this->xmlConfig)) {
            return false;
        }
        return $this->xmlConfig[$module]['config']['configpath'];
    }

    /**
     * Return module edit url
     * @param $module
     * @return bool
     */
    public function getActivityModuleEditUrl($module)
    {
        if (!array_key_exists($module, $this->xmlConfig)) {
            return false;
        }
        return $this->xmlConfig[$module]['config']['editurl'];
    }

    /**
     * Return module item name
     * @param $module
     * @return bool
     */
    public function getActivityModuleItemField($module)
    {
        if (!array_key_exists($module, $this->xmlConfig)) {
            return false;
        }
        return $this->xmlConfig[$module]['config']['itemfield'];
    }
}
