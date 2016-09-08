<?php

namespace hsTrading\FrontEndBundle\Utils;

/**
 * Description of EchTools
 *
 * @author SSH1
 */
class EchTools
{

    public static function TransformToArray(&$aOptions)
    {
        if ($aOptions instanceof \stdClass)
        {
            $aOptions = (array) $aOptions;
        }

        if (is_array($aOptions))
        {
            foreach ($aOptions as &$Options)
            {
                self::TransformToArray($Options);
            }
        }
    }

    /**
     * Valide une URL
     * 
     * @param <string> $psUrl
     * @return <boolean>
     */
    public static function validateUrl($psUrl)
    {
        if (!filter_var($psUrl, FILTER_VALIDATE_URL) === false)
        {
            return true;
        }
        return false;
    }

    /**
     * Retrouve la valeur d'une option
     * 
     * @param <array> $paOptions
     * @param <string> $psOption
     * @param <string> $psDefault
     * @param <boolean> $pbUnset
     * @return <type>
     * 
     */
    public static function getOption($paOptions, $psOption, $psDefault = null, $pbUnset = true)
    {
        $sValue = $psDefault;
        if (isset($paOptions[$psOption]))
        {
            $sValue = $paOptions[$psOption];
            if ($pbUnset)
            {
                unset($paOptions[$psOption]);
            }
        }
        return $sValue;
    }

    public static function getStdPath($path)
    {
        $ds = DIRECTORY_SEPARATOR;

        return str_replace(array('\\', '/'), array($ds, $ds), $path);
    }

    public static function pr($pValue, $pbExit = true)
    {
        echo '<pre>';
        print_r($pValue);
        echo '</pre>';
        if ($pbExit)
        {
            die();
        }
    }

    public static function completeArray($aSrc, $aDest, $value = null)
    {
        foreach ($aSrc as $valueSrc)
        {
            if (!isset($aDest[$valueSrc]))
            {
                $aDest[$valueSrc] = $value;
            }
        }
        return $aDest;
    }

    /**
     * Parse un tableau pour le formater
     *
     * @param array $aResultSet
     * @param array $aColumn
     * @param sting $sColumnInKey
     * @return array
     * @author Walid Saadaoui 28/05/2013
     */
    public static function getArrayFromResultSetGroupBy($aResultSet, $sColumnInKey, $aColumn)
    {
        $aResult = array();

        foreach ($aResultSet as $result)
        {
            $key = $result[$sColumnInKey];
            if (!isset($aResult[$key]))
            {
                $aResult[$key] = array();
            }

            foreach ($aColumn as $keyColmun => $sColumn)
            {
                if (is_array($sColumn))
                {
                    $aResult[$key][$result[$keyColmun]] = array();
                    foreach ($sColumn as $column)
                    {
                        $aResult[$key][$result[$keyColmun]][$column] = $result[$column];
                    }
                }
                else
                {
                    $aResult[$key][$sColumn] = $result[$sColumn];
                }
            }
        }
        return $aResult;
    }

    /**
     * Parse un tableau pour le formater
     *
     * @param array $aResultSet
     * @param array $aColumn
     * @param sting $sColumnInKey
     * @return array
     * @author Walid Saadaoui 28/05/2013
     */
    public static function getArrayFromResultSet($aResultSet, $sColumnInKey, $aColumn = array())
    {
        $aResult = array();

        foreach ($aResultSet as $result)
        {
            $key = $result[$sColumnInKey];
            if (!isset($aResult[$key]))
            {
                $aResult[$key] = array();
            }
            foreach ($aColumn as $sColumn)
            {
                $aResult[$key][$sColumn] = $result[$sColumn];
            }
        }
        return $aResult;
    }

    /**
     * Parse un tableau pour en extraire une colonne
     *
     * @param array $aResultSet
     * @param sting $sColumn
     * @param sting $sColumnInKey
     * @return array
     * @author Walid Saadaoui 28/05/2013
     */
    public static function getColumnFromResultSetGroupBy($aResultSet, $sColumn, $sColumnInKey)
    {
        $aResult = array();

        foreach ($aResultSet as $result)
        {
            if (isset($result[$sColumn]))
            {
                if (!isset($aResult[$result[$sColumnInKey]]))
                {
                    $aResult[$result[$sColumnInKey]] = array();
                }
                if (!in_array($result[$sColumn], $aResult[$result[$sColumnInKey]]))
                {
                    $aResult[$result[$sColumnInKey]][] = $result[$sColumn];
                }
            }
        }
        return $aResult;
    }

    /**
     * Parse un tableau pour en extraire une colonne
     *
     * @param array $aResultSet
     * @param string $sColumn
     * @param string $sColumnInKey
     * @return array
     * @author Walid Saadaoui 28/05/2013
     */
    public static function getColumnFromResultSet($aResultSet, $sColumn, $sColumnInKey = null)
    {
        $aResult = array();

        foreach ($aResultSet as $result)
        {

            if (isset($result[$sColumn]))
            {
                if ($sColumnInKey && isset($result[$sColumnInKey]))
                {
                    $aResult[$result[$sColumnInKey]] = $result[$sColumn];
                }
                else
                {
                    $aResult[] = $result[$sColumn];
                }
            }
        }
        return $aResult;
    }

    public static function getResultSetForSpecificValue($aResultSet, $sKeyWhen, $sValueWhen)
    {
        $aResult = array();

        foreach ($aResultSet as $result)
        {

            if (isset($result[$sKeyWhen]) && $result[$sKeyWhen] == $sValueWhen)
            {
                $aResult[] = $result;
            }
        }
        return $aResult;
    }

    /**
     * 
     * @return string
     */
    public static function getToken($data)
    {
        return strtoupper(str_replace(array('+', '/', '='), array('', '', ''), base64_encode($data)));
    }

}
