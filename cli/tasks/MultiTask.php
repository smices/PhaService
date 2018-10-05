<?php

/**
 * Class MultiTask
 *
 * @description('MultiTask', 'MultiTaskMultiTaskMultiTaskMultiTaskMultiTask')
 */


class MultiTask extends TaskBase
{
    /**
     * Main
     * @description('默认消息队列处理')
     *
     * @param({'type'='int', 'name'='worker_num', 'description'='开启处理任务的Worker数量' })
     */
    public function mainAction(array $params)
    {
        $funcMap    = ['a', 'b', 'c'];
        $worker_num = 3;//创建的进程数
        for ($i = 0; $i < $worker_num; $i++) {
            $process = new swoole_process([$this, $funcMap[$i]]);

            $process_name = sprintf(self::APP_SERVICE_NAME . '.%s:WORKER-%d', __CLASS__, $i);
            $process->name($process_name);

            //$process->daemon('true', 'true');
            $pid = $process->start();

            $this->cout('[WORKER CREATED] WORKER_PID:' . $pid, 'f50', TRUE);
            //sleep(2);
        }

        while (1) {
            $ret = swoole_process::wait();
            if ($ret) {// $ret 是个数组 code是进程退出状态码，
                $pid = $ret['pid'];
                //echo PHP_EOL . "Worker Exit, PID=" . $pid . PHP_EOL;
                $this->cout('[WORKER EXITED] WORKER_PID:' . $pid, 'f50', TRUE);
            } else {
                break;
            }
        }

    }//end


    /**
     * @DoNotCover
     */
    public function a(Swoole\Process $process)
    {
        for ($i = 0; $i < 10; $i++) {
            echo 'A:' . $i . PHP_EOL;
            sleep(20);
        }

    }

    /**
     * @DoNotCover
     */
    public function b(Swoole\Process $process)
    {
        for ($i = 0; $i < 10; $i++) {
            echo 'B:' . $i . PHP_EOL;
            sleep(20);
        }
    }

    /**
     * @DoNotCover
     */
    public function c(Swoole\Process $process)
    {
        for ($i = 0; $i < 10; $i++) {
            echo 'C:' . $i . PHP_EOL;
            sleep(20);
        }
    }


}//end

