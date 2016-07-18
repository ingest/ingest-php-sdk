<?php

namespace ING\PHPSDK;

class Utils
{
    private function parseTokenPayload($token)
    {
        $parts = explode('.', $token);

        if (sizeof($parts) <= 1) {
            return false;
        }

        $payload = base64_decode($parts[1]);

        return json_decode($payload);
    }

    public function isExpired($token) {
        $data = $this->parseTokenPayload($token);

        if ($data == false)
        {
            return true;
        }

        if (property_exists($data, 'exp') == false)
        {
            return false;
        }

        $now = time();
        $exp = $data->exp;

        if ($now < $exp) {
            return false;
        }

        return true;
    }

    public function parseTokens($template, $hash)
    {
        $keys = get_object_vars($hash);

        foreach ($keys as $key => $val) 
        {
            $template = str_replace($template, '<%=' . $key . '%>', $val);
        }

        return $template;
    }
}