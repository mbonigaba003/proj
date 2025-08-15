(function(){
	const $ = (sel, root=document) => root.querySelector(sel);
	const $$ = (sel, root=document) => Array.from(root.querySelectorAll(sel));

	const state = {
		data: null,
		chart: null,
		theme: 'light'
	};

	function setYear(){ $('#year').textContent = new Date().getFullYear(); }

	async function fetchData(){
		const res = await fetch('api/dashboard.php');
		if(!res.ok) throw new Error('Failed to fetch');
		return res.json();
	}

	function formatNumber(num){
		return Intl.NumberFormat().format(num);
	}

	function renderStats(stats){
		$('#stat-students').textContent = formatNumber(stats.students);
		$('#stat-employees').textContent = formatNumber(stats.employees);
		$('#stat-inflows').textContent = `$ ${formatNumber(stats.inflows)}`;
		$('#stat-messages').textContent = formatNumber(stats.messages);
		$('#badge-messages').textContent = formatNumber(stats.messages);
	}

	function showBanner(message){
		const banner = $('#system-banner');
		if(message){
			$('#banner-text').textContent = message;
			banner.hidden = false;
		}else {
			banner.hidden = true;
		}
	}

	function renderAnnouncements(list){
		const container = $('#announcements');
		container.innerHTML = '';
		list.forEach(a => {
			const el = document.createElement('div');
			el.className = 'announcement';
			el.innerHTML = `
				<div class="avatar">${a.author[0] ?? 'A'}</div>
				<div>
					<h4>${a.title}</h4>
					<p class="meta">${a.author} • ${new Date(a.createdAt).toLocaleString()}</p>
					<p>${a.content}</p>
				</div>
			`;
			container.appendChild(el);
		});
	}

	function renderChart(timeseries){
		const ctx = $('#sessionsChart');
		if(state.chart){ state.chart.destroy(); }
		state.chart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: timeseries.labels,
				datasets: timeseries.datasets.map(d => ({
					label: d.label,
					data: d.data,
					backgroundColor: d.backgroundColor,
					borderColor: d.borderColor,
					borderRadius: 8,
				}))
			},
			options: {
				plugins: { legend: { position: 'bottom' } },
				scales: {
					x: { grid: { display: false } },
					y: { grid: { color: 'rgba(148,163,184,.2)' }, ticks: { precision: 0 } }
				}
			}
		});
	}

	function buildCalendarGrid(date){
		const start = new Date(date.getFullYear(), date.getMonth(), 1);
		const end = new Date(date.getFullYear(), date.getMonth()+1, 0);
		const grid = document.createElement('div');
		grid.className = 'grid';
		const weekdays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
		// Headers
		weekdays.forEach(w => {
			const h = document.createElement('div');
			h.style.color = 'var(--muted)';
			h.style.fontSize = '12px';
			h.style.textAlign = 'center';
			h.style.padding = '4px 0';
			h.textContent = w;
			grid.appendChild(h);
		});
		// Calculate empty cells before first day
		const blanks = start.getDay();
		for(let i=0; i<blanks; i++){
			const cell = document.createElement('div');
			grid.appendChild(cell);
		}
		// Days
		for(let d=1; d<=end.getDate(); d++){
			const day = document.createElement('div');
			day.className = 'day';
			const num = document.createElement('div');
			num.className = 'd';
			num.textContent = String(d);
			day.appendChild(num);
			grid.appendChild(day);
		}
		return grid;
	}

	function renderCalendar(events){
		const cal = $('#calendar');
		cal.innerHTML = '';
		const now = new Date();
		const grid = buildCalendarGrid(now);
		cal.appendChild(grid);
		// Place events
		const start = new Date(now.getFullYear(), now.getMonth(), 1);
		const end = new Date(now.getFullYear(), now.getMonth()+1, 0);
		const cells = $$('.day', grid);
		const addEvent = (date, event) => {
			const idx = date.getDate()-1; // 0-based
			const cell = cells[idx];
			if(!cell) return;
			const tag = document.createElement('div');
			tag.className = 'event';
			tag.style.borderLeftColor = event.color || 'var(--primary)';
			tag.style.background = 'transparent';
			tag.textContent = event.title;
			cell.appendChild(tag);
		};
		events.forEach(e => {
			const s = new Date(e.start);
			if(s < start || s > end) return;
			addEvent(s, e);
		});
		// Legend
		const legend = document.createElement('div');
		legend.className = 'legend';
		legend.innerHTML = `
			<span><span class="dot" style="background:${events[0]?.color || 'var(--primary)'}"></span> Events</span>
		`;
		cal.appendChild(legend);
	}

	function setupThemeToggle(){
		const stored = localStorage.getItem('theme');
		if(stored){ state.theme = stored; }
		document.querySelector('.app-shell').setAttribute('data-theme', state.theme);
		$('#toggle-theme').addEventListener('click', () => {
			state.theme = state.theme === 'light' ? 'dark' : 'light';
			document.querySelector('.app-shell').setAttribute('data-theme', state.theme);
			localStorage.setItem('theme', state.theme);
		});
	}

	function setupSearch(){
		$('#global-search').addEventListener('input', (e) => {
			const q = e.target.value.toLowerCase();
			$$('.nav-item').forEach(item => {
				const text = item.textContent.toLowerCase();
				item.style.opacity = q && !text.includes(q) ? .4 : 1;
			});
		});
	}

	function setupActions(){
		$('#btn-refresh-chart').addEventListener('click', () => {
			if(!state.data) return;
			const ds = structuredClone(state.data.timeseries);
			// add small random noise for refresh effect
			ds.datasets.forEach(d => { d.data = d.data.map(v => Math.max(0, v + Math.round((Math.random()-.5)*6))); });
			renderChart(ds);
		});
	}

	async function init(){
		setYear();
		setupThemeToggle();
		setupSearch();
		setupActions();
		try {
			const data = await fetchData();
			state.data = data;
			renderStats(data.stats);
			renderChart(data.timeseries);
			renderCalendar(data.events);
			renderAnnouncements(data.announcements);
			showBanner(data.bannerMessage || 'They Payment Systems are currently undergoing maintenance, please try again within 2 hrs!');
		} catch (e) {
			console.error(e);
			showBanner('Unable to load dashboard data. Please try again later.');
		}
	}

	document.addEventListener('DOMContentLoaded', init);
})();