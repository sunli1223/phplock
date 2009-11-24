<?php
/**
 * PHPLock进程锁
 * 本进程锁用来解决php在并发时候的锁控制
 * 他根据文件锁来模拟多个进程之间的锁定，效率不是非常高。如果文件建立在内存中，可以大大提高效率。
 * @link http://code.google.com/p/phplock/
 * @author sunli
 * @blog http://sunli.cnblogs.com
 * @svnversion  $Id$
 * @version v1.0 beta1
 * @license Apache License Version 2.0
 * @copyright  sunli1223@gmail.com
 */

class PHPLock {
	/**
	 * 锁文件路径
	 *
	 * @var String
	 */
	private $path = null;
	/**
	 * 文件句柄
	 *
	 * @var resource 
	 */
	private $fp = null;
	/**
	 * 构造函数
	 *
	 * @param string $path 锁的存放目录，以"/"结尾
	 * @param string $name 锁名称，一般在对资源加锁的时候，会命名一个名字，这样不同的资源可以并发的进行。
	 */
	public function __construct($path, $name) {
		$this->path = $path . md5 ( $name ) . '.txt';
	}
	/**
	 * 初始化锁，是加锁前的必须步骤
	 * 打开一个文件
	 *
	 */
	public function startLock() {
		$this->fp = fopen ( $this->path, "w+" );
	}
	/**
	 * 开始加锁
	 *
	 * @return bool 加锁成功返回true,失败返回false
	 */
	public function lock() {
		if ($this->fp === false) {
			return false;
		}
		return flock ( $this->fp, LOCK_EX );
	}
	/**
	 * 释放锁
	 *
	 */
	public function unlock() {
		if ($this->fp !== false) {
			flock ( $this->fp, LOCK_UN );
			clearstatcache ();
		}
	}
	/**
	 * 结束锁控制
	 *
	 */
	public function endLock() {
		fclose ( $this->fp );
	}
}

?>