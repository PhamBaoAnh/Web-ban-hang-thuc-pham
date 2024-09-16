$(document).ready(function() {
    $('#imageInput').change(function(e) {
        const imagePreview = $('#imagePreview');
        imagePreview.empty();

        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const image = $('<img>').addClass('m-3 rounded-1').attr('src', e.target.result).attr('width', 150);
                imagePreview.append(image);

            }

            reader.readAsDataURL(file);
        }
    });
});