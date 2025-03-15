<?php

session_start();


class DB{
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=db14";
    protected $pdo;
    protected $table;
    public static $type=[
        1=>'健康新知',
        2=>'菸害防治',
        3=>'癌症防治',
        4=>'慢性病防治',
    ];

    function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,'root','');
    }

    function all(...$arg){
        $sql="SELECT * FROM $this->table";
        
        if(!empty($arg[0])){
            if(is_array($arg[0])){
                $where=$this->a2s($arg[0]);
                $sql=$sql . "WHERE" . join(" && ",$where);
            }else{
                $sql .=$arg[0];
            }
        }

        if(!empty($arg[1])){
            $sql=$sql . $arg[1];       
        }
        return $this->fetchAll($sql);
      
    }


    function find($id){
        $sql="SELECT * FROM $this->table";
        if(is_array($id)){
            $where=$this->a2s($id);
            $sql=$sql . " WHERE " . join(" && ",$where);
        }else{
            $sql .=" WHERE `id`='$id' ";
        }
        
        return $this->fetchOne($sql);
    }

    function del($id){
        $sql="DELETE FROM $this->table";
        if(is_array($id)){
            $where=$this->a2s($id);
            $sql=$sql . " WHERE " . join(" && ",$where);
        }else{
            $sql .=" WHERE `id`='$id' ";
        }
        
        return $this->pdo->exec($sql);
    }


  function save($array){
    if(isset($array['id'])){
        $id=$array['id'];
        unset($array['id']);
        $set=$this->a2s($array);
        $sql="UPDATE $this->table SET ".join(',',$set)." WHERE `id`='$id'";

    }else{
        $cols=array_keys($array);
        $sql="INSERT INTO $this->table (`".join("`,`",$cols)."`) VALUES('".join("','",$array)."')";
    }

    return $this->pdo->exec($sql);
  }



}


