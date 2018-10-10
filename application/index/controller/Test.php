<?php
namespace app\index\controller;
use think\Controller;
use think\Cache;
class Test extends Controller{
	
	public function add(){
		if(isset($_POST['key'])&&isset($_POST['value'])){
			$key=$_POST['key'];
			$value=$_POST['value'];
			Cache::set($key,$value,360);
		}
		//$result=Cache::set('key','sc',360);
		//$redis=Cache::get('mykey');
		return "添加成功";
	}

public function get(){
		if(isset($_POST['getKey'])){
			$key=$_POST['getKey'];
			$redis=Cache::get($key);
			var_dump($redis);
			//return $redis;
		}
		//$result=Cache::set('key','sc',360);
		//$redis=Cache::get('mykey');
		//return $redis;
	}
	public function delete(){
		if(isset($_POST['deleteKey'])){
			$key=$_POST['deleteKey'];
			$redis=Cache::rm($key);
			return "删除成功";
		}
		//$result=Cache::set('key','sc',360);
		//$redis=Cache::get('mykey');
		//return $redis;
	}
	public function array1(){
		$teacher=array("name"=>"小明",
			"age"=>32,"sex"=>"男");
		
		Cache::set('teacher',$teacher,360);
	}
}
?>