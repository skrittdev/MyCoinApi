<?php
/**
 * Created by PhpStorm.
 * User: Leonid
 * Date: 13.04.2019
 * Time: 12:08
 */

class Connect
{
    private $host="localhost";
    private $user="jnxdgqdx_bot";
    private $db="jnxdgqdx_bot";
    private $password="300403";
    private $connect;

    /**
     * Connect constructor.
     */
    public function __construct()
    {
        $this->connect = new mysqli($this->host,$this->user,$this->password,$this->db);
        if(!$this->connect)
            die(ApiErrors::getJsonError(1));
        $this->connect->set_charset('urf-8');
    }

    /**
     * @return mysqli
     */
    public function getConnect(): mysqli
    {
        return $this->connect;
    }
}