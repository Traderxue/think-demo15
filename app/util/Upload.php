<?php
namespace app\util;

class Upload
{
    public function file($request)
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 上传到本地服务器
        $savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file);

        // topic/20240111\f58221bf0a8bee5f909befe321317cec.png

        $savename = str_replace("\\","/",$savename);

        return $request->domain() ."/storage/". $savename;

    }
}