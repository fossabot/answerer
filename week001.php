<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * �v���O�������F  �X�P�W���[���Ǘ��V�X�e��(�A���T���[)
 * �v���O�����h�c�Findex
 * �쐬���t�F	   2012/10/01
 * �ŏI�X�V���F	   2012/10/01
 * �v���O���������F�T���g�b�v���
 * �ύX����
 * �ύX����		�ύX�Җ�			����
 * 2012/10/01	�g��				�V�K�쐬
*************************************************************** */

//����function�ǂݍ���
	require('./common.php');

//�f�t�H���g�̍X�V
	$sql="update cam_user set default_view =2 where user_id='".$user_id."'";
	mysql_query('SET NAMES sjis');
	mysql_query($sql,$conn);

//�w��̓����������ꍇ�͂��̓��̏T�����擾
if(isset($_REQUEST['date'])){
	$year=substr($_REQUEST['date'],0,4);
	$month=substr($_REQUEST['date'],5,2);
	$day=substr($_REQUEST['date'],8,2);
}else{
	$year=$strSystemYear;
	$month=$strSystemMonth;
	$day=$strSystemDay;
}

	$targetWeek = getWeek($year,$month,$day);
	$thisWeek=array();
	$tmpWeek = $targetWeek[0];

	for($i=0;$tmpWeek <= $targetWeek[1];$i++){
		$thisWeek[$i] = $tmpWeek;
		$tmpyear=substr($tmpWeek,0,4);
		$tmpmonth=substr($tmpWeek,5,2);
		$tmpday=substr($tmpWeek,8,2);
		$tmpWeek = date("Y-m-d",mktime(0,0,0,$tmpmonth, $tmpday+1, $tmpyear));
	}

$nextWeek=date("Y-m-d",mktime(0,0,0,$month, $day+7, $year));
$beforeWeek=date("Y-m-d",mktime(0,0,0,$month, $day-7, $year));

//���ʃw�b�_�̕\��
echo GetHeader($user_id,$conn);

?>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td valign="center"><b><?php print($year."�N".$month."��");?><b>
		</td>
		<td align="right"><a href="week001.php?date=<?php print($beforeWeek);?>">���O�T</a>�@<a href="week001.php?date=<?php print($nextWeek);?>">���T��</a></td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0"  border=1 >
<tr>
<td align="center" width="120pt">��</td>
<td align="center" width="40pt">�j��</td>
<td align="center" width="400pt">�^�C�g��</td>
</tr>
<?php
$weekKey = array(0=>"<font color='red'>��</font>",1=>"��",2=>"��",3=>"��",4=>"��",5=>"��",6=>"<font color='blue'>�y</font>");
for($i=0;$i<count($thisWeek);$i++){
	print("<tr>");
	print("<td align='center'><b><a href='day001.php?date=".$thisWeek[$i]."'>".str_replace("-","/",$thisWeek[$i])."</a></b></td>");
	print("<td align='center'><b>".$weekKey[$i]."</b></td>");
	print("<td>");
			$sql="select TIME_FORMAT(start_time,'%H:%i') as start_time,TIME_FORMAT(end_time,'%H:%i') as end_time,title from cat_schedule where user_id='".$_COOKIE['user_id'].
				"' and DATE_FORMAT(schedule_date,'%Y-%m-%d')='".$thisWeek[$i].
				"' and del_flg='0' order by start_time,end_time";
			mysql_query('SET NAMES sjis');

			$dayData =array();
			$rs = mysql_query($sql,$conn);
			$cnt =0;
			if($rs !=false){
				while($row=mysql_fetch_assoc($rs)){
					if($row["start_time"]=="00:00" && $row["end_time"]=="00:00"){
						$dayData[$cnt] = $row["title"]."<br>";
					}else{
						$dayData[$cnt] = "[".$row["start_time"]."�`".$row["end_time"]."]".$row["title"]."<br>";
					}
						$cnt = $cnt + 1;
					}
			}

			for($k=$cnt;$k<3;$k++){
				$dayData[$k] ="<br>";
			}

			for($j=0;$j<count($dayData);$j++){
				print($dayData[$j]);
			}
	print("</td></tr>");
}
print("</table>");
//���ʃt�b�^�̕\��
echo GetFooter();

?>