<div class="row">
	<div class="col">
		<div class="col">
			<div class="ibox bg-info color-white widget-stat">
				<div class="ibox-body container-status">
					<div class="head">
						<h2 class="m-b-5 font-strong"><?= $request ?></h2>
						<div class="m-b-5">PERINTAH REQUEST</div><i class="ti-bar-chart widget-stat-icon"></i>
					</div>
					<div class="statuses">
						<div class="status bg-warning">
							<h2 class="m-b-5  font-strong"><?= $statusRequestRequested ?></h2>
							<div class="m-b-5">REQUESTED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
						<div class="status bg-success">
							<h2 class="m-b-5 font-strong"><?= $statusRequestFinished ?></h2>
							<div class="m-b-5">FINISHED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
						<div class="status bg-danger">
							<h2 class="m-b-5 font-strong"><?= $statusRequestRejected ?></h2>
							<div class="m-b-5">REJECTED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="ibox bg-dark color-white widget-stat">
				<div class="ibox-body container-status">
					<div class="head">
						<h2 class="m-b-5 font-strong"><?= $replace ?></h2>
						<div class="m-b-5">PERINTAH REPLACE</div><i class="ti-bar-chart widget-stat-icon"></i>
					</div>
					<div class="statuses">
						<div class="status bg-warning">
							<h2 class="m-b-5  font-strong"><?= $statusReplaceRequested ?></h2>
							<div class="m-b-5">REQUESTED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
						<div class="status bg-success">
							<h2 class="m-b-5 font-strong"><?= $statusReplaceFinished ?></h2>
							<div class="m-b-5">FINISHED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
						<div class="status bg-danger">
							<h2 class="m-b-5 font-strong"><?= $statusReplaceRejected ?></h2>
							<div class="m-b-5">REJECTED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="ibox bg-primary color-white widget-stat">
				<div class="ibox-body container-status">
					<div class="head">
						<h2 class="m-b-5 font-strong"><?= $pinjam ?></h2>
						<div class="m-b-5">PERINTAH PINJAM</div><i class="ti-bar-chart widget-stat-icon"></i>
					</div>
					<div class="statuses">
						<div class="status bg-warning">
							<h2 class="m-b-5  font-strong"><?= $statusPinjamRequested ?></h2>
							<div class="m-b-5">REQUESTED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
						<div class="status bg-success">
							<h2 class="m-b-5 font-strong"><?= $statusPinjamFinished ?></h2>
							<div class="m-b-5">FINISHED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
						<div class="status bg-danger">
							<h2 class="m-b-5 font-strong"><?= $statusPinjamRejected ?></h2>
							<div class="m-b-5">REJECTED</div><i class="ti-bar-chart widget-stat-icon"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="col">
			<div class="ibox bg-success color-white widget-stat">
				<div class="ibox-body">
					<h2 class="m-b-5 font-strong"><?= $pengajuan ?></h2>
					<div class="m-b-5">PENGAJUAN</div><i class="ti-bar-chart widget-stat-icon"></i>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="ibox bg-warning color-white widget-stat">
				<div class="ibox-body">
					<h2 class="m-b-5 font-strong"><?= $barang ?></h2>
					<div class="m-b-5">NAMA BARANG</div><i class="ti-bar-chart widget-stat-icon"></i>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="ibox bg-danger color-white widget-stat">
				<div class="ibox-body">
					<h2 class="m-b-5 font-strong"><?= $det_barang ?></h2>
					<div class="m-b-5">DETAIL BARANG</div><i class="ti-bar-chart widget-stat-icon"></i>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<!-- <div class="col">
		<canvas id="DognutChart" width="100%"></canvas>
	</div> -->
	<div class="col">
		<canvas id="RequestChart" width="100%"></canvas>
	</div>
</div>
<div class="col">
	<canvas id="BarangChart" width="100%"></canvas>
</div>
<!-- <div class="row">
	<div class="col">
		<canvas id="ReplaceChart" width="100%"></canvas>
		<canvas id="PinjamChart" width="100%"></canvas>
	</div>
</div> -->


<style>
	.visitors-table tbody tr td:last-child {
		display: flex;
		align-items: center;
	}

	.visitors-table .progress {
		flex: 1;
	}

	.visitors-table .progress-parcent {
		text-align: right;
		margin-left: 10px;
	}
</style>
