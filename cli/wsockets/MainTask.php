<?php

class MainTask extends WebSocketBase
{
    public function mainAction(array $params)
    {
        $fd = $params['fd'];
        $data = $params['data'];
        $this->ws->push($fd, __CLASS__.':'.$data);
        //$ws->push($fd, __CLASS__);
    }//end

}//end
