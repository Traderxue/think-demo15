<?php
namespace app\controller;

use think\Request;
use app\BaseController;
use app\model\Type as TypeModel;
use app\util\Res;

class Type extends BaseController{
    private $result;

    function __construct(\think\App $app){
        $this->result = new Res();
    }

    function add(Request $request){
        $post = $request->post();

        $type = new TypeModel([
            "u_id"=>$post["u_id"],
            "type"=>$post["type"],
            "price"=>$post["price"],
            "add_time"=>date("Y-m-d H:i:s"),
            "up"=>$post["up"]
        ]);

        $res = $type->save();

        if($res){
            return $this->result->success("添加数据成功",$res);
        }
        return $this->result->error("添加数据失败");
    }

    function edit(Request $request){
        $post = $request->post();

        $type = TypeModel::where("id",$post["id"])->find();

        $res = $type->save([
            "price"=>$post["price"],
            "up"=>$post["up"]
        ]);

        if($res){
            return $this->result->success("编辑数据成功",$res);
        }
        return $this->result->error("编辑数据失败");
    }

    function deleteById($id){
        $res = TypeModel::where("id",$id)->delete();

        if($res){
            return $this->result->success("删除数据成功",$res);
        }
        return $this->result->error("删除失败");
    }

    function getAll($u_id){
        $list = TypeModel::where("u_id",$u_id)->select();
        return $this->result->success("获取数据成功",$list);
    }

    function getRun($u_id){
        $list = TypeModel::where("status",1)->where("id",$u_id)->select();
        return $this->result->success("获取数据成功",$list);
    }
}