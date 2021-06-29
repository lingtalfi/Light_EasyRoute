<?php


namespace Ling\Light_EasyRoute\Helper;


use Ling\BabyYaml\BabyYamlUtil;

/**
 * The LightEasyRouteHelper class.
 */
class LightEasyRouteHelper
{


    /**
     * Returns the expected plugin file for registering routes with our open registration system.
     *
     * @param string $appDir
     * @param string $planetDotName
     * @return string
     */
    public static function getPluginFile(string $appDir, string $planetDotName): string
    {
        return $appDir . "/config/data/$planetDotName/Ling.Light_EasyRoute/routes.byml";
    }

    /**
     * Merges the planet's route declaration file (if it exists) into the master.
     * See the @page(Light_EasyRoute conception notes) for more details.
     *
     * @param string $appDir
     * @param string $subscriberPlanetDotName
     * @throws \Exception
     */
    public static function copyRoutesFromPluginToMaster(string $appDir, string $subscriberPlanetDotName)
    {
        $pluginFile = self::getPluginFile($appDir, $subscriberPlanetDotName);
        if (true === file_exists($pluginFile)) {
            $arr = BabyYamlUtil::readFile($pluginFile);

            $masterFile = self::getMasterPath($appDir);
            if (true === file_exists($masterFile)) {
                $master = BabyYamlUtil::readFile($masterFile);
            } else {
                $master = [];
            }
            $master = array_merge($master, $arr);
            BabyYamlUtil::writeFile($master, $masterFile);
        }
    }


    /**
     * Removes the planet's route declaration file (if it exists) into the master.
     * See the @page(Light_EasyRoute conception notes) for more details.
     *
     * @param string $appDir
     * @param string $subscriberPlanetDotName
     * @throws \Exception
     */
    public static function removeRoutesFromMaster(string $appDir, string $subscriberPlanetDotName)
    {
        $masterFile = self::getMasterPath($appDir);
        if (true === file_exists($masterFile)) {
            $arr = BabyYamlUtil::readFile($masterFile);
            if (true === array_key_exists($subscriberPlanetDotName, $arr)) {
                unset($arr[$subscriberPlanetDotName]);
                BabyYamlUtil::writeFile($arr, $masterFile);
            }
        }
    }


    /**
     * Returns the path to the routes master declaration file.
     * See the @page(Light_EasyRoute conception notes) for more details.
     *
     * @param string $appDir
     * @return string
     */
    public static function getMasterPath(string $appDir): string
    {
        return $appDir . "/config/open/Ling.Light_EasyRoute/routes.byml";;
    }
}