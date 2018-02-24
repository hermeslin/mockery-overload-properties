<?php
namespace Mop;

use Mockery;
use Mockery\Generator\MockConfigurationBuilder;

/**
 * mock instance's Properties
 */
class InstancePropertyMocker
{
    /**
     * [$fileList description]
     *
     * @var array
     */
    private static $fileList = [];

    /**
     * [$tmpFolder description]
     *
     * @var string
     */
    public static $tmpFolder = '_tmp';

    /**
     * mock instance with properties that test case need
     *
     * @param  string $name       instance name
     * @param  array  $properties instance's properties that test case need to mock
     * @return Mockery\MockInterface
     */
    public static function mock($name, $properties = [])
    {
        self::property($properties, $name);

        // create mockery config builder
        $builder = new MockConfigurationBuilder();

        // instance parent class, we set properties in here actually
        $builder->addTarget('\\Mop\\InstanceProperty');

        // use NEW keyword
        $builder->setInstanceMock(true);

        // the instance name that we need to mock
        $builder->setName($name);

        return Mockery::mock($builder);
    }

    /**
     * delete file with name or delete all files
     *
     * @param  string $name instance name
     * @return boolean status
     */
    public static function close($name = '')
    {
        if ('' !== trim($name)) {
            self::closeByName($name);
            return true;
        }

        foreach (self::$fileList as $name) {
            self::closeByName($name);
        }

        self::$fileList = [];
        return true;
    }

    /**
     * delete file with name
     *
     * @param  string $name instance name
     * @return boolean status
     */
    public static function closeByName($name)
    {
        $file = dirname(__FILE__) . '/' . self::$tmpFolder . '/' . strtolower(str_replace('\\', '', $name));

        if (file_exists($file)) {
            unlink($file);
            unset(self::$fileList[$name]);
        }

        return true;
    }

    /**
     * actually, we store instance's properties in the file
     *
     * @param  array  $properties we want instance has these properties
     * @param  string $name       instance name
     * @return boolean  status
     */
    public static function property($properties, $name)
    {
        if (!is_array($properties) || empty($name)) {
            return false;
        }

        // store file list
        self::$fileList[] = $name;

        $file = dirname(__FILE__) . '/' . self::$tmpFolder . '/' . strtolower(str_replace('\\', '', $name));

        if (file_exists($file)) {
            $contents = file_get_contents($file);
            $properties = array_merge(json_decode($contents, true), $properties);
        }
        file_put_contents($file, json_encode($properties));

        return true;
    }
}
