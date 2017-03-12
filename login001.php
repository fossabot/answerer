<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：index
 * 作成日付：	   2012/10/01
 * 最終更新日：	   2012/10/01
 * プログラム説明：ログイン画面
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2012/10/01	紅雷				新規作成
*************************************************************** */

?>
<html>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=Shift_JIS">
		<title>スケジュール管理システム</title>
<style>
	input{background-color:transparent;border:0 solid blue; border-left:0 solid blue;font-size:10pt;}
</style>
<body>
<img src="img/login.jpg">
<form method="post" name="login001" action="login002.php">
<! -- ＩＤとパスワードの入力フォーム -->
<div ID="info_win" style="position:absolute;top:255;left:511;visibility:visible;z-index:1;border:0pt;">
<table><tr><td>
<input type="text" size="40" name="username" >
</td></tr></table>
</div>

<div ID="info_win" style="position:absolute;top:305;left:510;visibility:visible;z-index:2;border:0pt;">
<table><tr><td>
<input type="password" size="40" name="password">
</td></tr></table>
</div>

<div ID="info_win" style="position:absolute;top:391;left:544;visibility:true;z-index:0;border:0pt;">
<input type="image" name="submit" src="img/dummy.gif" width="116pt" height="25pt">
</div>


</form>
</body>
</html>