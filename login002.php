<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2012
 * プログラム名：  スケジュール管理システム(アンサラー)
 * プログラムＩＤ：index
 * 作成日付：	   2012/10/01
 * 最終更新日：	   2012/10/01
 * プログラム説明：認証画面
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2012/10/01	紅雷				新規作成
*************************************************************** */

//アクセス接続文字列
	require('./common.php');

/*リクエストより取得する変数
username ユーザーID
password　パスワード
*/

$username=htmlspecialchars($_REQUEST['username']);
$passWord=htmlspecialchars(rot13encrypt($_REQUEST['password']));

$sql="SELECT count(*) CNT FROM cam_user WHERE login_id='".$username."' AND user_pass='".$passWord."'";
$rs = exSQL($sql,$conn);
while($row = $rs->fetch_assoc()){
        $CNT=$row["CNT"];
}

if($CNT>0){
	//user_idの取得
$sql="SELECT user_id FROM cam_user WHERE login_id='".$username."' AND user_pass='".$passWord."'";
$rs = exSQL($sql,$conn);
while($row = $rs->fetch_assoc()){
        $user_id=$row["user_id"];
}

//ユーザーパスはブラウザ終了まで有効にしとく（期間未設定の場合ブラウザ閉じたら終了になる）
		setcookie("user_id",$user_id);
		setcookie("passWord",$passWord);

//画面遷移
	header("location: index001.php");
}else{
//画面遷移
	header("location: login001.php");
}

?>
