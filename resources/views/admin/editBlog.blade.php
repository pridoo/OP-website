<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <script src="https://cdn.tiny.cloud/1/q7twhsl784171tep9xogmizsx5ag5aet2xoosq6x8s8u3d5e/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>


    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
        tinymce.init({
        selector: '#content',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 400,
        forced_root_block: false,  // Prevents automatic <p> tags
        cleanup: true,
        cleanup_on_startup: true,
        valid_elements: 'strong,em,span[style],a[href],p,br,ul,ol,li',  // Restricts allowed HTML elements
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });


        // Add this script to handle form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            // Make sure TinyMCE updates the textarea before form submission
            tinymce.triggerSave();
        });
    </script>

    <style>
        body {
            background: url('/blogimage/background.gif') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Pirata One', cursive;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.5); 
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 50px auto;
        }

        .form-container h1 {
            font-size: 2rem;
            color: #dc2626;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #1e293b;
        }

        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
        }

        .form-container img {
            display: block;
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 2px solid #d1d5db;
        }

        .form-container .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .form-container .btn {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: bold;
            margin: 0 5px;
        }

        .form-container .btn-primary {
            background-color: #38bdf8;
            color: white;
            transition: background-color 0.3s ease;
        }

        .form-container .btn-primary:hover {
            background-color: #0284c7;
        }

        .form-container .btn-danger {
            background-color: #ef4444;
            color: white;
            transition: background-color 0.3s ease;
        }

        .form-container .btn-danger:hover {
            background-color: green;
        }
    </style>
</head>

<body>
    <div>
        @if(session()->has('message'))
            <div class="alert alert-success text-center p-4 bg-green-100 border-l-4 border-green-500 text-green-700 mb-6">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="form-container">
            <h1>Update Blog</h1>
            <form action="{{ url('updateBLog', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="title">Blog Title</label>
                    <input type="text" id="title" name="title" value="{{ $post->title }}" required>
                </div>

                <div>
                    <label for="content">Blog Content</label>
                    <textarea id="content" name="content" rows="5" required>{!! $post->content !!}</textarea>
                </div>

                <div>
                    <label>Old Image</label>
                    <img src="/blogimage/{{ $post->image }}" alt="Current Blog Image">
                </div>

                <div>
                    <label for="image">Update Blog Image</label>
                    <input type="file" id="image" name="image">
                </div>

                <div class="btn-group">
                    <input type="submit" value="Update" class="btn btn-primary">
                    <a href="{{ url()->previous() }}" class="btn btn-danger text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
