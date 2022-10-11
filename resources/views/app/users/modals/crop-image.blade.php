<div class="modal fade" id="crop_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Crop the image') }}</h4>
                <button type="button" class="close pt-4" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="crop_image" src="" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="crop">{{ __('Crop') }}</button>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="{{ action('App\UserController@updateProfilePicture', $user) }}" id="profile_picture_form" enctype="multipart/form-data" hidden>
    @csrf
    <input type="hidden" name="crop_x" id="crop_x" value="0"/>
    <input type="hidden" name="crop_y" id="crop_y" value="0"/>
    <input type="hidden" name="crop_width" id="crop_width" value="0"/>
    <input type="hidden" name="crop_height" id="crop_height" value="0"/>
    <input type="file" name="profile_picture" id="profile_picture" accept=".jpg,.jpeg,.png"/>
</form>

<link href="{{ asset('app/libs/cropper.js/cropper.min.css') }}" rel="stylesheet">

<style>
    .account-img-update {
        position: absolute;
        color: #fffcfc;
        top: 0.7em;
        left: 1.00em;
        opacity: 0;
    }

    .account-img:hover .account-img-update {
        opacity: 1;
    }

    .account-img:hover img{
        filter: brightness(0.6);
    }
</style>

@section('script')
    <script src="{{ asset('app/libs/cropper.js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            const cropImage = $('#crop_image');
            const cropModal = $('#crop_modal');
            let cropper;

            $('#profile_picture').on('change', function () {
                if (this.files.length == 0) {
                    return false;
                }

                // Check file size
                const file = this.files[0];
                if (file.size > 4 * 1024 * 1024) {
                    swal('Error!', '{{ __('Max file size is 4MB') }}');
                    $(this).val('');
                    return false;
                }

                // Init image
                const image = new Image();
                const url = window.URL || window.webkitURL;
                image.src = url.createObjectURL(file);

                // Set initial form fields values
                $('#crop_x').val(0);
                $('#crop_y').val(0);
                $('#crop_width').val(image.width);
                $('#crop_height').val(image.height);

                // Prepare image preview for cropping and show crop modal
                const done = function (url) {
                    cropImage.attr('src', url);
                    cropModal.modal('show');
                };
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            cropModal.on('shown.bs.modal', function () {
                cropper = new Cropper(cropImage[0], {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 1,
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
                $('#profile_picture').val('');
            });

            $('#crop').on('click', function () {
                if (cropper) {
                    const cropData = cropper.getData();

                    // Check cropped image dimensions
                    if (cropData.width < 500 && cropData.height < 500) {
                        swal('Error!', '{{ __('Min image dimensions are 500px x 500px') }}');
                        return false;
                    }

                    cropModal.modal('hide');

                    // Set form fields and submit the form
                    $('#crop_x').val(Math.round(cropData.x));
                    $('#crop_y').val(Math.round(cropData.y));
                    $('#crop_width').val(Math.round(cropData.width));
                    $('#crop_height').val(Math.round(cropData.height));

                    // Submit the form
                    $('#profile_picture_form').submit();
                }
            });
        });
    </script>
@append
