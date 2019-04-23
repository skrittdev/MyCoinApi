<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 13.04.2019
 * Time: 11:40
 */
header('Access-Control-Allow-Origin: *');

require 'classes/ApiErrors.php';
require 'classes/VKClient.php';
require 'classes/User.php';
require 'classes/Rating.php';

function base64_decode_fix( $data, $strict = false )
{
    if( $strict )
        if( preg_match( '![^a-zA-Z0-9/+=]!', $data ) )
            return( false );

    return( base64_decode( $data ) );
}

switch ($_GET['method'])
{
    case "getUser": {
        if($_GET['vk_id'] && $_GET['vk_id'] != "null")
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
    case "getTopFriends": {
        if($_GET['friends'] && $_GET['friends'] != "null") {
            $rating = new Rating();
            $_GET['friends']=json_decode(base64_decode($_GET['friends']),true);
            if($_GET['vk_id'] && $_GET['vk_id'] != "null")
                array_push($_GET['friends'],$_GET['vk_id']);
            die($rating->getTopFriendsJson($_GET['friends']));
        } else {
            die("null");
        }
    }
        break;
    case "searchUsers": {
        if($_GET['q'] && $_GET['q'] != "null") {
            $json=array();
            $user_c=new User(null);
            $users=json_decode(base64_decode_fix($_GET['q']),true);
            foreach ($users as $user)
            {
                $temp=array(
                    'vk_id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'photo' => $user['photo_100'],
                    'balance' => $user_c->getUserBalanceByVkId($user['id'])
                );
                array_push($json,$temp);
            }
            die(json_encode($json));
        } else {
            die("null");
        }
    }
        break;
    default: die(ApiErrors::getJsonError(0));
}