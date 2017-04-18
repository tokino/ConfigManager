<?php
namespace Tokino\Config;

/**
 * Created by PhpStorm.
 * User: kino
 * Date: 2016/08/18
 * Time: 17:05
 */

/**
 * Class Config
 * @package Tokino\Config
 * @author tomohiro.kino <t.kino0219@gmail.com>
 */
class ConfigManager
{
    /**
     * @var array $config application config
     */
    private static $config;

    /**
     * @var string $delimiter Hash Delimiter
     */
    private static $delimiter = '.';

    private static $defaultConfig = 'app.php';

    /**
     * コンフィグ読み込み
     *
     * @param string $config configのファイル名
     * @throws \Exception
     */
    public static function load($config = null) {
        $configDir = dirname(dirname(__DIR__)) . '/configs';

        if (is_null(static::$config)) {
            static::$config = require_once $configDir . '/' . self::$defaultConfig;
        }

        if (!is_null($config)) {
            $file = $configDir . '/' .$config.'.php';
            if (!file_exists($file)) {
                throw new \Exception('Invalid config file is: ' . $config);
            }

            static::$config = array_replace_recursive(static::$config, require_once $file);
        }
    }

    /**
     * コンフィグから値を取得
     *
     * @param string $target 欲しいコンフィグ名
     * @return array|mixed|null
     */
    public static function read($target) {
        $indexes = static::parse($target);

        return static::get($indexes);
    }

    /**
     * インデックスに分割
     *
     * @param string $str 配列名
     * @return array    インデックスの一覧
     */
    private static function parse($str) {
        return explode(static::$delimiter, $str);
    }

    /**
     * 設定の内容を取得
     *
     * @param array $indexes インデックスの一覧
     * @return array|mixed|null
     */
    private static function get(array $indexes) {
        $tmp = static::$config;
        foreach ($indexes as $index) {
            if (!isset($tmp[$index])) {
                return null;
            }

            $tmp = $tmp[$index];
        }

        return $tmp;
    }
}