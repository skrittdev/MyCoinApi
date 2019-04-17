<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 17.04.2019
 * Time: 13:52
 */
require_once 'Connect.php';
require_once 'VKClient.php';

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
        $this->vkclient=new VKClient("a0c47699a0c47699a0c4769937a0ad9e88aa0c4a0c47699fc6bf7b127f14b99e12630c5");
    }

    public function getTopUsersJson()
    {
        $ids="";
        $count=1;
        $json=array();
        $sql="SELECT * FROM `users` ORDER BY `balance` DESC LIMIT 100";
        $query=$this->connect->query($sql);
        while($row = $query->fetch_assoc()){
            $ids="{$ids}{$row['vk_id']},";
            $temp=array(
                'place' => $count++,
                'vk_id' => $row['vk_id'],
                'first_name' => '',
                'last_name' => '',
                'photo' => '',
                'balance' => $row['balance']
            );
            array_push($json,$temp);
        }
        $info=$this->vkclient->getUsersInfo($ids);
        for($i=0; $i<$count-1; $i++)
        {
            $json[$i]['first_name']=$info[$i]['first_name'];
            $json[$i]['last_name']=$info[$i]['last_name'];
            $json[$i]['photo']=$info[$i]['photo_100'];
        }
        return json_encode($json,JSON_UNESCAPED_UNICODE);
    }
}