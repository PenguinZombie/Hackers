<?php
	function str_conv($text) {
		// �󂯎������܂����̌�����n�C���C�g����̂��𐳋K�\���Ŏ擾����
		preg_match_all("/<code ([a-z]+)>/s",$text,$matches);
		// 2�����z�񂾂�()�̒��g���Ƃ�̂�[1]��foreach�ŉ�
		foreach($matches[1] as $value) {
			// <code php>�݂����Ȍ`�Ȃ̂ł����<codeStart><code php>�ɂ���
			// �X�v���b�g�ŕ��������Ƃ���<code php>�̕��������ꂽ���̂ł�������
			$text = str_replace("<code ". $value .">","<codeStart><code ". $value .">",$text);
		}
		// �I���͂ǂ̌���������Ȃ̂Ń��[�v��Ɏ��s
		$text = str_replace("</code>","</code></codeStart>",$text);
		// ����
		$diary = preg_split("/<codeStart>|<\/codeStart>/",$text);
		$i = 0;
		$j = 0;
		foreach($diary as $value) {
			// �v���O�������A�����łȂ������f
			if(preg_match("/^<code [a-z]+>/",$value)) {
				// �v���O�C���̎d�l�œ��ꕶ���ɂ��ċL�q���Ȃ��Ƃ����Ȃ��̂Ńv���O���������Ɉ�Uhtmlspecialchars������
				$diary[$i] = htmlspecialchars($diary[$i],ENT_QUOTES);
				// ���̂��Ƃɓ��ꕶ�����ƃ}�[�N�A�b�v�H���@�\���Ȃ��̂�<code>(&lt;code&gt;)��<pre~�ɒu��������
				// ����w��̕����͍ŏ��Ɏ擾������������Ԃɂ���Ă���
				$diary[$i] = str_replace("&lt;code ". $matches[1][$j] ."&gt;","<pre class='brush: ". $matches[1][$j] ."'>",$diary[$i]);
				$diary[$i] = str_replace("&lt;/code&gt;","</pre>",$diary[$i]);
				$j++;
			}else{
				// �ʏ�̕��������͓��ꕶ���ɂ��ĉ��s�𔽉f������
				$diary[$i] = htmlspecialchars($value,ENT_QUOTES);
				$diary[$i] = nl2br($diary[$i]);
			}
			$i++;
		}
		return $diary;
	}
?>