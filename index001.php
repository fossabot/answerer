<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Findex
 * �쐬���t�F	   2012/10/01
 * �ŏI�X�V���F	   2012/10/01
 * �v���O���������F�����g�b�v���
 * �ύX����
 * �ύX����		�ύX�Җ�			����
 * 2012/10/01	�g��				�V�K�쐬
*************************************************************** */

//����function�ǂݍ���
	require('./common.php');

//���t���̎擾
$sql="SELECT default_view FROM cam_user WHERE user_id='".$_COOKIE['user_id']."'";
$rs = exSQL($sql,$conn);
while($row = $rs->fetch_assoc()){
        $default_view=$row["default_view"];
}

//��ʑJ��
if($default_view ==1){
	header("location: month001.php");
}else if($default_view==2){
	header("location: week001.php");
}else if($default_view==3){
	header("location: day001.php");
}else{
	header("location: month001.php");
}

