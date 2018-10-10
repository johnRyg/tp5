<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Teacher as tm;
class Teacher extends Controller
{
	
    public function index()
    {  
       return 'hello';
	}
	public function listall(){
		
		$model=new tm();
		$teacher=null;
		
		$username=session('username');
		/*if(is_null($username)){
			return "你未登录"."<a href='/login.html'>登录</a>";
		}
		
		if(isset($_POST['name'])){
		$teacher= $model->where('name',$_POST['name'])->select();
		}else{
			
		}*/
		$teacher= $model->select();
		$this->assign('teachers',$teacher);
		$this->assign('username',$username);

				
		$htmls=$this->fetch();
		return $htmls;

	}
	public function add(){
		return $this->fetch();
	}
	public function insert(){
		
		$name=$_POST['name'];
		$sex=$_POST['sex'];
		$email=$_POST['email'];
		$username=$_POST['username'];
		$age=$_POST['age'];
		$model=new tm();
		$model->name=$name;
		$model->sex=$sex;
		$model->email=$email;
		$model->age=$age;
		//$model->username=$username;
		$model->save();
		return "新增成功"."<a href='/index/Teacher/listall'>返回列表</a>";
	}
	
        
}