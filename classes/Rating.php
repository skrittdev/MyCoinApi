<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 17.04.2019
 * Time: 13:52
 */
require_once 'Connect.php';
require_once 'VKClient.php';
require_once 'config.php';

class Rating
{
    private $connect;
    private $vkclient;

    /**
     * Rating constructor.
     */
    public function __construct()
    {
        $connect=new Connect();
        $this->connect=$connect->getConnect();
        $this->vkclient=new VKClient($access_token);
    }

    public function getTopUsersJson()
    {
        $count=1;
        $json=array(
            'users' => array()
        );
        $sql="SELECT * FROM `users` ORDER BY `balance` DESC LIMIT 100";
        $query=$this->connect->query($sql);
        while($row = $query->fetch_assoc()){
            $vk_user=$this->vkclient->getUserInfo($row['vk_id']);
            $temp=array(
                'place' => $count++,
                'vk_id' => $row['vk_id'],
                'first_name' => $vk_user->getFirstName(),
                'last_name' => $vk_user->getLastName(),
                'photo' => $vk_user->getPhoto100(),
                'balance' => $row['balance']
            );
            array_push($json['users'],$temp);
        }
        return json_encode($json);
    }
}