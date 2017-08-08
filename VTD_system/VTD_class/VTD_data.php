<?php
/*
**		@author     	Võ Tiến Diễn							**
**		@version    	1.0										**
**		@phone			01699.768.750							**
**		@Facebook		http://fb.com/votiendien95				**
**		@email			tiendien95@gmail.com					**
**		@copyright  	Copyright (C) 2016						**
*/


class data extends system {
	function __construct() {
		
	}
	public function connect () {
		return $GLOBALS['db_connect'];
	}
	public function execute($sql){
		$conn=data::connect();
		return $conn->query($sql);
	}
	public function db_close($sql){
		$conn=data::connect();
		$conn->close();
	}
	public function add($table, $data = array())
	{
	    // Hai biến danh sách fields và values
	    $fields = '';
	    $values = '';
	    // Lặp mảng dữ liệu để nối chuỗi
	    foreach ($data as $field => $value){
	        $fields .= $field .',';
	        $values .= "'".addslashes($value)."',";
	    }
	    // Xóa ký từ , ở cuối chuỗi
	    $fields = trim($fields, ',');
	    $values = trim($values, ',');
	    // Tạo câu SQL
	    //INSERT INTO News (title, content) VALUES ('tieu de', 'noi dung')
	    $sql = "INSERT INTO `".$table."` ($fields) VALUES ({$values})";
	    // Thực hiện INSERT
	    return data::execute($sql);
	}
	public function get_id () {
		$conn=data::connect();
		return $conn->insert_id;
	}
	public function update($table, $data = array(),$where)
	{
	    $str = '';
	    foreach ($data as $key => $value){
            $str.="`".$key."`='".$value."',";
        }
	    $str=trim($str,',');
	    return data::execute("UPDATE `".$table."` SET ".$str." ".$where."");
	}
	public function delete($table,$where=null) {
		$sql="DELETE FROM `".$table."` ".$where."";
		return data::execute($sql);
	}
	public function count_table($table,$where) {
		$conn=data::connect();
		$sql="SELECT * FROM `".$table."` ".$where;
        $result = data::execute($sql);
        return $result->num_rows;
    }
	public function show($table,$where=null,$limit=null) {
		$array = array();
		$conn=data::connect();
		$sql="SELECT * FROM ".$table." ".$where." ".$limit."";
        $result = data::execute($sql);
        //if ($result->num_rows > 0) {
        if (data::count_table($table,$where) > 0) {
        	while($row = $result->fetch_assoc()) {
		        $array[]=$row;
		    }
		    return $array;
        } else {
        	return null;
        }
    }
    
    public function key($table) {
    	/*
		Hàm dùng cho các bảng thuộc loại có 2 col : key và value
	    */
    	$conn=data::connect();
    	$value='';
    	$arr_v = array();
    	$array = array();
    	$arr=data::show($table);
    	foreach ($arr as $k => $v){
    		foreach ($v as $k1 => $v1){
				$value .=$v1."(-vtd|vtd-)";
    		}
    	}
    	$arr_v=explode("(-vtd|vtd-)",$value);
    	$count_arr_v=count($arr_v);
    	for ($i=0; $i<$count_arr_v-1; $i++) {
    		if ($i%2) {
    			continue;
    		} else {
    			$array[$arr_v[$i]]=$arr_v[$i+1];
    		}
    	}
    	return $array;
    }
}
?>