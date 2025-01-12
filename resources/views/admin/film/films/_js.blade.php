@if (!config('adminlte.enabled_laravel_mix'))
    @php($javaScriptSectionName = 'js')
@else
    @php($javaScriptSectionName = 'mix_adminlte_js')
@endif

@section($javaScriptSectionName)
{{--    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>--}}
    <script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/piexif.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/purify.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/themes/fa/theme.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/locales/uz.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/locales/ru.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/js/locales/LANG.js') }}"></script>

    <script>
        $('#genres').select2();

        let siteIndex = parseInt('{{ $siteIndex }}');
        siteIndex++;

        let posterInput = $("#poster-input");
        let posterUrl = '{{ $film ? ($film->poster ? $film->posterOriginal : null ) : null }}';

        let send = XMLHttpRequest.prototype.send, token = $('meta[name="csrf-token"]').attr('content');
        XMLHttpRequest.prototype.send = function(data) {
            this.setRequestHeader('X-CSRF-Token', token);
            return send.apply(this, arguments);
        };

        if (posterUrl) {
            posterInput.fileinput({
                initialPreview: [posterUrl],
                initialPreviewAsData: true,
                showUpload: false,
                previewFileType: 'text',
                browseOnZoneClick: true,
                overwriteInitial: true,
                deleteUrl: 'remove-poster',
                maxFileCount: 1,
                allowedFileExtensions: ['jpg', 'jpeg', 'png'],
            });
        } else {
            posterInput.fileinput({
                showUpload: false,
                previewFileType: 'text',
                browseOnZoneClick: true,
                maxFileCount: 1,
                allowedFileExtensions: ['jpg', 'jpeg', 'png'],
            });
        }

        $(document).ready(function (e) {
            $('#tv_series').change(function () {
                if (this.checked) {
                    $('#last_season_released_at').removeAttr('disabled');
                    $('#last_episode_released_at').removeAttr('disabled');
                } else {
                    $('#last_season_released_at').prop('disabled', true);
                    $('#last_episode_released_at').prop('disabled', true);
                }
            });

            $('#add-site').click(function (e) {
                e.preventDefault();

                let form =
                    '<div class="col-md-11 site-input-' + siteIndex + '">' +
                    '   <div class="form-group">' +
                    '       <input class="form-control" type="text" name="sites[]" id="sites[]">' +
                    '   </div>' +
                    '</div>' +
                    '<div class="form-group site-remove-button-' + siteIndex + '">' +
                    '   <button class="remove-site btn btn-danger" onclick="removeSite(event, ' + siteIndex + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>' +
                    '</div>';

                $('#site-row').append(form);

                siteIndex++;
            });
        });

        function removeSite(e, siteIndex) {
            e.preventDefault();

            $('.site-input-' + siteIndex).remove();
            $('.site-remove-button-' + siteIndex).remove();
        }
    </script>
@endsection
