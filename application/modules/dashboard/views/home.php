<div class="container-fluid">
  <div class="row no-gutters">

    <!-- Year -->
    <div class="col-md-2 p-2">
      <label>Year</label>
      <select class="form-control" id="period">
        <?php for ($year = date('Y'); $year >= date('Y') - 10; $year--): ?>
          <option><?= $year ?></option>
        <?php endfor; ?>
      </select>
    </div>

     <!-- Region -->
    <div class="col-md-2 p-2">
      <label>Region</label>
      <select id="member_state" class="form-control" <?php if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
        <?php foreach ($countries as $country): ?>
          <option value="<?= $country['id'] ?>" 
            <?php if($this->session->userdata('memberstate_id') == $country['id']){ echo "selected readonly"; } ?>>
            <?= $country['member_state'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Country -->
    <div class="col-md-2 p-2">
      <label>Country</label>
      <select id="member_state" class="form-control" <?php if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
        <?php foreach ($countries as $country): ?>
          <option value="<?= $country['id'] ?>" 
            <?php if($this->session->userdata('memberstate_id') == $country['id']){ echo "selected readonly"; } ?>>
            <?= $country['member_state'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Thematic Area -->
    <div class="col-md-3 p-2">
      <label>Thematic Area</label>
      <select id="thematic_area" class="form-control">
        <option value="">All Thematic Areas</option>
        <?php foreach ($thematic_areas as $area): ?>
          <option value="<?= $area->id ?>"><?= $area->name ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Prioritisation Category -->
    <div class="col-md-2 p-2">
      <label>Prioritisation Level</label>
      <select id="prioritisation_category" class="form-control" 
        <?php if(!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
        <?php foreach ($prioritisation_categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" 
            <?php if($this->session->userdata('priotisation_level') == $cat['id']){ echo "selected"; } ?>>
            <?= $cat['name'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

  </div> <!-- End of row -->
</div> <!-- End of container-fluid -->

<!-- Load Charts View -->
<?php $this->load->view('charts.php') ?>

<h5 class="mb-3" style="display:none;">Disease Ranking Prioritisation Data</h5>

<!-- Table -->
<div class="table-responsive" style="display:none;">
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
