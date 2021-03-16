<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<title>Rincian Pembelian</title>

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

	<style type="text/css">
		html, body {
			padding: 0px;
			margin: 0px;
			font-family: 'Open Sans', sans-serif;
			font-size: 14px;
		}

		.wrapper-outer {
			background: #FAFAFA;
		}

		.container {
			max-width: 640px;
			margin: auto;
			padding-top: 30px;
			padding-bottom: 30px;
		}

		.logo {
			text-align: center;
			margin-bottom: 30px;
		}

		.box-content {
			background: #ffffff;
			border: 1px solid #d5d5d5;
			padding: 30px;
		}
	</style>
</head>
<body>
	<div class="wrapper-outer">
		<div class="container">

			<div class="logo">
				<img src="<?= setting_item('site.site_logo'); ?>">
			</div>

			<div class="box-content">
				<p>Hai <?php echo $order->user['name']?>,</p>

				<p>Terimakasih telah melakukan pembayaran. Adapun rincian pembeliannya adalah sebagai berikut:</p>

				<table border="0">
				    <tr align="left"><td width="150">Nama Produk</td><td><strong><?php echo $order->items[0]->product_name;?></strong></td></tr>
				    <!--<tr><th>Qty</th><td>1</td></tr>-->
				    <tr align="left"><td width="150">Harga</td><td>Rp <?php echo number_format($order->gross_amount);?></td></tr>
				    <!--<tr align="left"><td width="150">Tanggal</td><td>04/08/2018</td></tr>-->
				    <tr align="left"><td width="150">Tipe</td><td><?php echo $order->items[0]->product_type;?></td></tr>
				    <tr align="left"><td width="150">Kupon Diskon</td><td><?php echo $order->coupon_code ?? '-';?></td></tr>
				    <tr align="left"><td width="150">Total Harga</td><td>Rp <?php echo number_format($order->gross_amount_discount);?></td></tr>
				</table>

				<p>Untuk memulai belajar, silahkan login kembali di <a href="<?= site_url(); ?>"><?= site_url(); ?></a> kemudian masuk ke menu <strong>My Dashboard</strong>.</p>

				<p>Jika kamu mengalami kesulitan dalam proses belajar, kamu bisa membuka pembahasan melalui Forum Diskusi yang telah disediakan dei setiap lesson-nya.</p>

				<p>Selamat belajar, semoga kamu mendapatkan hasil maksimal dalam proses belajarmu :)</p>
				
				<p>Salam hangat,<br/>
				<?= setting_item('site.site_title'); ?></p>
			</div>
		</div>
	</div>
</body>
</html>