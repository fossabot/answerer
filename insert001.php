<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Finsert001
 * �쐬���t�F	   2012/10/01
 * �ŏI�X�V���F	   2012/10/01
 * �v���O���������F�X�P�W���[���V�K�o�^
 * �ύX����
 * �ύX����		�ύX�Җ�			����
 * 2012/10/01	�g��				�V�K�쐬
*************************************************************** */
//����function�ǂݍ���
	require('./common.php');

$targetDate = htmlspecialchars($_REQUEST['date']);

//���ʃw�b�_�̕\��
echo GetHeader($user_id,$conn);

?>
<b>�\��̒ǉ�</b>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td>
<?php print(substr($targetDate,0,4)."�N".substr($targetDate,5,2)."��".substr($targetDate,8,2)."��"); ?>
		</td>
	</tr>
</table>
<form method="post" name="insert001"  onSubmit="return numberCheck()" action="insert002.php">
<table border="1" cellpadding="2" cellspacing="1" style="margin:0pt">
<tr>
	<td bgcolor="#FFFFCC" width="100pt">����</td>
	<td><input name="title" type="text" size="100"></td>
</tr>
<tr>
	<td bgcolor="#FFFFCC" width="100pt">����</td>
	<td>
	<select name="start_time"  width="70pt">
<?php print(GetTimeDropDown(99));?>
	</select>
		�`
	<select name ="end_time">
<?php print(GetTimeDropDown(99));?>
	</select>
	</td>
</tr>
<tr>
	<td bgcolor="#FFFFCC" width="100pt">���e</td>
	<td><textarea name ="detail" cols="80" rows="15"></textarea></td>
</tr>
</table>
<input type="hidden" name="set_date" value="<?php print($targetDate); ?>">
<br>
<input type="submit" value="�@�o�@�^�@">�@
<input type="button" value="�@�߁@��@"  onclick="location.href='day001.php?date=<?php print($targetDate); ?>'">�@



</form>
<?php
//���ʃt�b�^�̕\��
echo GetFooter();
?>