$(function() {
	// pjax�@�� .js-pjax�ɐݒ�
	// .center_con�̒��g��pjax�Ő؂�ւ���
	$(".js-pjax").pjax(".center_con");
	// �ݒ��ʓ��������x���̂Ō��h��������,�N���b�N���ꂽ�Ƃ��ɃR���e���c�������\���ɂ�,�������I���Ε\���ɂ���
	// p=1���̉�ʂ̂Ƃ��ɓ��L�������Ɖ��̂��G���[����������(�v���O�C�����Ƃ������ǂݍ��݂̖��݂���)
	// p=0�ɖ߂��ĉ����ƃG���[�͂łȂ��A�����ł��Ȃ��̂ŃN���b�N���ꂽURL�����L��href + �Z�b�V�����������pjax���g�p���Ȃ��Ŕ�΂�
	$(".js-pjax").click(function() {
		// �N���b�N���ꂽURL���擾���Ă���,$.post�̒��ł͎擾�o���Ȃ�
		var url = $(this).attr("href");
		// �X���C�h������ɔ�΂�
		$(".center_con").hide("slide",{direction:"right"},200,function() {
			// ���L�y�[�W�Ȃ�v���O�C���̊֌W�ŕK���X�V
			if(url == "Hackers_diary.php") {
				$.post("Ajax/syntax_ok.php",function(ret) {
					location.href = "Hackers_diary.php";
				});
			}
		});
	});
});