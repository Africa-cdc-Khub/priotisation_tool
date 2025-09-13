
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
        title: { text: 'Continental Shortlisted Diseases by Thematic Area' },
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
