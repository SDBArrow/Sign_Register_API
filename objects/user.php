<?php
// 'user' object
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
// create new user record
function create(){
 
    // insert query
    $sql = "INSERT INTO ".$this->table_name." SET firstname=?, lastname=?, email=?, password=?";
 
    // 初始化stat 防sql injection
    $stmt = $this->conn->stmt_init(); 
    $stmt -> prepare($sql); 
 
    // 消毒  strip_tags可不做 htmlspecialchars一定要做。 strip_tags：去掉 HTML 及 PHP 的標記 ; htmlspecialchars，將特殊字元轉成 HTML 格式
    $this->firstname=htmlspecialchars(strip_tags($this->firstname));
    $this->lastname=htmlspecialchars(strip_tags($this->lastname));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));
 
    // 密碼加密
    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

    // 帶入參數
    $stmt -> bind_param('ssss',$this->firstname,$this->lastname,$this->email,$password_hash); 
 
    // execute the query, also check if query was successful
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
 
// emailExists() method will be here
}