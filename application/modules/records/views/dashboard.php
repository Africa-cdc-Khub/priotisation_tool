<?php $this->load->view('charts.php');

//dd($this->session->userdata());
?>

<!-- Page Header -->
  <div class="page-header">
      <div class="container-fluid">
          <div class="d-flex align-items-center">
              <div class="page-icon page-icon-primary">
                  <i class="fa fa-chart-bar"></i>
              </div>
              <div>
                  <h1 class="page-title text-white">Disease and Condition Prioritisation</h1>
                  <p class="page-subtitle">Analyze and prioritise health conditions based on comprehensive criteria</p>
              </div>
          </div>
      </div>
  </div>

<div class="container-fluid">

    <!-- Filter Section -->
    <div class="filter-section slide-up">
        <h5 class="filter-title">
            <span class="au-icon au-icon-blue">
                <i class="fa fa-filter"></i>
            </span>
            Filter Criteria
        </h5>
        <div class="row align-items-end">
            <!-- Year -->
            <div class="col-lg-1 col-md-2 col-sm-4 mb-3">
                <div class="form-group mb-0">
                    <label class="form-label">
                        <span class="au-icon au-icon-gold" style="width: 16px; height: 16px; font-size: 10px;">
                            <i class="fa fa-calendar"></i>
                        </span>
                        Year
                    </label>
                    <select class="form-control form-control-sm" id="period">
                        <?php for ($year = date('Y'); $year >= date('Y') - 10; $year--): ?>
                            <option><?= $year ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            
            <!-- Region -->
            <div class="col-lg-2 col-md-3 col-sm-6 mb-3">
                <div class="form-group mb-0">
                    <label class="form-label">
                        <span class="au-icon au-icon-green" style="width: 16px; height: 16px; font-size: 10px;">
                            <i class="fa fa-globe-africa"></i>
                        </span>
                        Region
                    </label>
                    <select id="region" class="form-control form-control-sm" 
                        <?php if (!$is_admin): ?> disabled <?php endif; ?>>
                        <option value="">All Regions</option>
                        <?php foreach ($regions as $region): ?>
                            <option value="<?= $region['id'] ?>" 
                                <?php if (!$is_admin && isset($user_region) && $user_region['id'] == $region['id']): ?>
                                    selected
                                <?php elseif ($is_admin && $this->session->userdata('region_id') == $region['id']): ?>
                                    selected
                                <?php endif; ?>>
                                <?= $region['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Country -->
            <div class="col-lg-2 col-md-3 col-sm-6 mb-3">
                <div class="form-group mb-0">
                    <label class="form-label">
                        <span class="au-icon au-icon-red" style="width: 16px; height: 16px; font-size: 10px;">
                            <i class="fa fa-flag"></i>
                        </span>
                        Country
                    </label>
                    <select id="member_state" class="form-control form-control-sm" 
                        <?php if (!$is_admin): ?> disabled <?php endif; ?>>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?= $country['id'] ?>" 
                                <?php if (!$is_admin && isset($user_memberstate) && $user_memberstate['id'] == $country['id']): ?>
                                    selected
                                <?php elseif ($is_admin && $this->session->userdata('memberstate_id') == $country['id']): ?>
                                    selected
                                <?php endif; ?>>
                                <?= $country['member_state'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Thematic Area -->
            <div class="col-lg-2 col-md-3 col-sm-6 mb-3">
                <div class="form-group mb-0">
                    <label class="form-label">
                        <span class="au-icon au-icon-orange" style="width: 16px; height: 16px; font-size: 10px;">
                            <i class="fa fa-layer-group"></i>
                        </span>
                        All Areas
                    </label>
                    <select id="thematic_area" class="form-control form-control-sm">
                        <option value="">All Areas</option>
                        <?php foreach ($thematic_areas as $area): ?>
                            <option value="<?= $area->id ?>"><?= $area->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Prioritisation Category -->
            <div class="col-lg-2 col-md-3 col-sm-6 mb-3">
                <div class="form-group mb-0">
                    <label class="form-label">
                        <span class="au-icon au-icon-blue" style="width: 16px; height: 16px; font-size: 10px;">
                            <i class="fa fa-sort-amount-up"></i>
                        </span>
                        Priority Level
                    </label>
                    <select id="prioritisation_category" class="form-control form-control-sm" 
                        <?php if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
                        <?php foreach ($prioritisation_categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?php if($this->session->userdata('priotisation_level') == $cat['id']){ echo "selected"; }  ?>>
                                <?= $cat['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-lg-3 col-md-12 mb-3">
                <div class="form-group mb-0">
                    <div class="action-buttons d-flex gap-1">
                        <button id="save-draft" class="btn-modern btn-draft btn-sm">
                            <span class="au-icon au-icon-gold" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                                <i class="fa fa-save"></i>
                            </span>
                            Draft
                        </button>
                        <button id="final-submit" class="btn-modern btn-submit btn-sm">
                            <span class="au-icon au-icon-green" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                                <i class="fa fa-check"></i>
                            </span>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information Display for Non-Admin Users -->
    <?php if (!$is_admin && isset($user_region) && isset($user_memberstate)): ?>
    <div class="data-scope-subtle mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <span class="au-icon au-icon-blue" style="width: 20px; height: 20px; font-size: 12px; margin-right: 8px;">
                    <i class="fa fa-map-marker-alt"></i>
                </span>
                <span class="text-muted small">Current Scope:</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <span class="badge badge-light">
                    <strong>Region:</strong> <?= $user_region['name'] ?>
                </span>
                <span class="badge badge-light">
                    <strong>Country:</strong> <?= $user_memberstate['member_state'] ?> 
                    (<?= $user_memberstate['iso2_code'] ?>/<?= $user_memberstate['iso3_code'] ?>)
                </span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Data Table Card -->
    <div class="data-table-container fade-in">
        <div class="table-header">
            <h6 class="table-title">
                <span class="au-icon au-icon-green" style="width: 20px; height: 20px; font-size: 12px; margin-right: 8px;">
                    <i class="fa fa-table"></i>
                </span>
                Disease Ranking Table
            </h6>
            <div class="table-actions">
                <span class="text-muted small">Interactive ranking system</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
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
    </div>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmFinalModal" tabindex="-1" role="dialog" aria-labelledby="confirmFinalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmFinalModalLabel">
                    <i class="fa-solid fa-check-circle"></i> Confirm Final Submission
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to submit your final data? Once submitted, it cannot be edited again.</p>
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> This action cannot be undone. Please review your data carefully before proceeding.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" id="confirmFinalSubmit" class="btn-modern btn-submit">
                    <i class="fa-solid fa-check"></i> Yes, Submit
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // For non-admin users, ensure region is selected and trigger change
    <?php if (!$is_admin && isset($user_region)): ?>
    // Set the region value and trigger change for non-admin users
    $('#region').val('<?= $user_region['id'] ?>').trigger('change');
    <?php endif; ?>

    $('#region').on('change', function() {
        const regionId = $(this).val();

        // Only proceed if a region is selected
        if (regionId) {
            $.ajax({
                url: '<?= site_url("records/get_countries_by_region") ?>',
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
                            <?php if (!$is_admin && isset($user_memberstate)): ?>
                            if (country.id == <?= $user_memberstate['id'] ?>) {
                                selected = 'selected';
                            }
                            <?php endif; ?>
                            options += `<option value="${country.id}" ${selected}>${country.member_state}</option>`;
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
