<div class="row">
	<div class="col-lg-3">
		<div class="col">
			<div class="ibox bg-success color-white widget-stat">
				<div class="ibox-body">
					<h2 class="m-b-5 font-strong"><?= $pinjam ?></h2>
					<div class="m-b-5">PINJAM</div><i class="ti-bar-chart widget-stat-icon"></i>
					
				</div>
			</div>
		</div>
		<div class="col">
			<div class="ibox bg-info color-white widget-stat">
				<div class="ibox-body">
					<h2 class="m-b-5 font-strong"><?= $request ?></h2>
					<div class="m-b-5">REQUEST</div><i class="ti-bar-chart widget-stat-icon"></i>
					
				</div>
			</div>
		</div>
		<div class="col">
			<div class="ibox bg-warning color-white widget-stat">
				<div class="ibox-body">
					<h2 class="m-b-5 font-strong"><?= $replace ?></h2>
					<div class="m-b-5">REPLACE</div><i class="ti-bar-chart widget-stat-icon"></i>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="ibox bg-primary color-white widget-stat">
				<div class="ibox-body">
					<h2 class="m-b-5 font-strong"><?= $pengajuan ?></h2>
					<div class="m-b-5">PENGAJUAN</div><i class="ti-bar-chart widget-stat-icon"></i>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="ibox bg-danger color-white widget-stat">
				<div class="ibox-body">
					<h2 class="m-b-5 font-strong"><?= $barang ?></h2>
					<div class="m-b-5">BARANG</div><i class="ti-bar-chart widget-stat-icon"></i>
					
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<canvas id="BarangChart" width="100%"></canvas>
		<canvas id="RequestChart" width="100%"></canvas>
	</div>
	<div class="col">
		<canvas id="PinjamChart" width="100%"></canvas>
		<canvas id="ReplaceChart" width="100%"></canvas>
	</div>
</div>

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
