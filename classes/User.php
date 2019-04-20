<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 13.04.2019
 * Time: 12:05
 */

require_once 'Connect.php';
require_once 'VKClient.php';

class User
{
    private $connect;
    private $id;
    private $vk_id;
    private $balance;
    private $status;
    private $friends=array();
    private $vkclient;

    /**
     * User constructor.
     * @param $vk_id
     */
    public function __construct($vk_id)
    {
        $this->vkclient=new VKClient("a0c47699a0c47699a0c4769937a0ad9e88aa0c4a0c47699fc6bf7b127f14b99e12630c5");
        $this->vk_id = $vk_id;
        $connect=new Connect();
        $this->connect=$connect->getConnect();
        if($vk_id)
        $this->initUser();
    }

    public function initUser()
    {
        $sql="SELECT * FROM `users` WHERE `vk_id`={$this->vk_id}";
        $query=$this->connect->query($sql);
        if($query->num_rows)
        {
            $user=$query->fetch_assoc();
            $this->id=$user['id'];
            $this->balance=$user['balance'];
            $this->status=$user['status'];
        } else {
            $this->connect->query("INSERT INTO `users` (vk_id) VALUES ({$this->vk_id})");
            $this->id=$this->connect->insert_id;
            $this->balance=0.0000;
            $this->status=1;
        }
    }

    public function getUserBalanceByVkId($vk_id)
    {
        $sql="SELECT * FROM `users` WHERE `vk_id`={$vk_id}";
        $query=$this->connect->query($sql);
        if($query->num_rows)
        {
            $user=$query->fetch_assoc();
            return $user['balance'];
        } else {
            return "0.0000";
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getVkId()
    {
        return $this->vk_id;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getUserDataJson()
    {
        $data=array(
            'user_id' => $this->id,
            'vk_id' => $this->vk_id,
            'balance' => $this->balance,
            'status' => $this->status,
        );
        return json_encode($data);
    }
}