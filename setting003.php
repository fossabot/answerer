<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2009
 * プログラム名：  家計簿システム
 * プログラムＩＤ：setting003
 * 作成日付：	   2009/10/21
 * 最終更新日：	   2008/10/21
 * プログラム説明：DB更新画面
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2009/10/21	紅雷				新規作成
*************************************************************** */
//共通function読み込み
	require('./common.php');
/*
引数
input_id	ログインＩＤ
input_pass	パスワード
input_kgn	権限（0:管理者　1:一般ユーザー）
update_mode	更新モード（1:登録　2:更新）
*/
$update_cnt=$_REQUEST['update_cnt'];

if($_REQUEST['update_mode']=="1"){
	//登録時まずはuseridの最大値+1を取得
	$sql="select max(user_id)+1 max_id from cam_user";
	mysql_query('SET NAMES sjis');
	$rs = mysql_query($sql,$conn);

	while($row=mysql_fetch_assoc($rs)){
        $max_id=$row["max_id"];
	}
	$i = strlen($max_id);
	$user_id ="0000000000".(string)$max_id;
	$user_id = substr($user_id, $i, 10);

	//dbにインサートする
	$sql="insert into cam_user values('".$user_id."','".$_REQUEST['input_id']."','".rot13encrypt($_REQUEST['input_pass'])."','".$_REQUEST['input_username']."','".$_REQUEST['update_mode']."','1')";
	mysql_query('SET NAMES sjis');
	mysql_query($sql,$conn);

}else if($_REQUEST['update_mode']=="2"){

	for($i=0;$i<$update_cnt;$i++){
		if($_REQUEST['delflg'.$i]=="1"){
			$sql="delete from cam_user where user_id='".$_REQUEST['user_id'.$i]."'";
		}else{
			$sql="update cam_user set login_id='".$_REQUEST['login_id'.$i].
			"',user_pass='".rot13encrypt($_REQUEST['user_pass'.$i])."',user_name='".$_REQUEST['user_name'.$i]."',user_grade='".$_REQUEST['user_grade'.$i].
			"' where user_id='".$_REQUEST['user_id'.$i]."'";
		}
		mysql_query('SET NAMES sjis');
		mysql_query($sql,$conn);
	}
}

//画面遷移
header("location: setting002.php");
?>
