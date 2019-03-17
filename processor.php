<?php
/**
 * 便利店模块处理程序
 *
 * @author Gorden
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Css9_praiseModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W;
		$content = $this->message['content'];
		$user = pdo_fetchall("SELECT * FROM ".tablename('users'), array(), 'uid');
		return $this->respText($s);
	}
}