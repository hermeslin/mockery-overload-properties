<?php
namespace Mop;

use Mop\Exception\MopException;

/**
 * mocked instance's parent, use php magic method __get to detected if mocked instance need properties
 * if mocked instance need, we get properties from file and return them back
 */
class InstanceProperty
{
    /**
     * [$properties description]
     *
     * @var array
     */
    private $properties = [];

    /**
     * [$tmpFolder description]
     *
     * @var string
     */
    private $tmpFolder = '_tmp';

    /**
     * php magic method
     *
     * @param  string $name property's name
     * @return mix property's value that test case need
     */
    public function __get($name)
    {
        if (!isset($this->properties[$name])) {
            $instance = $this->whosCall();
            $file = dirname(__FILE__) . '/' . $this->tmpFolder . "/{$instance}";

            if (!file_exists($file)) {
                throw new MopException('instance file not exists');
            }

            $properties = json_decode(file_get_contents($file), true);

            foreach($properties as $property => $value) {
                $this->properties[$property] = $value;
            }
        }

        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }
    }

    /**
     * use debug_backtrace to get instance name
     *
     * @return string instance name
     */
    private function whosCall()
    {
        $trace = debug_backtrace();
        return strtolower(get_class($trace[1]['object']));
    }
}