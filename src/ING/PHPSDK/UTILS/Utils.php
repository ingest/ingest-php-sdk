<?php
/**
 * ING/PHPSDK/\TOOLS\Utils.php
 *
 * @author REDspace <https://redspace.com>
 * @author Jeff Hann <jeff.hann@redspace.com>
 * @copyright 2016 REDspace
 * @package ING\PHPSDK\TOOLS
 * @filesource
 */

namespace ING\PHPSDK\UTILS;

/**
 * Utility functions for dealing with the Ingest API.
 *
 * @package ING\PHPSDK\TOOLS
 */
class Utils {
    /**
     * parseTokenPayload
     *
     * Accept a JWT and return the payload.
     *
     * @param $token
     * @return bool|mixed
     */
    private function parseTokenPayload($token) {
        $parts = explode('.', $token);

        if (1 >= sizeof($parts)) {
            return false;
        }

        $payload = base64_decode($parts[1]);

        return json_decode($payload);
    }

    /**
     * isExpired
     *
     * Accept a JWT and compare the `exp` to a current unix date stamp, returning true if
     * the token has expired.
     *
     * @param $token
     * @return bool
     */
    public function isExpired($token) {
        $data = $this->parseTokenPayload($token);

        if (false == $data) {
            return true;
        }

        if (false == property_exists($data, 'exp'))  {
            return false;
        }

        $now = time();
        $exp = $data->exp;

        if ($now < $exp) {
            return false;
        }

        return true;
    }

    /**
     * parseTokens
     *
     * Accepts a template in the form of a string and an object containing
     * keys and matching values to replace within the template. Returns the completed
     * template.
     *
     * @param $template
     * @param $hash
     * @return mixed
     */
    public function parseTokens($template, $hash) {
        $keys = get_object_vars($hash);

        foreach ($keys as $key => $val) {
            $template = str_replace($template, '<%=' . $key . '%>', $val);
        }

        return $template;
    }
}