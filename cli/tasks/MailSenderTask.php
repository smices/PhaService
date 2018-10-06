<?php

/**
 * Class MailSenderTask
 *
 * @description('邮件发送处理', '基于队列的邮件处理单元')
 */
class MailSenderTask extends TaskBase
{
    use MultiProcessor;

    /**
     * Main
     * @description('邮件发送处理')
     *
     * @param({'type'='int', 'name'='worker_num', 'description'='开启处理任务的Worker数量' })
     */
    public function mainAction(array $params)
    {
        $this->CreateMultiProcessor(6,
            self::APP_SERVICE_NAME . '.' . strtoupper(__CLASS__),
            TRUE);
    }//end

    /**
     * 复写本函数进行真实的任务处理.
     * @param $index
     * @param $params
     */
    function RealWork($index, $params)
    {
        for ($i = 0; $i < 10; $i++) {
            $this->cout('[TASK][MAIL_SENDER]', 'f1');
            $this->cout("[" . date("Y/m/d H:i:s") . "]", 'f2');
            $this->cout('WORKER_INDEX:' . $index. ', PROCESS:' . $task. ' [完成]' . $i . PHP_EOL, 'f3');
            echo PHP_EOL;
        }
    }//end

}//end
