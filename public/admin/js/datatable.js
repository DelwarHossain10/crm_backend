const generate_datatable = (route,columns,order,button,db_table, filter = {}) => {
    var data = [];
    var action = [
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ];
    columns.forEach(element => {
        data.push({
            data: element.indexOf('.') > -1 ? element.split('.')[0] : element,
            name: element
        });
    });
    filter ? $('.data-table').DataTable().destroy() : '';
    button ? Array.prototype.push.apply(data,action) : data;

    let table = $('.data-table').DataTable({
        "processing": true,
        "serverSide": true,
        'paginate': true,
        'searchDelay': 700,
        "responsive": true,
        "order": [ [1, order] ],
        "searching": true,
        "language":
        {
        "processing": '<div class="sk-wave sk-primary"><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div><div class="sk-wave-rect"></div></div>',
        },
        "ajax":{
          "url": route,
          "dataType": "json",
          "type": "get",
          "data":{
            'filterColumn' : filter
          },
        },
        'columnDefs': [
          {
            'targets': 0,
            'checkboxes': {
              'selectRow': true
            },

          }
        ],
        'select': {
            'style': 'multi',
            'blurable': true
        },
        dom: 'Blfrtip',
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, 'All'],
        ],
        buttons: [
            // {
            //   text: '<button class="datatable publish-post" data-bs-target="#exportModal" data-bs-toggle="modal" title="Export"><i class="bx bxs-file-export"></i>Export</button>',
            //   action: function () {
            //       return true;
            //   }
            // },
            {
              text: '<button class="datatable publish-post" title="Print"><i class="bx bx-printer"></i>Print</button>',
              action: function () {
                $('table.data-table tr th:first-child').css('display','none');
                $('table.data-table tr td:first-child').css('display','none');
                $('table.data-table tr th:last-child').css('display','none');
                $('table.data-table tr td:last-child').css('display','none');
                window.print();
                setTimeout(()=>{
                  $('table.data-table tr th:first-child').css('display','');
                  $('table.data-table tr td:first-child').css('display','');
                  $('table.data-table tr th:last-child').css('display','');
                  $('table.data-table tr td:last-child').css('display','');
                },1000);
              }
            },
            {
              text: '<button class="datatable publish-post" title="PDF"><i class="bx bxs-file-pdf"></i>PDF</button>',
              action: function () {
                $('table.data-table tr th:first-child').css('display','none');
                $('table.data-table tr td:first-child').css('display','none');
                $('table.data-table tr th:last-child').css('display','none');
                $('table.data-table tr td:last-child').css('display','none');
                const element = document.getElementById('DataTables_Table_0');
                html2pdf().from(element).save();
                setTimeout(()=>{
                  $('table.data-table tr th:first-child').css('display','');
                  $('table.data-table tr td:first-child').css('display','');
                  $('table.data-table tr th:last-child').css('display','');
                  $('table.data-table tr td:last-child').css('display','');
                },1000);
              }
            },
            // {
            //   text: `<span class="btn-delete-datatable-row py-0" style="display:none;font-weight:bold;">Move to trash <span class="bx bx-trash"/></span>`,
            //   action: function () {
            //     var rows_selected = table.column(0).checkboxes.selected();
            //     var rows = [];
            //     $.each(rows_selected, function(index,rowId){
            //       rows.push(rowId);
            //     });
            //     $.ajax({
            //       url: '/delete/rows',
            //       type: 'get',
            //       data: {
            //         'rows': rows,
            //         'table' : db_table
            //       },
            //       success: function(data) {
            //         rows = [];
            //         table.ajax.reload();
            //         $('.btn-delete-datatable-row').hide();
            //       }
            //     });
            //   }
            // }
        ],
        columns: data,
        // initComplete: function() {
        //   var row = $('.data-table tfoot tr');
        //   $('.data-table thead').append(row);
        //   this.api().columns().every(function(columnNumber) {
        //     if(columnNumber == '0' || columnNumber == columns.length){
        //       return false;
        //     }
        //     var column = this;
        //     var input = document.createElement("input");
        //     input.classList.add('form-control');
        //     input.classList.add('form-control-sm');
        //     $(input).appendTo($(column.footer()).empty())
        //         .on('change', function() {
        //           column.search($(this).val()).draw();
        //         });
        //   });
        // }
    });
    $(".dt-checkboxes-select-all").on('click', function(e){
      $(".dt-checkboxes").prop('checked', $(this).prop('checked'));
      var row_count = $('.data-table').find('input[class=dt-checkboxes]:checked').length;
      row_count > 0 ? $('.btn-delete-datatable-row').hide() : $('.btn-delete-datatable-row').show();
    });

    $('body').on('click','.table', function(e){
      $(this).prop('checked', $(this).prop('checked'));
      var table_row = $('.data-table').find('input[type=checkbox]:checked').length;
      table_row > 0 ? $('.btn-delete-datatable-row').show() : $('.btn-delete-datatable-row').hide();
    });
}
