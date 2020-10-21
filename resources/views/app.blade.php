<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teleprompt</title>
    <link rel="icon" id="emojicon" href="/favicon.ico" />
    <script>
        window.backendData = @json($backendData);
    </script>
</head>
<body>
    <div id="app"></div>
    <script src="{{ str_replace('0.0.0.0', env('DOCKER_MIX_HOT_RELOAD_IP'), mix('js/app.js')) }}"></script>
</body>
</html>
