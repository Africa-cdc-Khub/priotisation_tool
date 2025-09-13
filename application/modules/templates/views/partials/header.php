<!-- ============================================================== -->
<!-- Modern Top Header -->
<!-- ============================================================== -->
<div class="modern-header">
	<div class="container-fluid">
		<div class="row align-items-center">
			<!-- Logo Section -->
			<div class="col-lg-3 col-md-3 d-none d-md-block">
				<div class="brand-section">
					<a class="brand-link" href="<?php echo base_url() ?>">
						<img src="<?php echo base_url() ?>assets/images/logo.png" class="brand-logo" alt="Africa CDC" />
					</a>
				</div>
			</div>
			
			<!-- Title Section -->
			<div class="col-lg-5 col-md-5 text-center">
				<div class="title-section">
					<h1 class="main-title">
						<a href="<?php echo base_url() ?>" class="title-link">
							Africa CDC Research Prioritisation Tool
						</a>
					</h1>
					<?php if (!empty($memberstate)): ?>
					<p class="subtitle">
						<i class="fa fa-map-marker-alt"></i> <?= @$memberstate ?>
					</p>
					<?php endif; ?>
				</div>
			</div>
			
			<!-- Language & User Section -->
			<div class="col-lg-4 col-md-4 text-end">
				<div class="header-actions">
					<!-- Language Selector -->
					<div class="language-selector">
						<div id="google_translate_element" style="display: none;"></div>
						<div class="language-dropdown">
							<button class="language-btn" type="button" data-toggle="dropdown">
								<i class="fa fa-globe"></i>
								<span class="current-lang">EN</span>
								<i class="fa fa-chevron-down"></i>
							</button>
							<div class="dropdown-menu language-menu">
								<a href="#" onclick="doGTranslate('en'); return false;" class="dropdown-item">
									<i class="flag-icon flag-icon-us"></i> English
								</a>
								<a href="#" onclick="doGTranslate('fr'); return false;" class="dropdown-item">
									<i class="flag-icon flag-icon-fr"></i> Français
								</a>
								<a href="#" onclick="doGTranslate('ar'); return false;" class="dropdown-item">
									<i class="flag-icon flag-icon-sa"></i> العربية
								</a>
								<a href="#" onclick="doGTranslate('es'); return false;" class="dropdown-item">
									<i class="flag-icon flag-icon-es"></i> Español
								</a>
								<a href="#" onclick="doGTranslate('pt'); return false;" class="dropdown-item">
									<i class="flag-icon flag-icon-pt"></i> Português
								</a>
								<a href="#" onclick="doGTranslate('sw'); return false;" class="dropdown-item">
									<i class="flag-icon flag-icon-ke"></i> Kiswahili
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modern Navigation -->
<nav class="modern-nav">
	<div class="container-fluid">
		<div class="nav-container">
			<!-- Mobile Menu Toggle -->
			<div class="mobile-toggle">
				<button class="nav-toggle-btn" type="button" data-toggle="collapse" data-target="#navbarNav">
					<span class="hamburger-line"></span>
					<span class="hamburger-line"></span>
					<span class="hamburger-line"></span>
				</button>
			</div>

			<!-- Navigation Menu -->
			<div class="navbar-nav-wrapper" id="navbarNav">
				<div class="nav-left">
					<ul class="modern-nav-menu">
						<li class="nav-item">
							<a class="nav-link" href="<?= base_url() ?>records">
								<span class="nav-icon nav-icon-dashboard">
									<i class="fa fa-chart-line"></i>
								</span>
								<span>Dashboard</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= base_url() ?>records/profile">
								<span class="nav-icon nav-icon-disease">
									<i class="fa fa-heartbeat"></i>
								</span>
								<span>Disease Profile</span>
							</a>
						</li>
					</ul>
				</div>

				<!-- User Menu -->
				<div class="nav-right">
					<?php if (!empty($this->session->userdata('id'))): ?>
						<div class="user-dropdown">
							<button class="user-btn" type="button" data-toggle="dropdown">
								<div class="user-avatar">
									<i class="fa fa-user"></i>
								</div>
								<div class="user-info">
									<span class="user-name"><?php echo $this->session->userdata('name'); ?></span>
									<span class="user-role">
										<?php echo ($this->session->userdata('role') == '10') ? 'Administrator' : 'User'; ?>
									</span>
								</div>
								<i class="fa fa-chevron-down"></i>
							</button>
							<div class="dropdown-menu user-menu">
								<div class="user-menu-header">
									<div class="user-avatar-large">
										<i class="fa fa-user"></i>
									</div>
									<div class="user-details">
										<h6><?php echo $this->session->userdata('name'); ?></h6>
										<small><?php echo $this->session->userdata('email'); ?></small>
									</div>
								</div>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo base_url('auth/profile'); ?>">
									<span class="nav-icon nav-icon-profile">
										<i class="fa fa-user-circle"></i>
									</span>
									Profile
								</a>
								<?php if($this->session->userdata('role') == "10"): ?>
									<a class="dropdown-item" href="<?php echo base_url('dashboard/home'); ?>">
										<span class="nav-icon nav-icon-dashboard">
											<i class="fa fa-cogs"></i>
										</span>
										Manage Data
									</a>
								<?php endif; ?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">
									<span class="nav-icon nav-icon-logout">
										<i class="fa fa-sign-out-alt"></i>
									</span>
									Logout
								</a>
							</div>
						</div>
					<?php else: ?>
						<a href="#" class="login-btn" data-toggle="modal" data-target="#login">
							<i class="fa fa-sign-in-alt"></i>
							<span>Login</span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</nav>
<!-- End Navigation -->
<div class="clearfix"></div>
<!-- ============================================================== -->
<!-- Top header  -->
<!-- ============================================================== -->