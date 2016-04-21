<?php

/*
 * Helpers - global functions/helpers
 * Caezar Rosales <8bytes@gmail.com>
 *
 */

namespace GAPlatform\Libraries;

class Helpers
{
    /**
    * Prepend Url http protocol
    * 
    * @param string $url
    * @return string Prepended url
    */
    static public function prependHttp($url)
    {
        if (!preg_match('/https:\/\//',$url)) {
            $url = 'http://'.str_replace('http://', '', $url);
        }

        return $url;
    }

    /**
     * Get remote IP address
     * 
     * @param string $type Return type 'both','long' and 'ip'
     * @return mixed return ip infos
     */
    static public function getRemoteIP($type = 'ip')
    {
        $return = array();
        if (getenv('HTTP_CLIENT_IP'))
            $return['ip'] = getenv('HTTP_CLIENT_IP');
        elseif (getenv('HTTP_X_FORWARDED_FOR'))
            $return['ip'] = getenv('HTTP_X_FORWARDED_FOR');
        elseif (getenv('HTTP_X_FORWARDED'))
            $return['ip'] = getenv('HTTP_X_FORWARDED');
        elseif (getenv('HTTP_FORWARDED_FOR'))
            $return['ip'] = getenv('HTTP_FORWARDED_FOR');
        elseif (getenv('HTTP_FORWARDED'))
            $return['ip'] = getenv('HTTP_FORWARDED');
        else
            $return['ip'] = $_SERVER['REMOTE_ADDR'];

        $return['long']   = ip2long($return['ip']);

        switch ($type) {
            case 'long':
                return $return['long'];
            break;
            case 'ip':
                return $return['ip'];
            break;
            default:
                return $return;
            break;
        }
    }
}
