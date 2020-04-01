$(document).on('change', '[data-type]', function() {
    if($(this).val() == 'select' || $(this).val() == 'checkbox' || $(this).val() == 'radio') {
        $(this).parent().parent().next().removeClass('d-none');
    }else{
        $(this).parent().parent().next().addClass('d-none');
    }
});

$(document).on('keyup blur paste', '.field-displayname', function() {
    let target = $(this).parent().parent().parent().parent().find('.content-field-header h4'),
        val = $(this).val();

    if(val.trim().length > 0) {
        target.text(val);
    }else{
        target.text('Field');
    }
});


var options = {
    valueNames: [
        {name: 'name', attr: 'value'},
        {name: 'display_name', attr: 'value'},
        {name: 'sort', attr: 'value'},
        {name: 'type', attr: 'select:option'},
        'description',
        'rules',
        'options',
    ],
    item: 'content-field'
};

var contentFields = new List('content-fields', options);

let contentField = {
    __increment: 0,
    __sort: 0,
    updateSort: function() {
        $('#content-fields .content-field').each((idx, item) => {
            $(item).find('.sort').val(this.__sort);

            this.__sort++;
        });
    },
    updateIncrement: function() {
    },
    add: function(data, close) {
        $('#content-fields .content-field').each((idx, item) => {
            this.close($(item));
        });

        let parent = this;

        contentFields.add(data, function(items) {
            items.forEach((item) => {
                let elm = $(item.elm),
                    inputs = elm.find(':input[name^="fields"]').not('button'),
                    values = item.values();

                if(close)
                    contentField.close(elm);

                elm.find('.content-field-header h4').text(values.display_name);
                elm.find('.field-sort').val(parent.__increment);
                if('id' in values) {
                    elm.append($('<input/>', {
                        type: 'hidden',
                        name: 'fields['+ parent.__increment +'][id]',
                        value: values.id
                    }))
                }

                if(values.type == 'select' || values.type == 'checkbox' || values.type == 'radio') {
                    elm.find('.options').closest('.form-group').removeClass('d-none');
                    elm.next().removeClass('d-none');
                }

                inputs.each(function(idx, input) {
                    var name = $(input).attr('name').replace(/fields\[-1\]/g, 'fields['+ parent.__increment +']');
                    $(input).attr('name', name);
                });

                parent.__increment++;
                parent.updateSort();
            });
        });
    },
    remove: function(field) {
        if(field) return field.remove();

        var modalToggle = window.__modalToggle__,
            modal = window.__modal__,
            field = modalToggle.closest('.content-field');

        $.destroyModal(modal);
        console.log(field)
        // field.remove();
    },
    toggle: function(target) {
        if(target.hasClass('slide-up')) {
            this.open(target);
        }else{
            this.close(target);
        }
    },
    close: function(target) {
        target.addClass('slide-up');
        target.find('.content-field-header .fas').removeClass('fa-chevron-up');
        target.find('.content-field-header .fas').addClass('fa-chevron-down');
    },
    open: function(target) {
        target.removeClass('slide-up');
        target.find('.content-field-header .fas').removeClass('fa-chevron-down');
        target.find('.content-field-header .fas').addClass('fa-chevron-up');
    }
}

$(document).on('click', '.content-field-header, .collapse-this', function() {
    $('#content-fields .list .content-field-header').not(this).each((idex, item) => {
        contentField.close($(item).parent());
    })
    contentField.toggle($(this).parent());

    return false;
});

$(document).on('click', '#content-fields .content-field .content-field-remove', function() {
    let field = $(this).closest('.content-field');

    contentField.remove(field);

    return false;
});

$("#add-new-field").click(function() {
    contentField.add([{}]);

    return false;

    // $("#sidebar-wrapper").fadeOut();
    // $('body').addClass('sidebar-wide');

    // let fielder = $('.fielder');

    // fielder.find('.fielder-title').html('New Field');

    // setTimeout(function() {
    //     fielder.fadeIn();
    //     update_sidebar_nicescroll();
    // }, 500);
    // return false;
});

if(fields) contentField.add(fields, true);

$("#content-manager-form").submit(function() {
    let me = $(this);

    $.ajax({
        url: me.attr('action'),
        data: me.serialize(),
        type: me.attr('method'),
        headers: {
            'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr('content')
        },
        error: function(xhr) {
            alert('Error: ' + xhr.status);
        },
        beforeSend: function() {
            $("#save-changes-btn").addClass('btn-progress disbaled');
        },
        complete: function() {
            $("#save-changes-btn").removeClass('btn-progress disabled');
        },
        success: function(data) {
            if(me.find('[name="_method"]').val() == 'PUT') {
                document.location.reload();
            }
        }
    });

    return false
});

new Sortable(document.getElementById('content-field-list'), {
    handle: '.handle',
    animation: 150,
    onChange: function(evt) {
        contentField.updateSort();
    }
});
