<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Findex
 * �쐬���t�F	   2012/10/01
 * �ŏI�X�V���F	   2012/10/01
 * �v���O���������F�F�؉��
 * �ύX����
 * �ύX����		�ύX�Җ�			����
 * 2012/10/01	�g��				�V�K�쐬
*************************************************************** */

//�A�N�Z�X�ڑ�������
	require('./common.php');

/*���N�G�X�g���擾����ϐ�
username ���[�U�[ID
password�@�p�X���[�h
*/

$username=htmlspecialchars($_REQUEST['username']);
$passWord=htmlspecialchars(rot13encrypt($_REQUEST['password']));

$sql="SELECT count(*) CNT FROM cam_user WHERE login_id='".$username."' AND user_pass='".$passWord."'";
$rs = exSQL($sql,$conn);
while($row = $rs->fetch_assoc()){
        $CNT=$row["CNT"];
}

if($CNT>0){
	//user_id�̎擾
$sql="SELECT user_id FROM cam_user WHERE login_id='".$username."' AND user_pass='".$passWord."'";
$rs = exSQL($sql,$conn);
while($row = $rs->fetch_assoc()){
        $user_id=$row["user_id"];
}

//���[�U�[�p�X�̓u���E�U�I���܂ŗL���ɂ��Ƃ��i���Ԗ��ݒ�̏ꍇ�u���E�U������I���ɂȂ�j
		setcookie("user_id",$user_id);
		setcookie("passWord",$passWord);

//��ʑJ��
	header("location: index001.php");
}else{
//��ʑJ��
	header("location: login001.php");
}

?>
