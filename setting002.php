<?php
/* ****************************************************************
 * All Rights Reserved, Copyright(C) korai 2009
 * プログラム名：  家計簿システム
 * プログラムＩＤ：setting002
 * 作成日付：	   2009/10/21
 * 最終更新日：	   2008/10/21
 * プログラム説明：ユーザー管理画面
 * 変更履歴
 * 変更日時		変更者名			説明
 * 2009/10/21	紅雷				新規作成
*************************************************************** */
//共通function読み込み
	require('./common.php');
//共通ヘッダの表示
echo GetHeader($user_id,$conn);

?>
<script language="javascript">
	function update(obj){
		//更新モードを次ページに移送する（1:登録　2:変更）
		document.ip_in.update_mode.value=obj;

		document.ip_in.submit();
	}
</script>

		</head>
<h4>ユーザー管理</h4><p>
<FORM method="post" name="ip_in" action="setting003.php">
<table>
<tr><td>
ログインＩＤ</td><td>：<INPUT size="28" value="" maxlength="28" type="text" name="input_id" >
</td></tr><tr><td>
パスワード</td><td>：<INPUT size="28" value="" maxlength="28" type="text" name="input_pass" ><br>
</td></tr><tr><td>
ユーザー名</td><td>：<INPUT size="28" value="" maxlength="28" type="text" name="input_username" ><br>
</td></tr><tr><td>
権限　　　</td><td>：<select name='input_kgn'><option value=0>管理者<option value=1 selected>一般ユーザー</select>
</td></tr>
</table>
<p>
<INPUT size="28" value="　登　録　" type="button" onclick="update(1)">　
<INPUT size="28" value="　更　新　" type="button" onclick="update(2)">　
<INPUT size="28" value="　戻　る　" type="button" onclick="location.href='setting001.php'">　
<INPUT size="0" value="" maxlength="28" type="text" name="dummy" style="visibility:hidden;">
<INPUT value="" type="hidden" name="update_mode">
<p>
<?php
//登録者一覧を取得
	$sql="select user_id,login_id,user_pass,user_name,user_grade from cam_user";

	mysql_query('SET NAMES sjis');
	$rs = mysql_query($sql,$conn);

//ヘッダを表示
	print("<table bgcolor='white' border='1' cellpadding='2' cellspacing='0' style='margin:0pt'>");
	print("<tr><th bgcolor='#FFFFCC' align='center' width='180'>ログインID</th>");
	print("<th bgcolor='#FFFFCC' align='center' width='90' >パスワード</th>");
	print("<th bgcolor='#FFFFCC' align='center' width='90' >ユーザー名</th>");
	print("<th bgcolor='#FFFFCC' align='center' width='30pt' >権限</th>");
	print("<th bgcolor='#FFFFCC' align='center' width='30pt' >削除</th></tr>");

//内容の取得と表示
$rec_cnt=0;
	while($row=mysql_fetch_assoc($rs)){
		$user_id=$row["user_id"];
		$login_id=$row["login_id"];
		$user_pass=rot13decrypt($row["user_pass"]);
		$user_name=$row["user_name"];
		$user_grade=$row["user_grade"];
		
		print("<input type='hidden'name='user_id".$rec_cnt."'value='".$user_id."'>".
		"<tr><td><input size=40 type='text'name='login_id".$rec_cnt."'value='".$login_id."'>".
		"</td><td><input type='text' name='user_pass".$rec_cnt."'value='".$user_pass."'>".
		"</td><td><input type='text' name='user_name".$rec_cnt."'value='".$user_name."'>");
		
		print("</td><td><select name='user_grade".$rec_cnt."'>");
		print("<option value='0'");
		if($user_grade=="0"){print(" selected");}
		print(">管理者");
		
		print("<option value='1'");
		if($user_grade=="1"){print(" selected");}
		print(">一般ユーザー");
		print("</sclect>");
		
		print("</td><td><input type='checkbox'name='delflg".$rec_cnt."'value='1'></td></tr>");
		$rec_cnt =$rec_cnt + 1;
	}


print("<INPUT value='".$rec_cnt."' type='hidden' name='update_cnt'>");

?>
</form>
<?php
//共通フッタの表示
echo GetFooter();

?>