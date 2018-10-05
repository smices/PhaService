# PhaService
## Phalcon + Swoole 无侵入解决方案 
Phalcon有着强大的性能同时又具备完整的MVC模式,    
Swoole也具备在Phalcon之外的其他能力,如果把两者无缝的结合,   
一定是一个不错的案例.   

所以本项目 同时支持 Nginx+Phalcon 与 Swoole+Phalcon,   
如果使用Nginx做负载均衡,可以做到无缝衔接,有Nginx+php-fpm的稳定,   
同时也能享受Swoole对于API的超高性能.   

本案例可以作为系统服务使用, 也可以做Restful开发使用,作为Web使用更是毫无问题. 

使用 wrk 做的的压测, 在MBP上的结果:
```$bash
wrk -c10000 -d10s --latency  http://127.0.0.1:8080/testRunning 10s test @ http://127.0.0.1:8080/test
  2 threads and 10000 connections
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency    38.66ms   50.01ms 266.35ms   81.83%
    Req/Sec    12.97k     1.54k   16.65k    88.17%
  Latency Distribution
     50%   11.53ms
     75%   68.33ms
     90%  116.48ms
     99%  183.72ms
  242375 requests in 10.06s, 36.59MB read
Requests/sec:  24104.01
Transfer/sec:      3.64MB
```
非常不错的结果. 

## Installation
使用Nginx+php-fpm 是最典型的, 可以.
使用Swoole则更简单了,运行脚本: 
```
./serve start
```
可以使用sys/GenSystemctlService.php可以生成Systemclt service文件,
根据提示安装成服务.
```
cd sys
php GenSystemctlService.php
```

## Configuration

## Features

## Documents
