<?php
/**
 * 便利店模块微站定义
 *
 * @author Gorden
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Css9_praiseModuleSite extends WeModuleSite {
	public function doWebTag(){
		global $_W,$_GPC;

		include $this->template('tag');
	}
	public function doWebContent(){
		global $_W,$_GPC;

		include $this->template('content');
	}
}