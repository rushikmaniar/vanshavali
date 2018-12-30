<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 26/6/2018
 * Time: 1:08 PM
 */ ?>
<div class="card">
    <div class="card-body">
        <style type="text/css">
            #chartdiv {
                width: 100%;
                height: 500px;
                font-size: 11px;
            }

            .amcharts-pie-slice {
                transform: scale(1);
                transform-origin: 50% 50%;
                transition-duration: 0.3s;
                transition: all .3s ease-out;
                -webkit-transition: all .3s ease-out;
                -moz-transition: all .3s ease-out;
                -o-transition: all .3s ease-out;
                cursor: pointer;
                box-shadow: 0 0 30px 0 #000;
            }

            .amcharts-pie-slice:hover {
                transform: scale(1.1);
                filter: url(#shadow);
            }
        </style>

        <form id="form_analysis" method="post" action="">
            <div class="row">

                <!-- Class List -->
                <div class="col-md-3 form-group">
                    <label>Select Class</label>
                    <select name="class_select[]" id="class_select" class="form-control select2">
                        <option value="0">All class</option>
                        <?php foreach ($class_list as $row_class): ?>
                            <option value="<?= $row_class['class_id']; ?>"><?= $row_class['class_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Section List -->
                <div class="col-md-3 form-group">
                    <label>Select Section</label>
                    <select name="section_select" id="section_select" class="form-control select2">
                        <option>Select Section</option>
                        <?php foreach ($section_list as $row_section): ?>
                            <option value="<?= $row_section['section_id']; ?>"><?= $row_section['section_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Criteria List -->
                <div class="col-md-3 form-group">
                    <label>Select Criterias</label>
                    <select name="criteria_select" id="criteria_select" class="form-control select2">
                    </select>
                </div>

                <!-- Employee List -->
                <div class="col-md-3 form-group" id="employee_select_div">
                    <label>Select Employees</label>
                    <select name="employee_select" id="employee_select" class="form-control select2">
                    </select>
                </div>

                <!-- Submit  Button -->
                <div class="col-md-12 form-group" id="employee_select_div">
                    <button type="button" id="btn_refresh" class="btn-md btn-primary">Refresh</button>
                </div>


            </div>
        </form>
        <div id="TotalFeedback"></div>
        <div id="chartdiv"></div>
        <div id="charttable"></div>
    </div>
</div>


<script src="<?= base_url() ?>assets/backoffice/js/lib/amcharts/amcharts.js"></script>
<script src="<?= base_url() ?>assets/backoffice/js/lib/amcharts/pie.js"></script>
<script src="<?= base_url() ?>assets/backoffice/js/lib/amcharts/serial.js"></script>
<script src="<?= base_url() ?>assets/backoffice/js/lib/amcharts/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/backoffice/css/lib/amchart/export.css" type="text/css"
      media="all"/>
<script src="<?= base_url() ?>assets/backoffice/js/lib/amcharts/themes/light.js"></script>
<script src="//www.amcharts.com/lib/3/plugins/responsive/responsive.min.js"></script>

<script type="text/javascript">

    function getAnalysisData(class_id, section_id, criteria_id, employee_id) {
        if (typeof class_id === 'undefined') {
            class_id = null;
        }
        if (typeof section_id === 'undefined') {
            section_id = null;
        }
        if (typeof criteria_id === 'undefined') {
            criteria_id = null;
        }
        if (typeof employee_id === 'undefined') {
            employee_id = null;
        }
        $('#charttable').html('');
        //alert(class_id + '  ' + section_id + '  ' + criteria_id + '  ' + employee_id);

        //ajax call for data
        $.ajax({
            url: base_url + 'backoffice/Analysis/getAnalysisData',
            type: 'post',
            data: {
                'class_id': class_id,
                'section_id': section_id,
                'criteria_id': criteria_id,
                'employee_id': employee_id
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.status == 1 && response.data.total_feedback > 0 && response.chart_type == "donut") {

                    var charttitle = '';
                    charttitle += $('#employee_select option:selected').text();
                    charttitle += ' : ' + response.data.criteria;

                    var chartsubtitle = ' Class : ' + $('#class_select option:selected').text();
                    chartsubtitle += '  Total Feedback : ' + response.data.total_feedback;


                    makeDonut(charttitle, chartsubtitle, response.data.titleField, response.data.valueField, response.data.donut_data, response.data.total_feedback);

                } else if (response.status == 1 && response.data.total_feedback > 0 && response.chart_type == "bar") {

                    var charttitle = '';
                    charttitle += $('#employee_select option:selected').text();
                    charttitle += ' : ' + $('#criteria_select option:selected').text();

                    var chartsubtitle = ' Class : ' + $('#class_select option:selected').text();
                    chartsubtitle += '  Total Feedback : ' + response.data.total_feedback;

                    var bar_chart_data = response.data.bar_chart_data;
                    var bar_graph_array = response.data.bar_graph_array;
                    var bar_category_field = response.data.bar_category_field;
                    var criteria_list = response.data.criteria_list;


                    makebar(charttitle, chartsubtitle, bar_chart_data, bar_graph_array, bar_category_field);
                    makeEmpTable(charttitle, chartsubtitle, response.data.bar_table_data, criteria_list);
                }
                else {
                    $('#TotalFeedback').html('<h2>Total Feedback : ' + response.data.total_feedback + '</h2>');
                    $('#chartdiv').html('<h2 align="center" class="text-danger">No Data Found</h2>');

                    console.log('else');
                }

            },
            error: function (response) {
                console.log(' ajax request error');
            }
        });

    }


    function makeEmpTable(title, subtitle, bar_table_data, criteria_list) {
        var html = '';
        html += '<table class="display nowrap table table-hover table-striped table-bordered table-responsive dataTable" id="EmpTable" style="white-space: nowrap;">';

        html += '<thead>';
        html += '<tr>';
        html += '<td>Sr</td>';
        html += '<td>Rank</td>';
        $.each(criteria_list, function (index, value) {
            html += '<td>' + value + '</td>';
        });
        html += '<td>Total</td>';
        html += '</tr>';
        html += '</thead>';

        html += '<tbody>';

        var i = 0;
        $.each(bar_table_data, function (rowindex, row) {

            html += '<tr>';
            html += '<td>' + i++ + '</td>';
            $.each(row, function (colindex, col) {

                html += '<td>' + col + '</td>';
            });
            html += '</tr>';
        });


        html += '</tbody>';

        html += '</table>';


        $('#charttable').html('');
        $('#charttable').html(html);

        $('#EmpTable').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });


    }

    function makeDonut(charttitle, chartsubtitle, titlefield, valuefield, donutdata, totalfeedback) {
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "pie",
            "startDuration": 1,
            "theme": "light",
            "addClassNames": true,
            "legend": {
                "position": "right",
                "marginRight": 100,
                "autoMargins": false
            },
            "innerRadius": "30%",
            "defs": {
                "filter": [{
                    "id": "shadow",
                    "width": "200%",
                    "height": "200%",
                    "feOffset": {
                        "result": "offOut",
                        "in": "SourceAlpha",
                        "dx": 0,
                        "dy": 0
                    },
                    "feGaussianBlur": {
                        "result": "blurOut",
                        "in": "offOut",
                        "stdDeviation": 5
                    },
                    "feBlend": {
                        "in": "SourceGraphic",
                        "in2": "blurOut",
                        "mode": "normal"
                    }
                }]
            },
            "dataProvider": donutdata,
            "valueField": valuefield,
            "titleField": titlefield,
            "export": {
                "enabled": true
            },
            "responsive": {
                "enabled": true
            },
            "titles": [
                {
                    "text": charttitle,
                    "size": 35
                }, {
                    "text": chartsubtitle,
                    "size": 25
                }
            ],
            "radius": 100
        });
        chart.div.style.height = '500px';

    }

    function makebar(charttitle, chartsubtitle, bar_chart_data, bar_graph_array, bar_category_field) {

        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "categoryField": bar_category_field,
            "rotate": true,
            "startDuration": 1,
            "categoryAxis": {
                "gridPosition": "start",
                "position": "left"
            },
            "trendLines": [],
            "graphs": bar_graph_array,
            "guides": [],
            "valueAxes": [
                {
                    "id": "ValueAxis-1",
                    "position": "top",
                    "axisAlpha": 0
                }
            ],
            "allLabels": [],
            "balloon": {},
            "titles": [{
                "text": charttitle,
                "size": 35
            }, {
                "text": chartsubtitle,
                "size": 25
            }],
            "dataProvider": bar_chart_data,
            "export": {
                "enabled": true
            }


        });
        // set base values
        var categoryWidth = 150;

        // calculate bottom margin based on number of data points
        var chartHeight = categoryWidth * chart.dataProvider.length;

        // set the value
        chart.div.style.height = chartHeight + 'px';

        // LEGEND
        var legend = new AmCharts.AmLegend();
        legend = new AmCharts.AmLegend();
        legend.position = "bottom";
        legend.align = "center";
        legend.markerType = "square";
        legend.valueText = "aa";
        chart.addLegend(legend);

        // WRITE
        chart.write("chartdiv");

    }


    $(document).ready(function () {

        $("#form_analysis").validate({
            errorClass: 'invalid-feedback animated fadeInDown',
            /*errorPlacement: function(error, element) {
             error.appendTo(element.parent().parent());
             },*/
            errorPlacement: function (e, a) {
                jQuery(a).parents(".form-group").append(e)
            },
            highlight: function (e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
            },
            success: function (e) {
                jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
            },
            rules: {
                'class_select': {
                    required: true
                },
                'section_select': {
                    required: true
                },
                'criteria_select': {
                    required: true
                },
                'employee_select': {
                    required: {
                        depends: function () {
                            return $('#section_select').val() == 1
                        }
                    }
                }
            },
            messages: {
                'class_select[]': {
                    required: "This field is required."
                },
                'section_select': {
                    required: "This field is required."
                },
                'criteria_select': {
                    required: "This field is required."
                },
                'employee_select': {
                    required: "This field is required."
                }
            }
        });

        $('#btn_refresh').on('click', function () {
            if ($('#form_analysis').valid()) {
                //form is valid
                //console.log('valid');
                var class_id = $('#class_select').select2('val');
                var section_id = $('#section_select').val();
                var criteria_id = $('#criteria_select').val();
                var employee_id = $('#employee_select').val();

                getAnalysisData(class_id, section_id, criteria_id, employee_id);


            } else {
                // form is invalid

                console.log('else');
            }
        });
        //on section change
        $('#section_select').on('change', function () {
            var sectionid = $(this).val();
            var class_id = $('#class_id').val();
            $('#class_select option[value = 0]').remove();
            if (sectionid != 1) {
                $('#class_select').append($('<option>', {
                    value: 0,
                    text: 'All Class'
                }));
            }
            //get criteria list
            $.ajax({
                url: base_url + 'backoffice/Analysis/getCriteriaEmpList',
                type: 'post',
                data: {'section_id': sectionid, 'class_id': class_id},
                success: function (response) {
                    response = JSON.parse(response);


                    //$('#criteria_select').html('');

                    //set criteria list
                    var option = '';
                    if (response.employee_list.length > 0)
                        option += '<option value="0">All Criterias</option>';
                    $.each(response.criteria_list, function (index, value) {
                        option += '<option value="' + value.criteria_id + '">' + value.criteria_name + '</option>';
                    });
                    $('#criteria_select').html(option);


                    //set employee list
                    var option = '';

                    // option += '<option value="0">All Employees</option>';
                    $.each(response.employee_list, function (index, value) {
                        option += '<option value="' + value.emp_code + '">' + value.emp_name + '</option>';
                    });
                    $('#employee_select').html(option);


                },
                error: function (response) {
                    console.log(response);
                }
            });
        });


        //on class change
        $('#class_select').on('change', function () {
            var class_id = $(this).val();
            var section_id = $('#section_select').val();
            console.log(class_id);
            if (section_id == 1) {
                //get criteria list
                $.ajax({
                    url: base_url + 'backoffice/Analysis/getEmpList',
                    type: 'post',
                    data: {'class_id': class_id},
                    success: function (response) {
                        response = JSON.parse(response);


                        //set employee list
                        var option = '';
                        //option += '<option value="">Select Employee</option>';
                        $.each(response.employee_list, function (index, value) {
                            option += '<option value="' + value.emp_code + '">' + value.emp_name + '</option>';
                        });
                        $('#employee_select').html(option);

                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            }
        });


        //Section select2
        $('#class_select').select2({
            placeholder: "Select a Class"
        });

        //Section select2
        $('#section_select').select2({
            placeholder: "Select a Section"
        });

        //Criteria select2
        $('#criteria_select').select2({
            placeholder: "Select a Criteria"
        });


        //select2
        $('.select2').select2({
            //allowClear: true,
            dropdownAutoWidth: true
        });
    });
</script>


