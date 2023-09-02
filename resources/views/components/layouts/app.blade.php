<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/svg+xml" href="/icon.svg" />
    <title>{{ setting('site_title') }} | {{ setting('site_name') }}</title>

    <link rel="stylesheet" href="/css/app.css">
    @stack('styles')
    <livewire:styles />
</head>

<body class="hold-transition sidebar-mini {{ setting('sidebar_collapse') ? 'sidebar-collapse' : '' }}">
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.partials.aside')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{ $slot }}
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('layouts.partials.footer')
    </div>
    <!-- ./wrapper -->
    <script src="/js/app.js"></script>
    <script src="/js/backend.js"></script>
    @stack('js')
    @stack('before-livewire-scripts')
    <livewire:scripts />
    @stack('after-livewire-scripts')

    @stack('alpine-plugins')
    <!-- Alpine Core -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
