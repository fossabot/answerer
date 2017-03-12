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

//日付情報の取得
$sql="SELECT default_view FROM cam_user WHERE user_id='".$_COOKIE['user_id']."'";
$rs = exSQL($sql,$conn);
while($row = $rs->fetch_assoc()){
        $default_view=$row["default_view"];
}

//画面遷移
if($default_view ==1){
	header("location: month001.php");
}else if($default_view==2){
	header("location: week001.php");
}else if($default_view==3){
	header("location: day001.php");
}else{
	header("location: month001.php");
}

