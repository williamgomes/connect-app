@section('script')
    <script>
        $(document).ready(function () {
            let options = $("#options");
            let minMaxBlock = $("#minMaxBlock");
            let defaultValueBlock = $("#defaultValue").closest('.form-group');
            let placeholderBlock = $("#placeholder").closest('.form-group');

            $('#type').change(function () {
                let type = $(this).val();

                // Toggle options
                if (type === '{{ \App\Models\CategoryField::TYPE_DROPDOWN }}' || type === '{{ \App\Models\CategoryField::TYPE_MULTIPLE }}') {
                    options.removeClass('d-none');
                } else {
                    options.addClass('d-none');
                }

                // Toggle options min and max inputs
                if (type === '{{ \App\Models\CategoryField::TYPE_INPUT }}' || type === '{{ \App\Models\CategoryField::TYPE_NUMBER }}') {
                    minMaxBlock.removeClass('d-none');
                } else {
                    minMaxBlock.addClass('d-none');
                }

                // Toggle default value and placeholder
                if (type === '{{ \App\Models\CategoryField::TYPE_ATTACHMENT }}' || type === '{{ \App\Models\CategoryField::TYPE_DROPDOWN }}' || type === '{{ \App\Models\CategoryField::TYPE_MULTIPLE }}') {
                    defaultValueBlock.addClass('d-none');
                    placeholderBlock.addClass('d-none');
                } else {
                    defaultValueBlock.removeClass('d-none');
                    placeholderBlock.removeClass('d-none');
                }
            });

            let optionBlock = $('.option-blocks:first');
            let addMore = $('#addMore');

            // Add more option button handler
            addMore.click(function (e) {
                e.preventDefault();

                let clonedOption = optionBlock.clone();
                clonedOption.find('input').val('');

                addMore.before(clonedOption);
            })

            // Remove option button handler
            $(document).on('click', '.remove-option', function (e) {
                e.preventDefault();

                $(this).closest('.option-blocks').remove();
            });

            $('form').one("submit", function (e) {
                e.preventDefault();

                $('.d-none').remove();

                $.each($('.default-options'), function (index, element) {
                    let radio = $(element);
                    let option = radio.closest('.option-blocks').find('input');

                    if (radio.is(':checked')) {
                        radio.val(option.val());
                    }
                });

                $(this).submit();
            });
        });
    </script>
@append