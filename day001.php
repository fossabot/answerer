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

//�f�t�H���g�̍X�V
	$sql="update cam_user set default_view =3 where user_id='".$user_id."'";
$rs = exSQL($sql,$conn);

//�w��̓����������ꍇ�͂��̓����擾
if(!isset($_REQUEST['date'])){
	$targetDate = $strSystemYear."-".$strSystemMonth."-".$strSystemDay;
}else{
	$targetDate = $_REQUEST['date'];
}

$nextDay =date("Y-m-d",strtotime("1 day" ,strtotime($targetDate)));
$beforeDay =date("Y-m-d",strtotime("-1 day" ,strtotime($targetDate)));
$returnDate =$targetDate;


//���ʃw�b�_�̕\��
echo GetHeader($user_id,$conn);

?>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td><b>
<?php print(substr($targetDate,0,4)."�N".substr($targetDate,5,2)."��".substr($targetDate,8,2)."��"); ?>

		</b></td>
		<td align="right"><a href="day001.php?date=<?php print($beforeDay);?>">���O��</a>�@<a href="day001.php?date=<?php print($nextDay);?>">������</a></td>
	</tr>
</table>
<form>
<input type="button" value="�X�P�W���[����ǉ�" onclick="location.href='insert001.php?date=<?php print($targetDate); ?>';">�@
<input type="button" value="�����\���ɖ߂�" onclick="location.href='month001.php?date=<?php print($returnDate); ?>';">�@
<input type="button" value="�T���\���ɖ߂�" onclick="location.href='week001.php?date=<?php print($returnDate); ?>';">�@
<p>
<?php
//�����f�[�^�擾�pSQL�̐���
$sql="select sec_number,TIME_FORMAT(start_time,'%H:%i') as start_time,TIME_FORMAT(end_time,'%H:%i') as end_time,title,detail ".
	"from cat_schedule where user_id='".$_COOKIE['user_id'].
	"' and DATE_FORMAT(schedule_date,'%Y-%m-%d')='".$targetDate."' and  del_flg='0' ".
	"order by start_time,end_time asc";
//echo $sql;
$rs = exSQL($sql,$conn);
//������0�̏ꍇ
if($rs->num_rows==0){
	print("�f�[�^�Ȃ�<br>");
}else{
	while($row = $rs->fetch_assoc()){
?>
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
			<td><?php print(http2link(nl2br($row["detail"]))); ?></td>
		</tr>
		</table>
		<table width="600pt" border="0" cellpadding="0" cellspacing="0" style="margin:3pt">
		<tr>
			<td>
			<input type="button" value="�@�ҁ@�W�@" onclick="location.href='edit001.php?date=<?php print($targetDate); ?>&number=<?php print($row["sec_number"]);?>';">�@
			<input type="button" value="�@��@���@" onclick="location.href='delete001.php?date=<?php print($targetDate); ?>&number=<?php print($row["sec_number"]);?>';">
			</td>
		</tr>
		</table>

<p>
<?php
	}
}
//���ʃt�b�^�̕\��
echo GetFooter();

?>