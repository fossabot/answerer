<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Fdelete002
 * �쐬���t�F	   2012/10/01
 * �ŏI�X�V���F	   2012/10/01
 * �v���O���������F�폜���s���
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
sec_number�@�A��

*/
$start_time =htmlspecialchars($_REQUEST["start_time"]);
$end_time = htmlspecialchars($_REQUEST["end_time"]);
$title = htmlspecialchars($_REQUEST["title"]);
$detail = htmlspecialchars($_REQUEST["detail"]);
$sec_number = htmlspecialchars($_REQUEST["sec_number"]);
$set_date = htmlspecialchars($_REQUEST["set_date"]);
	
//�f�[�^���c�a�ɍX�V
	$sql="UPDATE cat_schedule SET del_flg=1 where user_id='".$_COOKIE['user_id'].
		"' and schedule_date ='".$set_date."' and sec_number=".$sec_number;
	mysql_query('SET NAMES sjis');
	mysql_query($sql,$conn);

//��ʑJ��
	header("location: day001.php?date=".$_REQUEST["set_date"]);

?>
