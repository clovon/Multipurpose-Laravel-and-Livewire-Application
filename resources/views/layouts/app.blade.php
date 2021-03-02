<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminLTE 3 | Starter</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <livewire:styles />
</head>
<body class="hold-transition sidebar-mini">
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

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript" src="https://unpkg.com/moment"></script>
<script type="text/javascript" src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script>
  $(document).ready(function() {
    toastr.options = {
      "positionClass": "toast-bottom-right",
      "progressBar": true,
    }

    window.addEventListener('hide-form', event => {
      $('#form').modal('hide');
      toastr.success(event.detail.message, 'Success!');
    })
  });
</script>

<script>
  window.addEventListener('show-form', event => {
    $('#form').modal('show');
  })

  window.addEventListener('show-delete-modal', event => {
    $('#confirmationModal').modal('show');
  })

  window.addEventListener('hide-delete-modal', event => {
    $('#confirmationModal').modal('hide');
    toastr.success(event.detail.message, 'Success!');
  })
  
</script>

<script>
  $(document).ready(function() {
    $('#appointmentDate').datetimepicker({
      format: 'L',
    });

    $('#appointmentDate').on("change.datetimepicker", function (e) {
      let date = $(this).data('appointmentdate');
      eval(date).set('state.date', $('#appointmentDateInput').val());
    });

    $('#appointmentTime').datetimepicker({
      format: 'LT',
    });

    $('#appointmentTime').on("change.datetimepicker", function (e) {
      let time = $(this).data('appointmenttime');
      eval(time).set('state.time', $('#appointmentTimeInput').val());
    });
  });
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
            .create( document.querySelector( '#note' ) )
            .then( editor => {
                    // editor.model.document.on('change:data', () => {
                    //   let note = $('#note').data('note');
                    //   eval(note).set('state.note', editor.getData());
                    // });
                    document.querySelector('#submit').addEventListener('click', () => {
                      let note = $('#note').data('note');
                      eval(note).set('state.note', editor.getData());
                    });
            } )
            .catch( error => {
                    console.error( error );
            } );
</script>
<livewire:scripts />
</body>
</html>
