// Initialize the TinyMCE Editor
tinymce.init({
    selector: '.wysiwyg',
    menubar: false,
    statusbar: false,
    toolbar1: 'undo redo | bold  italic underline strikethrough',
    valid_elements: "p,br,b,i,strong,em",
    extended_valid_elements : "span[!style]",
    plugins: ['autoresize', 'paste']
});
