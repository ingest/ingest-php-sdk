<?php
/**
 *
 * Base.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING
 * @filesource
 */

namespace ING;

/**
 * Abstract class extended by the rest of the SDK.
 *
 * @package ING
 */
abstract class Base {
    /**
     * Request constructor.
     *
     * Accepts an object of properties.
     *
     * @param \stdClass|NULL $config
     */
    public function __construct(\stdClass $config = NULL) {
        if (false == is_null($config)) {
            foreach ($config as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Return an object containing all default properties of the class.
     *
     * @return object An object containing the default properties of the class.
     */
    public static function getDefaults() {
        $reflection = new \ReflectionClass(get_called_class());
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);
        $defaults = $reflection->getDefaultProperties();

        $config = new \StdClass;

        foreach($properties as $property) {
            $name = $property->name;
            $config->$name = $defaults[$name];
        }

        return $config;
    }
}