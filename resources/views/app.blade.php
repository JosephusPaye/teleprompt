<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teleprompt</title>
    <link rel="stylesheet" href="{{ str_replace('0.0.0.0', 'localhost', mix('css/app.css')) }}">
    <script>
        window.telepromptData = @json($vue_data);
    </script>
</head>
<body>
    <div id="app"></div>
    <script src="{{ str_replace('0.0.0.0', 'localhost', mix('js/app.js')) }}"></script>
</body>
</html>
