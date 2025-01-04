<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
</head>
<body>
    <h2>Staff Dashboard</h2>
    
    <!-- Button to navigate to create meeting page -->
    <a href="{{ route('create.meeting') }}" id="startVideoCallButton" class="bg-blue-500 text-white py-2 px-4 rounded mt-4">
        Start Video Call
    </a>

    <!-- Button to log out and navigate to login page -->
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">
            Log Out
        </button>
    </form>
</body>
</html>
