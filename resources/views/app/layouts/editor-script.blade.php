<script>
    tinymce.init({
        selector: 'textarea.content-editor',
        menubar: false,
        relative_urls : false,
        remove_script_host : false,
        image_class_list: [
            {title: 'Responsive', value: 'img-fluid'}
        ],
        height: 400,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
        },
        image_description: false,
        plugins: [
            "advlist autolink lists image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools link"
        ],
        paste_data_images: true,
        toolbar: "insertfile undo redo | bold italic | formatselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image link",
        images_upload_handler: function (blobInfo, success, failure, progress) {
            let xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ action('Ajax\EditorController@store', $path) }}');

            xhr.upload.onprogress = function (e) {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = function () {
                let json;

                if (xhr.status === 403) {
                    failure('HTTP Error: ' + xhr.status, {remove: true});
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            xhr.onerror = function () {
                failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('_token', '{{ csrf_token() }}');

            xhr.send(formData);
        }
    });
</script>

