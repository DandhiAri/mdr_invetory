<header class="header">
	<div class="page-brand">
		<a class="link" href="#">
			<span class="brand">Mangli Djaya Raya
				<!--<span class="brand-tip">(admin)</span>-->
			</span>
			<span class="brand-mini"></span>
		</a>
	</div>
	<div class="flexbox flex-1">
		<!-- START TOP-LEFT TOOLBAR-->
		<ul class="nav navbar-toolbar">
			<li>
				<a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
			</li>
			<!--<li>
				<form class="navbar-search" action="javascript:;">
					<div class="rel">
						<span class="search-icon"><i class="ti-search"></i></span>
						<input class="form-control" placeholder="Search here...">
					</div>
				</form>
			</li>-->
		</ul>
		<!-- END TOP-LEFT TOOLBAR-->
		<!-- START TOP-RIGHT TOOLBAR-->
		<ul class="nav navbar-toolbar">
				<li class="dropdown dropdown-user">
				<a class="nav-link dropdown-toggle link" data-toggle="dropdown">
					<img src="<?= base_url('assets'); ?>./img/mdr.png" width="45px" />
					<span>Admin<i class="fa fa-angle-down m-l-5"></i></a></span>
				<ul class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" href="<?= base_url('profile'); ?>"><i class="fa fa-user"></i>Profile</a>
					<li class="dropdown-divider"></li>
					<a class="dropdown-item" href=<?= base_url('auth/logout'); ?>><i class="fa fa-power-off"></i>Logout</a>
				</ul>
			</li>
		</ul>
		<!-- END TOP-RIGHT TOOLBAR-->
	</div>
</header>
<!-- END HEADER-->
