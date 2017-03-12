<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：index
 * 作成日付：	   2012/10/01
 * 最終更新日：	   2012/10/01
 * プログラム説明：月次トップ画面
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2012/10/01	紅雷				新規作成
*************************************************************** */

//共通function読み込み
	require('./common.php');

//デフォルトの更新
	$sql="update cam_user set default_view =1 where user_id='".$user_id."'";
	$rs = exSQL($sql,$conn);


//指定の月があった場合はその月の情報を取得
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

$nextMonth=computeMonth($year,$month,1,1); //翌月の1日
$beforeMonth=computeMonth($year,$month,1,-1); //前月の1日
$TodayMonth=computeMonth($strSystemYear,$strSystemMonth,1,0); //当月の1日


//初日の曜日を取得
$strStartWeek = date("w",mktime(0, 0, 0, $month, 1, $year));


//共通ヘッダの表示
echo GetHeader($user_id,$conn);

?>
					
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="center"><b><?php print($year."年".$month."月");?><b>
		</td>
		<td align="right"><a href="month001.php?date=<?php print($beforeMonth);?>">＜前月</a>　<a href="month001.php?date=<?php print($TodayMonth);?>">当月</a>　<a href="month001.php?date=<?php print($nextMonth);?>">翌月＞</a></td>
	</tr>
</table>
		<table bgcolor="white" width="100%" border="1" cellpadding="2" cellspacing="0" style="margin:0pt">
		<tr><td bgcolor="#FFFFCC" align="center" width="14%" width="90" style="color:red">日</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >月</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >火</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >水</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >木</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" >金</td>
		<td bgcolor="#FFFFCC" align="center" width="14%" width="90" style="color:blue">土</td>
		</tr>
<?php
//変数の初期化
$i=0;
$day_count=0;
$L_Loop_Count=0;
$F_Loop_Count=$strStartWeek-1;
$week_Count =1; //週カウント用
$chk_cnt=0;
$weekCount_Sun=0;//日曜の週カウント用
$weekCount_Mon=0;//月曜の週カウント用

	for($i=0;$i<7;$i++){

		if($strToay_lastDay-$day_count > 0){
				$chk_cnt=$chk_cnt + 1;
				//最初の１週間のスタート位置前のブランクを設定
				if($i==0){
					$F_Loop_Count+=1;
					//日曜日が初日の場合以外ここの処理を実行
					if($F_Loop_Count!=7){
						print("<tr>");
						for($j=1;$j<$F_Loop_Count+1;$j++){
							print("<td>&nbsp</td>");
							
						}
					}
					//最初の週カウントは特殊ロジック
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


				//日付と件数を表示
				for($j=1;$j<$Loop_Count+1;$j++){


					$day_count=$day_count+1;
					if($strSystemYear.$strSystemMonth.$strSystemDay==$year.$month.$day_count){
						print("<td bgcolor='#D3E9F7'>");
						print("<b><a class='blocklink_today' href='day001.php?date=");
					}else{
						print("<td>");
						print("<b><a class='blocklink' href='day001.php?date=");
					}
				//日付の表示設定
					$strWeek = date("w",mktime(0, 0, 0, $month, $day_count, $year));
					print($year."-".$month."-".sprintf("%02d",$day_count)."'>".
					dispDays($year,$month,$day_count,$weekCount_Sun,$weekCount_Mon,$strWeek)."</a>");
//個別スケジュールのリンクを出力する

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
				//最終週の終わり後のブランクを設定
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

//共通フッタの表示
echo GetFooter();

?>
