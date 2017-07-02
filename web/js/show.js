$(document).ready(function() {
    var selected = [];

    $('#data_table').DataTable({
        "processing" : true,
        "serverSide" : true,
        "pagingType" : "full_numbers",
        "ajax" : {
            "url": '/products/list',
            "type": "POST"
        },

        "dom": '<"toolbar">rft<"top"><"bottom"lip>',

        "rowCallback": function( row, data ) {
            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                $(row).addClass('selected');
            }
        },

        "columns": [
            { "data" : "DT_RowId" },
            { "data" : "title" },
            { "data" : "description" },
            { "data" : "price" },
            { "data" : "weight" },
            { "data" : "width" },
            { "data" : "height" }
        ],

        aoColumnDefs : [
            {
                "targets": "product-name",
                "render" : function (value, action, row, settings) {

                    return "<span>" + row.title + "</span>" +
                           "<button class='product_edit' onclick='return pr.edit(this, event)'><i class='fa fa-pencil-square-o'></i> Редактировать</button>";
                }
            }
        ],

        "language" : {
            "processing"        : "Подождите...",
            "search"            : "",
            searchPlaceholder   : "Поиск сервиса по названию...",
            "lengthMenu"        : "Отображать _MENU_",
            "info"              : "_START_ - _END_ (_TOTAL_)",
            "infoEmpty"         : "Записи с _START_ до _END_ из _TOTAL_ записей",
            "infoFiltered"      : "(отфильтровано из _MAX_ записей)",
            "infoPostFix"       : "",
            "loadingRecords"    : "Загрузка записей...",
            "zeroRecords"       : "Записи отсутствуют.",
            "emptyTable"        : "Такая запись не найдена",
            "paginate" : {
                "first": "Первая",
                "previous": "«",
                "next": "»",
                "last": "Последняя"
            },
            "aria" : {
                "sortAscending"     : ": активировать для сортировки столбца по возрастанию",
                "sortDescending"    : ": активировать для сортировки столбца по убыванию"
            }
        }
    });

    $('.dataTables_filter input').after('<span class="brd"></span>');

    $('#data_table tbody').on('click', 'tr', function () {

        var id      = this.id,
            index   = $.inArray(id, selected);

        if(index === -1)
            selected.push(id);
        else
            selected.splice(index, 1);

        if(selected.length >= 1)
            $('#delete_item').attr('class', 'active');
        else
            $('#delete_item').attr('class', '');

        $(this).toggleClass('selected');

    } );

    $("div.toolbar").html('<div class="table_tools_wrp">' +
        '<button id="delete_item" title="Удалить выбранные продукты">Удалить выбранные</button></div>');


    $('#delete_item').click(function(){

        if(this.className == 'active') {
            $.ajax({
                url     : 'products/del',
                type    : "POST",
                data    : { data : selected },
                success : function (data) {

                    console.log('data: ', data);
                    location.reload();
                }
            });
        }
    });

    $('#add_product').click(function(){

        if(this.className == 'active') {
            $.ajax({
                url     : 'products/del',
                type    : "POST",
                data    : { data : selected },
                success : function (data) {

                    console.log('data: ', data);
                    location.reload();
                }
            });
        }
    });
} );


var pr = {

    showModal : function() {
        $('#modal').css({display : 'block'});
    },

    closeModal : function() {
        $('#product_id').val('');

        $('#modal').css({display : 'none'});

        pr.clearForm();
    },

    clearForm : function() {

        $('#id').val('');
        $('#title').val('');
        $('#description').val('');
        $('#price').val('');
        $('#weight').val('');
        $('#width').val('');
        $('#height').val('');
    },

    edit : function (elem, event) {

        var id = elem.parentNode.previousElementSibling.innerHTML;

        var title       = elem.previousElementSibling.innerHTML,
            description = elem.parentNode.nextSibling.innerHTML,
            price       = elem.parentNode.parentNode.children[3].innerHTML,
            weight      = elem.parentNode.parentNode.children[4].innerHTML,
            width       = elem.parentNode.parentNode.children[5].innerHTML,
            height      = elem.parentNode.parentNode.children[6].innerHTML;

        $('#title').val(title);
        $('#description').val(description);
        $('#price').val(price);
        $('#weight').val(weight);
        $('#width').val(width);
        $('#height').val(height);


        $('#product_id').val(id);

        this.showModal();

        event.stopPropagation();
    }
};
