<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 17.04.2019
 * Time: 21:37
 */

class VKUser
{
    private $access_token;
    private $vk_id;
    private $first_name;
    private $last_name;
    private $photo_100;

    /**
     * VKUser constructor.
     * @param $access_token
     * @param $vk_id
     */
    public function __construct($access_token, $vk_id)
    {
        $this->access_token = $access_token;
        $this->vk_id = $vk_id;
        $request_params = array(
            'user_ids' => $this->vk_id,
            'fields' => 'photo_100',
            'access_token' => $this->access_token,
            'v' => '5.95'
        );
        $get_params = http_build_query($request_params);
        $result=file_get_contents('https://api.vk.com/method/users.get?'. $get_params);
        $result=json_decode($result,true)['response'][0];
        $this->first_name=$result['first_name'];
        $this->last_name=$result['last_name'];
        $this->photo_100=$result['photo_100'];
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getPhoto100()
    {
        return $this->photo_100;
    }
}