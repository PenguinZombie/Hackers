$(function() {
	$.post("Ajax/pjax_bool.php",function(ret) {
		if(ret) {
			$(".center_con").show("slide",{direction:"left"},200);
		}
	});
	// �E�ރ{�^���N���b�N��
	$(".dattai").click(function() {
		// id��com_no���i�[���Ă���
		var com_no = $(this).attr("id");
		// �߂�l�ɒE�ތ�̃R�~���j�e�B���󂯎��̂Ŕ��f������
		$.post("Ajax/com_dattai.php",{com_no:com_no},function(ret) {
			$(".sonota_com").html(ret);
		});
		$(".com_info_" + com_no).slideUp("fast");
	});
	// �Q���{�^���N���b�N��
	$(".sanka").click(function() {
		var com_no = $(this).attr("id");
		// �߂�l�ɎQ����̃R�~���j�e�B���󂯎��̂Ŕ��f������
		$.post("Ajax/com_sanka.php",{com_no:com_no},function(ret) {
			$(".my_com_area").html(ret);
		});
		$(".com_info_" + com_no).slideUp("fast");
	});
});
/************************************
  �v���[�X�z���_�[�̐ݒ�
*************************************/
$(function() {
	// �v���[�X�z���_�[���N���b�N�ł��e�L�X�g�{�b�N�X�Ƀt�H�[�J�X���ڂ�
	$(".placeholder").click(function() {
		// this(����)��prev(�ЂƂO�̗v�f)��focus(�t�H�[�J�X���ڂ�)
		$(this).prev().focus();
	});
	// keydown �L�[������������(�e�L�X�g�ɒl������O)
	// �����͎��ɑS�p/���p�ł������Ă��܂�
	// keyCode229���S�p/���p����,�S�p���͂ǂ̃A���t�@�x�b�g���͂ł�
	// 229�ɂȂ�̂Ŕ��f������̂Œ��߂�(�c�C�b�^�[�͏o���Ă��邯�ǥ��)
	$(".com_search").keydown(function(e) {
		// �����ꂽ�L�[���o�b�N�X�y�[�X�ȊO�Ȃ����
		if(e.keyCode != 8) {
			$(this).next().hide();
		}
	});
	// keyup �L�[����w��b�����u��(�e�L�X�g�ɒl������������)
	// ���̎��ɋ�Ȃ�e�L�X�g�{�b�N�X�ɒl���Ȃ��Ƃ������ƂȂ̂Ńv���[�X�z���_�[��\��
	$(".com_search").keyup(function() {
		var text = $(this).val();
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// �e�L�X�g�{�b�N�X(.text-input)����t�H�[�J�X���O�ꂽ�Ƃ�
	$(".com_search").blur(function() {
		// �e�L�X�g�̒��g���i�[
		var text = $(this).val();
		// ��������0�Ȃ�v���[�X�z���_�\��(���l�̔�r�Ȃ̂ő����炵��?)
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// �y�[�X�g������
	$(".com_search").bind("paste",function() {
		$(this).next().hide();
	});
});