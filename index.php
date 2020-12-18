<?php include('./func.php'); ?>

<!DOCTYPE>
<html lang="ja">
<head>
	<title>登録ページ</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>登録ページ</h1>

	<?php if( $page_flag === 1 ): ?>

	    <form method="post" action="">
			<div class="element_wrap">
				<label>氏名</label>
				<p><?php echo $_POST['your_name']; ?></p>
			</div>
			<div class="element_wrap">
				<label>メールアドレス</label>
				<p><?php echo $_POST['email']; ?></p>
			</div>
			<input type="submit" name="btn_back" value="戻る">
			<input type="submit" name="btn_submit" value="送信">
			<input type="hidden" name="your_name" value="<?php echo $_POST['your_name']; ?>">
			<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
		</form>

	<?php elseif( $page_flag === 2 ): ?>

		<p>送信が完了しました。</p>

	<?php else: ?>

		<?php include('./error.php'); ?>

		<form method="post" action="">
			<div class="element_wrap">
				<label>氏名</label>
				<input type="text" name="your_name" value="<?php if( !empty($_POST['your_name']) ){ echo $_POST['your_name']; } ?>">
			</div>
			<div class="element_wrap">
				<label>メールアドレス</label>
				<input type="text" name="email" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>">
			</div>
			<input type="submit" name="btn_confirm" value="確認">
			<input type="reset" name="btn_back" onclick="return confirm('削除しますか？');" value="リセット">
		</form>

	<?php endif; ?>
</body>
</html>
