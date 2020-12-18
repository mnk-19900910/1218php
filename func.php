<?php
// var_dump($_POST);

// 変数の初期化
$page_flag = 0;
$clean = array();
$error = array();

// サニタイズ
if( !empty($_POST) ) {
	foreach( $_POST as $key => $value ) {
		$clean[$key] = htmlspecialchars( $value, ENT_QUOTES);
	} 
}

if( !empty($_POST['btn_confirm']) ) {

    $error = validation($clean);

	if( empty($error) ) {
        $page_flag = 1;

        // セッションの書き込み
		session_start();
		$_SESSION['page'] = true;
	}
} elseif( !empty($clean['btn_submit']) ) {
	session_start();
	if( !empty($_SESSION['page']) && $_SESSION['page'] === true ) {

		// セッションの削除
		unset($_SESSION['page']);
        $page_flag = 2;
        
        // 変数とタイムゾーンを初期化
        $header = null;
	    $auto_reply_subject = null;
        $auto_reply_text = null;
        $admin_reply_subject = null;
	    $admin_reply_text = null;
	    date_default_timezone_set('Asia/Tokyo');

	    // ヘッダー情報を設定
	    $header = "MIME-Version: 1.0\n";
	    $header .= "From: GRAYCODE <noreply@gray-code.com>\n";
	    $header .= "Reply-To: GRAYCODE <noreply@gray-code.com>\n";

	    // 件名を設定
	    $auto_reply_subject = 'お問い合わせありがとうございます。';

	    // 本文を設定
	    $auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。\n\n";
	    $auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	    $auto_reply_text .= "氏名：" . $_POST['your_name'] . "\n";
	    $auto_reply_text .= "メールアドレス：" . $_POST['email'] . "\n\n";

	    // メール送信
        mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text);
        
	    // 運営側へ送るメールの件名
	    $admin_reply_subject = "お問い合わせを受け付けました";
        
	    // 本文を設定
	    $admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
	    $admin_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	    $admin_reply_text .= "氏名：" . $_POST['your_name'] . "\n";
	    $admin_reply_text .= "メールアドレス：" . $_POST['email'] . "\n\n";

	    // 運営側へメール送信
	    mb_send_mail( 'webmaster@gray-code.com', $admin_reply_subject, $admin_reply_text, $header);
    }else{
        $page_flag = 0;
    }
}

function validation($data) {

	$error = array();

	// 氏名のバリデーション
	if( empty($data['your_name']) ) {
		$error[] = "「氏名」は必ず入力してください。";

	} elseif( 40 < mb_strlen($data['your_name']) ) {
        $error[] = "「氏名」は40文字以内で入力してください。";
        
    } elseif( !preg_match( '/([ァ-ヴ]+\s[ァ-ヴ]+)$/', $data['your_name']) ) {
        $error[] = "「氏名」は全角カナで入力してください。(氏名の間は半角スペース１文字)";
    }

	// メールアドレスのバリデーション
	if( empty($data['email']) ) {
		$error[] = "「メールアドレス」は必ず入力してください。";

	} elseif( !preg_match( '/([a-zA-Z0-9\.-_]+)@([a-zA-Z0-9\.-_]+)$/', $data['email']) ) {
		$error[] = "「メールアドレス」は正しい形式で入力してください。";
	}
	return $error;
}
?>