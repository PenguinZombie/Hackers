<?php
	// �C���N���[�g�̃p�X�ݒ�
	ini_set('include_path','PEAR');
	require_once("MDB2.php");
	session_start();
	$id = $_SESSION["id"];
	// DB�̏���
	// �f�[�^�x�[�X�ڑ� mysql://���[�U��:�p�X���[�h@�z�X�g��/DB��?charset=�����R�[�h�w��
	$mdb2 = MDB2::connect("mysql://LAA0170018:kouyansaiko@mysql561.phy.lolipop.jp/LAA0170018-seisaku?charset=utf8");
	// $mdb2 = MDB2::connect("mysql://root:kouyansaiko@localhost/hackers?charset=utf8");
	// �t�F�b�`���[�h�ݒ� �J���������L�[�Ƃ���(���̗񖼂Ɋ֌W�Ȃ��K��������)
	$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
	// id�������ł����ꖼ���������̂�ύX
	$sql = "UPDATE user_lang SET user_color = ? WHERE user_id = ? AND user_lang = ?";
	$sth = $mdb2->prepare($sql,array("text","integer","text"));
	$loop = $_POST["kazu"];
	for($i=0; $i<$loop; $i++) {
		// ����,�F�ő����Ă���̂ŋ�؂��Ċi�[(0�Ɍ���,1�ɐF������)
		$langset = preg_split("/,/",$_POST["tokui" . $i]);
		$sth->execute(array($langset[1],$id,$langset[0]));
	}
	header("Location:Hackers_settei.php?ok_lang");
?>