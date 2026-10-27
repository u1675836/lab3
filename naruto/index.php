<?php
declare(strict_types=1);

$characters = [
	['Naruto Uzumaki', 'Uzumaki Clan', 'Seventh Hokage'],
	['Sasuke Uchiha', 'Uchiha Clan', 'Shadow Hokage'],
	['Sakura Haruno', 'Medical Ninja', 'Medical-nin'],
	['Kakashi Hatake', 'Hatake Clan', 'Sixth Hokage'],
	['Hinata Hyuga', 'Hyuga Clan', 'Byakugan user'],
	['Shikamaru Nara', 'Nara Clan', 'Strategist'],
	['Choji Akimichi', 'Akimichi Clan', 'Expansion jutsu user'],
	['Ino Yamanaka', 'Yamanaka Clan', 'Sensor ninja'],
	['Rock Lee', 'Team Guy', 'Taijutsu specialist'],
	['Neji Hyuga', 'Hyuga Clan', 'Jounin'],
	['Might Guy', 'Team Guy', 'Taijutsu master'],
	['Gaara', 'Village Hidden in the Sand', 'Fifth Kazekage'],
	['Temari', 'Village Hidden in the Sand', 'Wind-style user'],
	['Kankuro', 'Village Hidden in the Sand', 'Puppet master'],
	['Jiraiya', 'Legendary Sannin', 'Toad sage'],
	['Tsunade', 'Legendary Sannin', 'Fifth Hokage'],
	['Orochimaru', 'Legendary Sannin', 'Ninja researcher'],
	['Itachi Uchiha', 'Uchiha Clan', 'Akatsuki member'],
	['Might Duy', 'Hidden Leaf Village', 'Eternal genin'],
	['Minato Namikaze', 'Namikaze Clan', 'Fourth Hokage'],
];

try {
	$pdo = new PDO('sqlite:' . __DIR__ . '/naruto.sqlite');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec(
		'CREATE TABLE IF NOT EXISTS characters (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			name TEXT NOT NULL UNIQUE,
			clan TEXT NOT NULL,
			specialty TEXT NOT NULL
		)'
	);
	$statement = $pdo->prepare(
		'INSERT OR IGNORE INTO characters (name, clan, specialty) VALUES (:name, :clan, :specialty)'
	);
	foreach ($characters as [$name, $clan, $specialty]) {
		$statement->execute compact('name', 'clan', 'specialty');
	}
	$databaseMessage = 'The character database is ready.';
} catch (PDOException $exception) {
	$databaseMessage = 'The character database is currently unavailable.';
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Naruto World</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body { background: linear-gradient(135deg, #fff3cd, #f8d7da); min-height: 100vh; }
		.hero { background: rgba(255,255,255,.9); border-radius: 1.5rem; }
	</style>
</head>
<body>
	<nav class="navbar navbar-dark bg-dark shadow-sm">
		<div class="container"><span class="navbar-brand fw-bold">🍥 Naruto World</span></div>
	</nav>
	<main class="container py-5">
		<section class="hero shadow p-4 p-md-5 text-center">
			<span class="badge text-bg-danger mb-3">Believe it!</span>
			<h1 class="display-4 fw-bold">Welcome to Naruto World</h1>
			<p class="lead text-secondary mx-auto" style="max-width: 700px;">
				Explore the shinobi, clans, and legends who shaped the world of Naruto.
			</p>
			<a class="btn btn-danger btn-lg px-4" href="characters.php">View Characters</a>
			<p class="small text-success mt-4 mb-0"><?= htmlspecialchars($databaseMessage, ENT_QUOTES, 'UTF-8') ?></p>
		</section>
	</main>
</body>
</html>
