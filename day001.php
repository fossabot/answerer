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
	$sql="update cam_user set default_view =3 where user_id='".$user_id."'";
$rs = exSQL($sql,$conn);

//指定の日があった場合はその日を取得
if(!isset($_REQUEST['date'])){
	$targetDate = $strSystemYear."-".$strSystemMonth."-".$strSystemDay;
}else{
	$targetDate = $_REQUEST['date'];
}

$nextDay =date("Y-m-d",strtotime("1 day" ,strtotime($targetDate)));
$beforeDay =date("Y-m-d",strtotime("-1 day" ,strtotime($targetDate)));
$returnDate =$targetDate;


//共通ヘッダの表示
echo GetHeader($user_id,$conn);

?>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td><b>
<?php print(substr($targetDate,0,4)."年".substr($targetDate,5,2)."月".substr($targetDate,8,2)."日"); ?>

		</b></td>
		<td align="right"><a href="day001.php?date=<?php print($beforeDay);?>">＜前日</a>　<a href="day001.php?date=<?php print($nextDay);?>">翌日＞</a></td>
	</tr>
</table>
<form>
<input type="button" value="スケジュールを追加" onclick="location.href='insert001.php?date=<?php print($targetDate); ?>';">　
<input type="button" value="月次表示に戻る" onclick="location.href='month001.php?date=<?php print($returnDate); ?>';">　
<input type="button" value="週次表示に戻る" onclick="location.href='week001.php?date=<?php print($returnDate); ?>';">　
<p>
<?php
//当日データ取得用SQLの生成
$sql="select sec_number,TIME_FORMAT(start_time,'%H:%i') as start_time,TIME_FORMAT(end_time,'%H:%i') as end_time,title,detail ".
	"from cat_schedule where user_id='".$_COOKIE['user_id'].
	"' and DATE_FORMAT(schedule_date,'%Y-%m-%d')='".$targetDate."' and  del_flg='0' ".
	"order by start_time,end_time asc";
//echo $sql;
$rs = exSQL($sql,$conn);
//件数が0の場合
if($rs->num_rows==0){
	print("データなし<br>");
}else{
	while($row = $rs->fetch_assoc()){
?>
		<table width="600pt" border="1" cellpadding="2" cellspacing="1" style="margin:0pt">
		<tr>
			<td bgcolor="#FFFFCC" width="100pt">件名</td>
			<td><b><?php print($row["title"]); ?><b></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFCC" width="100pt">時間</td>
			<td>
			<?php
				if($row["start_time"] =="00:00" && $row["end_time"]=="00:00"){
					print("<br>");
				}else{
					print($row["start_time"]."～".$row["end_time"]);
				}
			 ?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFCC" width="100pt">内容</td>
			<td><?php print(http2link(nl2br($row["detail"]))); ?></td>
		</tr>
		</table>
		<table width="600pt" border="0" cellpadding="0" cellspacing="0" style="margin:3pt">
		<tr>
			<td>
			<input type="button" value="　編　集　" onclick="location.href='edit001.php?date=<?php print($targetDate); ?>&number=<?php print($row["sec_number"]);?>';">　
			<input type="button" value="　削　除　" onclick="location.href='delete001.php?date=<?php print($targetDate); ?>&number=<?php print($row["sec_number"]);?>';">
			</td>
		</tr>
		</table>

<p>
<?php
	}
}
//共通フッタの表示
echo GetFooter();

?>