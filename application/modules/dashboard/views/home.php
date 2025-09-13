<!-- Professional Dashboard Header -->
<div class="dashboard-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="dashboard-title">
                    <i class="fa fa-chart-line"></i>
                    Disease Prioritisation Dashboard
                </h1>
                <p class="dashboard-subtitle">Comprehensive analysis of disease prioritisation</p>
            </div>
            <div class="col-md-4 text-end">
                <!-- <div class="dashboard-stats">
                    <div class="stat-item">
                        <span class="stat-number"><?= count($countries) ?></span>
                        <span class="stat-label">Countries</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?= count($regions) ?></span>
                        <span class="stat-label">Regions</span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>


<!-- Professional Filter Section -->
<div class="filter-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="filter-card">
                    <div class="filter-header">
                        <h5><i class="fa fa-filter"></i> Filter Data</h5>
                    </div>
                    <div class="filter-body">
                        <div class="row g-3">
                            <!-- Year -->
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label class="form-label">Year</label>
                                <select class="form-control form-control-sm" id="period">
                                    <?php for ($year = date('Y'); $year >= date('Y') - 10; $year--): ?>
                                        <option><?= $year ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Region -->
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label class="form-label">Region</label>
                                <select id="region" class="form-control form-control-sm" <?php if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
                                    <option value="">All Regions</option>
                                    <?php foreach ($regions as $region): ?>
                                        <option value="<?= $region['id'] ?>" 
                                            <?php if($this->session->userdata('region_id') == $region['id']){ echo "selected"; } ?>>
                                            <?= $region['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Country -->
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label class="form-label">Country</label>
                                <select id="member_state" class="form-control form-control-sm" <?php if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
                                    <option value="" <?php if($this->session->userdata('is_admin')): ?>selected<?php endif; ?>>All Countries</option>
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?= $country['id'] ?>" 
                                            <?php if(!$this->session->userdata('is_admin') && $this->session->userdata('memberstate_id') == $country['id']){ echo "selected"; } ?>>
                                            <?= $country['member_state'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Thematic Area -->
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <label class="form-label">Thematic Area</label>
                                <select id="thematic_area" class="form-control form-control-sm">
                                    <option value="">All Thematic Areas</option>
                                    <?php foreach ($thematic_areas as $area): ?>
                                        <option value="<?= $area->id ?>"><?= $area->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Prioritisation Level -->
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <label class="form-label">Priority Level</label>
                                <select id="prioritisation_category" class="form-control form-control-sm" 
                                    <?php if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
                                    <?php foreach ($prioritisation_categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" 
                                            <?php if($this->session->userdata('priotisation_level') == $cat['id']){ echo "selected"; } ?>>
                                            <?= $cat['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-lg-1 col-md-12">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="button" id="apply-filters" class="btn btn-primary btn-sm">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button type="button" id="reset-filters" class="btn btn-secondary btn-sm">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="charts-card">
                    <div class="charts-header">
                        <h5><i class="fa fa-chart-bar"></i> Disease Analysis Charts</h5>
                    </div>
                    <div class="charts-body">
                        <?php $this->load->view('charts.php') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Africa Map Section -->
<div class="map-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="map-card">
                    <div class="map-header">
                        <h5><i class="fa fa-map"></i> Disease Prioritisation Map - Africa</h5>
                        <p class="map-subtitle">Interactive map showing disease prioritisation rankings by country</p>
                    </div>
                    <div class="map-body">
                        <div id="africa-map" style="height: 600px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table Section -->
<div class="table-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-white">
                            <i class="fa fa-table me-2 text-white"></i> Disease Ranking Data
                        </h5>
                        <div class="card-toolbar">
                            <button type="button" id="refresh-table" class="btn btn-outline-light btn-sm text-white">
                                <i class="fa fa-refresh me-1 text-white"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body m-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0" id="ranking-datatable" style="width:100%">
                                <thead class="table-default text-white" style="color: #fff !important;">
                                    <tr>
                                        <th class="text-center">Period</th>
                                        <th class="text-center">Priority Level</th>
                                        <th class="text-center">Region</th>
                                        <th class="text-center">Country</th>
                                        <th class="text-center">Disease Name</th>
                                        <th class="text-center">Thematic Area</th>
                                        <th class="text-center">Prevention</th>
                                        <th class="text-center">Detection</th>
                                        <th class="text-center">Morbidity</th>
                                        <th class="text-center">Case Management</th>
                                        <th class="text-center">Mortality</th>
                                        <th class="text-center">Composite Index</th>
                                        <th class="text-center">Probability</th>
                                        <th class="text-center">Priority Level</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Created</th>
                                        <th class="text-center">Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="17" class="text-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <p class="mt-2 mb-0">Loading data...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-muted">
                        <small>
                            <i class="fa fa-info-circle me-1"></i>
                            Click on column headers to sort. Use the search box to filter data. Export options available above the table.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmFinalModal" tabindex="-1" role="dialog" aria-labelledby="confirmFinalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="confirmFinalModalLabel">
          <i class="fa-solid fa-check-circle"></i> Confirm Final Submission
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to submit your final data? Once submitted, it cannot be edited again.
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmFinalSubmit" class="btn btn-success">
          <i class="fa-solid fa-check"></i> Yes, Submit
        </button>
      </div>

    </div>
  </div>
</div>
