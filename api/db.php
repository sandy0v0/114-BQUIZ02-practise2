<?php

session_start();

class DB{
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=db14-2-p3";
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
        $sql="SELECT * FROM $this->table ";
        if(!empty($arg[0])){
            if(is_array($arg[0])){
                $where=$this->a2s($arg[0]);
                $sql=$sql ." WHERE ". join(" && ",$where);
            }else{
                $sql .= $arg[0];
            }
        }

        if(!empty($arg[1])){
            $sql=$sql . $arg[1];
        }

        return $this->fetchAll($sql);

    }

    function find($id){
        $sql="SELECT * FROM $this->table ";

        if(is_array($id)){
            $where=$this->a2s($id);
            $sql=$sql ." WHERE ". join(" && ",$where);
        }else{
            $sql .= " WHERE `id`='$id' ";
        }
        return $this->fetchOne($sql);

    }

    function save($array){

        if(isset($array['id'])){
            $id=$array['id'];
            unset($array['id']);
            $set=$this->a2s($array);
            $sql ="UPDATE $this->table SET ".join(',',$set)." where `id`='$id'";

        }else{
            $cols=array_keys($array);
            $sql ="INSERT INTO $this->table (`".join("`,`",$cols)."`) VALUES('".join("','",$array)."')";
        }

        return $this->pdo->exec($sql);

    }

    function del($id){
        $sql="DELETE FROM $this->table ";

        if(is_array($id)){
            $where=$this->a2s($id);
            $sql=$sql ." WHERE ". join(" && ",$where);
        }else{
            $sql .= " WHERE `id`='$id' ";
        }
        return $this->pdo->exec($sql);

    }

    function a2s($array){
        $tmp=[];
        foreach($array as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        return $tmp;
    }

    function max($col,$where=[]){
        return $this->math('max',$col,$where);
    }
    function sum($col,$where=[]){
        return $this->math('sum',$col,$where);
    }
    function min($col,$where=[]){
        return $this->math('min',$col,$where);
    }
    function avg($col,$where=[]){
        return $this->avg('avg',$col,$where);
    }
    function count($where=[]){
        return $this->math('count','*',$where);
    }

    protected function fetchOne($sql){
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    protected function fetchAll($sql){
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function math($math,$col='id',$where=[]){
        $sql="SELECT $math($col) FROM $this->table";

        if(!empty($where)){
            $tmp=$this->a2s($where);
            $sql=$sql ." WHERE ". join(" && ",$tmp);
        }

        return $this->pdo->query($sql)->fetchColumn();
    }

}

function q($sql){
    $pdo=new PDO("mysql:host=localhost;charset=utf8;dbname=db14-2-p3",'root','');
    return $pdo->query($sql)->fetchAll();
}

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function to($url){
    header("location:".$url);
}

$Total=new DB('tortal');
$User=new DB('users');
$News=new DB('news');
$Que=new DB('que');
$Log=new DB('log');

if(!isset($_SESSION['view'])){
    if($Total->count(['date'=>date("Y-m-d")])>0){
        $total=$Total->find(['date'=>date("Y-m-d")]);
        $total['total']++;
        $Total->save($total);
    }else{
        $Total->save(['date'=>date("Y-m-d"),'total'=>1]);
    }
    $_SESSION['view']=1;
}

















?>