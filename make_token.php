<?php
	function make_Token() {
		// ��T�ԕ��̎���
		$timeout = 7 * 24 * 60 * 60;
		// ���݂̎��ԂɃv���X����
		$expires = time() + $timeout;
		// ���j�[�Nid+����+���ݎ����Ń��j�[�N�Ȓl���쐬����
		$token = uniqid() . mt_rand() . time();
		// �߂�l����Ȃ̂Ŕz��ŕԂ�,�󂯎�葤��list($a,$b) �ϐ��ЂƂ��Ǝ����Ŕz��ɂȂ�
		return array($token,$expires);
	}
?>