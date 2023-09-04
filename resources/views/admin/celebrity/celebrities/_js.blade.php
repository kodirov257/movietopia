@if (!config('adminlte.enabled_laravel_mix'))
    @php($javaScriptSectionName = 'js')
@else
    @php($javaScriptSectionName = 'mix_adminlte_js')
@endif

@section($javaScriptSectionName)
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/piexif.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/purify.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/themes/fa/theme.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/locales/uz.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/locales/ru.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/locales/LANG.js') }}"></script>

    <script>
        let avatarInput = $("#photo-input");
        let avatarUrl = '{{ $celebrity ? ($celebrity->photo ? $celebrity->photoOriginal : null ): null }}';

        let send = XMLHttpRequest.prototype.send, token = $('meta[name="csrf-token"]').attr('content');
        XMLHttpRequest.prototype.send = function(data) {
            this.setRequestHeader('X-CSRF-Token', token);
            return send.apply(this, arguments);
        };

        if (avatarUrl) {
            avatarInput.fileinput({
                initialPreview: [avatarUrl],
                initialPreviewAsData: true,
                showUpload: false,
                previewFileType: 'text',
                browseOnZoneClick: true,
                overwriteInitial: true,
                deleteUrl: 'remove-photo',
                maxFileCount: 1,
                allowedFileExtensions: ['jpg', 'jpeg', 'png'],
            });
        } else {
            avatarInput.fileinput({
                showUpload: false,
                previewFileType: 'text',
                browseOnZoneClick: true,
                maxFileCount: 1,
                allowedFileExtensions: ['jpg', 'jpeg', 'png'],
            });
        }

        $('#live_place').select2({
            ajax: {
                url: '/api/search-regions',
                method: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        page: params.page || 1,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.data.regions,
                        pagination: {
                            more: (params.page * 10) < data.data.total,
                        },
                    };
                },
                delay: 250,
            },
            placeholder: '{{ __('adminlte.celebrity.live_place') }}',
            minimumInputLength: 2,
            allowClear: true,
            templateResult: function (region) {
                if (region.loading) {
                    return region.text;
                }

                return region.name || region.text;
            },
            templateSelection: function (region) {
                return region.name || region.text;
            },
        });

        $('#birth_place').select2({
            ajax: {
                url: '/api/search-regions',
                method: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        page: params.page || 1,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.data.regions,
                        pagination: {
                            more: (params.page * 10) < data.data.total,
                        },
                    };
                },
                delay: 250,
            },
            placeholder: '{{ __('adminlte.celebrity.birth_place') }}',
            minimumInputLength: 2,
            allowClear: true,
            templateResult: function (region) {
                if (region.loading) {
                    return region.text;
                }

                return region.name || region.text;
            },
            templateSelection: function (region) {
                return region.name || region.text;
            },
        });

        $('#death_place').select2({
            ajax: {
                url: '/api/search-regions',
                method: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        page: params.page || 1,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.data.regions,
                        pagination: {
                            more: (params.page * 10) < data.data.total,
                        },
                    };
                },
                delay: 250,
            },
            placeholder: '{{ __('adminlte.celebrity.death_place') }}',
            minimumInputLength: 2,
            allowClear: true,
            templateResult: function (region) {
                if (region.loading) {
                    return region.text;
                }

                return region.name || region.text;
            },
            templateSelection: function (region) {
                return region.name || region.text;
            },
        });
    </script>
@endsection
