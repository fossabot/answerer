<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2009
 * プログラム名：  家計簿システム
 * プログラムＩＤ：common.php
 * 作成日付：	   2009/06/01
 * 最終更新日：	   2008/06/01
 * プログラム説明：共通モジュール
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2009/06/01	紅雷				新規作成
*************************************************************** */

//db接続文字列
	require('./config.php');
	ob_start ("ob_gzhandler");

//セキュリティチェック
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

//当日
$strSystemDay =date("j"); //dd 当日（日）
$strSystemYear = date("Y"); //yyyy　当年
$strSystemMonth = date("m"); //mm　当月

/******************************************************************************
 sql実行用Function（）
 引数：	$sql	実行用SQL
 返り値：レコードセット
*/ //**************************************************************************
Function exSQL($sql,$conn){

	$conn->query('SET NAMES sjis');
	$rs = $conn->query($sql);

	return $rs;
}

/******************************************************************************
 セキュリティ用Function（）
 引数：	$user_id	ユーザー名
 		$passWord	パスワード
 		$conn		接続文字列
 返り値：セキュリティ表示区分
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
 セキュリティ用Function（）
 引数：	$str		対象文字列
 返り値：暗号化した文字列
*/ //**************************************************************************
Function rot13encrypt ($str) {
    return str_rot13(base64_encode($str));
}
/******************************************************************************
 セキュリティ用Function（）
 引数：	$str		暗号化した文字列
 返り値：復号化した文字列
*/ //**************************************************************************
Function rot13decrypt ($str) {
    return base64_decode(str_rot13($str));
}

/******************************************************************************
 共通ヘッダーFunction（）
 引数：	なし
 返り値：ヘッダー部分のhtml
*/ //**************************************************************************
Function GetHeader($user_id,$conn){

	$HeaderHtml ="";
	$HeaderHtml ="<html>";
	$HeaderHtml =$HeaderHtml."<head>";
	$HeaderHtml =$HeaderHtml."<META HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=Shift_JIS'>";
	$HeaderHtml =$HeaderHtml."<link rel='stylesheet' type='text/css' href='css/style.css'>";

	$HeaderHtml =$HeaderHtml."<title>スケジュール管理システム</title>";
	$HeaderHtml =$HeaderHtml."</head>";
	$HeaderHtml =$HeaderHtml."<body>";
	$HeaderHtml =$HeaderHtml."<div id='container'>";
	$HeaderHtml =$HeaderHtml."	<div id='header'>";
	$HeaderHtml =$HeaderHtml."		<br>";
	$HeaderHtml =$HeaderHtml."	</div>";

	$HeaderHtml =$HeaderHtml."	<div id='content'>";
	$HeaderHtml =$HeaderHtml."		<div id='center'>";

	$HeaderHtml =$HeaderHtml."	<div id='banner'>";
	$HeaderHtml =$HeaderHtml."		<h1><strong>紅雷　スケジュール管理システム-answerer-(ログインユーザー：";

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
//	$HeaderHtml =$HeaderHtml."				<h1>メニュー</h1>";
	$HeaderHtml =$HeaderHtml."				<a href='month001.php'>月次</a>　";
	$HeaderHtml =$HeaderHtml."				<a href='week001.php'>週次</a>　";
	$HeaderHtml =$HeaderHtml."				<a href='day001.php'>日次</a>　";
//	$HeaderHtml =$HeaderHtml."				<a href='insert003.php'>複数登録</a>　";
	$HeaderHtml =$HeaderHtml."				<a href='user001.php'>設定</a>　";
	if($user_grade ==0){
		$HeaderHtml =$HeaderHtml."				<a href='setting001.php'>管理</a>";
	}
	$HeaderHtml =$HeaderHtml."			<hr>";
	$HeaderHtml =$HeaderHtml."			<table border=0>";
	$HeaderHtml =$HeaderHtml."				<tr>";
	$HeaderHtml =$HeaderHtml."					<td width='770'>";
	return $HeaderHtml;

}
/******************************************************************************
 共通フッターFunction（）
 引数：	なし
 返り値：ヘッダー部分のhtml
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
 * 年月を指定して月末日を求める関数
 * $year 年
 * $month 月
*/ //**************************************************************************
Function getMonthEndDay($year,$month){
    $dt = mktime(0, 0, 0, $month + 1, 0, $year);
    return date("d", $dt);
}

/******************************************************************************
 * 年月日と加算月からnヶ月後、nヶ月前の日付を求める
 * $year 年
 * $month 月
 * $day 日
 * $addMonths 加算月。マイナス指定でnヶ月前も設定可能
*/ //**************************************************************************
Function computeMonth($year,$month,$day,$addMonths){
    $month += $addMonths;
    $endDay = getMonthEndDay($year, $month);
    if($day > $endDay) $day = $endDay;
    $dt = mktime(0, 0, 0, $month, $day, $year);//正規化
    return date("Y-m-d", $dt);
}
/******************************************************************************
 * 年月日からその週頭と週末の日付を求める
 * $year 年
 * $month 月
 * $day 日
 * $addMonths 加算月。マイナス指定でnヶ月前も設定可能
*/ //**************************************************************************
Function getWeek($year,$month,$day){

    $targetDate = mktime(0,0,0,$month, $day, $year);
    $w = (intval(date("w",$targetDate)) + 6) % 7;
    
    $thisWeek[0] = date("Y-m-d",$targetDate - 86400 * $w);
    $thisWeek[1] = date("Y-m-d",$targetDate + 86400 * (6 - $w));
    
    return $thisWeek;
}
/*******************************************************************************
該当日の表示文字列を編集する
引数
$strYear		年
$strMonth		月
$strDay			日
$strWeekCnt1	何週目の日曜日か
$strWeekCnt2	何週目の月曜日か
$strWeek		曜日のカウント（日が0～土が6）
返り値
表示文字列
*/ //***************************************************************************
Function dispDays($strYear,$strMonth,$strDay,$strWeekCnt1,$strWeekCnt2,$strWeek){

	$dispDay="";
///日曜日は赤く、土曜日は青く表示する
	if($strWeek==0){ //1が日曜日
          $dispDay="<font color='red'>".$strDay."</font>";
	}else if($strWeek==6){
          $dispDay="<font color='blue'>".$strDay."</font>";
	}else{
          $dispDay=$strDay;
	}

//祝日の判定と表示ロジック
	$HolidayDisp="";
	if($strMonth=="1" && $strDay=="1"){//元日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 元日";
	}else if($strMonth=="1" && $strDay=="2" && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="1" && $strWeekCnt2=="2" && $strWeek=="1"){//成人の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 成人の日";
	}

	if($strMonth=="2" && $strDay=="11"){//建国記念の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 建国記念の日";
	}else if($strMonth=="2" && $strDay=="12" && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}
	//春分の日計算ロジック（1980-2099年まで）
	$springHoliday =(int)(20.8431+0.242194*($strYear-1980)-(int)(($strYear-1980)/4));

	if($strMonth=="3" && $strDay==$springHoliday){//春分の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 春分の日";
	}else if($strMonth=="3" && $strDay==$springHoliday+1 && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="4" && $strDay=="29"){//みどりの日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" みどりの日";
	}else if($strMonth=="4" && $strDay=="30" && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

//ＧＷの振替ロジックはちょっと特殊
	if($strMonth=="5" && $strDay=="3"){//憲法記念日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 憲法記念日";
	}else if($strMonth=="5" && $strDay=="6" && $strWeek=="3"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="5" && $strDay=="4"){//国民の休日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 国民の休日";
	}else if($strMonth=="5" && $strDay=="6" && $strWeek=="2"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="5" && $strDay=="5"){//子供の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 子供の日";
	}else if($strMonth=="5" && $strDay=="6" && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="7" && $strWeekCnt2=="3" && $strWeek=="1"){//海の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 海の日";
	}

	//秋分の日計算ロジック（1980-2099年まで）
	$fallHoliday =(int)(23.2488+0.242194*($strYear-1980)-(int)(($strYear-1980)/4));

	if($strMonth=="9" && $strDay==$fallHoliday){//秋分の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 秋分の日";
	}else if($strMonth=="9" && $strDay==$fallHoliday+1 && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="9" && $strWeekCnt2=="3" && $strWeek=="1"){//敬老の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 敬老の日";
	}

//敬老の日が21の場合、23日とオセロになるので22日は休みになる
	if($strMonth=="9" && $strWeekCnt2=="3" && $strWeek=="2" && $strDay=="22" && $fallHoliday !="22"){//敬老の日特殊ロジック
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="10" && $strWeekCnt2=="2" && $strWeek=="1"){//体育の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 体育の日";
	}

	if($strMonth=="11" && $strDay=="3"){//文化の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 文化の日";
	}else if($strMonth=="11" && $strDay=="4" && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="11" && $strDay=="23"){//勤労感謝の日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 勤労感謝の日";
	}else if($strMonth=="11" && $strDay=="24" && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

	if($strMonth=="12" && $strDay=="23"){//天皇誕生日
		$dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 天皇誕生日";
	}else if($strMonth=="12" && $strDay=="24" && $strWeek=="1"){//振り替え
        $dispDay="<font color='red'>".$strDay."</font>";
		$HolidayDisp=" 振替休日";
	}

//日本の特殊な日を判定しておこう
	$dispKey="";
	if($strMonth=="2" && $strDay=="14"){//バレンタインデー
		$dispKey=" バレンタイン";
	}

	if($strMonth=="3" && $strDay=="3"){//雛祭り
		$dispKey=" 雛祭り";
	}
	
	if($strMonth=="3" && $strDay=="14"){//ホワイトデー
		$dispKey=" ホワイトデー";
	}
	
	if($strMonth=="4" && $strDay=="1"){//エイプリルフール
		$dispKey=" ｴｲﾌﾟﾘﾙﾌｰﾙ";
	}

	if($strMonth=="5" && $strWeekCnt2=="2" && $strWeek=="0"){//母の日
		$dispKey=" 母の日";
	}
	
	if($strMonth=="6" && $strWeekCnt2=="3" && $strWeek=="0"){//父の日
		$dispKey=" 父の日";
	}

	if($strMonth=="7" && $strDay=="7"){//七夕
		$dispKey=" 七夕";
	}

	if($strMonth=="12" && $strDay=="25"){//クリスマス
		$dispKey=" クリスマス";
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
 時間のプルダウン用Function（）
 引数：	なし
 返り値：時間のプルダウン部分のhtml
*/ //**************************************************************************
Function GetTimeDropDown($obj){

	$DropDownHtml="";
	$DropDownHtml="<option value=0>設定なし";

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
 リンクの文字列をハイパーリンクに置き換えるFunction（）
 引数：
$str リンクを含む文字列
 返り値：リンク箇所を置き換えた文字列
*/ //**************************************************************************
Function http2link($str){
	$text = preg_replace("/(https?:\/\/[a-zA-Z0-9;\/?:@&=\+$,\-_\.!~*'\(\)%#]+)/","<a href='\\0' target='_blank'>\\0</a>",$str);
    return $text;
}
?>
