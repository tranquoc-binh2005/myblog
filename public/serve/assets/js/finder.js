setupCkEditor = () => {
    document.querySelectorAll('.ck-editor').forEach((element) => {
        const height = element.getAttribute('data-height');
        ClassicEditor.create(element, {
            ckfinder: {
                uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
            },
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    'subscript',
                    'superscript',
                    'alignment',
                    '|',
                    'link',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo',
                    '|',
                    'CKFinder' // Thêm CKFinder vào toolbar
                ],
                shouldNotGroupWhenFull: true,
            },
            language: 'en',
        })
            .then(editor => {
                window.editor = editor;
                CKFinder.setupCKEditor(editor);
                if (height) {
                    editor.ui.view.editable.element.style.height = `${height}px`; 
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
}

setupCkFinder = () => {
    $('.upload-image').on('click', function() {
        if($('.upload-image').length){
            $('.upload-image').each(function() {
                let _this = $(this)
                let id = _this.attr('id')
                selectFileWithCKFinder(id)
            })
        }
    })
}


function selectFileWithCKFinder(elementId) {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                var output = document.getElementById(elementId);
                output.value = file.getUrl();

                let ckAtavaImg = elementId + "Img"
                if(ckAtavaImg){
                    let imgElement = document.getElementById(ckAtavaImg);
                    if (imgElement) {
                        console.log(123)
                        imgElement.src = output.value;
                    }
                }
            });

            finder.on('file:choose:resizedImage', function (evt) {
                var output = document.getElementById(elementId);
                output.value = evt.data.resizedUrl;
            });
        }
    });
}

uploadImageAvata = () => {
    $('.image-target').on('click', function () {
        if ($('.ck-target').length) {
            $('.ck-target').each(function() {
                let _this = $(this);
                let _id = _this.attr('id'); 
                selectFileWithCKFinder(_id);
            });
        } else {
            console.log('No ck-target elements found.');
        }
    });
}


function multipleUploadImage() {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var files = evt.data.files.toArray(); // Lấy danh sách file được chọn
                files.forEach(function (file) {
                    appendImage(file.getUrl());
                });
            });

            finder.on('file:choose:resizedImage', function (evt) {
                appendImage(evt.data.resizedUrl);
            });
        }
    });
}
function appendImage(imageUrl) {
    console.log(imageUrl)
    const container = document.getElementById('imageContainer');

    let html = ''
    html += '<span class="image-wrapper">'
    html += '<img class="multipleUploadImage uploaded-image" id="ckAlbum" src="'+imageUrl+'" alt="'+imageUrl+'">'
    html += '<input type="hidden" name="album[]" value="'+imageUrl+'">'
    html += '<span class="delete-icon">x</span>'
    html += '</span>'

    $(container).append(html); 
    $('.contentmultipleUploadImage').addClass('hidden');
    $( "#imageContainer" ).sortable();
}

deletePicture = () => {
    $(document).on('click', '.delete-icon', function () {
        let _this = $(this)
        _this.parents('.image-wrapper').remove()
        if ($('#imageContainer .image-wrapper').length === 0) {
            $('.contentmultipleUploadImage').removeClass('hidden');
        }
    })
}


$(document).ready(function () {
    setupCkEditor();
    setupCkFinder();
    uploadImageAvata();
    $('.multipleUploadImage').on('click', function () {
        multipleUploadImage();
    });
    deletePicture();
    if ($('#imageContainer .image-wrapper').length !== 0) {
        $('.contentmultipleUploadImage').addClass('hidden');
    }
})