jQuery(document).ready(function(){

    $('[data-mask]').inputmask();

    $('#student').DataTable({
        "ordering": false
    });
    // $('#monthcal').DataTable({
    //     "ordering": false
    // });
    $('#employee').DataTable({
        "ordering": false
    });

    $('#transaction').DataTable({
        "ordering": false
    });


    url = $('#getUrl').val();
    searchurl = $('#searchUrl').val();

    setDatatable(url);
    var table;
    function setDatatable(url){
        table = $('#mealday').DataTable({
            "ordering": false,
            "lengthMenu": [
                [100, 300, 500, -1],
                [100, 300, 500, "All"]
            ],

            processing: true,
            ajax: {
                "url": url,
                "type": "GET",
                "error": function (e) {
                    console.log('yes error');
                },
                "dataSrc": function (d) {
                    var ovrl_stdmeal = d['ovrl_stdmeal'];
                    return ovrl_stdmeal;
                }
            },
            columns: [
                { data: 'name' },
                { data: 'dept_id' },
                { data: 'room_no' },
                { data: 'batch' },
                { data: 'dept' },
                { data: 'mealform' },
                { data: 'meal_cost' },
                { data: 'eggform' }
            ]
        });
    }



    mealformsubmit = function(id,form) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        form = $(form).attr('id');
        form = '#' + form;


        $(form).submit(function(e) {
            e.preventDefault();
            var url = $(form).attr('action');
            var method = $(form).attr('method');

            $.ajax({
                url: url,
                type: method,
                data: $(form).serialize(),
                success: function (response) {
                    table.ajax.reload();

                    document.getElementById("avg_emp_cost").innerText = (response.avg_emp_cost).toFixed(2);
                    document.getElementById("total_mealcost").innerText = (response.total_meal_cost).toFixed(0);
                    document.getElementById("meal_rate").innerText = (response.meal_rate).toFixed(2);
                    document.getElementById("meal_no").innerText = (response.std_meal_no).toFixed(1) + ' + ' + (response.emp_meal_no).toFixed(1);

                    swal({
                        icon: "success",
                        timer: 1500,
                        title: 'Updated!'
                    });

                }
            });


        });
        $(form).submit();
    }

    eggformsubmit = function (id, form) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        form = $(form).attr('id');
        form = '#' + form;


        $(form).submit(function (e) {
            e.preventDefault();
            var url = $(form).attr('action');
            var method = $(form).attr('method');

            $.ajax({
                url: url,
                type: method,
                data: $(form).serialize(),
                success: function (response) {
                    table.ajax.reload();

                    document.getElementById("avg_emp_cost").innerText = (response.avg_emp_cost).toFixed(2);
                    document.getElementById("total_mealcost").innerText = (response.total_meal_cost).toFixed(0);
                    document.getElementById("meal_rate").innerText = (response.meal_rate).toFixed(2);
                    document.getElementById("meal_no").innerText = (response.std_meal_no).toFixed(1) + ' + ' + (response.emp_meal_no).toFixed(1);

                    swal({
                        icon: "success",
                        timer: 1500,
                        title: 'Updated!'
                    });
                }
            });


        });
        $(form).submit();
    }



    // Setup - add a text input to each footer cell
    $('#mealday thead tr:eq(1) th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" class="column_search" />');
    });

    // Apply the search
    $('#mealday thead').on('keyup', ".column_search", function () {

        table
            .column($(this).parent().index())
            .search(this.value)
            .draw();
    });


    var SpecialElementHandler = {
        "#editor":function(element,renderer) {
            return true;
        }
    }

    pdfbtnfun = function(name) {
        var doc = new jsPDF('p', 'pt', 'a4');
        doc.fromHTML($("#singleinfo").html(), 10, 10, {
            "elementHandlers": SpecialElementHandler
        });

        doc.autoTable({
            html: '#singlemeal',
            startY: doc.lastAutoTable + 100,
            styles: { fontSize: 12, font: 'times', halign: 'left' }
        })


        doc.setFontSize(12);
        doc.save(name + '.pdf');
    };

    convertPDF = function (id) {
        var doc = new jsPDF('p', 'pt', 'a3');

        doc.autoTable({
            html: id,
            tableWidth: 'auto',
            columnStyles: {
                0: {
                    columnWidth: 70
                },
                1: {
                    columnWidth: 60
                },
                2: {
                    columnWidth: 60
                },
                3: {
                    columnWidth: 'auto'
                },
                4: {
                    columnWidth: 70
                },
                5: {
                    columnWidth: 70
                },
                6: {
                    columnWidth: 100
                }
            },
            startY: doc.lastAutoTable + 50,
            styles: {
                fontSize: 12,
                font: 'times',
                halign: 'left'
            }
        })


        doc.setFontSize(12);
        doc.save('transaction_history' + '.pdf');
    };



});
