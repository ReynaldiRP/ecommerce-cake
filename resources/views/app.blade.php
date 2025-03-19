<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script type="module" src="{{ asset('build/assets/app-DbPSS4nj.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('build/assets/app-CXm2PakZ.css') }}">
    @routes
    @inertiaHead
</head>

<body>
    @inertia
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
    <script>
        window.baseUrl = "{{ config('app.url') }}";
    </script>
</body>

</html>
