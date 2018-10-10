<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Driver as dr;
//套餐表
use app\common\model\DriverTaocan as dt;
use think\Request;
use think\Cache;
class Driver extends Controller{
	public function index(){

		$username=session('username');
		$driver=new dr();
		$drivers=Cache::get('drivers');
		if($drivers==null||$drivers==''){
			$drivers=$driver->select();
			Cache::set('drivers',$drivers);
		}
		
		
		$this->assign('drivers',$drivers);
		$this->assign('username',$username);
		$htmls=$this->fetch();
		return $htmls;
	}
	/**
	*跳转到添加页面		
	*/
	public function add(){
		$htmls=$this->fetch();
		return $htmls;
	}
	/**
	*增加驾校
	*/
	public function insert(){
		$name=$_POST['name'];
		$address=$_POST['address'];
		$distance=$_POST['distance'];
		$driver=new dr();
		$driver->name=$name;
		$driver->address=$address;
		$driver->distance=$distance;
		$driver->save();
		Cache::rm('drivers');
		return "添加成功"."<a href='/home.html'>首页</a>"."<a href='/index/driver/index'>驾校列表</a>";
	}
	/**报名*/
	public function signup($id){
		$taocan=new dt();
		$package=$taocan->where("driver_id",$id)->select();
		$username=session("username");
		$this->assign('packages',$package);
		$this->assign('driverId',$id);
		$this->assign('username',$username);
		$htmls=$this->fetch();
		return $htmls;
	}
	/**跳转到增加套餐页面*/
	public function addPackage(){
		$taocan=new dt();
		$driverId=Request::instance()->param('id');
		$this->assign('driverId',$driverId);
		$htmls=$this->fetch("addPackage");
		return $htmls;
	}
	/**套餐列表*/
	public function package($id){
		//获取前台传过来的id
		//$id=Request::instance()->param('id');				
		$taocan=new dt();
		$username=session("username");
		$package=$taocan->where("driver_id",$id)->select();
		$this->assign('packages',$package);
		$this->assign('driverId',$id);
		$this->assign('username',$username);
		$htmls=$this->fetch();
		return $htmls;
	}
	/**增加套餐*/
	public function insertPackage($driverId){
		//$driverId=Request::instance()->param('driverId');
		//package($driverId);
		$username=session("username");
		$taocan=new dt();
		$taocan->name=$_POST['name'];
		$taocan->price=$_POST['price'];
		$taocan->description=$_POST['description'];
		$taocan->driver_id=$driverId;
		$taocan->save();
		$this->redirect("/index/driver/package",array('id'=>$driverId));
		
		
	}
	public function mode($id,$packageId){
		$username=session("username");
		$this->assign('id',$id);
		$this->assign('packageId',$packageId);
		$taocan=new dt();
		$package=$taocan->get(['id'=>$id]);
		$this->assign('package',$package);
		$this->assign('username',$username);
		$htmls=$this->fetch();
		return $htmls;
	}
	public function deletePackage($packageId){
		$taocan=new dt();
		$s=$taocan->where('id',$packageId)->delete();
		if($s==1){
			return ['txt'=>'删除成功!','status'=>200];
		}else{
			return ['txt'=>'删除失败！','status'=>500];
		}
		return $s;
	}
	public function deleteDriver($id){
		$driver=new dr();
		$s=$driver->where('id',$id)->delete();
		Cache::rm('drivers');
		if($s==1){
			return ['txt'=>'删除成功!','status'=>200];
		}else{
			return ['txt'=>'删除失败！','status'=>500];
		}
		return $s;
	}
}
?>