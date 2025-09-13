<!-- ============================ Footer Start ================================== -->
<footer class="light-footer skin-light-footer style-2">


	<div class="footer-bottom br-top">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-12 col-md-12 text-center">
					<p class="mb-0">© <?php echo date('Y') ?> Africa CDC.</p>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- ============================ Footer End ================================== -->

<!-- Log In Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
	<div class="modal-dialog modal-xl login-pop-form" role="document">
		<div class="modal-content" id="loginmodal">
			<div class="modal-headers">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="ti-close"></span>
				</button>
			</div>

			<div class="modal-body p-5">
				<div class="text-center mb-4">
					<h2 class="m-0 ft-regular">Login</h2>
				</div>

				<?php echo form_open(base_url('auth/login')); ?>

				<input type="hidden" name="route" value="front" />
				<div class="form-group">
					<label>User Name</label>
					<input type="text" name="username" class="form-control" placeholder="Username*">
				</div>

				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control" placeholder="Password*">
				</div>

				<div class="form-group">
					<div class="d-flex align-items-center justify-content-between">
						<div class="flex-1">
							<input id="dd" class="checkbox-custom" name="dd" type="checkbox">
							<label for="dd" class="checkbox-custom-label">Remember Me</label>
						</div>
						<div class="eltio_k2">
							<a href="#" class="theme-cl">Lost Your Password?</a>
						</div>
					</div>
				</div>

				<div class="form-group">
					<button type="submit"
						class="btn btn-md full-width theme-bg text-light fs-md ft-medium">Login</button>
				</div>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->

<script src="<?php echo base_url(); ?>resources/js/jquery.min.js"></script>


<div id="google_translate_element" style="display:none;"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"
	type="text/javascript"></script>
<script>
	//mobile change select
    function handleLanguageChange(selectElement) {
        var selectedLanguage = selectElement.value;
        doGTranslate(selectedLanguage);
    }
</script>
<script type="text/javascript">
	function googleTranslateElementInit() {
		new google.translate.TranslateElement({
			pageLanguage: 'en',
			autoDisplay: false,
			disableAutoHover: true,
			showBanner: false
		},
			'google_translate_element');

	}
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
<script>
	$(function () {
		$('.selectpicker').selectpicker();
	});




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