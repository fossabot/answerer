<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2009
 * �v���O�������F  �ƌv��V�X�e��
 * �v���O�����h�c�Fcommon.php
 * �쐬���t�F	   2009/06/01
 * �ŏI�X�V���F	   2008/06/01
 * �v���O���������F���ʃ��W���[��
 * �ύX����
 * �ύX����		�ύX�Җ�			����
 * 2009/06/01	�g��				�V�K�쐬
*************************************************************** */

//db�ڑ�������
	require('./config.php');
	ob_start ("ob_gzhandler");

//�Z�L�����e�B�`�F�b�N
	$user_id="";
	if(isset($_COOKIE['user_id'])){
		$user_id=$_COOKIE['user_id'];
		$passWord=$_COOKIE['passWord'];
	}
	$CNT=SecChk($user_id,$passWord,$conn);

	if($CNT>0){

	}else{
		header("location: login001.php");
	}

//����
$strSystemDay =date("j"); //dd �����i���j
$strSystemYear = date("Y"); //yyyy�@���N
$strSystemMonth = date("m"); //mm�@����

/******************************************************************************
 sql���s�pFunction�i�j
 �����F	$sql	���s�pSQL
 �Ԃ�l�F���R�[�h�Z�b�g
*/ //**************************************************************************
Function exSQL($sql,$conn){

	$conn->query('SET NAMES sjis');
	$rs = $conn->query($sql);

	return $rs;
}

/******************************************************************************
 �Z�L�����e�B�pFunction�i�j
 �����F	$user_id	���[�U�[��
 		$passWord	�p�X���[�h
 		$conn		�ڑ�������
 �Ԃ�l�F�Z�L�����e�B�\���敪
*/ //**************************************************************************
Function SecChk($user_id,$passWord,$conn){
	$CNT=0;
	if($user_id==""){
		return $CNT;
	}
	$sql="SELECT count(*) CNT FROM cam_user WHERE user_id='".$user_id."' AND user_pass='".$passWord."'";
$rs = exSQL($sql,$conn);
while($row = $rs->fetch_assoc()){
        $CNT=$row["CNT"];
	}
	return $CNT;
}
/******************************************************************************
 �Z�L�����e�B�pFunction�i�j
 �����F	$str		�Ώە�����
 �Ԃ�l�F�Í�������������
*/ //**************************************************************************
Function rot13encrypt ($str) {
    return str_rot13(base64_encode($str));
}
/******************************************************************************
 �Z�L�����e�B�pFunction�i�j
 �����F	$str		�Í�������������
 �Ԃ�l�F����������������
*/ //**************************************************************************
Function rot13decrypt ($str) {
    return base64_decode(str_rot13($str));
}

/******************************************************************************
 ���ʃw�b�_�[Function�i�j
 �����F	�Ȃ�
 �Ԃ�l�F�w�b�_�[������html
*/ //**************************************************************************
Function GetHeader($user_id,$conn){

	$HeaderHtml ="";
	$HeaderHtml ="<html>";
	$HeaderHtml =$HeaderHtml."<head>";
	$HeaderHtml =$HeaderHtml."<META HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=Shift_JIS'>";
	$HeaderHtml =$HeaderHtml."<link rel='stylesheet' type='text/css' href='css/style.css'>";

	$HeaderHtml =$HeaderHtml."<title>�X�P�W���[���Ǘ��V�X�e��</title>";
	$HeaderHtml =$HeaderHtml."</head>";
	$HeaderHtml =$HeaderHtml."<body>";
	$HeaderHtml =$HeaderHtml."<div id='container'>";
	$HeaderHtml =$HeaderHtml."	<div id='header'>";
	$HeaderHtml =$HeaderHtml."		<br>";
	$HeaderHtml =$HeaderHtml."	</div>";

	$HeaderHtml =$HeaderHtml."	<div id='content'>";
	$HeaderHtml =$HeaderHtml."		<div id='center'>";

	$HeaderHtml =$HeaderHtml."	<div id='banner'>";
	$HeaderHtml =$HeaderHtml."		<h1><strong>�g���@�X�P�W���[���Ǘ��V�X�e��-answerer-(���O�C�����[�U�[�F";

	$sql="SELECT user_name,user_grade FROM cam_user WHERE user_id='".$user_id."'";
	$rs = exSQL($sql,$conn);
	$user_name="";
	$user_grade="";
	while($row = $rs->fetch_assoc()){
        $user_name=$row["user_name"];
		$user_grade=$row["user_grade"];
	}
	$HeaderHtml =$HeaderHtml.$user_name;

	$HeaderHtml =$HeaderHtml.")</strong></h1>";
	$HeaderHtml =$HeaderHtml."	</div>";
	$HeaderHtml =$HeaderHtml."			<div class='content02'>";
//	$HeaderHtml =$HeaderHtml."				<h1>���j���[</h1>";
	$HeaderHtml =$HeaderHtml."				<a href='month001.php'>����</a>�@";
	$HeaderHtml =$HeaderHtml."				<a href='week001.php'>�T��</a>�@";
	$HeaderHtml =$HeaderHtml."				<a href='day001.php'>����</a>�@";
//	$HeaderHtml =$HeaderHtml."				<a href='insert003.php'>�����o�^</a>�@";
	$HeaderHtml =$HeaderHtml."				<a href='user001.php'>�ݒ�</a>�@";
	if($user_grade ==0){
		$HeaderHtml =$HeaderHtml."				<a href='setting001.php'>�Ǘ�</a>";
	}
	$HeaderHtml =$HeaderHtml."			<hr>";
	$HeaderHtml =$HeaderHtml."			<table border=0>";
	$HeaderHtml =$HeaderHtml."				<tr>";
	$HeaderHtml =$HeaderHtml."					<td width='770'>";
	return $HeaderHtml;

}
/******************************************************************************
 ���ʃt�b�^�[Function�i�j
 �����F	�Ȃ�
 �Ԃ�l�F�w�b�_�[������html
*/ //**************************************************************************

Function GetFooter(){

	$FooterHtml ="";
	$FooterHtml=$FooterHtml."</td></tr>";
	$FooterHtml=$FooterHtml."</table>";
	$FooterHtml=$FooterHtml."					</td>";
	$FooterHtml=$FooterHtml."				</tr>";
	$FooterHtml=$FooterHtml."			</table>";
	$FooterHtml=$FooterHtml."			</div>";
	$FooterHtml=$FooterHtml."			<div id='footer'>";
	$FooterHtml=$FooterHtml."			All Rights Reserved, Copyright(C) korai 2012";
	$FooterHtml=$FooterHtml."			</div>";
	$FooterHtml=$FooterHtml."		</div>";
	$FooterHtml=$FooterHtml."	</div>";
	$FooterHtml=$FooterHtml."</div>";
	$FooterHtml=$FooterHtml."</body>";
	$FooterHtml=$FooterHtml."</html>";

	return $FooterHtml;

}
/******************************************************************************
 * �N�����w�肵�Č����������߂�֐�
 * $year �N
 * $month ��
*/ //**************************************************************************
Function getMonthEndDay($year,$month){
    $dt = mktime(0, 0, 0, $month + 1, 0, $year);
    return date("d", $dt);
}

/******************************************************************************
 * �N�����Ɖ��Z������n������An�����O�̓��t�����߂�
 * $year �N
 * $month ��
 * $day ��
 * $addMonths ���Z���B�}�C�i�X�w���n�����O���ݒ�\
*/ //**************************************************************************
Function computeMonth($year,$month,$day,$addMonths){
    $month += $addMonths;
    $endDay = getMonthEndDay($year, $month);
    if($day > $endDay) $day = $endDay;
    $dt = mktime(0, 0, 0, $month, $day, $year);//���K��
    return date("Y-m-d", $dt);
}
/******************************************************************************
 * �N�������炻�̏T���ƏT���̓��t�����߂�
 * $year �N
 * $month ��
 * $day ��
 * $addMonths ���Z���B�}�C�i�X�w���n�����O���ݒ�\
*/ //**************************************************************************
Function getWeek($year,$month,$day){

    $targetDate = mktime(0,0,0,$month, $day, $year);
    $w = (intval(date("w",$targetDate)) + 6) % 7;
    
    $thisWeek[0] = date("Y-m-d",$targetDate - 86400 * $w);
    $thisWeek[1] = date("Y-m-d",$targetDate + 86400 * (6 - $w));
    
    return $thisWeek;
}
/*******************************************************************************
�Y�����̕\���������ҏW����
����
$strYear		�N
$strMonth		��
$strDay			��
$strWeekCnt1	���T�ڂ̓��j����
$strWeekCnt2	���T�ڂ̌��j����
$strWeek		�j���̃J�E���g�i����0�`�y��6�j
�Ԃ�l
�\��������
*/ //***************************************************************************
Function dispDays($strYear,$strMonth,$strDay,$strWeekCnt1,$strWeekCnt2,$strWeek){

	$dispDay="";
///���j���͐Ԃ��A�y�j���͐��\������
	if($strWeek==0){ //1�����j��
          $dispDay="<font color='red'>".$strDay."</font>";
	}else if($strWeek==6){
          $dispDay="<font color='blue'>".$strDay."</font>";
	}else{
          $dispDay=$strDay;
	}

//�j���̔���ƕ\�����W�b�N
	$HolidayDisp="";
	if($strMonth=="1" && $strDay=="1"){//����
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" ����";
	}else if($strMonth=="1" && $strDay=="2" && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="1" && $strWeekCnt2=="2" && $strWeek=="1"){//���l�̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" ���l�̓�";
	}

	if($strMonth=="2" && $strDay=="11"){//�����L�O�̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �����L�O�̓�";
	}else if($strMonth=="2" && $strDay=="12" && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}
	//�t���̓��v�Z���W�b�N�i1980-2099�N�܂Łj
	$springHoliday =(int)(20.8431+0.242194*($strYear-1980)-(int)(($strYear-1980)/4));

	if($strMonth=="3" && $strDay==$springHoliday){//�t���̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �t���̓�";
	}else if($strMonth=="3" && $strDay==$springHoliday+1 && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="4" && $strDay=="29"){//�݂ǂ�̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �݂ǂ�̓�";
	}else if($strMonth=="4" && $strDay=="30" && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

//�f�v�̐U�փ��W�b�N�͂�����Ɠ���
	if($strMonth=="5" && $strDay=="3"){//���@�L�O��
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" ���@�L�O��";
	}else if($strMonth=="5" && $strDay=="6" && $strWeek=="3"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="5" && $strDay=="4"){//�����̋x��
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �����̋x��";
	}else if($strMonth=="5" && $strDay=="6" && $strWeek=="2"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="5" && $strDay=="5"){//�q���̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �q���̓�";
	}else if($strMonth=="5" && $strDay=="6" && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="7" && $strWeekCnt2=="3" && $strWeek=="1"){//�C�̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �C�̓�";
	}

	//�H���̓��v�Z���W�b�N�i1980-2099�N�܂Łj
	$fallHoliday =(int)(23.2488+0.242194*($strYear-1980)-(int)(($strYear-1980)/4));

	if($strMonth=="9" && $strDay==$fallHoliday){//�H���̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �H���̓�";
	}else if($strMonth=="9" && $strDay==$fallHoliday+1 && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="9" && $strWeekCnt2=="3" && $strWeek=="1"){//�h�V�̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �h�V�̓�";
	}

//�h�V�̓���21�̏ꍇ�A23���ƃI�Z���ɂȂ�̂�22���͋x�݂ɂȂ�
	if($strMonth=="9" && $strWeekCnt2=="3" && $strWeek=="2" && $strDay=="22" && $fallHoliday !="22"){//�h�V�̓����ꃍ�W�b�N
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="10" && $strWeekCnt2=="2" && $strWeek=="1"){//�̈�̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �̈�̓�";
	}

	if($strMonth=="11" && $strDay=="3"){//�����̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �����̓�";
	}else if($strMonth=="11" && $strDay=="4" && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="11" && $strDay=="23"){//�ΘJ���ӂ̓�
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �ΘJ���ӂ̓�";
	}else if($strMonth=="11" && $strDay=="24" && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

	if($strMonth=="12" && $strDay=="23"){//�V�c�a����
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �V�c�a����";
	}else if($strMonth=="12" && $strDay=="24" && $strWeek=="1"){//�U��ւ�
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" �U�֋x��";
	}

//���{�̓���ȓ��𔻒肵�Ă�����
	$dispKey="";
	if($strMonth=="2" && $strDay=="14"){//�o�����^�C���f�[
		$dispKey=" �o�����^�C��";
	}

	if($strMonth=="3" && $strDay=="3"){//���Ղ�
		$dispKey=" ���Ղ�";
	}
	
	if($strMonth=="3" && $strDay=="14"){//�z���C�g�f�[
		$dispKey=" �z���C�g�f�[";
	}
	
	if($strMonth=="4" && $strDay=="1"){//�G�C�v�����t�[��
		$dispKey=" ������̰�";
	}

	if($strMonth=="5" && $strWeekCnt2=="2" && $strWeek=="0"){//��̓�
		$dispKey=" ��̓�";
	}
	
	if($strMonth=="6" && $strWeekCnt2=="3" && $strWeek=="0"){//���̓�
		$dispKey=" ���̓�";
	}

	if($strMonth=="7" && $strDay=="7"){//���[
		$dispKey=" ���[";
	}

	if($strMonth=="12" && $strDay=="25"){//�N���X�}�X
		$dispKey=" �N���X�}�X";
	}

	if($HolidayDisp <> ""){
		$dispDay =$dispDay."</font><font color='red'>".$HolidayDisp."</font></div>";
	}else if($dispKey <> ""){
		if($strWeek=="0"){
			$dispDay =$dispDay."</font><font color='red'>".$dispKey."</font></div>";
		}else if($strWeek=="6"){
			$dispDay =$dispDay."</font><font color='blue'>".$dispKey."</font></div>";
		}else{
			$dispDay =$dispDay.$dispKey."</font></div>";
		}
	}else{
		$dispDay =$dispDay."</font></div>";
	}
	return $dispDay;
}
/******************************************************************************
 ���Ԃ̃v���_�E���pFunction�i�j
 �����F	�Ȃ�
 �Ԃ�l�F���Ԃ̃v���_�E��������html
*/ //**************************************************************************
Function GetTimeDropDown($obj){

	$DropDownHtml="";
	$DropDownHtml="<option value=0>�ݒ�Ȃ�";

	for($i=0;$i <= 23;$i++){
			if($obj==$i."00"){
				$DropDownHtml=$DropDownHtml."<option value='".$i.":00' selected>".$i.":00";
			}else{
				$DropDownHtml=$DropDownHtml."<option value='".$i.":00'>".$i.":00";				
			}
			if($obj==$i."30"){
				$DropDownHtml=$DropDownHtml."<option value='".$i.":30' selected>".$i.":30";
			}else{
				$DropDownHtml=$DropDownHtml."<option value='".$i.":30'>".$i.":30";				
			}

	}
	return $DropDownHtml;
}

/******************************************************************************
 �����N�̕�������n�C�p�[�����N�ɒu��������Function�i�j
 �����F
$str �����N���܂ޕ�����
 �Ԃ�l�F�����N�ӏ���u��������������
*/ //**************************************************************************
Function http2link($str){
	$text = preg_replace("/(https?:\/\/[a-zA-Z0-9;\/?:@&=\+$,\-_\.!~*'\(\)%#]+)/","<a href='\\0' target='_blank'>\\0</a>",$str);
    return $text;
}
?>
