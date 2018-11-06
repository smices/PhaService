<?php

namespace PhaSvc\Http;

use Phalcon\Http\Response as PhResponse;

class Response extends PhResponse
{
    const YES                   = 0;
    const OK                    = 200;
    const CREATED               = 201;
    const ACCEPTED              = 202;
    const MOVED_PERMANENTLY     = 301;
    const FOUND                 = 302;
    const TEMPORARY_REDIRECT    = 307;
    const PERMANENTLY_REDIRECT  = 308;
    const BAD_REQUEST           = 400;
    const UNAUTHORIZED          = 401;
    const FORBIDDEN             = 403;
    const NOT_FOUND             = 404;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED       = 501;
    const BAD_GATEWAY           = 502;

    const BAD_PARAMS         = 4000;
    const RES_DATABASE_ERROR = 4001;
    const RES_NOT_FOUND      = 4002;
    const SIGNATURE_ERROR    = 4003;
    const NETWORK_ERROR      = 4004;
    const RES_PARSE_ERROR    = 4005;
    const RES_REMOTE_ERROR   = 4006;
    const BUSINESS_TIMEOUT   = 4007;

    public $codes = [
        0   => 'Done',
        200 => 'OK',
        301 => 'Moved Permanently',
        302 => 'Found',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',

        4000 => 'Param(s) Error',
        4001 => 'Database Error',
        4002 => 'Resource/Record Not Found',
        4003 => 'Signature Error',
        4004 => 'Network Error',
        4005 => 'Parsing Resource Error',
        4006 => 'Remote Server Response Error',
        4007 => 'The Business Unit Timeout',

    ];


    /**
     * Send API Messages
     *
     * @param int    $code
     * @param string $data
     *
     * @return PhResponse|void
     */
    public function send(int $code = 0, $data = ''): PhResponse
    {
        $ret = [];

        $ret['meta']['v']  = '1.0';
        $ret['meta']['ts'] = time();

        $ret['code'] = $code;
        $ret['data'] = $data;

        if (0 != $code) {
            $ret['except'] = $this->codes[$code];
        }

        $this->setJsonContent($ret);
        return parent::send();
    }//end


    /**
     * Get code description
     *
     * @param int $code
     *
     * @return int|string
     */
    public function getCodeDescription(int $code)
    {
        if (TRUE === isset($this->codes[$code])) {
            return sprintf('%d:%s', $code, $this->codes[$code]);
        }

        return $code;
    }//end

}//end
