<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 13.04.2019
 * Time: 11:48
 */

class ApiErrors
{

    /**
     * @param $code
     * @return string
     */
    public static function getJsonError($code)
    {
        require_once 'errors_list.php';
        return json_encode(array('error_code' => $code,'description' => $errors[$code]));
    }
}