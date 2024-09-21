const selectPermission = param => {
    $('input[id=' + param + ']').prop('checked', $('.' + param + '').prop('checked'));
}
$('body').on('click', '#selectAll', function (e) {
    var clicks = $(this).data('clicks');
    $("input[class=form-check-input]").prop('checked', $(this).prop('checked'));
    if (clicks) {
        $('#replace').html('Select All');
    } else {
        $('#replace').html('Unchek All');
    }
    $(this).data("clicks", !clicks);
});
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
    $('body').on('click', '.bg-ddd', function (e) {
        e.preventDefault();
        $('.needs-validation')
            .trigger("reset")
            .removeClass('was-validated')
        $('#download').hide();
        $('.loader').hide();
    });
});
$("body").on("click", ".show_confirm", function (event) {
    var form = $(this).closest("form");
    event.preventDefault();
    swal({
        title: `Do you want to delete it?`,
        text: "If you delete this, it will be gone forever.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
});
$('body').on('click', '.ajax-modal-btn', function (e) {
    e.preventDefault();
    var url = $(this).data('link');
    $.get(url, function (data) {
        $('.edit-modal').html(data)
        $('#myDynamicEditModal').modal('show');
    })
});
$('body').on('click', '.ajax-modal-file-btn', function (e) {
    e.preventDefault();
    var url = $(this).data('link');
    $.get(url, function (data) {
        $('.file-modal').html(data)
        $('#myDynamicFileModal').modal('show');
    })
});
document.addEventListener("DOMContentLoaded", function () {
    $('#basicModal').modal({ backdrop: 'static', keyboard: false });
    $('#myDynamicEditModal').modal({ backdrop: 'static', keyboard: false });
    $('#output').hide();
});
$('body').on('click', '#image_label', function (e) {
    var el = document.getElementById('image_label');
    e.preventDefault();
    const url = window.origin + '/file-manager/fm-button';
    window.open(
        url,
        'fm', 'width=1500,height=1500,position=center'
    );
});
function fmSetLink($url) {
    $('#output').show();
    document.getElementById('image_label').value = $url;
    document.getElementById('output').src = $url;
}

$('body').on('click', '.selected_all_row', function (e) {
    $(".selected_row_column").prop('checked', $(this).prop('checked'));
    $('#checkbox_error').hide();
})

$('body').on('click', '.selected_row_column', function (e) {
    $('#checkbox_error').hide();
})

$('body').on('click', '#export', function (e) {
    e.preventDefault();
    var row_count = $('.export-form').find('input[type=checkbox]:checked').length;
    if (row_count == '0') {
        $('#checkbox_error').show();
        return false;
    }
    $('#loader').show();
    var ids = [];
    var db_table = $('#db_table').val();
    $('input[id="selected_column"]:checked').each(function () {
        ids.push(this.value);
    });
    const date_from = $('#date_form').val();
    const date_to = $('#date_to').val();
    const baseUrl = window.location.origin + '/' + window.location.pathname.split('/')[1];
    $.ajax({
        url: baseUrl + '/export?rows=' + ids + '&db_table=' + db_table + '&date_from=' + date_from + '&date_to=' + date_to,
        type: 'get',
        success: function (res) {
            $('#loader').hide();
            const link = document.createElement("a");
            link.href = res;
            link.download = 'data.csv';
            link.click();
        }
    })
});

function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('DataTables_Table_0');
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fn || ('list.' + (type || 'xlsx')));
}

$('body').on('click', '.filter-row', e => {
    const data = $('.filter-form').serialize();
    generate_datatable(route, columns, order, button, table, data);
});

const dynamicTagGenerator = data => {
    $('.select2').select2({
        theme: "classic",
        placeholder: '',
        minimumInputLength: 1,
        data: data,
        tags: true,
        allowClear: true,
        tokenSeparators: [','],
        insertTag: function (data, tag) {
            data.push(tag);
        },
    });
}

const dynamicTagifyGenerator = () => {
    var input = document.querySelector("#TagifyBasic");
    tagify = new Tagify(input);
}

const generateSearchableDropdown = (data, placeholder, inputLength) => {
    $('.searchable-dropdown').select2({
        placeholder: placeholder,
        minimumInputLength: inputLength,
        data: data
    });
}

const generateSearchableDropdownTwo = (data, placeholder, inputLength) => {
    $('.searchable-dropdown-two').select2({
        placeholder: placeholder,
        minimumInputLength: inputLength,
        data: data
    });
}
