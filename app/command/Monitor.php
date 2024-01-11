<?php
declare(strict_types=1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use app\util\Email;
use app\util\Okx;
use app\model\Type as TypeModel;
use app\model\User as UserModel;

class Monitor extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('monitor')
            ->setDescription('the monitor command');
    }

    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        $output->writeln('monitor is running');

        $okx = new Okx();
        $email = new Email();

        while (true) {
            $types = TypeModel::where("status", 1)->select();
            foreach ($types as $type) {
                $price = $okx->getPrice($type->type);
                if ($type->up == 1) {
                    if ((float) $price > (float) $type->price) {
                        $user = UserModel::where('id', $type->u_id)->find();
                        $email->sendMail($user->email, $type->type, $price);
                        $type->save([
                            "status" => 0
                        ]);
                    }
                } else {
                    if ((float) $price < (float) $type->price) {
                        $user = UserModel::where('id', $type->u_id)->find();
                        $email->sendMail($user->email, $type->type, $price);
                        $type->save([
                            "status" => 0
                        ]);
                    }
                }
            }
            sleep(30);
        }
    }
}
