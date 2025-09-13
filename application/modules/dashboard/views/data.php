<?php $this->load->view('charts.php')?>
<div class="container-fluid">

<div class="row">


</div>
    <h5 class="mb-3">Disease Ranking Prioritisation Form (Annual)</h5>

    <!-- Filters -->

    
    <div class="row mb-2">
        <!-- Year -->
        <div class="col-md-2">
            <label>Year</label>
            <select class="form-control" id="period">
                <?php for ($year = date('Y'); $year >= date('Y') - 10; $year--): ?>
                    <option><?= $year ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <!-- Country -->
        <div class="col-md-2">
            <label>Country</label>
            <select id="member_state" class="form-control" <?php  if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country['id'] ?>" <?php if($this->session->userdata('memberstate_id')==$country['id']){ echo "selected readonly";}?>><?= $country['member_state'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Thematic Area -->
        <div class="col-md-3">
            <label>Thematic Area</label>
            <select id="thematic_area" class="form-control">
                <option value="">All Thematic Areas</option>
                <?php foreach ($thematic_areas as $area): ?>
                    <option value="<?= $area->id ?>"><?= $area->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Prioritisation Category -->
        <div class="col-md-2">
            <label>Prioritisation Level</label>
            <select id="prioritisation_category" class="form-control" 
                <?php if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
                <?php foreach ($prioritisation_categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                        <?php if($this->session->userdata('priotisation_level') == $cat['id']){ echo "selected"; }  ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Save Button -->
             <!-- Save Button -->
             <div class="col-md-3 mt-4 pt-2">
    <button id="save-draft" class="btn btn-warning">
        <i class="fa-solid fa-floppy-disk"></i> Draft
    </button>
    <button id="final-submit" class="btn btn-success">
        <i class="fa-solid fa-check-circle"></i> Final Submission
    </button>
</div>
      
    </div>

    <!-- Table -->
    <table class="table table-bordered table-sm table-striped">
        <thead class="thead-dark">
            <tr>
                <th style="width:25%;">Health Condition</th>
                <th style="width:15%;">Prevention</th>
                <th style="width:15%;">Detection</th>
                <th style="width:15%;">Morbidity</th>
                <th style="width:15%;">Case Management</th>
                <th style="width:15%;">Mortality</th>
            </tr>
        </thead>
        <tbody id="ranking-body">
            <!-- Dynamic content loaded here -->
        </tbody>
    </table>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmFinalModal" tabindex="-1" role="dialog" aria-labelledby="confirmFinalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="confirmFinalModalLabel" style="color:#FFF;">
                    <i class="fa-solid fa-check-circle"></i> Confirm Final Submission
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                Are you sure you want to submit your final data? Once submitted, it cannot be edited again.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmFinalSubmit" class="btn btn-success">
                    <i class="fa-solid fa-check"></i> Yes, Submit
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
  $('#summernote').summernote({
    placeholder: 'Discussion body here',
    tabsize: 2,
    height: 200
  });

  $('.autocomplete').autocomplete({
    source: "<?= base_url(); ?>records/autocomplete",
    minLength: 3,
    select: function (event, ui) {
      $('.term').val(ui.item.label);
      $('.search-form').submit();
    }
  });

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
  $.post('<?= base_url() ?>records/load_ranking_form', filters, function (html) {
    $('#ranking-body').html(html);
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
      const colors = ['#CE1126', '#FCD116', '#007749', '#CBA135', '#000000', '#FFFFFF'];
      const seriesData = counts.map((count, i) => ({ y: count, color: colors[i % colors.length] }));

      Highcharts.chart('priority-disease-chart', {
        chart: { type: 'bar', backgroundColor: '#ffffff' },
        title: { text: 'Shorlisted Diseases by Thematic Area' },
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
        const prob = parseFloat(item.probability);
        const color = prob > 0.87 ? '#CE1126' : prob >= 0.7 ? '#FCD116' : '#007749';
        return { name: item.disease_name, y: prob * 100, color };
      });

      Highcharts.chart('priority-probability-chart', {
        chart: { type: 'bar', backgroundColor: '#fff' },
        title: { text: 'Priority Diseases Ranked by Probabilities' },
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
      const colors = ['#119A48', '#007749', '#CE1126', '#FCD116', '#CBA135'];
      const seriesData = counts.map((count, i) => ({ y: count, color: colors[i % colors.length] }));

      Highcharts.chart('continental-disease-chart', {
        chart: { type: 'bar', backgroundColor: '#fff' },
        title: { text: 'Continental Shorlisted Diseases by Thematic Area' },
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
      let color = '#007749';
      if (probValue >= 0.87) color = '#CE1126';
      else if (probValue >= 0.7) color = '#FCD116';

      Highcharts.chart('disease-probability-gauge', {
        chart: {
          type: 'gauge',
          plotBackgroundColor: null,
          plotBackgroundImage: null,
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
            to: probValue * 100,
            color: color
          }]
        },
        series: [{
          name: 'Probability',
          data: [parseFloat((probValue * 100).toFixed(1))],
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
</script>