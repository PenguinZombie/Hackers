<?php
	require_once("MDB2.php");
	session_start();
	$id = $_SESSION["id"];
	// �f�[�^�x�[�X�ڑ� mysql://���[�U��:�p�X���[�h@�z�X�g��/DB��?charset=�����R�[�h�w��
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// �t�F�b�`���[�h�ݒ� �J���������L�[�Ƃ���(���̗񖼂Ɋ֌W�Ȃ��K��������)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	// sql��,id���L�[�Ɍ��݂̃��[�e�B���O�̒l������Ă���
	$sql = "SELECT * FROM user_rating WHERE user_id = ?";
	$sth = $mdb2->prepare($sql,array("integer"));
	$rs = $sth->execute(array($id));
	$rows = $rs->fetchRow();
	// 1�s�ł������(�K������)
	if($rows > 0) {
		// ��ނ𔻕�,0�Ȃ�PG,SE 1�Ȃ�web�n �킯��͎̂�ނɉ����č��ڂ��Ⴄ����
		if($rows["user_syurui"] == 0) {
			// ������
		}else{
			// �S�Ēl��ϐ��Ɋi�[����(html���ł킩��₷��) �������DB�Ɋi�[����l�Ȃ̂�-6�͂��Ȃ�
			// js���ł���Ƃ�₱�����̂Ł�10���Ċi�[����
			$rating = array(
				$rows["user_idea"] / 10,
				$rows["user_algorithm"] / 10,
				$rows["user_design"] / 10,
				$rows["user_serverside"] / 10,
				$rows["user_clientside"] / 10,
				$rows["user_db"] / 10,
				$rows["user_linux"] / 10
			);
		}
	}
	$rating_csv = join(",",$rating); 
	echo $rating_csv
?>