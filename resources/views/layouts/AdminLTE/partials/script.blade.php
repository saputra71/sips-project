<!-- Theme style -->
<link rel="stylesheet" href="{{asset('AdminLTE/dist')}}/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{asset('AdminLTE/plugins')}}/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{asset('AdminLTE/plugins')}}/daterangepicker/daterangepicker.css">
<!-- tambahan style -->
<link href="{{ url('/admin/css/styles.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="{{asset('AdminLTE/plugins')}}/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('AdminLTE/plugins')}}/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- overlayScrollbars -->
<script src="{{asset('AdminLTE/plugins')}}/overlayScrollbars/js/jquery.overlayScrollbars.min.js" defer></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE/dist')}}/js/adminlte.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/super-build/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" defer></script>
<!-- tambahan script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous" defer></script>