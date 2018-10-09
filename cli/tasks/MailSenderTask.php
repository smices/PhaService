<?php
/**
 * Class MailSenderTask
 *
 * @description('邮件发送处理', '基于队列的邮件处理单元')
 */

class MailSenderTask extends TaskBase
{
    use MultiProcessor;

    public $queueName = 'MAIL_SENDER';

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
     * 查看队列信息
     * @description('查看队列信息')
     */
    public function infoAction()
    {
//        foreach ($this->beanstalk->listTubes() as $tube) {
//            $stats = $this->beanstalk->statsTube($tube);
        $stats = $this->beanstalk->statsTube($this->queueName);
        printf(
            "%s:\n\tready: %d\n\treserved: %d\n",
            $this->queueName,
            $stats['current-jobs-ready'],
            $stats['current-jobs-reserved']
        );
//        }
    }//end


    /**
     * 复写本函数进行真实的任务处理.
     *
     * @DoNotCover
     *
     * @param $index
     * @param $params
     */
    public function RealWork($index, $params)
    {
        try {
            static $max_process = 5000;
            static $count = 0;
            $this->beanstalk->useTube($this->queueName);
            while (TRUE) {
                if ($count > $max_process) {
                    $this->dm(
                        'Worker process finished and exit the processor.please restart.',
                        'f1');
                    break;
                }

                if (($job = $this->beanstalk->peekReady()) !== FALSE) {
                    $msg = $job->getBody();


                    //真实业务处理
                    $this->dm($msg, 'f2');
                    //真实业务处理
                    $job->delete();//完成任务, 删除
                    $count++;
                    usleep(200000);

                } else {
                    $this->dm('[SKIP] SLEEPING...', 'f1');
                    sleep(3);//usleep(200000);
                }

            }
        } catch (\Exception $e) {
            $this->dm($e->getMessage(), 'f1');
        }

    }//end

}//end
