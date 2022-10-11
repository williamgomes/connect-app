@section('script')
    <script>
        $(function () {
            let sortableObj = $(".sortable-" + '{{ $type }}');

            sortableObj.sortable({
                update: function (event, ui) {
                    var sortedIDs = sortableObj.sortable("toArray", {attribute: 'data-id'});
                    $.ajax({
                        method: "POST",
                        url: "{{ $url }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            items: sortedIDs,
                        },
                        beforeSend: function () {
                            sortableObj.addClass('processing');
                        },
                        error: function () {
                            swal('Error!', '{{ __('An error occurred while saving') }}', 'error');
                        },
                        complete: function () {
                            sortableObj.removeClass('processing');
                        }
                    });
                }
            });
            sortableObj.disableSelection();
        });
    </script>
@append
