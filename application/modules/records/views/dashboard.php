<?php $this->load->view('charts.php');

//dd($this->session->userdata());
?>
<div class="container-fluid">

<div class="row">


</div>
    <h5 class="mb-3">Disease Ranking Prioritisation</h5>

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
        <!-- Region -->
        <div class="col-md-2">
            <label>Regions</label>
            <select id="region" class="form-control" 
                <?php if (!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
                <option value="">All Regions</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['id'] ?>" 
                        <?= $this->session->userdata('region_id') == $region['id'] ? 'selected' : '' ?>>
                        <?= $region['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Country -->
        <div class="col-md-2">
            <label>Country</label>
            <select id="member_state" class="form-control" 
                <?php if (!$this->session->userdata('is_admin')): ?> disabled <?php endif; ?>>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country['id'] ?>" 
                        <?= $this->session->userdata('memberstate_id') == $country['id'] ? 'selected' : '' ?>>
                        <?= $country['member_state'] ?>
                    </option>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
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
                            options += `<option value="${country.id}">${country.member_state}</option>`;
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
