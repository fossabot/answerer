<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Fedit001
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
$targetSecNumber = htmlspecialchars($_REQUEST['number']);

$sql="select sec_number,TIME_FORMAT(start_time,'%H%m') as start_time,TIME_FORMAT(end_time,'%H%m') as end_time,title,detail ".
	"from cat_schedule where user_id='".$_COOKIE['user_id'].
	"' and DATE_FORMAT(schedule_date,'%Y-%m-%d')='".$targetDate."' and  del_flg='0' and sec_number='".$targetSecNumber."'";

$rs = exSQL($sql,$conn);

//���ʃw�b�_�̕\��
echo GetHeader($user_id,$conn);
//������0�̏ꍇ
if($rs->num_rows==0){
	print("�i���j�G���[");
}else{
		while($row = $rs->fetch_assoc()){

?>
<b>�\��̕ҏW</b>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td>
<?php print(substr($targetDate,0,4)."�N".substr($targetDate,5,2)."��".substr($targetDate,8,2)."��"); ?>
		</td>
	</tr>
</table>
<form method="post" name="edit001" action="edit002.php">
<table border="1" cellpadding="2" cellspacing="1" style="margin:0pt">
<tr>
	<td bgcolor="#FFFFCC" width="100pt">����</td>
	<td><input name="title" type="text" size="100" value="<?php print($row["title"]); ?>"></td>
</tr>
<tr>
	<td bgcolor="#FFFFCC" width="100pt">����</td>
<td>
<select name="start_time">
<?php print(GetTimeDropDown($row["start_time"]));?>
</select>
�`
<select name ="end_time">
<?php print(GetTimeDropDown($row["end_time"]));?>
</select>
</td>
<tr>
	<td bgcolor="#FFFFCC" width="100pt">���e</td>
	<td><textarea name ="detail" cols="80" rows="15"><?php print($row["detail"]); ?></textarea></td>
</tr>
</table>
<input type="hidden" name="set_date" value="<?php print($targetDate); ?>">
<input type="hidden" name="sec_number" value="<?php print($targetSecNumber); ?>">

<br>
<input type="submit" value="�@�X�@�V�@">�@
<input type="button" value="�@�߁@��@"  onclick="location.href='day001.php?date=<?php print($targetDate); ?>'">�@



</form>
<?php
	}
}
//���ʃt�b�^�̕\��
echo GetFooter();
?>