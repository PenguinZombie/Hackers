<?php
	session_start();
	$id = $_SESSION["id"];
	$text = $_SESSION["diary_text"];
	// mysql�̃f�[�^�̃t�H�[�}�b�g�ɍ��킹��
	$today = time();
	// ���L�̓��e�̃Z�b�V������j��
	unset($_SESSION["diary_text"]);
	// �C���N���[�h�p�X��ݒ�
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	// �C���T�[�g�������Ɛݒ��ʂɖ߂�,�ύX�����̕������o��
	// �f�[�^�x�[�X�ڑ� mysql://���[�U��:�p�X���[�h@�z�X�g��/DB��?charset=�����R�[�h�w��
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// �t�F�b�`���[�h�ݒ� �J���������L�[�Ƃ���(���̗񖼂Ɋ֌W�Ȃ��K��������)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$sql = "INSERT INTO user_diary(user_id,user_text,user_time) ";
	$sql.= "VALUES(?,?,?)";
	$sth = $mdb2->prepare($sql,array("integer","text","integer"));
	$sth->execute(array($id,$text,$today));
	header("Location:Hackers_diary.php");
?>