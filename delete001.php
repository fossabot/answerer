<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Fdelete001
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

$sql="select sec_number,TIME_FORMAT(start_time,'%H:%m') as start_time,TIME_FORMAT(end_time,'%H:%m') as end_time,title,detail ".
	"from cat_schedule where user_id='".$_COOKIE['user_id'].
	"' and DATE_FORMAT(schedule_date,'%Y-%m-%d')='".$targetDate."' and  del_flg='0' and sec_number='".$targetSecNumber."'";

mysql_query('SET NAMES sjis');
$rs = mysql_query($sql,$conn);

//���ʃw�b�_�̕\��
echo GetHeader($user_id,$conn);
//������0�̏ꍇ
if(mysql_num_rows($rs)==0){
	print("�i���j�G���[");
}else{
	while($row=mysql_fetch_assoc($rs)){

?>
<b>�\��̍폜</b>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td>
<?php print(substr($targetDate,0,4)."�N".substr($targetDate,5,2)."��".substr($targetDate,8,2)."��"); ?>
		</td>
	</tr>
</table>
<b>���̃X�P�W���[�����폜���܂�</b>
<form method="post" name="delete001" action="delete002.php">
		<table width="600pt" border="1" cellpadding="2" cellspacing="1" style="margin:0pt">
		<tr>
			<td bgcolor="#FFFFCC" width="100pt">����</td>
			<td><b><?php print($row["title"]); ?><b></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFCC" width="100pt">����</td>
			<td>
			<?php
				if($row["start_time"] =="00:00" && $row["end_time"]=="00:00"){
					print("<br>");
				}else{
					print($row["start_time"]."�`".$row["end_time"]);
				}
			 ?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFCC" width="100pt">���e</td>
			<td><?php print(nl2br($row["detail"])); ?></td>
		</tr>
		</table>

<input type="hidden" name="set_date" value="<?php print($targetDate); ?>">
<input type="hidden" name="sec_number" value="<?php print($targetSecNumber); ?>">

<br>
<input type="submit" value="�@��@���@">�@
<input type="button" value="�@�߁@��@"  onclick="location.href='day001.php?date=<?php print($targetDate); ?>'">�@



</form>
<?php
	}
}
//���ʃt�b�^�̕\��
echo GetFooter();
?>