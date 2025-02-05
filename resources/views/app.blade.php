<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>{{ config('app.name') }}</title>
    <script>
        window.APP_NAME = "{{ config('app.name') }}";
    </script>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
</head>
<body class="text-gray-300">
    <div id="app" class="bg-theme-lightBackground dark:bg-theme-darkBackground"></div>
</body>
</html>
