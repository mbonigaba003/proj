<?php
declare(strict_types=1);

// Error reporting for development; adjust as needed for production
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Resolve base path and URL
$APP_ROOT = dirname(__DIR__);
$PUBLIC_PATH = $APP_ROOT . '/public';

// Detect base URL dynamically
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$baseDir = rtrim(str_replace('index.php', '', $scriptName), '/');
$BASE_URL = $scheme . '://' . $host . $baseDir;

// Simple helper to respond with JSON
function json_response(array $data, int $statusCode = 200): void {
	header('Content-Type: application/json; charset=utf-8');
	http_response_code($statusCode);
	echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	exit;
}

// Allow CORS for API endpoints during development
if (str_contains($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type, Authorization');
	if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
		exit;
	}
}

// Basic in-memory data source for demo
function get_demo_data(): array {
	return [
		'stats' => [
			'students' => 15300,
			'employees' => 1300,
			'inflows' => 2300,
			'messages' => 12300,
		],
		'announcements' => [
			[
				'id' => 1,
				'title' => 'Payment Systems Maintenance',
				'content' => 'Payment systems are undergoing maintenance. Expected resolution within 2 hours.',
				'author' => 'ICT Department',
				'createdAt' => date('c', strtotime('-1 hour')),
			],
			[
				'id' => 2,
				'title' => 'Midterm Exams Schedule',
				'content' => 'Midterm exams start next Monday. Check your timetable portal.',
				'author' => 'Academics Office',
				'createdAt' => date('c', strtotime('-1 day')),
			],
		],
		'events' => [
			[
				'id' => 'evt-1',
				'title' => 'Faculty Meeting',
				'color' => '#4f46e5',
				'start' => date('Y-m-d', strtotime('next tuesday')) . 'T10:00:00',
				'end' => date('Y-m-d', strtotime('next tuesday')) . 'T11:00:00',
			],
			[
				'id' => 'evt-2',
				'title' => 'Sports Day',
				'color' => '#059669',
				'start' => date('Y-m-d', strtotime('+10 days')),
				'end' => date('Y-m-d', strtotime('+10 days')),
				'allDay' => true,
			],
			[
				'id' => 'evt-3',
				'title' => 'Admissions Deadline',
				'color' => '#dc2626',
				'start' => date('Y-m-d', strtotime('+14 days')),
				'end' => date('Y-m-d', strtotime('+14 days')),
				'allDay' => true,
			],
		],
		'timeseries' => [
			'labels' => ['30/01', '30/10', '2/02', '2/12'],
			'datasets' => [
				[
					'label' => 'Sessions',
					'backgroundColor' => '#06b6d4',
					'borderColor' => '#06b6d4',
					'data' => [28, 45, 32, 54],
				],
				[
					'label' => 'Active Users',
					'backgroundColor' => '#8b5cf6',
					'borderColor' => '#8b5cf6',
					'data' => [22, 40, 18, 30],
				],
			],
		],
	];
}