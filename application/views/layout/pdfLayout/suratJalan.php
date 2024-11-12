<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
	<link rel="icon" href="<?= base_url('assets/img/mdr.png') ?>" type="image/png">
	<link rel="stylesheet" href=<?= base_url("assets/css/suratJalanStyle.css")?>>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?= base_url('assets/img/logos/logo-surat.jpg'); ?>" alt="Logo">
        </div>

        <div class="doc-title">SURAT JALAN</div>
		<div class="doc-number"><?= $title; ?></div>

        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>
					<?php 
						$formatted_date = date('d F Y', strtotime($request->tgl_request)); 
						echo $formatted_date;
					?>
					</td>
					<td>No DN</td>
                    <td>:</td>
                    <td><?= $title; ?></td>
                </tr>
                <tr>
                    <td>Tujuan</td>
                    <td>:</td>
					<td>
						<?php
							$unique_locations = [];
							foreach ($detail_request as $tujuan) {
								if (!in_array($tujuan->lokasi, $unique_locations)) {
									$unique_locations[] = $tujuan->lokasi;
								}
							}
							echo implode(', ', $unique_locations);
						?>
					</td>
					<td>Plat No</td>
                    <td>:</td>
                    <td> </td>
                </tr>
            </table>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Item</th>
                    <th width="100">Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php 
				$no = 0;
				foreach($detail_request as $index){ ?>
                <tr>
                    <td style="text-align: center;"><?= $no+=1 ?></td>
                    <td><?= $index->nama_barang?></td>
                    <td style="text-align: center;"><?= $index->qtty ?></td>
                </tr>
                <?php 
				} 
				?>
            </tbody>
        </table>

        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td>
                        Pengirim,
						<p><?= $user['name'] ?></p>
                    </td>
                    <td>
                        Driver,
						<p><div class="signature-line"></div></p>
                    </td>
                    <td>
                        Penerima,
						<p><?= $request->nama ?> </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
