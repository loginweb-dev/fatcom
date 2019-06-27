$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;
            $('#img-preview').html(``);

            $(`<button type="button" class="btn" onclick="add_img()">
                    <h1 style="font-size:50px;margin:10px"><span class="voyager-plus"></span></h1>
                </button>`).appendTo(placeToInsertImagePreview);

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $(`
                        <img src="${event.target.result}" style="height:100px" class="img-thumbnail img-sm img-gallery">
                    `).appendTo(placeToInsertImagePreview)
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, $('#img-preview'));
    });
});

function add_img(){
    $('#gallery-photo-add').trigger('click');
}
