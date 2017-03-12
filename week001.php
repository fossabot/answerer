<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：index
 * 作成日付：	   2012/10/01
 * 最終更新日：	   2012/10/01
 * プログラム説明：週次トップ画面
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2012/10/01	紅雷				新規作成
*************************************************************** */

//共通function読み込み
	require('./common.php');

//デフォルトの更新
	$sql="update cam_user set default_view =2 where user_id='".$user_id."'";
	mysql_query('SET NAMES sjis');
	mysql_query($sql,$conn);

//指定の日があった場合はその日の週情報を取得
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

//共通ヘッダの表示
echo GetHeader($user_id,$conn);

?>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td valign="center"><b><?php print($year."年".$month."月");?><b>
		</td>
		<td align="right"><a href="week001.php?date=<?php print($beforeWeek);?>">＜前週</a>　<a href="week001.php?date=<?php print($nextWeek);?>">翌週＞</a></td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0"  border=1 >
<tr>
<td align="center" width="120pt">日</td>
<td align="center" width="40pt">曜日</td>
<td align="center" width="400pt">タイトル</td>
</tr>
<?php
$weekKey = array(0=>"<font color='red'>日</font>",1=>"月",2=>"火",3=>"水",4=>"木",5=>"金",6=>"<font color='blue'>土</font>");
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
						$dayData[$cnt] = "[".$row["start_time"]."～".$row["end_time"]."]".$row["title"]."<br>";
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
//共通フッタの表示
echo GetFooter();

?>