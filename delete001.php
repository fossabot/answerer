<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：delete001
 * 作成日付：	   2012/10/01
 * 最終更新日：	   2012/10/01
 * プログラム説明：スケジュール新規登録
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2012/10/01	紅雷				新規作成
*************************************************************** */
//共通function読み込み
	require('./common.php');

$targetDate = htmlspecialchars($_REQUEST['date']);
$targetSecNumber = htmlspecialchars($_REQUEST['number']);

$sql="select sec_number,TIME_FORMAT(start_time,'%H:%m') as start_time,TIME_FORMAT(end_time,'%H:%m') as end_time,title,detail ".
	"from cat_schedule where user_id='".$_COOKIE['user_id'].
	"' and DATE_FORMAT(schedule_date,'%Y-%m-%d')='".$targetDate."' and  del_flg='0' and sec_number='".$targetSecNumber."'";

mysql_query('SET NAMES sjis');
$rs = mysql_query($sql,$conn);

//共通ヘッダの表示
echo GetHeader($user_id,$conn);
//件数が0の場合
if(mysql_num_rows($rs)==0){
	print("（仮）エラー");
}else{
	while($row=mysql_fetch_assoc($rs)){

?>
<b>予定の削除</b>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td>
<?php print(substr($targetDate,0,4)."年".substr($targetDate,5,2)."月".substr($targetDate,8,2)."日"); ?>
		</td>
	</tr>
</table>
<b>このスケジュールを削除します</b>
<form method="post" name="delete001" action="delete002.php">
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
			<td><?php print(nl2br($row["detail"])); ?></td>
		</tr>
		</table>

<input type="hidden" name="set_date" value="<?php print($targetDate); ?>">
<input type="hidden" name="sec_number" value="<?php print($targetSecNumber); ?>">

<br>
<input type="submit" value="　削　除　">　
<input type="button" value="　戻　る　"  onclick="location.href='day001.php?date=<?php print($targetDate); ?>'">　



</form>
<?php
	}
}
//共通フッタの表示
echo GetFooter();
?>