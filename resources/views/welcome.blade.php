<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Piece Adventure</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pirata+One&display=swap');

        .pirate-font {
            font-family: 'Pirata One', cursive;
        }

        .map-bg {
            background-image: url('blogimage/k.gif'); 
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-blue-50 text-black">
    <!-- Hero Section -->
    <header class="map-bg h-screen flex items-center justify-center text-center">
        <div>
            <h1 class="text-5xl pirate-font">MEET THE STRAW HAT CREW!!!!</h1>
            <p class="mt-4 text-lg">"One Piece wa jitsuzai suru!"</p>
            <a href="{{ url('/home') }}" class="mt-6 inline-block bg-yellow-400 text-black font-bold py-2 px-6 rounded-lg hover:bg-yellow-500">Discover More</a>
        </div>
    </header>


</body>

</html>
