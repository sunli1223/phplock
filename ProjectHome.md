PHP在多进程模式下（并发的web访问）由于没有内置的锁支持，在处理一些资源的之后，很容易出现并发性问题。

在web开发中我们经常对我们的数据库耗时操作做缓存，但是可能出现一个陷阱，在缓存失效的一瞬间，大量的访问得到缓存失效的标示，都去后端查询数据库，导致

同时大量的数据库耗时查询，出现数据库宕机等问题。此问题隐藏深，不容易查找。本项目主要用于解决php的进程间锁问题。<<?php

/**
 * 测试例子，同时打开两个页面，可以发现总是同时只能一个页面进入到锁区间的代码
 * @link http://code.google.com/p/phplock/
 * @author sunli
 * @blog http://sunli.cnblogs.com
 * @svnversion  $Id: test.php 4 2009-11-25 05:05:13Z sunli1223 $
 * @version v1.0 beta1
 * @license Apache License Version 2.0
 * @copyright  sunli1223@gmail.com
 */

require 'class.phplock.php';
$lock = new PHPLock ( 'lock/', 'lockname' );
$lock->startLock ();
$status = $lock->Lock ();
if (! $status) {
	exit ( "lock error" );
}
echo increment ();
$lock->unlock ();
$lock->endLock ();

function increment() {
	if (! file_exists ( 'testlockfile' )) {
		file_put_contents ( 'testlockfile', 0 );
	}
	$num = file_get_contents ( 'testlockfile' );
	$num = $num + 1;
	file_put_contents ( 'testlockfile', $num );
	return file_get_contents ( 'testlockfile' );
}
/**
 * cache操作
 *
 * @return $array
 */
function getCache($key) {
	return $cache;
}
/**
 * 设置缓存
 *
 * @param string $key
 * @param array $value
 */
function setCache($key, $value) {

}
$key = 'cachekey';
$cache = getCache ( $key );
if (! $cache) {
	//缓存不存在，开始加锁
	$lock = new PHPLock ( 'lock/', $key );
	$lock->startLock ();
	$lock->Lock ();
	//尝试判断缓存是否有数据，可能已经有访问重建缓存了，就不需要再次查询数据库
	$cache = getCache ( $key );
	if (! $cache) {
		//数据库查询操作,代码省略了
		$data = $dbdata;
		setCache ( $key, $data );
	}
	//释放锁
	$lock->unlock ();
	$lock->endLock ();
}

?>}}}```