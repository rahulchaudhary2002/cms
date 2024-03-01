<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CMS') }} | @yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/cms.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    @yield('page-specific-style')
</head>

<body>
    @include('includes.sidebar')
    @include('includes.navbar')
    <div class="content">
        @yield('breadcrumb')
        @yield('content')
    </div>
    @yield('modal')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    
    <script src="{{ asset('assets/plugins/ckeditor/js/ckeditor.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('[data-init-plugin=select2]').select2();
            $('#calendar').fullCalendar();
            initCKEditor();
        });

        function initCKEditor() {
            document.querySelectorAll('[data-init-plugin=ckeditor]').forEach(element => {
                ClassicEditor
                    .create(element, {
                        ckfinder: {
                            uploadUrl: "{{ route('ck-file-upload').'?_token='.csrf_token() }}"
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        }
    </script>
    @yield('page-specific-script')
</body>

</html>