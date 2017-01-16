<?php
/**
 * Created by PhpStorm.
 * User: gooya
 * Date: 16/12/14
 * Time: 12:24
 */


use Tokino\Config\ConfigManager;


class ConfigManagerTest extends PHPUnit_Framework_TestCase
{
    public function testLoad() {
        ConfigManager::load();
        $this->assertFalse(ConfigManager::read('App.debug'));
    }

    public function testExtendsLoad() {
        ConfigManager::load('development');
        $this->assertTrue(ConfigManager::read('App.debug'));
    }
}
