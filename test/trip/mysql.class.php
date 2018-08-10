<?php
require("confing.php");
class mysql{
    var $link;
	var $db_host;
	var $db_user;
	var $db_password;
	var $db;
	var $db_perfix;
	var $db_pc;
	function mysql($db_host,$db_user,$db_password,$db,$db_charset,$pc_connect){
		$this->db_host=$db_host;
		$this->db_user=$db_user;
		$this->db_password=$db_password;
		$this->db=$db;
		$this->db_charset=$db_charset;
		$this->db_pc=$pc_connect;
		$this->open();
		$this->s1_db();
	}

	//连接数据库
	function open_link(){
		$this->link=($this->db_pc)?@mysql_pconnect($this->db_host,$this->db_user,$this->db_password):@mysql_connect($this->bd_host,$this->db_user,$this->db_password);
		if(!$this->link){
			err('数据库连接不成功'.mysql_error(),"javascript:history.go(-1);");
		}
	}

	//查询数据库是否存在
	function s1_db(){
		if(!@mysql_select_db($this->db,$this->link)){
			err('DB_PRE'.$this->db.'不存在',"javascript:history.go(-1);");
		}
		@mysql_unbuffered_query("set names{$this->db_charset}");
	}
	//判断是否可以查询
	function query($sql){
		if(!$res=@mysql_query($sql,$this-link)){
			err('操作数据库失败'.mysql_error()."<br/>sql:{$sql}","javascript:history.go(-1);");
		}
		return $res;
	}

	/*
		*取出数字作为数组索引的数据集合
		*return $array
		* 
	 */
	function fetch_array($sql){
		$result=$this->query($sql);
		while ($rows=mysql_fetch_array($result)) {
			$arr[]=$rows;
		}
		mysql_free_result($result);
		return $arr;
	}

	/*
		*取得上次添加数据的id
		*return $id
	 */
	function insert_id(){
		return mysql_insert_id($this->link);
	}

	//取得一行数据
	function get_row($sql,$row=0,$field=0){
		$rel=$this->query($sql);
		$row=mysql_result($rel,$row,$field);
		mysql_free_result($rel);
		return $row;
	}

	//返回数据数目
	function fetch_rows($sql){
		$result=$this->query($sql);
		$num=@mysql_num_rows($result);
		mysql_free_result($result);
		return $num;
	}

	//返回字段名数组
	function fetch_field($sql){
		$result=$this->query($sql);
		$num=mysql_num_fields($result);
		for($i=0;i<$num;$i++){
			$arr[]=mysql_field_name($result,$i);
		}
		return $arr;
	}

	//创建数据表
	function create_tb($table,$field){
		$sql="create tale ".DB_PRE.$table."(".$field.")ENGIN=MYISAM CHARSRT utf8_general_ci NULL";
		return $this->query($sql);
	}

	//添加字段
	
	function add_field($table,$field){
		$sql="alert table ".DB_PRE.$table."add".$field."CHARACTER SET utf8 COLLATE utf8_general_ci NULL";
		return $this->query($sql);
	}

	//修改字段
	function xg_field($table,$field){
		$sql="alert table ".DB_PRE.$table."CHANGE".$field."CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
		return $this->query($sql);
	}

	//删除字段
	
	function drop_field($table,$field){
		$sql="alert table ".DB_PRE.$table."drop cloumn".$field;
		return $this->query($sql);
	}
	
}

