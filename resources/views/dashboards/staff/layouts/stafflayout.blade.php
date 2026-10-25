{{-- Website content (CMS) pages now render inside the unified portal layout. --}}
@extends('layouts.portal')

@push('scripts')
<script>
    $(function () {
        $('#content, #content1').summernote({
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        if ($('#registeredUsersTable').length && !$.fn.dataTable.isDataTable('#registeredUsersTable')) {
            $('#registeredUsersTable').DataTable({ pageLength: 25, dom: 'Bfrtip', buttons: ['copy', 'excel', 'csv', 'print'] });
        }
    });
</script>
@endpush
