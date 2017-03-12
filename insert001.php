<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：insert001
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

//共通ヘッダの表示
echo GetHeader($user_id,$conn);

?>
<b>予定の追加</b>
<table width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td>
<?php print(substr($targetDate,0,4)."年".substr($targetDate,5,2)."月".substr($targetDate,8,2)."日"); ?>
		</td>
	</tr>
</table>
<form method="post" name="insert001"  onSubmit="return numberCheck()" action="insert002.php">
<table border="1" cellpadding="2" cellspacing="1" style="margin:0pt">
<tr>
	<td bgcolor="#FFFFCC" width="100pt">件名</td>
	<td><input name="title" type="text" size="100"></td>
</tr>
<tr>
	<td bgcolor="#FFFFCC" width="100pt">時間</td>
	<td>
	<select name="start_time"  width="70pt">
<?php print(GetTimeDropDown(99));?>
	</select>
		～
	<select name ="end_time">
<?php print(GetTimeDropDown(99));?>
	</select>
	</td>
</tr>
<tr>
	<td bgcolor="#FFFFCC" width="100pt">内容</td>
	<td><textarea name ="detail" cols="80" rows="15"></textarea></td>
</tr>
</table>
<input type="hidden" name="set_date" value="<?php print($targetDate); ?>">
<br>
<input type="submit" value="　登　録　">　
<input type="button" value="　戻　る　"  onclick="location.href='day001.php?date=<?php print($targetDate); ?>'">　



</form>
<?php
//共通フッタの表示
echo GetFooter();
?>