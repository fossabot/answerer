<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Finsert002
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
//�ݒ��������̃��R�[�h��������
	$sql="SELECT count(*) CNT FROM cat_schedule WHERE user_id='".$_COOKIE['user_id']."' and schedule_date ='".$_REQUEST["set_date"]."'";
$rs = exSQL($sql,$conn);
//print($sql);
if($rs->num_rows==0){
		$CNT=0;
	}else{
		while($row = $rs->fetch_assoc()){
	        $CNT=$row["CNT"];
		}
	}
//�Y�����{�P��indexnumber�ɐݒ肷��
	$CNT +=1;
	
//�f�[�^���c�a�ɓo�^
	$sql="INSERT INTO cat_schedule VALUES('".$_COOKIE['user_id']."','".$CNT."','".$_REQUEST["set_date"].
	"','".$_REQUEST["start_time"]."','".$_REQUEST["end_time"]."','".$_REQUEST["title"]."','".$_REQUEST["detail"]."','0')";
	$rs = exSQL($sql,$conn);

//print($sql);
//��ʑJ��
	header("location: day001.php?date=".$_REQUEST["set_date"]);

?>
