<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 17.04.2019
 * Time: 21:24
 */

class VKClient
{
    private $access_token;

    /**
     * VKClient constructor.
     * @param $access_token
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    public function getUsersInfo($ids)
    {
        $request_params = array(
            'user_ids' => $ids,
            'fields' => 'photo_100',
            'access_token' => $this->access_token,
            'v' => '5.95',
            'lang' => 'ru'
        );
        $get_params = http_build_query($request_params);
        $result=file_get_contents('https://api.vk.com/method/users.get?'. $get_params);
        return json_decode($result,true)['response'];
    }
}