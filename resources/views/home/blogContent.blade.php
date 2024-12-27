<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        /* Fullscreen GIF Background */
        .gif-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('blogimage/sun.gif') }}');
            background-size : cover;
            background-position: center center;
            z-index: -1;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            position: relative;
        }

        .navbar {
            background: #105edd;
            padding: 10px;
            text-align: center;
        }

        .navbar a {
            color: #fefefe;
            text-decoration: none;
            padding: 10px;
            margin: 0 15px;
            border-radius: 5px;
            background: #c8472c;
        }

        .navbar a:hover {
            background: #f8de3c;
        }

        .post-content {
            background: rgba(255, 255, 255, 0.5);
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        /* Adjusted Image Flexibility */
        .post-content img {
            width: 100%;  
            height: auto;  
            max-height: 400px;  
            object-fit: contain;  
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .post-title {
            font-size: 32px;
            font-weight: bold;
            color: #412a1e;
            margin-bottom: 20px;
        }

        .post-body {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .like-button,
        .comment-button {
            background: #105edd;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .like-button:hover,
        .comment-button:hover {
            background: #f8de3c;
        }

        .comments-section {
            margin-top: 50px;
        }

        .comment {
            background: #fefefe;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comment-header {
            font-weight: bold;
            color: #412a1e;
        }

        .comment-body {
            color: #555;
        }

        .back-button {
            background: #f8de3c;
            color: #412a1e;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background: #c8472c;
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- GIF Background -->
    <div class="gif-background"></div>

    <div class="navbar">
        @auth
            <span class="text-white">Welcome, {{ Auth::user()->name }}</span>
        @else
            <a href="{{ route('login') }}">Login</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif
        @endauth
    </div>

    <div class="container mx-auto p-6">
        <!-- Post Content -->
        <div class="post-content">
            <img src="/blogimage/{{ $post->image }}" alt="{{ $post->title }}">
            <div class="post-title">{{ $post->title }}</div>
            <div class="post-body">{!!$post->content!!}</div>

            <div class="flex items-center">
                <span id="likeCount" class="text-lg font-semibold">{{ $post->likes->count() }}</span> Likes
                @auth
                    <button id="likeButton" data-post-id="{{ $post->id }}"
                        class="like-button ml-4">
                        {{ $post->likes->where('user_id', auth()->id())->count() ? 'Unlike' : 'Like' }}
                    </button>
                @endauth
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <h3 class="text-xl font-semibold mb-4">Comments</h3>

            <div id="comments" class="mb-4">
                @foreach ($post->comments as $comment)
                    <div class="comment">
                        <div class="comment-header">{{ $comment->user->name }}:</div>
                        <div class="comment-body">{{ $comment->content }}</div>
                    </div>
                @endforeach
            </div>

            @auth
                <form id="commentForm" class="mb-4">
                    <textarea id="commentContent" placeholder="Write a comment..." required
                        class="w-full p-2 border border-gray-300 rounded-md mb-4"></textarea>
                    <button type="submit" class="comment-button">Post Comment</button>
                </form>
            @else
                <p class="text-black-700">Please <a href="{{ route('login') }}" class="text-blue-500">log in</a> to post a comment.</p>
            @endauth
        </div>

        <!-- Go Back Button -->
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="back-button">Go Back</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Like script --}}
    <script>
        $(document).ready(function () {
            $('#likeButton').click(function () {
                const postId = $(this).data('post-id');
                const token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route("like") }}',
                    method: 'POST',
                    data: {
                        _token: token,
                        post_id: postId,
                    },
                    success: function (response) {
                        const likeButton = $('#likeButton');
                        const likeCount = $('#likeCount');

                        if (response.status === 'liked') {
                            likeButton.text('Unlike');
                            likeCount.text(parseInt(likeCount.text()) + 1);
                        } else if (response.status === 'unliked') {
                            likeButton.text('Like');
                            likeCount.text(parseInt(likeCount.text()) - 1);
                        }
                    },
                    error: function (xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

    {{-- Comment script --}}
    <script>
        $(document).ready(function() {
            $('#commentForm').submit(function(e) {
                e.preventDefault();

                const content = $('#commentContent').val();
                const postId = {{ $post->id }};
                const token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/add-comment',
                    method: 'POST',
                    data: {
                        _token: token,
                        post_id: postId,
                        content: content
                    },
                    success: function(response) {
                        $('#comments').append(`
                            <div class="comment">
                                <div class="comment-header">You:</div>
                                <div class="comment-body">${content}</div>
                            </div>
                        `);
                        $('#commentContent').val('');
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

</body>

</html>
