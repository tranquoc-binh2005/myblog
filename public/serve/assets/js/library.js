changeStatus = () => {
    $('.changeStatusPublish').on('change', function () {
        _this = $(this)
        filed = _this.attr('data-filed')
        column = _this.attr('data-column')
        _id = _this.attr('data-id')
        value = _this.attr('data-value')

        $.ajax({
            url: BASE_URL + 'change-status',
            type: 'POST',
            data: {id: _id, filed: filed, column: column, value: value},
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === 'success') {
                    console.log("Thành công: " + response.message + " với ID: " + response.id);
                } else {
                    console.log("Lỗi: " + response.message + " với ID: " + response.id);
                }
            },
            error: function (e) {

            }
        });
    })
}

changeStatusAll = () => {
    $(document).on('click', '.publishAll', function (e) {
        e.preventDefault()
        let ids = []
        $('.inputCheck').each(function () {
            let inputCheck = $(this)
            if (inputCheck.prop('checked')) {
                ids.push(inputCheck.attr('data-id'))
            }
        })

        let _this = $(this)
        let option = {
            'field': _this.attr('data-field'),
            'column': _this.attr('data-column'),
            'value': _this.attr('data-value'),
        }
        console.log(ids);
        $.ajax({
            url: BASE_URL + 'change-statusAll',
            type: 'POST',
            data: {'ids': ids, 'option': option},
            success: function (data) {
                console.log(data.new_value);
            
                let cssSpanPublish = 'background-color: rgb(100, 176, 242); border-color: rgb(100, 176, 242); ' +
                    'box-shadow: rgb(100, 176, 242) 0px 0px 0px 10.5px inset; transition: border 0.4s, box-shadow 0.4s, background-color 1.2s;';
                let cssSmallPublish = 'left: 12px; transition: background-color 0.4s, left 0.2s; background-color: rgb(255, 255, 255);';
            
                let cssSpanUnpublish = 'box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); ' +
                    'background-color: rgb(255, 255, 255); transition: border 0.4s, box-shadow 0.4s;';
                let cssSmallUnpublish = 'left: 0px; transition: background-color 0.4s, left 0.2s;';
            
                for (let i = 0; i < ids.length; i++) {
                    let location = $('.location-' + ids[i]);
                    let userSpan = location.siblings('span.switchery'); 
                    let smallSwitch = userSpan.find('small');           
        
                    if (data.new_publish == 1) { 
                        location.prop('checked', true).trigger('change'); 
                        userSpan.attr('style', cssSpanPublish);           
                        smallSwitch.attr('style', cssSmallPublish);   
                    } else if (data.new_publish == 2) { 
                        location.prop('checked', false).trigger('change');
                        userSpan.attr('style', cssSpanUnpublish);
                        smallSwitch.attr('style', cssSmallUnpublish);
                    }
                }
            },                      
            error: function (e) {

            }
        });
    })
}
inputCheckAll = () => {
    if ($('#checkAll').length) {
        $(document).on('click', '#checkAll', function (e) {
            let isChecked = $(this).prop('checked');
            $('.inputCheck').prop('checked', isChecked);

            $('.inputCheck').each(function () {
                changeBackground($(this));
            });
        });
    }
}

inputCheck = () => {
    if ($('.inputCheck').length) {
        $(document).on('click', '.inputCheck', function (e) {
            let _this = $(this);
            let unCheckedInputCheckExists = $('.inputCheck:not(:checked)').length > 0;
            $('#checkAll').prop('checked', !unCheckedInputCheckExists);
            changeBackground(_this);
        });
    }
}

changeBackground = (object) => {
    let isChecked = object.prop('checked');
    if (isChecked) {
        object.closest('tr').addClass('bg-active');
    } else {
        object.closest('tr').removeClass('bg-active');
    }
}

setupSelect2 = () => {
    $('.select-2').select2({
        placeholder: "Hãy chọn danh mục",
        allowClear: true
    });
}

$(document).ready(function () {
    changeStatus()
    changeStatusAll()
    inputCheckAll()
    inputCheck()
    setupSelect2()
})
