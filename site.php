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
		$tags = pdo_fetchall("SELECT * FROM ".tablename('cjd_praise_tag')." ORDER BY createAt ASC");
		include $this->template('tag');
	}
	public function doWebAddTag(){
		global $_W,$_GPC;
		$json = array(
			'code'	=> 0,
			'msg'	=> '添加出错'
		);
		if(isset($_GPC['tag'])){
			$total = pdo_fetch("SELECT COUNT(*) as count FROM ".tablename('cjd_praise_tag')." WHERE `name` = :name LIMIT 1", array(':name' => $_GPC['tag']));
			if($total['count'] > 0){
				$json = array(
					'code'	=> 0,
					'msg'	=> '该标签已经添加过了'
				);
			}else if(empty($_GPC['tag'])){
				$json = array(
					'code'	=> 0,
					'msg'	=> '标签不能为空'
				);
			}else{
				$result = pdo_insert('cjd_praise_tag', array('name'=>$_GPC['tag'],'createAt'=>date('y-m-d'),'enabled'=>1));
				if (!empty($result)) {
					$row = pdo_fetch("SELECT * FROM ".tablename('cjd_praise_tag')." WHERE `name` = :name LIMIT 1", array(':name' => $_GPC['tag']));
					$json = array(
						'code'	=> 1,
						'name'	=> $row['name'],
						'id'	=> $row['id'],
						'msg'	=> '添加成功'
					);
				}
			}
		}
		die(json_encode($json));
	}
	public function doWebAddContent(){
		global $_W,$_GPC;
		$json = array(
			'code'	=> 0,
			'msg'	=> '添加出错'
		);
		if(isset($_GPC['content']) && isset($_GPC['tag'])){
			$total = pdo_fetch("SELECT COUNT(*) as count FROM ".tablename('cjd_praise_content')." WHERE `content` = :content LIMIT 1", array(':content' => $_GPC['content']));
			if($total['count'] > 0){
				$json = array(
					'code'	=> 0,
					'msg'	=> '内容已经添加过了'
				);
			/*}else if(empty($_GPC['tag']) || empty($_GPC['content'])){
				$json = array(
					'code'	=> 0,
					'msg'	=> '内容或标签不能为空'
				);
			}
			*/
			}else{
				$result = pdo_insert('cjd_praise_content', array('content'=>$_GPC['content'],'tag'=>$_GPC['tag'],'createAt'=>date('y-m-d'),'enabled'=>1));
				if (!empty($result)) {
					$json = array(
						'code'	=> 1,
						'msg'	=> '添加成功'
					);
				}
			}
		}
		die(json_encode($json));
	}
	public function doWebDeleteTag(){
		global $_W,$_GPC;
		$json = array(
			'code'	=> 0,
			'msg'	=> '删除失败'
		);
		if(isset($_GPC['tag'])){
			$result = pdo_delete('cjd_praise_tag', array('id' => $_GPC['tag']));
			if (!empty($result)) {
				$json = array(
					'code'	=> 1,
					'msg'	=> '删除成功'
				);
			}
		}
		die(json_encode($json));
	}
	public function doWebList(){
		global $_W,$_GPC;
		$pageSize = 15;
		$query = load()->object('query');
		$total = $query->from('cjd_praise_content', 'u')->count();
		$page = 0;
		if(empty($_GPC['page']) || $_GPC['page'] == 1 || $_GPC['page'] == 0){
			$page = 0;
		}else{
			$page = $pageSize*($_GPC['page']-1);
		}
		$content = $query->from('cjd_praise_content', 'u')->limit($page, $pageSize)->getall();
		//$content = pdo_fetchall('SELECT * FROM '.tablename('cjd_praise_content').' LIMIT 20');
		$list = array();
		foreach ($content as $key => $value) {
			$tags = pdo_fetchall('SELECT * FROM '.tablename('cjd_praise_tag').' WHERE FIND_IN_SET(id,"'.$value['tag'].'")');
			$list[] = array(
				'id'		=> $value['id'],
				'content'	=> $value['content'],
				'tag'		=> $tags
			);
		}
		include $this->template('list');
	}
	public function doWebContent(){
		global $_W,$_GPC;
		$tags = pdo_fetchall("SELECT * FROM ".tablename('cjd_praise_tag')." ORDER BY createAt ASC");
		include $this->template('content');
	}
	public function doWebDeleteContent(){
		global $_W,$_GPC;
		$json = array(
			'code'	=> 0,
			'msg'	=> '删除失败'
		);
		if(isset($_GPC['id'])){
			$result = pdo_delete('cjd_praise_content', array('id' => $_GPC['id']));
			if (!empty($result)) {
			    $json = array(
					'code'	=> 1,
					'msg'	=> '删除成功'
				);
			}
		}
		die(json_encode($json));
	}
	public function doWebUpdateContent(){
		global $_W,$_GPC;
		$json = array(
			'code'	=> 0,
			'msg'	=> '删除失败'
		);
		if(isset($_GPC['id'])){
			$update_data = array();
			if(isset($_GPC['content'])){
				$update_data = array(
			    	'content' => $_GPC['content'],
			    	'tag'     => $_GPC['tag'],
				);
				$total = pdo_fetch("SELECT COUNT(*) as count FROM ".tablename('cjd_praise_content')." WHERE `content` = :content LIMIT 1", array(':content' => $_GPC['content']));
				if($total['count'] > 0){
					$json = array(
						'code'	=> 0,
						'msg'	=> '内容已存在'
					);
				}else{
					$result = pdo_update('cjd_praise_content', $update_data, array('id' => $_GPC['id']));
					if (!empty($result)) {
					    $json = array(
							'code'	=> 1,
							'msg'	=> '修改成功'
						);
					}
				}
			} 
		}
		die(json_encode($json));
	}
}