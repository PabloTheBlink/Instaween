<?php

namespace App\Utils;

/**
 * Class Device
 * This class is used to get the device type from the user agent.
 * @package App\Utils
 */
class Device
{

    /**
     * Gets the device type from the user agent.
     *
     * @return string|null The device type or null if the user agent is not recognized.
     */
    public static function getType()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (!isset($_SERVER['HTTP_USER_AGENT']))
            return null;
        $device_types = array(
            'iPhone' => 'IPHONE',
            'iPad' => 'IPAD',
            'Android' => 'ANDROID',
            'Windows Phone' => 'WINDOWS_PHONE',
            'Windows' => 'WINDOWS',
            'Macintosh' => 'MACINTOSH',
            'Linux' => 'LINUX'
        );
        $device_type = null;
        foreach ($device_types as $keyword => $type) {
            if (strpos($user_agent, $keyword) !== false) {
                $device_type = $type;
                break;
            }
        }
        return $device_type;
    }

}