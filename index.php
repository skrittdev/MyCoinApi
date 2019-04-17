<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 13.04.2019
 * Time: 11:40
 */

require 'classes/ApiErrors.php';
require 'classes/User.php';
require 'classes/Rating.php';

switch ($_GET['method'])
{
    case "getUser": {
        if($_GET['vk_id'] && $_GET['vk_id'] != null)
        {
            $user = new User($_GET['vk_id']);
            die($user->getUserDataJson());
        } else die(ApiErrors::getJsonError(2));
    }
        break;
    case "getTopAll": {
            $rating = new Rating();
            die($rating->getTopUsersJson());
    }
        break;
    default: die(ApiErrors::getJsonError(0));
}