<?php
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	session_start();
	$id = $_SESSION["id"];
	// ����̔z����i�[���邱�ƂőS�ẴZ�b�V�����ϐ����폜���邱�Ƃ��ł���
	$_SESSION = array();
	// �Z�b�V������j��(���O�A�E�g)
	session_destroy();
	// �N�b�L�[���폜
	setcookie("token","�N�b�L�[���폜",time() - 60);
	// �f�[�^�x�[�X�ڑ� mysql://���[�U��:�p�X���[�h@�z�X�g��/DB��?charset=�����R�[�h�w��
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// �t�F�b�`���[�h�w��(�񖼎w��)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$sql = "DELETE FROM autologin WHERE user_id = ?";
	$sth = $mdb2->prepare($sql,array("integer"));
	$sth->execute(array($id));
	header("Location:Hackers_top.php");
?>
