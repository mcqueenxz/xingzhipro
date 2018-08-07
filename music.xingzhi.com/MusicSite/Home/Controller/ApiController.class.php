<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\SingerModel;
use Home\Model\SingeralbumModel;
use Home\Model\SongModel;
use Home\Model\MusicModel;
/**
 * API 接口文件.
 * @author xingzhi 2018年8月6日下午5:49:30
 *
 */
class ApiController extends Controller {
	/**
	 * 结果对象.
	 * @author xingzhi 2018年8月6日下午5:50:06
	 * @var array
	 */	
	private $result = array( 
			'code'=>'0',
			'msg'=>'Success',
			'result' => ''
	);
	
	/**
	 * 添加歌手信息.
	 * @author xingzhi 2017年6月24日下午6:01:36
	 * @param string $singername 歌手名称
	 * @param string $gender 性别
	 * @param string $region 所属地区
	 */
	public function addsinger($singername, $gender, $region) {
		if (empty( $singername )) {
			$this->result ['msg'] = '歌手名称必须填写.';
		} else {
			$singerdb = new SingerModel();
			$this->result['code'] = $singerdb->add_singer($singername, $gender, $region);
			if ($this->result['code'] < 1) {
				$this->result['msg'] = '添加歌手'.$singername.'失败.';
			} else {
				$this->result['msg'] = '添加歌手'.$singername.'成功.';
			}
		}
		echo json_encode( $this->result );
	}
	/**
	 * 获取全部歌手.
	 * @author xingzhi 2018年8月7日上午10:26:20
	 */
	public function getsingerlist() {
		$singerdb = new SingerModel();
		$array = $singerdb->get_singer_list();
		$this->result['result'] = $array;
		echo get_url_param( 'callback' )."(".json_encode( $this->result ).")";
	}
	/**
	 * 获取专辑列表
	 * @author xingzhi 2018年8月7日上午10:32:02
	 * @param int $singerId 歌手主键
	 * @param int $index 索引页
	 * @param int $rows 显示行.
	 */
	public function getalbumlist($singerId, $index, $rows) {
		$albumdb = new SingeralbumModel ();
		$this->result ['result'] = $albumdb->get_album_list( $singerId, $index, $rows );
		$this->result ['msg'] = '';
		echo get_url_param( 'callback' )."(" . json_encode( $this->result ).")";
	}
	/**
	 * 
	 * 获取专辑列表
	 * @author xingzhi 2018年8月5日上午11:13:24
	 * @param int $albumId 专辑主键.
	 */
	public function getalbuminfo($albumId) {
		$singeralbum = new SingeralbumModel ();
		$result = $singeralbum->get_album_byid( $albumId );
		$this->result ['result'] = $result;
		echo get_url_param( 'callback' )."(".json_encode( $this->result ).")";
	}
	/**
	 * 获取歌曲列表
	 * @author xingzhi 2018年8月6日上午9:33:50
	 * @param int $albumnId 专辑主键id
	 */
	public function getsonglist($albumnId) {
		$songdb = new SongModel();
		$this->result ['result'] = $songdb->get_song_list($albumnId);
		echo get_url_param ('callback')."(".json_encode($this->result).")";
	}

	/**
	 * 上传专辑信息
	 * @author xingzhi 2017年6月24日下午2:09:06
	 */
	public function addalbumn() {
		$singerid = get_url_param ( "sid" );
		$albumname = get_url_param ( "albumname" );
		$issueyear = get_url_param ( "issueyear" ); // 发行年份
		$issuetime = get_url_param ( "issuetime" );
		$languages = get_url_param ( "languages" ); // 语言类型
		$issuemonth = get_url_param ( "issuemonth" ); // 发行月份
		
		if (empty ( $issuetime )) {
			$issuetime = $issueyear . date ( '-m-d' );
		}
		
		// 原始文件名
		$original = $_FILES ['filedata'] ['name'];
		// 临时图片路径
		$temp_img = $_FILES ['filedata'] ['tmp_name'];
		// 图片大小
		//$img_size = $_FILES ['filedata'] ['size'];
		// 文件扩展名
		$file_ex = get_file_ext ( $original );
		// 文件名
		$file_name = create_guid () . $file_ex;
		
		$save_root = C ( 'SAVE_ROOT_IMAGE_MUSIC' );
		$dir_path = '/' . date ( 'Ym' ) . '/';
		// 创建不存在的文件夹
		if (! is_dir ( $save_root . $dir_path )) {
			mkdir ( $save_root . $dir_path, 0777, true );
		}
		// 调用Model层进行数据添加.
		$albumndb = new SingeralbumModel ();
		$rs = $albumndb->add_album ( $albumname, $singerid, $issueyear, $issuemonth, $dir_path . $file_name, $issuetime, $languages );
		$this->result ['code'] = $rs;
		if ($rs > 0) {
			$movers = move_uploaded_file ( $temp_img, $save_root . $dir_path . $file_name );
			if ($movers) {
				$this->result ['msg'] = '专辑【' . $albumname . '】上传成功.';
			} else {
				$this->result ['msg'] = '数据上传成功.封面图片移动失败.';
			}
		} else {
			$this->result ['code'] = 0;
			$this->result ['msg'] = $albumname . "数据上传失败";
		}
		
		echo json_encode ( $this->result );
	}
	/**
	 * 删除歌曲信息
	 *
	 * @author 邢志 2017年10月4日上午9:29:04
	 */
	public function deletesong($songid) {
		if (empty ( $songid )) {
			$this->result['result'] = 1;
			$this->result['msg'] = '歌曲主键错误.';
		} else {
			$songdb = new SongModel ();
			$songarray = $songdb->get_song_byid ( $songid );
			if (! empty ( $songarray )) {
				$rs = $songdb->deletesong ( $songid );
				$this->result ['result'] = $rs;
				$path_root = C ( 'SAVE_ROOT_MUSIC_FILE' );
				// 在utf-8编码时，对中文路径的文件，需要先做gbk编码处理.
				$delresult = @unlink ( iconv ( 'utf-8', 'gbk', $path_root . $songarray [0] ['path'] ) );
				if ($delresult) {
					$this->result ['msg'] = '歌曲【' . $songarray [0] ['songname'] . '】删除完毕.';
				} else {
					$this->result ['msg'] = '歌曲【' . $songarray [0] ['songname'] . '】删除数据.但文件无法删除.';
				}
			}
		}
		echo json_encode ( $this->result );
	}

	/**
	 * 歌曲编辑页
	 * @author xingzhi 2018年8月7日下午3:17:40
	 * @param string $op 操作类型 
	 * @param int $songid 歌曲主键id
	 * @param string $songname 歌曲名称
	 * @param string $byword 作词
	 * @param string $bymusic 作曲
	 * @param string $bianqu 编曲
	 * @param string $feat 合唱者
	 * @param string $notes 备注说明
	 * @param string $songword 歌词信息
	 */
	public function editsong($op, $songid, $songname, $byword, $bymusic, $bianqu, $feat, $notes, $songword) {
		// 获取歌曲信息
		$songdb = new SongModel ();
		$song = $songdb->get_song_byid ( $songid );
		// $song_path = C('SAVE_ROOT_MUSIC_FILE').$song[0]['path'];
		if (empty ( $op )) {
			$this->assign ( 'song', $song );
			$this->assign ( 'songid', $songid );
			$this->display ( 'editsong' );
		} else {
			// 修改数据
			$value = $songdb->editor_song ( $songid, $songname, $byword, $bymusic, $bianqu, $feat, $notes, $songword );
			// 增加数据到MongoDB.
			$mongo = new MusicModel ();
			$songModel = $mongo->queryone($songid);
			if(is_null($songModel)){
				$mongo->insert( $songid, $songword );
			} else {
				$mongo->update($songid, $songword);
			}
			// if($value > 0) {
			// //重命名文件.
			// rename($song_path, $songname);
			// }
			$result = array (
					"result" => $value
			);
			echo json_encode ( $result );
		}
	}

}