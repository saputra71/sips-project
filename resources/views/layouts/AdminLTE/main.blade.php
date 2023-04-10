<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title') | SIPS
    </title>

    <link rel="icon" type="image/x-icon" href="{{asset('AdminLTE/dist')}}/img/kewzlogo_black.png" />

    @include('layouts.AdminLTE.partials.script')
</head>

<body class="hold-transition sidebar-mini layout-fixed" oncontextmenu="return false">

    <!-- ckeditor -->
    <style>
        #container {
            width: 1000px;
            margin: 20px auto;
        }

        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
        }

        .ck-content .image {
            /* block images */
            max-width: 80%;
            margin: 20px auto;

            .btn {
                position: relative;
                display: inline-block;
            }

            .btn:hover:after {
                content: attr(data-nama);
                display: block;
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translate(-50%, 10px);
                background-color: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 5px 10px;
                border-radius: 5px;
                font-size: 12px;
                white-space: nowrap;
            }

            /* on hover delete*/
            .delete:hover:after {
                content: "delete";
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                font-size: 10px;
                background-color: rgba(0, 0, 0, 0.8);
                color: #fff;
                padding: 2px 4px;
            }

            /* on hover edit */
            .edit:hover:after {
                content: "edit";
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                font-size: 10px;
                background-color: rgba(0, 0, 0, 0.8);
                color: #fff;
                padding: 2px 4px;
            }

            /* on hover disposisi */
            .disposisi:hover:after {
                content: "disposisi";
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                font-size: 10px;
                background-color: rgba(0, 0, 0, 0.8);
                color: #fff;
                padding: 2px 4px;
            }

            /* on hover view surat keluar */
            .view:hover:after {
                content: "view";
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                font-size: 10px;
                background-color: rgba(0, 0, 0, 0.8);
                color: #fff;
                padding: 2px 4px;
            }
    </style>

    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{asset('AdminLTE/dist')}}/img/kewzlogo_black.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('layouts.AdminLTE.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar" style="background-color: whitesmoke;">
            <div class="mt-3"></div>
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link d-flex justify-content-center">
                <img src="{{asset('AdminLTE/dist')}}/img/kewzlogo_black.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light mt-2"><b style="color: black; font: 17pt 'Times New Roman';"> SIPS </b></span>
            </a>
            <hr class="mt-1">
            <div class="mt-3"></div>
            <div class="card mx-4">
                <form method="POST" action="{{ route('dashboard.notifications.index') }}" x-data>
                    @csrf
                    @method('GET')

                    <button type="submit" class="">
                        <i class="fas fa-bell mx-3"></i>
                        Notifikasi
                    </button>

                </form>
            </div>
            <div class="card mx-4">
                <form method="POST" action="http://localhost/kewntodz/public/backup" x-data>
                    @csrf
                    @method('GET')

                    <button type="submit" class="">
                        <i class="fas fa-save mx-3"></i>
                        Backup Data
                    </button>

                </form>
            </div>
            <div class="card mx-4">
                <form method="POST" action="{{ route('profile.show') }}" x-data>
                    @csrf
                    @method('GET')

                    <button type="submit" class="">
                        <i class="fa-solid fa-user mx-3"></i>
                        Profile
                    </button>

                </form>
            </div>
            @can ('view-logs')
            <div class="card mx-4">
                <form method="GET" action="{{ route('dashboard.activity-logs.index') }}" x-data>
                    <button type="submit" class="">
                        <i class="fa-solid fa-clock mx-3"></i>
                        Log Activity
                    </button>
                </form>
            </div>
            @endcan
            <div class="card mx-4">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <button type="submit" class="">
                        <i class="fas fa-sign-out-alt mx-3"></i>
                        Logout
                    </button>

                </form>
            </div>
            <hr class="mt-1">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <!-- <img src="{{ Auth::user()->profile_photo_url }}" class="img-circle elevation-2" alt="User Image"> -->
                <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">

                        @if (Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="img-circle elevation-2" alt="User Image">
                        @else
                        <img src="{{ Auth::user()->profile_photo_url }}" class="img-circle elevation-2" alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div> -->

                <!-- Sidebar -->

                <!-- Sidebar Menu -->
                @include('layouts.AdminLTE.partials.sidebar')
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->
            @include('layouts.AdminLTE.partials.header')

            <!-- Main content -->
            <section class="content">
                <x-guest-layout>
                    @yield('content')
                </x-guest-layout>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer" style="background-color: whitesmoke;">
            <strong>all right reserved &copy; Copyright 2022, SISP, SMKN 11 Bandung</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Software Engineer</b>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script>
        // This sample still does not showcase all CKEditor 5 features (!)
        // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
        CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
            entities: false,
            // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
            toolbar: {
                items: [
                    'exportPDF', 'exportWord', '|',
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            // Changing the language of the interface requires loading the language file using the <script> tag.
            // language: 'es',
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
            heading: {
                options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
            placeholder: 'Silahkan isi narasi surat disini',
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
            // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
            htmlSupport: {
                allow: [{
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }]
            },
            // Be careful with enabling previews
            // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
            htmlEmbed: {
                showPreviews: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
            mention: {
                feeds: [{
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }]
            },
            // The "super-build" contains more premium features that require additional configuration, disable them below.
            // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
            removePlugins: [
                // These two are commercial, but you can try them out without registering to a trial.
                // 'ExportPdf',
                // 'ExportWord',
                'CKBox',
                'CKFinder',
                'EasyImage',
                // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                // Storing images as Base64 is usually a very bad idea.
                // Replace it on production website with other solutions:
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                // 'Base64UploadAdapter',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType
                'MathType'
            ]
        });
    </script>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#maintable').DataTable();
        });

        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });
    </script>


</body>

</html>