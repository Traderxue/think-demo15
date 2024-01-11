<?php
namespace app\model;

use think\Model;

class Type extends Model{
    protected $table  = "type";

    function monitor($type){
        $type->save([
            "status"=>0
        ]);
    }
}