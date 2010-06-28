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

echo increment ();
function increment() {
	if (! file_exists ( 'testunlockfile' )) {
		file_put_contents ( 'testunlockfile', 0 );
	}
	$num = file_get_contents ( 'testunlockfile' );
	$num = $num + 1;
	file_put_contents ( 'testunlockfile', $num );
	return file_get_contents ( 'testunlockfile' );
}
?>