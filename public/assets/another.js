jQuery(document).ready(function () {

    url = $('#monthlyurl').val();
    setDatatable(url);

    function setDatatable(url) {
        table = $('#monthcal').DataTable({
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
                    var ovrl_monthcost = d['ovrl_monthcost'];
                    return ovrl_monthcost;
                }
            },
            columns: [
                {
                    data: 'dept_id'
                },
                {
                    data: 'room_no'
                },
                {
                    data: 'elec_bill'
                },
                {
                    data: 'internet_bill'
                },
                {
                    data: 'seat_bill'
                },
                {
                    data: 'meal_no'
                },
                {
                    data: 'meal_cost'
                },
                {
                    data: 'total'
                },
                {
                    data: 'deposit'
                },
                {
                    data: 'surplus',
                    class: "srpls"
                },
                {
                    data: 'action'
                }
            ],
            "columnDefs": [{
                    "targets": 9,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if (cellData < 0) {
                            $(td).css('color', 'red')
                        } else if (cellData > 0) {
                            $(td).css('color', 'green')
                        }
                    }
                },
                {
                    "targets": [6, 7, 9],
                    "render": $.fn.dataTable.render.number(',', '.', 1)
                }
            ]
        });
    }

    if ($('.srpls').val() > 0) {
        this.attr('style', 'background-color:green');
    }

    depositsubmit = function (id) {
        $('#myModal' + id).modal('hide');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = '#myModal' + id + ' #cash' + id;
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
    credit = function (id) {
        $('#myModal' + id).modal('hide');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = '#myModal' + id + ' #credit' + id;
        $(form).submit(function (e) {
            e.preventDefault();
            var url = $(form).attr('action');
            var method = $(form).attr('method');

            $.ajax({
                url: url,
                type: method,
                data: $(form).serialize(),
                success: function (response) {
                    if(response.data == 'over'){
                        swal({
                            icon: "error",
                            timer: 2500,
                            title: 'Student has not this amount on his account balance!'
                        });
                    }else if(response.data == 'success'){
                        table.ajax.reload();
                        swal({
                            icon: "success",
                            timer: 1500,
                            title: 'Updated!'
                        });
                    }


                }
            });

        });
        $(form).submit();
    }

    debit = function (id) {
        $('#myModal' + id).modal('hide');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = '#myModal' + id + ' #debit' + id;
        $(form).submit(function (e) {
            e.preventDefault();
            var url = $(form).attr('action');
            var method = $(form).attr('method');

            $.ajax({
                url: url,
                type: method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.data == 'over') {
                        swal({
                            icon: "error",
                            timer: 5000,
                            title: 'Debit Balance is over this month deposit!'
                        });
                    } else if (response.data == 'success') {
                        table.ajax.reload();
                        swal({
                            icon: "success",
                            timer: 1500,
                            title: 'Updated!'
                        });
                    }


                }
            });

        });
        $(form).submit();
    }







});
