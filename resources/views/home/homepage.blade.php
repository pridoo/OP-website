<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>One Piece Blog</title>

    <!-- One Piece Inspired Font -->
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Pirata One', sans-serif;
        margin: 0;
        padding: 0;
        overflow: auto; /* Allow scrolling */
        position: relative;
    }

    /* Fullscreen GIF Background */
    .gif-background {
        position: fixed; 
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('blogimage/background.gif') }}'); 
        background-size: cover;
        background-position: center center;
        z-index: -1; /* Behind content */
    }

    .header {
        background: #add8e6; 
        opacity: 50%;
        color: black;
        padding: 10px 20px;
        text-align: left;
        font-size: 36px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header .login-register {
        display: flex;
        gap: 20px;
    }

    .navbar a {
        color: #add8e6;
        text-decoration: none;
        padding: 10px;
        margin: 0 15px;
        border-radius: 5px;
        background: #add8e6;
    }

    .navbar a:hover {
        background: #add8e6;
    }

    .search-container {
        text-align: center;
        padding: 30px;
        margin-top: 60px;
    }

    .search-container input,
    .search-container select {
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        margin-right: 10px;
        border: 2px solid #58acf4;
    }

    .search-container button {
        padding: 10px;
        background: #c8472c;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .search-container button:hover {
        background: #f8de3c;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        padding: 20px;
        position: relative;
        z-index: 1; /* Ensures content stays above background */
    }

    .post-card {
        background: #412a1e;
        border-radius: 15px;
        padding: 15px;
        width: 250px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .post-card img {
        width: 100%;
        border-radius: 10px;
    }

    .post-card h4 {
        font-size: 20px;
        margin: 10px 0;
        color: #f8de3c;
    }

    .post-card .btn-main {
        background: #58acf4;
        color: white;
        padding: 10px;
        border-radius: 5px;
        text-decoration: none;
    }

    .post-card .btn-main:hover {
        background: #105edd;
    }

    .social-share {
        margin-top: 10px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .social-share a {
        color: white;
        font-size: 18px;
        text-decoration: none;
    }
</style>

</head>

<body>
    <!-- GIF Background -->
    <div class="gif-background"></div>

    <div class="header">
        <span>One Piece Blog</span>
        <div class="login-register">
            @auth
                <span>Welcome, {{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    </div>

    <div class="search-container">
        <input type="text" id="search" placeholder="Search blog posts..." class="border p-2 rounded">
        <select id="filter">
            <option value="">Sort by</option>
            <option value="a-z">Title: A-Z</option>
            <option value="z-a">Title: Z-A</option>
            <option value="most-liked">Most Liked</option>
        </select>
        <button>Search</button>
    </div>

    <div class="container">
        @foreach ($post as $post)
        <div class="post-card">
            <img src="/blogimage/{{ $post->image }}" alt="{{ $post->title }}">
            <h4>{{ $post->title }}</h4>
            <div class="btn-main"><a href="{{ url('blogContent', $post->id) }}">Read More</a></div>
            
            <div class="social-share">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">ShareOnFacebook</a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank">ShareOnTwitter</a>
            </div>
        </div>
        @endforeach
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchBlogs(search = '', sort = '') {
                $.ajax({
                    url: "{{ route('search') }}", 
                    type: "GET",
                    data: {
                        search: search,
                        sort: sort
                    },
                    success: function(data) {
                        let results = $('.container');
                        results.empty();
                        if (data.length === 0) {
                            results.append('<p>No results found</p>');
                        } else {
                            data.forEach(post => {
                                results.append(`
                                    <div class="post-card">
                                        <img src="/blogimage/${post.image}" alt="${post.title}">
                                        <h4>${post.title}</h4>
                                        <div class="btn-main">
                                            <a href="/blogContent/${post.id}">Read More</a>
                                        </div>
                                    </div>
                                `);
                            });
                        }
                    },
                    error: function() {
                        console.log('Error retrieving data.');
                    }
                });
            }

            $('#search').on('keyup', function() {
                let search = $(this).val();
                let sort = $('#filter').val();
                fetchBlogs(search, sort);
            });

            $('#filter').on('change', function() {
                let sort = $(this).val();
                let search = $('#search').val();
                fetchBlogs(search, sort);
            });
        });
    </script>
</body>

</html>
