<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-1h6G3D..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="antialiased bg-gray-100 text-gray-900">

<x-header />
<x-hero />
<x-product />
<x-about />
<x-contact />
<x-footer />

</body>
</html>
