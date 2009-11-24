<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>简单测试</title>
</head>

<body>
<?php

/**
 * 测试例子，同时打开两个页面，可以发现总是同时只能一个页面进入到锁区间的代码
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
$lock->startLock ();
//process code
echo "<span>进入锁</span><br />\r\n";
ob_end_flush();
flush();
ob_flush();
sleep ( 5 ); //休眠20秒，模拟并发操作
echo "执行完成<br />\r\n";
$lock->unlock ();
$lock->endLock ();
echo "释放锁完成<br />\r\n";
?>
</body>
</html>