var click = 100;
function addSliderInput() {
    click++;
    $('.slider-lists').append(
        '<div class="row">\n' +
        '<div class="form-group col-md-5">\n' +
        '<input type="text" class="form-control images-modal" onclick="MediaModal(this)" name="slider['+ click +'][url]" placeholder="Изображение">\n' +
        '</div>\n' +
        '<div class="form-group col-md-6">\n' +
        '<input type="text" class="form-control" name="slider['+ click +'][title]" placeholder="Ссылка">\n' +
        '</div>\n' +
        '<div class="form-group col-md-1">\n' +
        '<a href="#" onclick="removeSliderInput(this); return false;" class="btn btn-danger"><i class="fa fa-close"></i> </a>\n' +
        '</div>\n' +
        '</div>'
    );
}

function addSocialInput() {
    click++;
    $('.social-lists').append(
        '<div class="row">\n' +
        '<div class="form-group col-md-5">\n' +
        '<input type="text" class="form-control" name="social['+ click +'][icon]" placeholder="Иконка">\n' +
        '</div>\n' +
        '<div class="form-group col-md-6">\n' +
        '<input type="text" class="form-control" name="social['+ click +'][url]" placeholder="Ссылка">\n' +
        '</div>\n' +
        '<div class="form-group col-md-1">\n' +
        '<a href="#" onclick="removeSliderInput(this); return false;" class="btn btn-danger"><i class="fa fa-close"></i> </a>\n' +
        '</div>\n' +
        '</div>'
    );
}

function addPhoneInput() {
    click++;
    $('.phone-lists').append(
        '<div class="row">\n' +
        '<div class="form-group col-md-5">\n' +
        '<input type="text" class="form-control" name="phone['+ click +'][number]" placeholder="Номер телефона">\n' +
        '</div>\n' +
        '<div class="form-group col-md-6">\n' +
        '<input type="text" class="form-control" name="phone['+ click +'][visual]" placeholder="Номер телефона визуально">\n' +
        '</div>\n' +
        '<div class="form-group col-md-1">\n' +
        '<a href="#" onclick="removeSliderInput(this); return false;" class="btn btn-danger"><i class="fa fa-close"></i> </a>\n' +
        '</div>\n' +
        '</div>'
    );
}

function removeSliderInput(btn) {
    $(btn).parent().parent('.row').remove();
}