<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2009
 * �v���O�������F  �ݒ�p�t�@�C��
 * �v���O�����h�c�Fconfig.php
 * �쐬���t�F	   2009/06/01
 * �ŏI�X�V���F	   2009/06/01
 * �v���O���������FMYSQL�Ƃ̐ڑ��������ݒ肷��
 * �ύX����
 * �ύX����		�ύX�Җ�			����
 * 2009/06/01	�g��				�V�K�쐬
 *************************************************************** */
$my_user="calendar";
$my_pass="calendar";
$my_host="localhost";
$my_conectDB="calendar";
//$conn = mysql_connect($my_host,$my_user,$my_pass);
//mysql_select_db($my_conectDB,$conn);
$conn = new mysqli($my_host,$my_user,$my_pass,$my_conectDB);

