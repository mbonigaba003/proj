<?php
require_once __DIR__ . '/../app/bootstrap.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>School Dashboard</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
	<div class="app-shell" data-theme="light">
		<aside class="sidebar">
			<div class="brand">
				<img src="assets/img/logo.svg" alt="Logo" class="logo" />
				<span class="brand-title">AstriaLearning</span>
			</div>
			<nav class="nav">
				<a class="nav-item active" href="#">
					<span class="icon">🏠</span>
					<span>Dashboard</span>
				</a>
				<span class="nav-section">Academics</span>
				<a class="nav-item" href="#"><span class="icon">📄</span><span>Application</span></a>
				<a class="nav-item" href="#"><span class="icon">📝</span><span>Registration</span></a>
				<a class="nav-item" href="#"><span class="icon">📊</span><span>Gradebook</span></a>
				<span class="nav-section">Collaboration</span>
				<a class="nav-item" href="#"><span class="icon">💬</span><span>Messages</span><span class="badge" id="badge-messages">0</span></a>
				<a class="nav-item" href="#"><span class="icon">👥</span><span>Human Resource</span></a>
				<span class="nav-section">System</span>
				<a class="nav-item" href="#"><span class="icon">📈</span><span>Data & Reports</span></a>
				<a class="nav-item" href="#"><span class="icon">⚙️</span><span>Settings</span></a>
			</nav>
			<div class="sidebar-footer">
				<button id="toggle-theme" class="btn btn-ghost">🌙 <span>Dark Mode</span></button>
			</div>
		</aside>
		<main class="content">
			<header class="topbar">
				<div class="search">
					<input type="search" id="global-search" placeholder="Search..." />
				</div>
				<div class="user-actions">
					<button class="icon-btn" id="btn-bell" title="Notifications">🔔</button>
					<button class="icon-btn" id="btn-help" title="Help">❓</button>
					<div class="user-avatar" title="Profile">R</div>
				</div>
			</header>

			<section id="system-banner" class="banner banner-warning" hidden>
				<span class="icon">⚠️</span>
				<p id="banner-text"></p>
			</section>

			<section class="widgets-grid">
				<div class="widget stat">
					<div class="stat-icon bg-pink">👨‍🎓</div>
					<div class="stat-info">
						<h3>Students</h3>
						<p class="stat-value" id="stat-students">0</p>
					</div>
				</div>
				<div class="widget stat">
					<div class="stat-icon bg-blue">👔</div>
					<div class="stat-info">
						<h3>Employees</h3>
						<p class="stat-value" id="stat-employees">0</p>
					</div>
				</div>
				<div class="widget stat">
					<div class="stat-icon bg-green">💵</div>
					<div class="stat-info">
						<h3>Inflows</h3>
						<p class="stat-value" id="stat-inflows">$0</p>
					</div>
				</div>
				<div class="widget stat">
					<div class="stat-icon bg-purple">✉️</div>
					<div class="stat-info">
						<h3>Messages</h3>
						<p class="stat-value" id="stat-messages">0</p>
					</div>
				</div>
			</section>

			<section class="grid-2">
				<div class="panel">
					<div class="panel-header">
						<h3>Calendar & Activities</h3>
						<div>
							<select id="calendar-range" class="input">
								<option value="month">This Month</option>
								<option value="week">This Week</option>
								<option value="day">Today</option>
							</select>
						</div>
					</div>
					<div id="calendar" class="calendar"></div>
				</div>
				<div class="panel">
					<div class="panel-header">
						<h3>Session Recorded</h3>
						<div>
							<button class="btn btn-ghost btn-sm" id="btn-refresh-chart">↻ Refresh</button>
						</div>
					</div>
					<canvas id="sessionsChart" height="130"></canvas>
					<div class="action-list">
						<button class="action-item">📝 New Announcement</button>
						<button class="action-item">💬 Send Message</button>
						<button class="action-item">📄 View Report</button>
						<button class="action-item">👥 Human Resource</button>
						<button class="action-item">✅ Admit Students</button>
					</div>
				</div>
			</section>

			<section class="panel">
				<div class="panel-header">
					<h3>Announcements</h3>
				</div>
				<div id="announcements" class="announcements"></div>
			</section>

			<footer class="footer">
				<p>© AstriaLearning Campus Management • <span id="year"></span></p>
			</footer>
		</main>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
	<script src="assets/js/app.js"></script>
</body>
</html>