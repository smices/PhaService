<?php
/**
 * Class MainTask
 *
 * @description('Welcome', '显示欢迎信息')
 */


class MainTask extends TaskBase
{
    public function mainAction()
    {
        return $this->dispatcher->forward([
            "controller" => "info",
            "action"     => "main",
        ]);
    }//end

}//end
