$(function() {
	// �����ŏ������I�����Ă��邩�킩��Ȃ�����,�R�[���o�b�N���Ȃ��̂ł����ɋL�q
	// �X���C�h��(show)�ɃT�C�h���j���[���N���b�N������show��2��d�Ȃ邱�Ƃ�����̂�,css��diplay�̏�ԂƗ����Ŕ���
	$.post("Ajax/pjax_bool.php",function(ret) {
		if(ret) {
			$(".center_con").show("slide",{direction:"left"},200);
		}
	});
});