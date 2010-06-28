<?php
/**
 * 测试例子
 * @link http://code.google.com/p/phplock/
 * @author sunli
 * @blog http://sunli.cnblogs.com
 * @svnversion  $Id$
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
?>