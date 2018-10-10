<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\User;
class Home extends Controller{
	public function index(){
		return 'index';
	}
	public function register(){
		$model=new User();
		if(!isset($_POST['loginname'])||!isset($_POST['password'])){
			return '遇到错误了';
		}
		$username=$_POST['loginname'];
		$password=$_POST['password'];
		$model->username=$username;
		$model->password=$password;
		$model->address='123';
		$model->age=13;
		$model->save();
		return '注册成功'."<a href='../../login.html'>登录</a>";
	}
	public function login(){

		$model=new User();
		if(!isset($_POST['loginname'])||!isset($_POST['password'])){
			return '遇到错误了';
		}
		$username=$_POST['loginname'];
		$password=$_POST['password'];
		$model->username=$username;
		$model->password=$password;
		$user=$model::get(['username'=>$username]);
		if($password==$user->password){
			session('username',$username);
			return "登陆成功"."<a href='/index/teacher/listall'>教师列表</a>";
		}

		return '密码错误'."<a href='/login.html'>重新登录</a>";
	}
	public function logout(){
		session('username',null);
		return "注销成功"."<a href='/login.html'>登录</a>"."<a href='/regist.html'>注册</a>"."<a href='/login.html'>登录</a>"."<a href='/home.html'>首页</a>";
	}

}
?>