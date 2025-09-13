<!-- Footer opened -->
<div class="main-footer ht-40">
	<div class="container-fluid pd-t-0-f ht-100p">
		<span>Copyright &copy; <?php echo date('Y'); ?><a href="https://www.africacdc.org/">Africa CDC</a> All rights
			reserved.</span>
	</div>
</div>
<!-- Footer closed -->


<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

<!-- JQuery min js -->
<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>

<!-- Popper js -->
<script src="<?php echo base_url() ?>assets/plugins/popper/popper.min.js"></script>

<!-- Bootstrap Bundle js -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Ionicons js -->
<script src="<?php echo base_url() ?>assets/plugins/ionicons/ionicons.js"></script>

<!-- Moment js -->
<script src="<?php echo base_url() ?>assets/plugins/moment/moment.js"></script>

<!-- Sparkline js -->
<script src="<?php echo base_url() ?>assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- Piety js -->
<script src="<?php echo base_url() ?>assets/plugins/peity/jquery.peity.min.js"></script>



<!-- Horizontalmenu js-->
<script src="<?php echo base_url() ?>assets/plugins/horizontal-menu/horizontal-menu.js"></script>

<!--- Colorchange js -->
<script src="<?php echo base_url() ?>assets/js/color-change.js"></script>

<!-- Internal Flot js-->
<script src="<?php echo base_url() ?>assets/plugins/jquery.flot/jquery.flot.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery.flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery.flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/jquery.flot/jquery.flot.categories.js"></script>

<!-- Internal Chart js-->
<script src="<?php echo base_url() ?>assets/plugins/chart.js/Chart.bundle.min.js"></script>

<!-- Rating js-->
<script src="<?php echo base_url() ?>assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/rating/jquery.barrating.js"></script>

<!-- Internal Echart Plugin -->
<script src="<?php echo base_url() ?>assets/plugins/echart/echart.js"></script>

<!-- Tooltip js -->
<script src="<?php echo base_url() ?>assets/js/tooltip.js"></script>

<!-- Internal Index js -->
<script src="<?php echo base_url() ?>assets/js/index.js" id="change-js"></script>
<script src="<?php echo base_url() ?>assets/js/dashboard.sampledata.js"></script>
<script src="<?php echo base_url() ?>assets/js/chart.flot.sampledata.js"></script>



<!-- Custom js -->
<script src="<?php echo base_url() ?>assets/js/custom.js"></script>

<!-- Add Select2 Nodemodules -->
<link href="<?php echo base_url() ?>node_modules/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url() ?>node_modules/select2/dist/js/select2.min.js"></script>


<!-- Add Sweetalert2 Nodemodule -->
<script src="<?php echo base_url() ?>node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

<!-- Right-sidebar js -->

<!-- Notify.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script type="text/javascript"
	src="https://cdn.datatables.net/v/dt/dt-1.13.1/b-2.3.3/b-html5-2.3.3/datatables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



<script>
$('#disease_selector').select2({
  placeholder: 'Select Disease or Condition',
  allowClear: true,
  width: '100%'
});

    $(document).ready(function () {
  var container = document.querySelector('.scroll-wrapper');
  if (container) {
    new PerfectScrollbar(container);
  }
});
	$(document).ready(function () {
		// Handle deactivate button click
		// CSRF token from a meta tag or hidden input
       var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
	   var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

    // Handle deactivate button click
    $('.deactivate-btn').click(function () {
        var id = $(this).data('id');
        var row = $('#outbreak-' + id);

        swal({
            title: "Are you sure?",
            text: "This will deactivate the outbreak.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDeactivate) => {
            if (willDeactivate) {
                // Make an AJAX POST request to update the status
                $.ajax({
                    url: "<?= site_url('outbreaks/edit/'); ?>" + id + "/inactive",
                    type: "POST",
                    data: { [csrfName]: csrfHash },
                    success: function (response) {
                        swal("Success!", "The outbreak has been deactivated.", "success");
                        row.find('.status').text('Inactive');
                    },
                    error: function () {
                        swal("Error!", "Failed to deactivate the outbreak.", "error");
                    }
                });
            }
        });
    });



	
    // Get CSRF token from a meta tag or hidden input
            var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
			var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

			// Handle delete button click
			$('.delete-btn').click(function () {
				var id = $(this).data('id');
				var row = $('#outbreak-' + id);

				swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this outbreak!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				}).then((willDelete) => {
					if (willDelete) {
						// Make an AJAX POST request to delete the outbreak
						$.ajax({
							url: "<?= site_url('outbreaks/delete/'); ?>" + id,
							type: "POST",
							data: { [csrfName]: csrfHash },
							success: function (response) {
								swal("Deleted!", "The outbreak has been deleted.", "success");
								row.remove();
							},
							error: function () {
								swal("Error!", "Failed to delete the outbreak.", "error");
							}
						});
					}
				});
			});
		


		// Handle edit button click
		$('.edit-btn').click(function () {
			var id = $(this).data('id');
			var row = $('#outbreak-' + id);
			$('#outbreakId').val(id);
			$('#outbreakName').val(row.find('td:eq(1)').text());
			$('#outbreakType').val(row.find('td:eq(2)').text());
			$('#startDate').val(row.find('td:eq(3)').text());
			$('#endDate').val(row.find('td:eq(4)').text() !== 'Ongoing' ? row.find('td:eq(4)').text() : '');
			$('#severityLevel').val(row.find('td:eq(5)').text().toLowerCase());
			$('#status').val(row.find('.status').text().toLowerCase());
			$('#updateModal').modal('show');
		});


		var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

		// Handle form submission for updating
		$('#updateForm').submit(function (e) {
			e.preventDefault();
			var id = $('#outbreakId').val();
			var formData = $(this).serializeArray();

			// Add CSRF token to formData
			formData.push({ name: csrfName, value: csrfHash });

			$.post("<?= site_url('outbreaks/edit/'); ?>" + id, formData, function (response) {
				swal("Success!", "The outbreak has been updated successfully.", "success").then(() => {
					location.reload();
				});
			}).fail(function () {
				swal("Error!", "Failed to update the outbreak.", "error");
			});
		});
	});

</script>


<script>
	$(document).ready(function () {
		$('.select2').select2();
	});
</script>




    

<script>
    $(document).ready(function() {
		var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
		var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
        $("#data-table").DataTable({
            "paging": true,
            "pageLength": 20,
            "searching": true,
            "ordering": true,
            "info": true,
            dom: 'Bfrtip', // Enables buttons
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Export CSV',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    className: 'btn btn-success'
                }
            ]
        });
    });

 $(document).on("click", ".verify-button", function() {
    var csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash(); ?>";
    var rowId = $(this).data("id");
    var table = $(this).data("table");
    var button = $(this);

    $.post("<?php echo base_url()?>data/verify_status/" + table, {
        id: rowId,
        [csrfName]: csrfHash // Include CSRF token
    }, function(response) {
        if (response.success) {
            button.toggleClass("btn-danger btn-success").text(response.status);
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Verification status updated successfully!",
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Verification update failed. Please try again.",
            });
        }
    }, "json").fail(function() {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Server error. Please check your network or try again later.",
        });
    });
});
$(document).on("blur", "td[contenteditable=true]", function() {
    var csrfName = "<?= $this->security->get_csrf_token_name(); ?>";
    var csrfHash = "<?= $this->security->get_csrf_hash(); ?>";
    var rowId = $(this).closest("tr").data("id");
    var table = $(this).closest("tr").data("table");
    var field = $(this).data("field");
    var value = $(this).text();

    $.post("<?php echo base_url()?>data/update_field/" + table, {
        id: rowId,
        field: field,
        value: value,
        [csrfName]: csrfHash // Include CSRF token
    }, function(response) {
        if (response.success) {
            $.notify("Data Updated", { className: "success", position: "top right" });
        } else {
            $.notify("Update failed: " + response.message, { className: "error", position: "top right" });
        }
    }, "json").fail(function() {
        $.notify("Server error. Please try again later.", { className: "error", position: "top right" });
    });
});


$(document).ready(function () {
    $("#tables_data").on("submit", function (event) {
        event.preventDefault(); // Prevent default form submission (Page reload)

        var form = $(this);
        var formData = form.serialize(); // Serialize form data

        // Include CSRF Token
        formData += "&" + $("input[name='<?= $this->security->get_csrf_token_name(); ?>']").serialize();

        $.ajax({
            url: form.attr("action"), // Gets the action URL dynamically
            type: "POST",
            data: formData,
            dataType: "json",
            beforeSend: function () {
                $("button[type='submit']").prop("disabled", true); // Disable button to prevent multiple submissions
            },
            success: function (response) {
                if (response.success) {
                    $.notify("Form Data Saved successfully!", { className: "success", position: "top right" });

                    // Optionally, reset the form after submission
                    $("#tables_data")[0].reset();
                } else {
                    $.notify("Error: " + response.message, { className: "error", position: "top right" });
                }
            },
            error: function () {
                $.notify("Server error. Please try again later.", { className: "error", position: "top right" });
            },
            complete: function () {
                $("button[type='submit']").prop("disabled", false); // Re-enable button
            }
        });
    });
});



</script>

<script type="text/javascript">
$(document).ready(function () {

  handleFilterChange();
  renderContinentalChart();
  renderDiseaseProbabilityGauge();

  $('#member_state, #period, #thematic_area, #prioritisation_category').change(() => {
    handleFilterChange();
    renderDiseaseProbabilityGauge($('#disease_selector').val());
  });

  $('#disease_selector').change(() => {
    renderDiseaseProbabilityGauge($('#disease_selector').val());
  });

  $('#save-draft').click(() => saveAllChanges(1));
  $('#final-submit').click(() => $('#confirmFinalModal').modal('show'));
  $('#confirmFinalSubmit').click(() => {
    $('#confirmFinalModal').modal('hide');
    saveAllChanges(0);
  });
});

function handleFilterChange() {
  const filters = getFilters();
  loadRankingForm(filters);
  renderChartByThematicArea(filters);
  renderChartByProbability(filters);
}

function getFilters() {
  return {
    member_state_id: $('#member_state').val(),
    period: $('#period').val(),
    thematic_area_id: $('#thematic_area').val(),
    prioritisation_category_id: $('#prioritisation_category').val(),
    disease_id: $('#disease_selector').val()
  };
}

function loadRankingForm(filters) {
  const tableBody = $('#ranking-body');

  // Temporary placeholder during fetch
  tableBody.html(`
    <tr class="table-placeholder">
      <td colspan="6" class="text-center text-muted" style="height: 150px;">
        Loading...
      </td>
    </tr>
  `);

  $.post('<?= base_url() ?>records/load_ranking_form', filters, function (html) {
    // Inject new rows with fade effect
    tableBody.fadeOut(100, function () {
      tableBody.html(html).fadeIn(200);
    });
  }).fail(function () {
    tableBody.html(`
      <tr>
        <td colspan="6" class="text-center text-danger" style="height: 150px;">
          Failed to load data.
        </td>
      </tr>
    `);
  });
}

function renderChartByThematicArea(filters) {
  fetch('<?= base_url('records/get_disease_chart_data') ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(filters)
  })
    .then(res => res.json())
    .then(data => {
      const categories = data.map(item => item.thematic_area);
      const counts = data.map(item => parseInt(item.total));
      const colors = ['#B3B3B3'];
      const seriesData = counts.map((count, i) => ({ y: count, color: colors[i % colors.length] }));

      Highcharts.chart('priority-disease-chart', {
        chart: { type: 'bar', backgroundColor: '#ffffff' },
        title: { text: 'Shortlisted Diseases by Thematic Area' },
        xAxis: { categories, title: null },
        yAxis: {
          min: 0,
          title: { text: 'Number of Diseases' },
          allowDecimals: false
        },
        plotOptions: { bar: { dataLabels: { enabled: true } } },
        legend: { enabled: false },
        credits: { enabled: false },
        series: [{ name: 'Diseases', data: seriesData }]
      });
    });
}

function renderChartByProbability(filters) {
  fetch('<?= base_url('records/get_disease_probability_chart_data') ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(filters)
  })
    .then(res => res.json())
    .then(data => {
      const seriesData = data.map(item => {
        const probPercent = parseFloat(item.probability) * 100;
        let color;

        if (probPercent > 80) {
          color = '#CE1126'; // High - Red
        } else if (probPercent >= 65) {
          color = '#FCD116'; // Medium - Yellow
        } else {
          color = '#007749'; // Low - Green
        }

        return { name: item.disease_name, y: probPercent, color };
      });

      Highcharts.chart('priority-probability-chart', {
        chart: { type: 'bar', backgroundColor: '#fff' },
        title: { text: 'Priority Diseases & Conditions Ranked by Probabilities' },
        xAxis: { type: 'category', title: null },
        yAxis: {
          max: 100,
          title: { text: 'Probability (%)' },
          labels: { format: '{value}%' }
        },
        tooltip: { pointFormat: '<b>{point.y:.1f}%</b>' },
        plotOptions: {
          bar: { dataLabels: { enabled: true, format: '{point.y:.1f}%' } }
        },
        legend: { enabled: false },
        credits: { enabled: false },
        series: [{ name: 'Probability', data: seriesData }]
      });
    });
}


function renderContinentalChart() {
  fetch('<?= base_url('records/get_continental_disease_chart_data') ?>')
    .then(res => res.json())
    .then(data => {
      const categories = data.map(item => item.thematic_area);
      const counts = data.map(item => parseInt(item.total));
      const colors = ['#B3B3B3'];
      const seriesData = counts.map((count, i) => ({ y: count, color: colors[i % colors.length] }));

      Highcharts.chart('continental-disease-chart', {
        chart: { type: 'bar', backgroundColor: '#fff' },
        title: { text: 'Continental Shortlisted Diseases & Conditions by Thematic Area' },
        xAxis: { categories, title: null },
        yAxis: {
          min: 0,
          title: { text: 'Number of Diseases' },
          allowDecimals: false
        },
        plotOptions: { bar: { dataLabels: { enabled: true } } },
        legend: { enabled: false },
        credits: { enabled: false },
        series: [{ name: 'Diseases', data: seriesData }]
      });
    });
}

function renderDiseaseProbabilityGauge(diseaseId = null) {
  const filters = getFilters();

  fetch('<?= base_url('records/get_disease_probability_gauge') ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(filters)
  })
    .then(res => res.json())
    .then(probability => {
      const probValue = parseFloat(probability) || 0;
      const probPercent = probValue * 100;

      let color = '#007749'; // Default: low
      if (probPercent > 80) {
        color = '#CE1126'; // High
      } else if (probPercent >= 65) {
        color = '#FCD116'; // Medium
      }

      Highcharts.chart('disease-probability-gauge', {
        chart: {
          type: 'gauge',
          plotBackgroundColor: null,
          plotBorderWidth: 0,
          plotShadow: false,
          height: '90%'
        },
        title: { text: '' },
        subtitle: { text: '' },
        pane: {
          startAngle: -90,
          endAngle: 89.9,
          background: {
            backgroundColor: '#f0f0f0',
            innerRadius: '90%',
            outerRadius: '100%',
            shape: 'arc'
          },
          center: ['50%', '70%'],
          size: '90%'
        },
        yAxis: {
          min: 0,
          max: 100,
          tickPixelInterval: 72,
          tickPosition: 'inside',
          tickColor: '#FFFFFF',
          tickLength: 20,
          tickWidth: 2,
          minorTickInterval: null,
          labels: {
            distance: 20,
            style: { fontSize: '14px' }
          },
          lineWidth: 0,
          plotBands: [{
            from: 0,
            to: probPercent,
            color: color
          }]
        },
        series: [{
          name: 'Probability',
          data: [parseFloat(probPercent.toFixed(1))],
          tooltip: { valueSuffix: ' %' },
          dataLabels: {
            format: '{y} %',
            borderWidth: 0,
            style: { fontSize: '16px' }
          },
          dial: {
            radius: '80%',
            backgroundColor: 'gray',
            baseWidth: 12,
            baseLength: '0%',
            rearLength: '0%'
          },
          pivot: {
            backgroundColor: 'gray',
            radius: 6
          }
        }],
        credits: { enabled: false }
      });
    });
}


function saveAllChanges(draft_status) {
  let changes = [];
  let hasEmpty = false;

  $('.param-select').each(function () {
    const val = $(this).val();
    if (val === "") {
      hasEmpty = true;
      $(this).addClass('is-invalid');
    } else {
      $(this).removeClass('is-invalid');
      changes.push({
        member_state_id: $('#member_state').val(),
        period: $('#period').val(),
        prioritisation_category_id: $('#prioritisation_category').val(),
        disease_id: $(this).data('disease'),
        param: $(this).data('param'),
        creteria: val,
        draft_status
      });
    }
  });

  if (hasEmpty && draft_status === 0) {
    show_notification('Please fill all required fields before final submission.', 'error');
    return;
  }

  if (changes.length > 0) {
    $.post('<?= base_url() ?>records/save_all_ranking_data', { changes }, function () {
      const msg = (draft_status === 1) ? 'Draft saved successfully.' : 'Final submission completed.';
      show_notification(msg, 'success');
      if (draft_status === 0) {
        setTimeout(() => location.reload(), 1500);
      } else {
        handleFilterChange();
      }
    }).fail(() => show_notification('Failed to save data.', 'error'));
  } else {
    show_notification('Nothing to save.', 'info');
  }
}

function show_notification(message, msgtype = 'info') {
  $.notify(message, {
    className: msgtype,
    position: "top right",
    autoHideDelay: 5000
  });
}
</script>


<script>
  $(document).ready(function() {

    var message = "<?php echo $this->session->tempdata('msg'); ?>";
    var msgtype = "<?php echo $this->session->tempdata('type'); ?>";
    if (msgtype !== '') {
  
      show_notification(message, msgtype);
    }
    <?php
    $_SESSION['type'] = '';
    $_SESSION['msg'] = '';
    ?>

  });



  ///get diseases
  $(document).ready(function () {
  function fetchDiseases(member_state_id) {
    $.post("<?= base_url('records/get_diseases_by_country') ?>", 
      { member_state_id: member_state_id }, 
      function (response) {
        const diseases = JSON.parse(response);
        const selector = $('#disease_selector');

        // Clear previous options except the placeholder
        selector.find('option:not(:first)').remove();

        // Append new options
        diseases.forEach(function (disease) {
          selector.append(`<option value="${disease.disease_id}">${disease.name}</option>`);
        });

        selector.trigger('change.select2');
      }
    );
  }

  // On country change (for admins)
  $('#member_state').on('change', function () {
    fetchDiseases($(this).val());
  });

  // Auto-load on page load based on current selected country
  fetchDiseases($('#member_state').val());
});

</script>


  
</body>

</html>