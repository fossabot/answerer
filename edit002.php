<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Fedit002
 * �쐬���t�F	   2012/10/01
 * �ŏI�X�V���F	   2012/10/01
 * �v���O���������F�o�^���s���
 * �ύX����
 * �ύX����		�ύX�Җ�			����
 * 2012/10/01	�g��				�V�K�쐬
*************************************************************** */
//����function�ǂݍ���
	require('./common.php');
/*
����
user_id		���[�U�[�h�c[�N�b�L�[���]
set_date	�ݒ��
start_time	�J�n����
end_time	�I������
title		�^�C�g��
detail		����

*/
$start_time =$_REQUEST["start_time"];
$end_time = $_REQUEST["end_time"];
$title = $_REQUEST["title"];
$detail = $_REQUEST["detail"];
$sec_number = $_REQUEST["sec_number"];
$set_date = $_REQUEST["set_date"];

//�f�[�^���c�a�ɍX�V
	$sql="UPDATE cat_schedule SET start_time='".$start_time."',end_time='".$end_time.
		"',title='".$title."',detail='".$detail."' where user_id='".$_COOKIE['user_id'].
		"' and schedule_date ='".$set_date."' and sec_number=".$sec_number;
$rs = exSQL($sql,$conn);
echo($sql);
//��ʑJ��
	header("location: day001.php?date=".$_REQUEST["set_date"]);

?>
