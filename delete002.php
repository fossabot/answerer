<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：delete002
 * 作成日付：	   2012/10/01
 * 最終更新日：	   2012/10/01
 * プログラム説明：削除実行画面
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2012/10/01	紅雷				新規作成
*************************************************************** */
//共通function読み込み
	require('./common.php');
/*
引数
user_id		ユーザーＩＤ[クッキー情報]
set_date	設定日
sec_number　連番

*/
$start_time =htmlspecialchars($_REQUEST["start_time"]);
$end_time = htmlspecialchars($_REQUEST["end_time"]);
$title = htmlspecialchars($_REQUEST["title"]);
$detail = htmlspecialchars($_REQUEST["detail"]);
$sec_number = htmlspecialchars($_REQUEST["sec_number"]);
$set_date = htmlspecialchars($_REQUEST["set_date"]);
	
//データをＤＢに更新
	$sql="UPDATE cat_schedule SET del_flg=1 where user_id='".$_COOKIE['user_id'].
		"' and schedule_date ='".$set_date."' and sec_number=".$sec_number;
	mysql_query('SET NAMES sjis');
	mysql_query($sql,$conn);

//画面遷移
	header("location: day001.php?date=".$_REQUEST["set_date"]);

?>
