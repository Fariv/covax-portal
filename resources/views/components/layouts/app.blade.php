<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name') ?? 'Page Title' }}</title>
        <style>
            span.error {
                color: red;
            }
        </style>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
