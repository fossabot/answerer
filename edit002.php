<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：edit002
 * 作成日付：	   2012/10/01
 * 最終更新日：	   2012/10/01
 * プログラム説明：登録実行画面
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
start_time	開始時間
end_time	終了時間
title		タイトル
detail		明細

*/
$start_time =$_REQUEST["start_time"];
$end_time = $_REQUEST["end_time"];
$title = $_REQUEST["title"];
$detail = $_REQUEST["detail"];
$sec_number = $_REQUEST["sec_number"];
$set_date = $_REQUEST["set_date"];

//データをＤＢに更新
	$sql="UPDATE cat_schedule SET start_time='".$start_time."',end_time='".$end_time.
		"',title='".$title."',detail='".$detail."' where user_id='".$_COOKIE['user_id'].
		"' and schedule_date ='".$set_date."' and sec_number=".$sec_number;
$rs = exSQL($sql,$conn);
echo($sql);
//画面遷移
	header("location: day001.php?date=".$_REQUEST["set_date"]);

?>
