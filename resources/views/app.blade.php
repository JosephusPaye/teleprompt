<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <title>Teleprompt</title>
    <meta
        name="description"
        content="A fast and simple teleprompter you can control with a presentation remote."
    />
    <meta
        name="og:description"
        content="A fast and simple teleprompter you can control with a presentation remote."
    />
    <meta name="og:url" content="https://teleprompt.webpluslabs.com/" />
    <meta name="og:title" content="Teleprompt" />
    <link
        id="emojicon"
        rel="shortcut icon"
        href="/favicon.ico"
    />
    <link
        rel="apple-touch-icon"
        sizes="194x194"
        href="/apple-touch-icon.png"
        type="image/png"
    />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <script>
        window.backendData = @json($backendData);
    </script>
</head>
<body>
    <div id="app"></div>
    <script src="{{ str_replace('0.0.0.0', env('DOCKER_MIX_HOT_RELOAD_IP'), mix('js/app.js')) }}"></script>
</body>
</html>
