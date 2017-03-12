<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：insert002
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
//設定日が同一のレコード数を検索
	$sql="SELECT count(*) CNT FROM cat_schedule WHERE user_id='".$_COOKIE['user_id']."' and schedule_date ='".$_REQUEST["set_date"]."'";
$rs = exSQL($sql,$conn);
//print($sql);
if($rs->num_rows==0){
		$CNT=0;
	}else{
		while($row = $rs->fetch_assoc()){
	        $CNT=$row["CNT"];
		}
	}
//該当数＋１をindexnumberに設定する
	$CNT +=1;
	
//データをＤＢに登録
	$sql="INSERT INTO cat_schedule VALUES('".$_COOKIE['user_id']."','".$CNT."','".$_REQUEST["set_date"].
	"','".$_REQUEST["start_time"]."','".$_REQUEST["end_time"]."','".$_REQUEST["title"]."','".$_REQUEST["detail"]."','0')";
	$rs = exSQL($sql,$conn);

//print($sql);
//画面遷移
	header("location: day001.php?date=".$_REQUEST["set_date"]);

?>
