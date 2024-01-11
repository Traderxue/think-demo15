<?php
namespace app\controller;

use think\Request;
use app\BaseController;
use app\model\User as UserModel;
use app\util\Res;
use Firebase\JWT\JWT;
use app\util\Upload;

class User extends BaseController
{
    private $result;

    function __construct(\think\App $app)
    {
        $this->result = new Res();
    }

    function register(Request $request)
    {
        $post = $request->post();

        $u = UserModel::where('username', $post["username"])->find();

        if ($u) {
            return $this->result->error("用户已存在");
        }

        $user = new UserModel([
            "username" => $post["username"],
            "password" => password_hash($post["password"], PASSWORD_DEFAULT),
            "email" => $post["email"]
        ]);

        $res = $user->save();

        if ($res) {
            return $this->result->success("注册成功", $user);
        }
        return $this->result->error("注册失败");
    }

    function login(Request $request)
    {
        $post = $request->post();

        $user = UserModel::where("username", $post["username"])->find();

        if (!$user) {
            return $this->result->error("用户不存在");
        }

        if (password_verify($post["password"], $user->password)) {

            $secretKey = '123456789'; // 用于签名令牌的密钥，请更改为安全的密钥

            $payload = array(
                // "iss" => "http://127.0.0.1:8000",  // JWT的签发者
                // "aud" => "http://127.0.0.1:9528/",  // JWT的接收者可以省略
                "iat" => time(),  // token 的创建时间
                "nbf" => time(),  // token 的生效时间
                "exp" => time() + 3600,  // token 的过期时间
                "data" => [
                    // 包含的用户信息等数据
                ]
            );
            // 使用密钥进行签名
            $token = JWT::encode($payload, $secretKey, 'HS256');
            return $this->result->success("登录成功", [
                "user"=>$user,
                "data"=>$token
            ]
    );
        }
        return $this->result->error("登录失败");

    }

    function edit(Request $reqeust)
    {
        $upload = new Upload();

        $post = $reqeust->post();

        $user = UserModel::where("id", $post["id"])->find();

        $url = $upload->file($reqeust);

        $res = $user->save([
            "nickname" => $post["nickname"],
            "email" => $post["email"],
            "avatar" => $url
        ]);

        if ($res) {
            return $this->result->success("编辑数据成功", $res);
        }
        return $this->result->error("编辑数据失败");
    }


}