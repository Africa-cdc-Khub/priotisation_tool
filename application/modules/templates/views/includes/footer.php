<!-- Footer opened -->
<div class="main-footer ht-40">
	<div class="container-fluid pd-t-0-f ht-100p">
		<span>Copyright &copy; <?php echo date('Y'); ?><a href="https://www.africacdc.org/">Africa CDC</a> All rights
			reserved.</span>
	</div>
</div>
<!-- Footer closed -->
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/lobibox@1.2.7/dist/js/lobibox.min.js"></script>

	<script src="https://code.highcharts.com/highcharts.js"></script>

	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	<script src="https://code.highcharts.com/modules/boost.js"></script>
	<script src="https://code.highcharts.com/highcharts-more.js"></script>
	<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>

	
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<!-- SweetAlert2 CSS and JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Additional required libraries -->
	<script src="https://cdn.jsdelivr.net/npm/notify-js@0.4.2/notify.min.js"></script>
<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

<!-- JQuery min js -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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


<!-- Notify.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

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
	//use if u need to set a langauge from the database
	//  $(document).ready(function () {
	//     doGTranslate('en'); // Translate the page in the user langauge
	//   });
	function GTranslateGetCurrentLang() { var keyValue = document['cookie'].match('(^|;) ?googtrans=([^;]*)(;|$)'); return keyValue ? keyValue[2].split('/')[2] : null; }
	function GTranslateFireEvent(element, event) { try { if (document.createEventObject) { var evt = document.createEventObject(); element.fireEvent('on' + event, evt) } else { var evt = document.createEvent('HTMLEvents'); evt.initEvent(event, true, true); element.dispatchEvent(evt) } } catch (e) { } }

	function doGTranslate(lang_code) {


		var lang = lang_code || 'en'; // transalte to provided langauge
		var teCombo = document.querySelector('select.goog-te-combo:not(.menu-language-menu-container select)');

		if (!teCombo || !teCombo.innerHTML) {
			setTimeout(function () { doGTranslate(lang_code) }, 500);
			return;
		}

		var langIndex = Array.from(teCombo.options).findIndex(option => option.value === lang);

		if (langIndex !== -1) {
			teCombo.selectedIndex = langIndex;
			GTranslateFireEvent(teCombo, 'change');
			GTranslateFireEvent(teCombo, 'change');
		}
	}


</script>

<script type="text/javascript"
	src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script src="<?php echo base_url(); ?>resources/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>resources/js/slick.js"></script>
<script src="<?php echo base_url(); ?>resources/js/slider-bg.js"></script>
<script src="<?php echo base_url(); ?>resources/js/smoothproducts.js"></script>
<script src="<?php echo base_url(); ?>resources/js/snackbar.min.js"></script>
<script src="<?php echo base_url(); ?>resources/js/jQuery.style.switcher.js"></script>
<script src="<?php echo base_url(); ?>resources/js/custom.js"></script>


<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="<?php echo base_url()?>assets/js/notify.min.js"></script>
<script>
	$(document).ready(function () {
		$('#search-button').on('click', function () {
			performSearch();
		});

		$('#search-input').on('keypress', function (e) {
			if (e.which === 13) {
				performSearch();
			}
		});

		function performSearch() {
			var searchTerm = $('#search-input').val();
			$.ajax({
				url: '<?= site_url('records/search') ?>',
				method: 'GET',
				data: { term: searchTerm },
				success: function (response) {
					$('#outbreak-events').html(response);
				},
				error: function () {
					alert('An error occurred while searching. Please try again.');
				}
			});
		}
	});
</script>

<script>
	setTimeout(function () {
		var alert = document.getElementById('autoHideAlert');
		if (alert) {
			alert.style.transition = 'opacity 0.5s';
			alert.style.opacity = '0';
			setTimeout(function () {
				alert.style.display = 'none';
			}, 500);
		}
	}, 3000);
</script>


<script type="text/javascript">
$(document).ready(function () {
 

  handleFilterChange();
  renderContinentalChart();
  renderDiseaseProbabilityGauge();

  $('#region, #member_state, #period, #thematic_area, #prioritisation_category').change(() => {
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
    region_id: $('#region').val(),
    member_state_id: $('#member_state').val(),
    period: $('#period').val(),
    thematic_area_id: $('#thematic_area').val(),
    prioritisation_category_id: $('#prioritisation_category').val(),
    disease_id: $('#disease_selector').val()
  };
}

function loadRankingForm(filters) {
  console.log('Loading ranking form with filters:', filters);
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

function show_notification(message, msgtype) {
  Lobibox.notify(msgtype, {
    pauseDelayOnHover: true,
    position: 'top right',
    icon: 'bx bx-check-circle',
    msg: message
  });
}

$('#changePass').submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    var url = '<?php echo base_url()?>auth/changePass';
    console.log(data);
    $.ajax({
        url: url,
        method: "post",
        data: data,
        success: function(res) {

                show_notification(res, 'success');
           
            //console.log(res);
        }
    });
});

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
          selector.append('<option value="' + disease.disease_id + '">' + disease.name + '</option>');
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

<script>
$(document).ready(function() {
    // For non-admin users, ensure region is selected and trigger change
    
    $('#region').on('change', function() {
        const regionId = $(this).val();

        // Only proceed if a region is selected
        if (regionId) {
            $.ajax({
                url: 'http://localhost/priotisation_tool/records/get_countries_by_region',
                type: 'POST',
                data: { region_id: regionId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const countries = response.countries;
                        let options = '<option value="">-- Select Country --</option>';
                        countries.forEach(function(country) {
                            // For non-admin users, pre-select their country
                            let selected = '';
                            options += '<option value="' + country.id + '" ' + selected + '>' + country.member_state + '</option>';
                        });
                        $('#member_state').html(options);
                    } else {
                        $('#member_state').html('<option value="">No countries found</option>');
                    }
                },
                error: function() {
                    $('#member_state').html('<option value="">Error loading countries</option>');
                }
            });
        } else {
            $('#member_state').html('<option value="">-- Select Country --</option>');
        }
    });
});
</script>



<script>
$(document).ready(function() {
    // Region-Country chaining
    $('#region').on('change', function() {
        const regionId = $(this).val();
        
        if (regionId) {
            $.ajax({
                url: '<?= site_url("records/get_countries_by_region") ?>',
                type: 'POST',
                data: { region_id: regionId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const countries = response.countries;
                        let options = '<option value="">All Countries</option>';
                        countries.forEach(function(country) {
                            options += '<option value="' + country.id + '">' + country.member_state + '</option>';
                        });
                        $('#member_state').html(options);
                    } else {
                        $('#member_state').html('<option value="">No countries found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    $('#member_state').html('<option value="">Error loading countries</option>');
                }
            });
        } else {
            // Reset to default options
            $('#member_state').html('<option value="">All Countries</option>');
        }
    });

    // Initialize components with proper delays
    let initTimeout1 = setTimeout(function() {
        testHighchartsMap(); // Test Highcharts availability first
        initializeAfricaMap();
    }, 1000);
    
    let initTimeout2 = setTimeout(function() {
        loadMapData();
    }, 1500);
    
    // Filter buttons
    $('#apply-filters').click(function() {
        loadMapData();
        refreshDataTable();
    });
    
    $('#reset-filters').click(function() {
        $('#region, #member_state, #thematic_area, #prioritisation_category').val('');
        $('#period').val('<?= date('Y') ?>');
        loadMapData();
        refreshDataTable();
    });
    
    // Initialize DataTable after a short delay to ensure DOM is ready
    setTimeout(function() {
        console.log('Attempting to initialize DataTable...');
        console.log('Table element exists:', $('#ranking-datatable').length > 0);
        console.log('jQuery DataTable available:', typeof $.fn.DataTable !== 'undefined');
        
        // Only initialize if we're on the dashboard page
        if ($('#ranking-datatable').length > 0) {
            initializeDataTable();
        }
    }, 3000); // Increased delay to ensure all libraries are loaded
    
    // Refresh table button
    $('#refresh-table').click(function() {
        refreshDataTable();
    });
});

function initializeAfricaMap() {
    console.log('Initializing Africa map with OpenStreetMap...');
    
    // Use OpenStreetMap instead of Highcharts map
    initializeOpenStreetMap();
}

function initializeOpenStreetMap() {
    const container = document.getElementById('africa-map');
    if (!container) {
        console.error('Africa map container not found');
        return;
    }
    
    console.log('Initializing OpenStreetMap...');
    
    // Load Leaflet CSS and JS
    if (typeof L === 'undefined') {
        // Load Leaflet CSS
        if (!document.querySelector('link[href*="leaflet"]')) {
            const leafletCSS = document.createElement('link');
            leafletCSS.rel = 'stylesheet';
            leafletCSS.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
            document.head.appendChild(leafletCSS);
        }
        
        // Load Leaflet JS
        $.getScript('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', function() {
            console.log('Leaflet loaded successfully');
            createOpenStreetMap();
        }).fail(function() {
            console.error('Failed to load Leaflet');
            showMapFallback([]);
        });
    } else {
        console.log('Leaflet already loaded');
        createOpenStreetMap();
    }
}

function createOpenStreetMap() {
    const container = document.getElementById('africa-map');
    if (!container || typeof L === 'undefined') {
        console.error('Container or Leaflet not available');
        return;
    }
    
    // Clear container
    container.innerHTML = '';
    
    // Initialize map centered on Africa with better bounds
    const map = L.map('africa-map', {
        center: [0, 20],
        zoom: 3,
        minZoom: 2,
        maxZoom: 6,
        zoomControl: true,
        scrollWheelZoom: true,
        doubleClickZoom: true,
        boxZoom: true,
        keyboard: true,
        dragging: true
    });
    
    // Set Africa bounds to keep focus on Africa
    const africaBounds = L.latLngBounds(
        L.latLng(-35, -20), // Southwest corner
        L.latLng(37, 55)    // Northeast corner
    );
    map.setMaxBounds(africaBounds);
    
    // Add CartoDB tiles with English labels for better readability
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors © CARTO',
        maxZoom: 18,
        subdomains: 'abcd',
        variant: 'light_all'
    }).addTo(map);
    
    // Store map reference for data loading
    window.africaMap = map;
    
    console.log('OpenStreetMap initialized successfully');
    
    // Load map data
    loadMapData();
}

// Removed loadAfricaMapData - using OpenStreetMap instead

function loadMapData() {
    console.log('Loading map data for OpenStreetMap...');
    
    const filters = {
        member_state_id: $('#member_state').val(),
        period: $('#period').val(),
        thematic_area_id: $('#thematic_area').val(),
        prioritisation_category_id: $('#prioritisation_category').val()
    };
    
    console.log('Map data filters:', filters);
    
    $.ajax({
        url: '<?= site_url("records/get_map_data") ?>',
        type: 'POST',
        data: filters,
        dataType: 'json',
        success: function(response) {
            console.log('Map data response:', response);
            if (response.status === 'success') {
                console.log('Map data loaded successfully, rendering OpenStreetMap...');
                renderOpenStreetMap(response.data);
            } else {
                console.error('Map data response error:', response.message);
                showMapFallback([]);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading map data:', error);
            console.error('Response:', xhr.responseText);
            showMapFallback([]);
        }
    });
}

function renderOpenStreetMap(mapData) {
    console.log('Rendering OpenStreetMap with data:', mapData);
    
    if (!window.africaMap || typeof L === 'undefined') {
        console.error('Map or Leaflet not available');
        showMapFallback(mapData);
        return;
    }
    
    const map = window.africaMap;
    
    // Clear existing country layer
    if (window.countryLayer) {
        map.removeLayer(window.countryLayer);
    }
    
    if (!mapData || mapData.length === 0) {
        console.warn('No map data available');
        showMapFallback(mapData);
        return;
    }
    
    console.log('Adding markers for', mapData.length, 'countries');
    
    // Country coordinates (simplified for Africa)
    const countryCoords = {
        'DZA': [28.0339, 1.6596], // Algeria
        'AGO': [-11.2027, 17.8739], // Angola
        'BEN': [9.3077, 2.3158], // Benin
        'BWA': [-22.3285, 24.6849], // Botswana
        'BFA': [12.2383, -1.5616], // Burkina Faso
        'BDI': [-3.3731, 29.9189], // Burundi
        'CMR': [7.3697, 12.3547], // Cameroon
        'CPV': [16.5388, -24.0132], // Cape Verde
        'CAF': [6.6111, 20.9394], // Central African Republic
        'TCD': [15.4542, 18.7322], // Chad
        'COM': [-11.8750, 43.8722], // Comoros
        'COG': [-0.2280, 15.8277], // Congo
        'COD': [-4.0383, 21.7587], // Democratic Republic of the Congo
        'CIV': [7.5400, -5.5471], // Côte d'Ivoire
        'DJI': [11.8251, 42.5903], // Djibouti
        'EGY': [26.0975, 30.0444], // Egypt
        'GNQ': [1.6508, 10.2679], // Equatorial Guinea
        'ERI': [15.1794, 39.7823], // Eritrea
        'SWZ': [-26.5225, 31.4659], // Eswatini
        'ETH': [9.1450, 40.4897], // Ethiopia
        'GAB': [-0.8037, 11.6094], // Gabon
        'GMB': [13.4432, -15.3101], // Gambia
        'GHA': [7.9465, -1.0232], // Ghana
        'GIN': [9.6412, -9.6966], // Guinea
        'GNB': [11.8037, -15.1804], // Guinea-Bissau
        'KEN': [-0.0236, 37.9062], // Kenya
        'LSO': [-29.6100, 28.2336], // Lesotho
        'LBR': [6.4281, -9.4295], // Liberia
        'LBY': [26.3351, 17.2283], // Libya
        'MDG': [-18.7669, 46.8691], // Madagascar
        'MWI': [-13.2543, 34.3015], // Malawi
        'MLI': [17.5707, -3.9962], // Mali
        'MRT': [21.0079, -10.9408], // Mauritania
        'MUS': [-20.3484, 57.5522], // Mauritius
        'MAR': [31.6295, -7.9811], // Morocco
        'MOZ': [-18.6657, 35.5296], // Mozambique
        'NAM': [-22.9576, 18.4904], // Namibia
        'NER': [17.6078, 8.0817], // Niger
        'NGA': [9.0820, 8.6753], // Nigeria
        'RWA': [-1.9403, 29.8739], // Rwanda
        'STP': [0.1864, 6.6131], // São Tomé and Príncipe
        'SEN': [14.4974, -14.4524], // Senegal
        'SYC': [-4.6796, 55.4920], // Seychelles
        'SLE': [8.4606, -11.7799], // Sierra Leone
        'SOM': [5.1521, 46.1996], // Somalia
        'ZAF': [-30.5595, 22.9375], // South Africa
        'SSD': [6.8770, 31.3070], // South Sudan
        'SDN': [12.8628, 30.2176], // Sudan
        'TZA': [-6.3690, 34.8888], // Tanzania
        'TGO': [8.6195, 0.8248], // Togo
        'TUN': [33.8869, 9.5375], // Tunisia
        'UGA': [1.3733, 32.2903], // Uganda
        'ZMB': [-13.1339, 27.8493], // Zambia
        'ZWE': [-19.0154, 29.1549] // Zimbabwe
    };
    
    // Create a layer group for country polygons
    const countryLayer = L.layerGroup().addTo(map);
    window.countryLayer = countryLayer;
    
    // Add country polygons for each country
    mapData.forEach(function(item) {
        const coords = countryCoords[item.iso3_code];
        if (coords) {
            const priority = item.avg_priority || 0;
            const diseaseCount = item.total_diseases || 0;
            
            // Color based on priority level
            let color = '#28a745'; // Green for low priority
            let opacity = 0.3;
            if (priority > 7) {
                color = '#dc3545'; // Red for high priority
                opacity = 0.7;
            } else if (priority > 4) {
                color = '#ffc107'; // Yellow for medium priority
                opacity = 0.5;
            }
            
            // Create a larger circle to represent the country area
            const countryArea = L.circle(coords, {
                radius: 200000, // 200km radius to create country-like areas
                fillColor: color,
                color: '#fff',
                weight: 2,
                opacity: 1,
                fillOpacity: opacity
            });
            
            // Create popup content with English labels
            const popupContent = `
                <div style="min-width: 250px; font-family: Arial, sans-serif;">
                    <div style="text-align: center; margin-bottom: 10px;">
                        <h5 style="margin: 0; color: #2c3e50; font-weight: bold;"><strong>${item.member_state}</strong></h5>
                        <small style="color: #6c757d; font-size: 12px;">${item.region_name || 'N/A'}</small>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                        <div style="text-align: center; padding: 8px; background: #f8f9fa; border-radius: 5px;">
                            <div style="font-size: 18px; font-weight: bold; color: #007bff;">${diseaseCount}</div>
                            <div style="font-size: 12px; color: #6c757d;">Total Diseases</div>
                        </div>
                        <div style="text-align: center; padding: 8px; background: #f8f9fa; border-radius: 5px;">
                            <div style="font-size: 18px; font-weight: bold; color: ${priority > 7 ? '#dc3545' : priority > 4 ? '#ffc107' : '#28a745'};">${priority.toFixed(1)}</div>
                            <div style="font-size: 12px; color: #6c757d;">Avg Priority</div>
                        </div>
                    </div>
                    <div>
                        <strong style="color: #2c3e50; font-size: 13px;">Top Diseases:</strong>
                        <ul style="margin: 5px 0 0 0; padding-left: 15px; font-size: 13px;">
                            ${item.diseases ? item.diseases.slice(0, 3).map(d => `<li style="margin: 2px 0; color: #2c3e50;">${d.name}</li>`).join('') : '<li style="color: #6c757d;">No data available</li>'}
                        </ul>
                    </div>
                </div>
            `;
            
            countryArea.bindPopup(popupContent);
            countryArea.addTo(countryLayer);
            
            // Add a small marker in the center for better visibility
            const centerMarker = L.circleMarker(coords, {
                radius: 6,
                fillColor: '#fff',
                color: color,
                weight: 3,
                opacity: 1,
                fillOpacity: 1
            });
            centerMarker.bindPopup(popupContent);
            centerMarker.addTo(countryLayer);
        }
    });
    
    // Remove existing legend if it exists
    if (window.mapLegend) {
        map.removeControl(window.mapLegend);
        window.mapLegend = null;
    }
    
    // Add legend with English labels
    const legend = L.control({position: 'bottomright'});
    legend.onAdd = function(map) {
        const div = L.DomUtil.create('div', 'map-legend');
        div.style.cssText = 'background: white; padding: 10px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); font-size: 12px; font-family: Arial, sans-serif;';
        div.innerHTML = `
            <div style="font-weight: bold; margin-bottom: 8px; color: #2c3e50;">Priority Level</div>
            <div style="display: flex; align-items: center; margin: 3px 0;">
                <div style="width: 15px; height: 15px; background: #28a745; margin-right: 8px; border-radius: 3px;"></div>
                <span style="color: #2c3e50;">Low (0-4)</span>
            </div>
            <div style="display: flex; align-items: center; margin: 3px 0;">
                <div style="width: 15px; height: 15px; background: #ffc107; margin-right: 8px; border-radius: 3px;"></div>
                <span style="color: #2c3e50;">Medium (4-7)</span>
            </div>
            <div style="display: flex; align-items: center; margin: 3px 0;">
                <div style="width: 15px; height: 15px; background: #dc3545; margin-right: 8px; border-radius: 3px;"></div>
                <span style="color: #2c3e50;">High (7+)</span>
            </div>
        `;
        return div;
    };
    legend.addTo(map);
    
    // Store legend reference for future removal
    window.mapLegend = legend;
    
    console.log('OpenStreetMap markers added successfully');
}


var dataTable;

function initializeDataTable() {
    try {
        // Check if table element exists
        if ($('#ranking-datatable').length === 0) {
            console.log('DataTable element not found, skipping initialization');
            return;
        }
        
        // Check if jQuery DataTable is available
        if (typeof $.fn.DataTable === 'undefined') {
            console.error('jQuery DataTable not available');
            return;
        }
        
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#ranking-datatable')) {
            console.log('DataTable already initialized, destroying first');
            $('#ranking-datatable').DataTable().destroy();
        }
        
        console.log('Initializing DataTable...');
        
        // Test the data endpoint first
        $.ajax({
            url: '<?= site_url("records/test_ranking_data") ?>',
            type: 'GET',
            success: function(response) {
                console.log('Data test successful:', response);
                if (response.count === 0) {
                    console.warn('No data found in member_state_diseases_data table');
                }
            },
            error: function(xhr, status, error) {
                console.error('Data test failed:', error);
                console.error('Response:', xhr.responseText);
            }
        });
        
        // Test the AJAX endpoint
        $.ajax({
            url: '<?= site_url("records/get_ranking_data") ?>',
            type: 'POST',
            data: {
                draw: 1,
                start: 0,
                length: 10,
                member_state_id: $('#member_state').val() || '',
                period: $('#period').val() || '',
                thematic_area_id: $('#thematic_area').val() || '',
                prioritisation_category_id: $('#prioritisation_category').val() || '',
                region_id: $('#region').val() || ''
            },
            success: function(response) {
                console.log('AJAX test successful:', response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX test failed:', error);
                console.error('Response:', xhr.responseText);
            }
        });
        
        // Check if DataTables buttons are available
        var availableButtons = [];
        
        // Check for Excel button
        if (typeof $.fn.DataTable.ext.buttons.excelHtml5 !== 'undefined') {
            availableButtons.push({
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: 'Disease Ranking Data',
                filename: 'disease_ranking_data_' + new Date().toISOString().split('T')[0]
            });
        }
        
        // Check for CSV button
        if (typeof $.fn.DataTable.ext.buttons.csvHtml5 !== 'undefined') {
            availableButtons.push({
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-csv"></i> CSV',
                className: 'btn btn-info btn-sm',
                title: 'Disease Ranking Data',
                filename: 'disease_ranking_data_' + new Date().toISOString().split('T')[0]
            });
        }
        
        // Check for PDF button
        if (typeof $.fn.DataTable.ext.buttons.pdfHtml5 !== 'undefined') {
            availableButtons.push({
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Disease Ranking Data',
                filename: 'disease_ranking_data_' + new Date().toISOString().split('T')[0],
                orientation: 'landscape',
                pageSize: 'A4'
            });
        }
        
        // Check for Print button
        if (typeof $.fn.DataTable.ext.buttons.print !== 'undefined') {
            availableButtons.push({
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                className: 'btn btn-secondary btn-sm',
                title: 'Disease Ranking Data'
            });
        }
        
        console.log('Available buttons:', availableButtons.length);
        console.log('Button types available:', {
            excel: typeof $.fn.DataTable.ext.buttons.excelHtml5,
            csv: typeof $.fn.DataTable.ext.buttons.csvHtml5,
            pdf: typeof $.fn.DataTable.ext.buttons.pdfHtml5,
            print: typeof $.fn.DataTable.ext.buttons.print
        });
        
        // DataTable configuration
        var dataTableConfig = {
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url("records/get_ranking_data") ?>',
                type: 'POST',
                data: function(d) {
                    d.member_state_id = $('#member_state').val() || '';
                    d.period = $('#period').val() || '';
                    d.thematic_area_id = $('#thematic_area').val() || '';
                    d.prioritisation_category_id = $('#prioritisation_category').val() || '';
                    d.region_id = $('#region').val() || '';
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables AJAX error:', error);
                    console.error('Response:', xhr.responseText);
                }
            },
            columns: [
                { data: 0, title: 'Period' },
                { data: 1, title: 'Priority Level' },
                { data: 2, title: 'Region' },
                { data: 3, title: 'Country' },
                { data: 4, title: 'Disease Name' },
                { data: 5, title: 'Thematic Area' },
                { data: 6, title: 'Prevention' },
                { data: 7, title: 'Detection' },
                { data: 8, title: 'Morbidity' },
                { data: 9, title: 'Case Management' },
                { data: 10, title: 'Mortality' },
                { data: 11, title: 'Composite Index' },
                { data: 12, title: 'Probability' },
                { data: 13, title: 'Priority Level' },
                { data: 14, title: 'Status' },
                { data: 15, title: 'Created' },
                { data: 16, title: 'Updated' }
            ],
            order: [[13, 'desc']],
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            responsive: true,
            scrollX: true,
            language: {
                processing: "Loading data...",
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            initComplete: function() {
                console.log('DataTable initialized successfully');
            }
        };
        
        // Add buttons and DOM configuration if buttons are available
        if (availableButtons.length > 0) {
            dataTableConfig.dom = 'Bfrtip';
            dataTableConfig.buttons = availableButtons;
            dataTableConfig.language.buttons = {
                excel: "Export to Excel",
                csv: "Export to CSV",
                pdf: "Export to PDF",
                print: "Print"
            };
        } else {
            dataTableConfig.dom = 'frtip';
            console.warn('No export buttons available, using basic configuration');
        }
        
        // Initialize DataTable
        dataTable = $('#ranking-datatable').DataTable(dataTableConfig);
        
        // Add fallback print button if DataTables print is not available
        if (availableButtons.length > 0 && typeof $.fn.DataTable.ext.buttons.print === 'undefined') {
            // Add a custom print button
            setTimeout(function() {
                var printButton = $('<button class="btn btn-secondary btn-sm dt-button" style="margin-left: 5px;"><i class="fa fa-print"></i> Print</button>');
                $('.dt-buttons').append(printButton);
                
                printButton.on('click', function() {
                    window.print();
                });
            }, 1000);
        }
        
        console.log('DataTable initialization completed');
    } catch (error) {
        console.error('Error initializing DataTable:', error);
        
        // Fallback: Show a simple message
        $('#ranking-datatable tbody').html(`
            <tr>
                <td colspan="17" class="text-center text-danger">
                    <i class="fa fa-exclamation-triangle"></i>
                    Error loading data. Please refresh the page.
                </td>
            </tr>
        `);
    }
}

function refreshDataTable() {
    if (dataTable) {
        dataTable.ajax.reload();
    }
}

// DEPRECATED: Using OpenStreetMap instead
function renderAfricaMap(mapData) {
    console.log('DEPRECATED: renderAfricaMap called - using OpenStreetMap instead');
    showMapFallback(mapData);
    return;
    
    console.log('Rendering Africa map with data:', mapData);
    
    // Check if container exists
    const container = document.getElementById('africa-map');
    if (!container) {
        console.error('Africa map container not found');
        return;
    }
    
    console.log('Map container found:', container);
    
    // Check if Highcharts is available
    if (typeof Highcharts === 'undefined') {
        console.error('Highcharts not available');
        container.innerHTML = '<div class="text-center text-danger p-4"><i class="fa fa-exclamation-triangle"></i> Highcharts not loaded</div>';
        return;
    }
    
    if (typeof Highcharts.mapChart === 'undefined') {
        console.error('Highcharts mapChart not available, trying to load it...');
        
        // Try to load the map module dynamically
        $.getScript('https://code.highcharts.com/modules/map.js', function() {
            console.log('Map module loaded dynamically, retrying map render...');
            // Retry rendering after a short delay
            setTimeout(function() {
                renderAfricaMap(mapData);
            }, 500);
        }).fail(function() {
            console.error('Failed to load map module dynamically');
            // Show fallback table instead of error
            showMapFallback(mapData);
        });
        return;
    }
    
    console.log('Highcharts and mapChart are available');
    
    // Check if map data is empty
    if (!mapData || mapData.length === 0) {
        console.warn('No map data available');
        container.innerHTML = '<div class="text-center text-warning p-4"><i class="fa fa-info-circle"></i> No data available for the selected filters</div>';
        return;
    }
    
    console.log('Map data length:', mapData.length);
    
    // Prepare data for Highcharts map
    const mapSeriesData = mapData.map(function(item) {
        return {
            'hc-key': item.iso3_code.toLowerCase(),
            name: item.member_state,
            value: item.total_diseases || 0,
            diseases: item.diseases || [],
            region: item.region_name || '',
            priority_level: item.avg_priority || 0
        };
    });
    
    try {
        Highcharts.mapChart('africa-map', {
        chart: {
            map: 'custom/africa',
            backgroundColor: '#f8f9fa'
        },
        title: {
            text: 'Disease Prioritisation by Country',
            style: {
                color: '#2c3e50',
                fontSize: '18px',
                fontWeight: 'bold'
            }
        },
        subtitle: {
            text: 'Click on countries to view detailed disease rankings',
            style: {
                color: '#6c757d'
            }
        },
        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },
        colorAxis: {
            min: 0,
            stops: [
                [0, '#E8F5E8'],
                [0.5, '#FFE066'],
                [1, '#FF6B6B']
            ],
            labels: {
                style: {
                    color: '#2c3e50'
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            title: {
                text: 'Number of Diseases',
                style: {
                    fontWeight: 'bold'
                }
            }
        },
        series: [{
            data: mapSeriesData,
            name: 'Diseases',
            states: {
                hover: {
                    brightness: 0.1
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}',
                style: {
                    fontSize: '10px',
                    fontWeight: 'bold',
                    textOutline: '1px contrast'
                }
            },
            tooltip: {
                useHTML: true,
                formatter: function() {
                    const diseases = this.point.diseases || [];
                    let diseaseList = '';
                    if (diseases.length > 0) {
                        diseaseList = '<br><strong>Top Diseases:</strong><br>';
                        diseases.slice(0, 5).forEach(function(disease) {
                            diseaseList += '• ' + disease.name + ' (Priority: ' + disease.priority_level + ')<br>';
                        });
                        if (diseases.length > 5) {
                            diseaseList += '... and ' + (diseases.length - 5) + ' more';
                        }
                    }
                    
                    return '<div style="padding: 10px;">' +
                        '<h4 style="margin: 0 0 10px 0; color: #2c3e50;">' + this.point.name + '</h4>' +
                        '<p style="margin: 0;"><strong>Region:</strong> ' + this.point.region + '</p>' +
                        '<p style="margin: 0;"><strong>Total Diseases:</strong> ' + this.point.value + '</p>' +
                        '<p style="margin: 0;"><strong>Avg Priority:</strong> ' + this.point.priority_level.toFixed(2) + '</p>' +
                        diseaseList +
                        '</div>';
                }
            }
        }],
        credits: {
            enabled: false
        }
    });
    } catch (error) {
        console.error('Error rendering Africa map:', error);
        // Show error message in container
        const container = document.getElementById('africa-map');
        if (container) {
            // Show fallback table with map data
            let fallbackHtml = '<div class="text-center text-warning p-2"><i class="fa fa-exclamation-triangle"></i> Map rendering failed, showing data table instead</div>';
            fallbackHtml += '<div class="table-responsive"><table class="table table-striped table-sm">';
            fallbackHtml += '<thead><tr><th>Country</th><th>Region</th><th>Total Diseases</th><th>Avg Priority</th><th>Top Diseases</th></tr></thead><tbody>';
            
            mapData.forEach(function(item) {
                const topDiseases = item.diseases.slice(0, 3).map(d => d.name).join(', ');
                fallbackHtml += '<tr>';
                fallbackHtml += '<td>' + item.member_state + '</td>';
                fallbackHtml += '<td>' + item.region_name + '</td>';
                fallbackHtml += '<td>' + item.total_diseases + '</td>';
                fallbackHtml += '<td>' + item.avg_priority.toFixed(2) + '</td>';
                fallbackHtml += '<td>' + topDiseases + '</td>';
                fallbackHtml += '</tr>';
            });
            
            fallbackHtml += '</tbody></table></div>';
            container.innerHTML = fallbackHtml;
        }
    }
}

// Test function to check Highcharts map module availability
function testHighchartsMap() {
    console.log('Testing Highcharts map module...');
    console.log('Highcharts available:', typeof Highcharts !== 'undefined');
    console.log('Highcharts.mapChart available:', typeof Highcharts.mapChart !== 'undefined');
    console.log('Highcharts.map available:', typeof Highcharts.map !== 'undefined');
    
    if (typeof Highcharts !== 'undefined') {
        console.log('Highcharts version:', Highcharts.version);
        console.log('Available chart types:', Object.keys(Highcharts));
    }
    
    // Make it available globally for testing
    window.testHighchartsMap = testHighchartsMap;
}

// Fallback function to show map data as a table
function showMapFallback(mapData) {
    const container = document.getElementById('africa-map');
    if (!container) return;
    
    console.log('Showing map fallback table with data:', mapData);
    
    let fallbackHtml = '<div class="text-center text-warning p-2 mb-3"><i class="fa fa-info-circle"></i> Map unavailable, showing data table instead</div>';
    fallbackHtml += '<div class="table-responsive"><table class="table table-striped table-sm">';
    fallbackHtml += '<thead class="table-dark"><tr><th>Country</th><th>Region</th><th>Total Diseases</th><th>Avg Priority</th><th>Top Diseases</th></tr></thead><tbody>';
    
    if (mapData && mapData.length > 0) {
        mapData.forEach(function(item) {
            const topDiseases = item.diseases ? item.diseases.slice(0, 3).map(d => d.name).join(', ') : 'No data';
            fallbackHtml += '<tr>';
            fallbackHtml += '<td><strong>' + item.member_state + '</strong></td>';
            fallbackHtml += '<td>' + item.region_name + '</td>';
            fallbackHtml += '<td><span class="badge badge-primary">' + item.total_diseases + '</span></td>';
            fallbackHtml += '<td>' + (item.avg_priority ? item.avg_priority.toFixed(2) : '0.00') + '</td>';
            fallbackHtml += '<td><small>' + topDiseases + '</small></td>';
            fallbackHtml += '</tr>';
        });
    } else {
        fallbackHtml += '<tr><td colspan="5" class="text-center text-muted">No data available</td></tr>';
    }
    
    fallbackHtml += '</tbody></table></div>';
    container.innerHTML = fallbackHtml;
}
</script>


  
</body>

</html>