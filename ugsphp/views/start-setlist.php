<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Starting Setlist - <?php echo($model->PageTitle); ?></title>
	<style>
		body {
			font-family: Arial, sans-serif;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
			background: #f5f5f5;
		}
		.loading-container {
			text-align: center;
			padding: 40px;
			background: white;
			border-radius: 8px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		}
		.spinner {
			width: 40px;
			height: 40px;
			border: 4px solid #f3f3f3;
			border-top: 4px solid #007cba;
			border-radius: 50%;
			animation: spin 1s linear infinite;
			margin: 0 auto 20px;
		}
		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
	</style>
</head>
<body>
	<div class="loading-container">
		<div class="spinner"></div>
		<h2>Starting Setlist...</h2>
		<p>Redirecting to the first song...</p>
	</div>
</body>
</html> 