<!-- welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartphone Online Repair</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-custom">

    <div class="flex flex-col items-center justify-center min-h-screen text-center">
        <h1 class="text-white text-4xl mb-4">Welcome to Smartphone Online Repair</h1>
        <p class="text-white mb-8">Your one-stop solution for smartphone repairs. We provide professional services with a commitment to quality.</p>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Login</a>
            <a href="{{ route('register') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Register</a>
        </div>
    </div>
    
</body>
</html>
