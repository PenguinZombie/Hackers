<?php
	// �C���N���[�h�p�X��ݒ�
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	session_start();
	$id = $_SESSION["id"];
	// �ύX��̃��[�e�B���O�̒l��10�{���Ď󂯎��
	$idea = $_POST["slider_idea_value"] * 10;
	$algorithm = $_POST["slider_algorithm_value"] * 10;
	$design = $_POST["slider_design_value"] * 10;
	$serverside = $_POST["slider_serverside_value"] * 10;
	$clientside = $_POST["slider_clientside_value"] * 10;
	$db = $_POST["slider_db_value"] * 10;
	$linux = $_POST["slider_linux_value"] * 10;
	// �C���T�[�g�������Ɛݒ��ʂɖ߂�,�ύX�����̕������o��
	// �f�[�^�x�[�X�ڑ� mysql://���[�U��:�p�X���[�h@�z�X�g��/DB��?charset=�����R�[�h�w��
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// �t�F�b�`���[�h�ݒ� �J���������L�[�Ƃ���(���̗񖼂Ɋ֌W�Ȃ��K��������)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	$sql = "UPDATE user_rating SET user_idea = ?";
	$sql.= ",user_algorithm = ?";
	$sql.= ",user_design = ?";
	$sql.= ",user_serverside = ?";
	$sql.= ",user_clientside = ?";
	$sql.= ",user_db = ?";
	$sql.= ",user_linux = ?";
	$sql.= " WHERE user_id = ?";
	// �f�[�^�^�w��
	$sth = $mdb2->prepare($sql,array("integer","integer","integer","integer","integer","integer","integer","integer"));
	// �l��n���Ď��s(UPDATE)
	$sth->execute(array($idea,$algorithm,$design,$serverside,$clientside,$db,$linux,$id));
	// �o�^���܂����̉�ʂ��o���Ȃ��^�C�v�ɂ���(�V�K�o�^�Ƃ͈Ⴄ)
	// �ύX��ʂɃ��b�Z�[�W���o���ĕ\������`�ɂ���
	header("location:Hackers_settei.php?ok_rating");
?>