<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 13.04.2019
 * Time: 11:40
 */

require 'classes/Errors.php';
require 'classes/User.php';

switch ($_GET['method'])
{
    case "getUser": {
        if($_GET['vk_id'])
        {
            $user = new User($_GET['vk_id']);
            die($user->getUserDataJson());
        } else die(Errors::getJsonError(2));
    }
    break;
    default: die(Errors::getJsonError(0));
}