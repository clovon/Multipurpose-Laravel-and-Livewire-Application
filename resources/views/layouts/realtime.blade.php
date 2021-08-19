<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Live Count</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <livewire:styles />
</head>
​

<body>
    {{ $slot }}
    <livewire:scripts />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @stack('js')
</body>

</html>
