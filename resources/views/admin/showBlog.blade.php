<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .gif-background {
            position: fixed; 
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('blogimage/seas.gif') }}'); 
            background-size: cover;
            background-position: center center;
            z-index: -1; 
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="gif-background"></div>

    <div class="container mx-auto p-6 mt-0">
        @if(session()->has('message'))
            <div class="alert alert-primary bg-green-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">All Blogs</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ url('addBlog') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Add Blog
                </a>
                <a href="{{ route('logout') }}" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Blog Title</th>
                    <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Blog Content</th>
                    <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Blog Image</th>
                    <th class="py-3 px-6 text-center text-sm font-medium text-gray-700">Edit</th>
                    <th class="py-3 px-6 text-center text-sm font-medium text-gray-700">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($post as $post)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-3 px-6 text-sm text-gray-800">{{ $post->title }}</td>
                        <td class="py-3 px-6 text-sm text-gray-600">{!!$post->content!!}</td>

                        <td class="py-3 px-6 text-center">
                            <img src="blogimage/{{ $post->image }}" alt="Blog Image" class="w-24 h-24 object-cover rounded-md">
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ url('editBlog', $post->id) }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                                Edit
                            </a>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ url('deleteBlog', $post->id) }}" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600"
                               onclick="return confirm('Delete Confirmation')">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
