<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<script type="text/javascript">
    // generateDonutBuyer('<?php echo date('Y-m-d'); ?>', '<?php echo date('Y-m-d'); ?>');
    // generateDonutUser('<?php echo date('Y-m-d'); ?>', '<?php echo date('Y-m-d'); ?>');

    $('.clreservationdate').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    function getByBuyerPeriod() {
        event.preventDefault();
        generateDonutBuyer($('#idstartdatebuyer').val(), $('#idenddatebuyer').val());
    }

    function getByUserPeriod() {
        event.preventDefault();
        generateDonutUser($('#idstartdateuser').val(), $('#idenddateuser').val());
    }

    function generateDonutBuyer(startdate, enddate) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'home/getChartByBuyerPeriod'; ?>',
            data: {
                startdate: startdate,
                enddate: enddate,
            },
            async: false,
            success: function(data) {
                printDonutChart(data, '#pieChartBuyer');
            }
        });
    }

    function generateDonutUser(startdate, enddate) {
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() . 'home/getChartByUserPeriod'; ?>',
            data: {
                startdate: startdate,
                enddate: enddate,
            },
            async: false,
            success: function(data) {
                printDonutChart(data, '#pieChartUser');
            }
        });
    }

    function printDonutChart(pieData, element) {

        var pieChartCanvas = $(element).get(0).getContext('2d')
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,

            legend: {
                display: true,
                position: 'chartArea'
            }
        }
        var canvasChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
        canvasChart.clear();
        canvasChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    }

    // var resultProcessed;
    // var resultSuccessValidation;
    // var getProcessed =
    //     $.ajax({
    //         type: 'GET',
    //         url: '<?php echo base_url() . 'home/getProcessed'; ?>',
    //         async: false,
    //         success: function(data) {
    //             resultProcessed = data;
    //             if (data.code == 200) {
    //                 $('#idprocessed').text(data.data_count);
    //                 $('.overlay-processed').fadeOut();
    //             }
    //         }
    //     });

    // var getSuccessValidation =
    //     $.ajax({
    //         type: 'GET',
    //         url: '<?php echo base_url() . 'home/getSuccessValidation'; ?>',
    //         async: false,
    //         success: function(data) {
    //             resultSuccessValidation = data;
    //             if (data.code == 200) {
    //                 $('#idvalidationsuccess').text(data.data_count);
    //                 $('.overlay-validation-success').fadeOut();
    //             }
    //         }
    //     });

    // var getProcessedToday =
    //     $.ajax({
    //         type: 'GET',
    //         url: '<?php echo base_url() . 'home/getProcessedToday'; ?>',
    //         async: false,
    //         success: function(data) {
    //             resultSuccessValidation = data;
    //             if (data.code == 200) {
    //                 $('#idprocessedtoday').text(data.data_count);
    //                 $('.overlay-processed-today').fadeOut();
    //             }
    //         }
    //     });

    // $.when(getSuccessValidation, getProcessed).then(function() {
    //     var processed = parseInt($('#idprocessed').text());
    //     var valSuccess = parseInt($('#idvalidationsuccess').text());
    //     var valErr = processed - valSuccess;
    //     $('#idvalidationerror').text(valErr);
    //     $('.overlay-validation-error').fadeOut();
    // });
</script>