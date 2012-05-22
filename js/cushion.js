/************************************
�@�@�p�X���[�h�̃}�X�N�\��/��\���̐؂�ւ�
*************************************/
$(function() {
	// �y�[�W�ǂݍ��ݎ��Ƀ`�F�b�N�{�b�N�X�̃`�F�b�N���O��(���Ă���X�V�����ƈ��ڂ̃`�F�b�N�ŉ��������Ȃ��Ȃ�̂�)
	$(".show-pass").attr("checked",false);
	// �`�F�b�N�{�b�N�X���؂�ւ�����Ƃ�
	$(".show-pass").change(function() {
		// �`�F�b�N�����Ă���΃e�L�X�g�ɁA�����łȂ���΃p�X���[�h��replaceWith�Œu��������
		if ($(this).attr('checked')) {
			// html���Ɠ�������,value�Ɍ��݂̒l�����Ă��邾��,���̂�����
			$(".text-pass").replaceWith('<input type="text" name="pass" class="text-input text-pass" value="' + $('.text-pass').val() + '" />');
		} else {
			$(".text-pass").replaceWith('<input type="password" name="pass" class="text-input text-pass" value="' + $('.text-pass').val() + '" />');
		}
	});
});
/************************************
  �v���[�X�z���_�[�̐ݒ�
*************************************/
$(function() {
	// ������Ă���X�V���ꂽ�Ƃ��Ƀv���[�X�z���_�[���Ȃ���ԂɂȂ�̂ōŏ��ɑS�ă`�F�b�N��
	// �l���i�[����Ă��Ȃ��e�L�X�g�{�b�N�X�ɂ̓v���[�X�z���_�[��\������
	$.each($(".text-input"),function() {
		var text = $(this).val();
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// �v���[�X�z���_�[���N���b�N�ł��e�L�X�g�{�b�N�X�Ƀt�H�[�J�X���ڂ�
	$(".placeholder").click(function() {
		// this(����)��prev(�ЂƂO�̗v�f)��focus(�t�H�[�J�X���ڂ�)
		$(this).prev().focus();
	});
	// keydown �L�[������������(�e�L�X�g�ɒl������O)
	// �����͎��ɑS�p/���p�ł������Ă��܂�
	// keyCode229���S�p/���p����,�S�p���͂ǂ̃A���t�@�x�b�g���͂ł�
	// 229�ɂȂ�̂Ŕ��f������̂Œ��߂�(�c�C�b�^�[�͏o���Ă��邯�ǥ��)
	$(".text-input").keydown(function(e) {
		// �����ꂽ�L�[���o�b�N�X�y�[�X�ȊO�Ȃ����
		if(e.keyCode != 8) {
			$(this).next().hide();
		}
	});
	// keyup �L�[����w��b�����u��(�e�L�X�g�ɒl������������)
	// ���̎��ɋ�Ȃ�e�L�X�g�{�b�N�X�ɒl���Ȃ��Ƃ������ƂȂ̂Ńv���[�X�z���_�[��\��
	$(".text-input").keyup(function() {
		var text = $(this).val();
		if(text.length == 0) {
			$(this).next().show();
		}
	});
	// �e�L�X�g�{�b�N�X(.text-input)����t�H�[�J�X���O�ꂽ�Ƃ�
	$(".text-input").blur(function() {
		// �e�L�X�g�̒��g���i�[
		var text = $(this).val();
		// ��������0�Ȃ�v���[�X�z���_�\��(���l�̔�r�Ȃ̂ő����炵��?)
		if(text.length == 0) {
			$(this).next().show();
		}
	});
});
/************************************
�@�@submit���̏���
*************************************/
$(function() {
	// form�̃N���X��
	$(".register").click(function(e) {
		e.preventDefault();
		// GIF��\��
		$(".load-gif").show();
		var sei = $(".text-sei").val();
		var mei = $(".text-mei").val();
		var mail = $(".text-mail").val();
		var pass = $(".text-pass").val();
		$.post("Ajax/check.php",{
			sei:sei,
			mei:mei,
			mail:mail,
			pass:pass
		},function(ret) {
			// ret��OK_NEXT�̏ꍇ�̓G���[���Ȃ��Ƃ������ƂȂ̂Ŕ�΂�
			if(ret != "OK_NEXT") {
				// �G���[���b�Z�[�W����U��\��(���e���������ƕύX���킩��ɂ���)
				$(".result").hide();
				// GIF���\����(�����Ẵt�F�[�h�A�E�g)
				$(".load-gif").fadeOut();
				// �G���[���b�Z�[�W��HTML��PHP����̖߂�l���Z�b�g����
				$(".result").html(ret);
				// �G���[���b�Z�[�W��\��
				$(".result").fadeIn("normal");
			}else{
				// OK�Ȃ̂�submit�𔭐�������
				$(".register_form").trigger("submit");
			}
		});
	});
});
