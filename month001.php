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
	$sql="update cam_user set default_view =1 where user_id='".$user_id."'";
	$rs = exSQL($sql,$conn);


//�w��̌����������ꍇ�͂��̌��̏����擾
if(isset($_REQUEST['date'])){
	$year=substr($_REQUEST['date'],0,4);
	$month=substr($_REQUEST['date'],5,2);
	$targetDay=computeMonth($year,$month,1,0);
	$strToday=1;
	$strToay_lastDay=date("t",mktime(0, 0, 0, $month, 1, $year));
}else{
	$year=$strSystemYear;
	$month=$strSystemMonth;
	$strToday=$strSystemDay;
	$strToay_lastDay=date("t");
}

$nextMonth=computeMonth($year,$month,1,1); //������1��
$beforeMonth=computeMonth($year,$month,1,-1); //�O����1��
$TodayMonth=computeMonth($strSystemYear,$strSystemMonth,1,0); //������1��


//�����̗j�����擾
$strStartWeek = date("w",mktime(0, 0, 0, $month, 1, $year));


//���ʃw�b�_�̕\��
echo GetHeader($user_id,$conn);

?>
					
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="center"><b><?php print($year."�N".$month."��");?><b>
		</td>
		<td align="right"><a href="month001.php?date=<?php print($beforeMonth);?>">���O��</a>�@<a href="month001.php?date=<?php print($TodayMonth);?>">����</a>�@<a href="month001.php?date=<?php print($nextMonth);?>">������</a></td>
	</tr>
</table>
		<table bgcolor="white" width="100%" border="1" cellpadding="2" cellspacing="0" style="margin:0pt">
		<tr><td bgcolor="#FFFFCC" align="center" width="14%" width="90" style="color:red">��</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >��</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >��</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >��</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >��</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >��</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" style="color:blue">�y</td>
		</tr>
<?php
//�ϐ��̏�����
$i=0;
$day_count=0;
$L_Loop_Count=0;
$F_Loop_Count=$strStartWeek-1;
$week_Count =1; //�T�J�E���g�p
$chk_cnt=0;
$weekCount_Sun=0;//���j�̏T�J�E���g�p
$weekCount_Mon=0;//���j�̏T�J�E���g�p

	for($i=0;$i<7;$i++){

		if($strToay_lastDay-$day_count > 0){
				$chk_cnt=$chk_cnt + 1;
				//�ŏ��̂P�T�Ԃ̃X�^�[�g�ʒu�O�̃u�����N��ݒ�
				if($i==0){
					$F_Loop_Count+=1;
					//���j���������̏ꍇ�ȊO�����̏��������s
					if($F_Loop_Count!=7){
						print("<tr>");
						for($j=1;$j<$F_Loop_Count+1;$j++){
							print("<td>&nbsp</td>");
							
						}
					}
					//�ŏ��̏T�J�E���g�͓��ꃍ�W�b�N
					if($F_Loop_Count==0){
						$weekCount_Sun=$weekCount_Sun + 1;
						$weekCount_Mon=$weekCount_Mon + 1;
					}
					if($F_Loop_Count ==1){
						$weekCount_Mon=$weekCount_Mon + 1;
					}

				}else{
					print("<tr>");
					$week_Count =$week_Count +1;
					$weekCount_Sun=$weekCount_Sun + 1;
					$weekCount_Mon=$weekCount_Mon + 1;
				}
				if($i==0){
					$Loop_Count = 7 - $F_Loop_Count;
				}else if($strToay_lastDay-($day_count + 7) < 0){
						$Loop_Count=$strToay_lastDay-$day_count;
						$L_Loop_Count=6-$strToay_lastDay-$day_count;
				}else{
					$Loop_Count =7;
				}


				//���t�ƌ�����\��
				for($j=1;$j<$Loop_Count+1;$j++){


					$day_count=$day_count+1;
					if($strSystemYear.$strSystemMonth.$strSystemDay==$year.$month.$day_count){
						print("<td bgcolor='#D3E9F7'>");
						print("<b><a class='blocklink_today' href='day001.php?date=");
					}else{
						print("<td>");
						print("<b><a class='blocklink' href='day001.php?date=");
					}
				//���t�̕\���ݒ�
					$strWeek = date("w",mktime(0, 0, 0, $month, $day_count, $year));
					print($year."-".$month."-".sprintf("%02d",$day_count)."'>".
					dispDays($year,$month,$day_count,$weekCount_Sun,$weekCount_Mon,$strWeek)."</a>");
//�ʃX�P�W���[���̃����N���o�͂���

					$sql="select TIME_FORMAT(start_time,'%H:%i') as start_time,TIME_FORMAT(end_time,'%H:%i') as end_time,title from cat_schedule where user_id='".$_COOKIE['user_id'].
						"' and DATE_FORMAT(schedule_date,'%Y-%m-%d')='".$year."-".$month."-".sprintf("%02d",$day_count).
						"' and del_flg='0' order by start_time,end_time limit 3";

					$dayData =array(0=>"<br>",1=>"<br>",2=>"<br>");
					$rs = exSQL($sql,$conn);
					$cnt =0;
//print($sql);
					if($rs !=false){
						while($row = $rs->fetch_assoc()){
							if($row["start_time"]=="00:00" && $row["end_time"]=="00:00"){
								if(strlen($row["title"]) > 17){
									$dayData[$cnt] = substr($row["title"],0,16)."<br>";
								}else{
									$dayData[$cnt] = $row["title"]."<br>";
								}
							}else{
								if(strlen($row["title"]) > 10){
									$dayData[$cnt] = "[".$row["start_time"]."]".substr($row["title"],0,10)."<br>";
								}else{
									$dayData[$cnt] = "[".$row["start_time"]."]".$row["title"]."<br>";
								}
							}
							$cnt = $cnt + 1;
						}
					}
					print("<table width=100%><tr><td class='detail'>");
					print($dayData[0].$dayData[1].$dayData[2]."</td></tr></table>");

					print("</td>");
				}
				//�ŏI�T�̏I����̃u�����N��ݒ�
				if($strToay_lastDay==$day_count){
					$Loop_Count=7-$Loop_Count;
//					print($Loop_Count);
						for($j=0;$j<$Loop_Count;$j++){
							print("<td>&nbsp</td>");
					}
				}
				
			if($F_Loop_Count!=7){
				print("</tr>\n");
			}
		}
	}

//���ʃt�b�^�̕\��
echo GetFooter();

?>
