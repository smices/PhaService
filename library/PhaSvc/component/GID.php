<?php

namespace PhaSvc\Component;

/**
 * Global ID Generator
 * Base snowflake
 *
 * Depend:
 * extension: DonkeyId (https://github.com/osgochina/donkeyid)
 */
class GID
{

    public static $service_no = 00001;

    /**
     * 生成ID
     *
     * @return mixed
     */
    static function next_id()
    {
        return dk_get_next_id();
    }//end


    /**
     * 获取id列表
     *
     * @param     $num  生成id的数量
     * @param int $time 需要生成指定时间的id.$time 默认为0 生成当前时间指定数量的id
     *
     * @return array
     */
    static function next_ids($num, $time = 0)
    {
        return dk_get_next_ids($num, $time);
    }//end


    /**
     * explain global id
     *
     * @param $gid
     *
     * @return null
     * @throws \Exception
     */
    static function explain($gid)
    {
        return dk_parse_id($gid);
    }//end

}//end
