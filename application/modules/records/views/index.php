<div class="container-fluid mt-4">
    <h3 class="mb-4">Assign Diseases to Countries</h3>

    <!-- User Information Display for Non-Admin Users -->
    <?php if (!$is_admin && isset($user_region) && isset($user_memberstate)): ?>
    <div class="alert alert-info mb-4">
        <h5><i class="fa fa-info-circle"></i> Your Data Scope</h5>
        <div class="row">
            <div class="col-md-6">
                <strong>Region:</strong> <?= $user_region['name'] ?>
            </div>
            <div class="col-md-6">
                <strong>Member State:</strong> <?= $user_memberstate['member_state'] ?> 
                (<?= $user_memberstate['iso2_code'] ?>/<?= $user_memberstate['iso3_code'] ?>)
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Country Selection -->
    <div class="form-group">
        <label>Country</label>
        <select id="member_state" class="form-control" <?php if(!$is_admin): ?> disabled <?php endif; ?>>
            <?php foreach ($countries as $country): ?>
                <option value="<?= $country['id'] ?>" <?php if($this->session->userdata('memberstate_id')==$country['id']){ echo "selected readonly";}?>><?= $country['member_state'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Select Thematic Areas:</label>
                <div class="form-check">
                    <input type="checkbox" id="select_all_thematic" class="form-check-input">
                    <label class="form-check-label" for="select_all_thematic">Select All</label>
                </div>
                <?php foreach ($thematic_areas as $area): 
                    
                    //dd($thematic_areas)?>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input thematic-checkbox" value="<?= $area->id ?>">
                        <label class="form-check-label"> <?= $area->name ?> </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6">
            <!-- <button class="btn btn-success mb-2" id="assign-btn">Assign Diseases</button> -->
            <button class="btn btn-info mb-2" id="show-summary-btn">View Assigned Diseases</button>
            <?php if ($this->session->userdata('role') == '10'): ?>
                <button class="btn btn-danger mb-2" id="unassign-btn">Unassign Diseases</button>
            <?php endif; ?>
            <!-- Save Button -->
            <button class="btn btn-info mb-2" id="save-all-btn">Save All Changes</button>

            <div class="form-group">
                <label>Select Diseases:</label>
                <div class="form-check">
                    <input type="checkbox" id="select_all_diseases" class="form-check-input">
                    <label class="form-check-label" for="select_all_diseases">Select All</label>
                </div>
                <input type="text" id="disease-search" class="form-control mb-3" placeholder="Search diseases...">
                <div id="disease-list-container">
                    <div id="disease-list" class="disease-grid"></div>
                </div>
            </div>

            
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    let showCheckboxes = false; // Default state: without checkboxes

    function show_notification(message, msgtype) {
        Lobibox.notify(msgtype, {
            pauseDelayOnHover: true,
            position: 'top right',
            icon: 'bx bx-check-circle',
            msg: message
        });
    }

    function loadDiseases() {
        let thematicIds = $('.thematic-checkbox:checked').map(function() { return $(this).val(); }).get();
        if(thematicIds.length > 0) {
            $.post('<?= base_url() ?>lists/get_diseases_by_theme', { thematic_ids: thematicIds }, function(response) {
                renderDiseases(JSON.parse(response), true);
            });
        } else { $('#disease-list').html(''); }
    }

    function renderDiseases(diseases, showCheckboxes = true) {
        $('#disease-list').html(diseases.map(d => `
            <div class="form-check">
                ${showCheckboxes ? `<input type="checkbox" class="form-check-input disease-checkbox" id="disease_${d.id}" value="${d.id}">` : ''}
                <label class="form-check-label" for="disease_${d.id}">${d.name}</label>
            </div>`
        ));
    }

    $('#select_all_thematic').change(function() {
        $('.thematic-checkbox').prop('checked', this.checked);
        loadDiseases();
    });

    $('.thematic-checkbox').change(loadDiseases);

    $('#assign-btn, #unassign-btn').click(function() {
        let url = $(this).attr('id') === 'assign-btn' ? 'assign_diseases' : 'unassign_diseases';
        
        // For non-admin users, use session member state ID
        let memberStateId = $('#member_state').val();
        <?php if (!$is_admin): ?>
        memberStateId = <?= $this->session->userdata('memberstate_id') ?>;
        <?php endif; ?>
        
        let data = { member_state_id: memberStateId, diseases: $('.disease-checkbox:checked').map(function(){return $(this).val();}).get() };
        $.post(`<?= base_url()?>records/${url}`, data, function(response) {
            let res = JSON.parse(response);
            show_notification(res.message, res.status ? 'success' : 'error');
        });
    });

    $('#show-summary-btn').click(function() {
        showCheckboxes = !showCheckboxes; // Toggle the state
        $(this).text(showCheckboxes ? 'View Assigned Diseases(+-)' : 'View Assigned Diseases');
        
        // For non-admin users, use session member state ID
        let memberStateId = $('#member_state').val();
        <?php if (!$is_admin): ?>
        memberStateId = <?= $this->session->userdata('memberstate_id') ?>;
        <?php endif; ?>
        
        $.post('<?= base_url()?>records/get_assigned_diseases', { member_state_id: memberStateId }, function(diseases) {
            renderDiseases(diseases, showCheckboxes);
        },'json');
    });

    $('#select_all_diseases').change(function() {
        $('.disease-checkbox').prop('checked', this.checked);
    });

    $('#disease-search').keyup(function() {
        let val = $(this).val().toLowerCase();
        $('.form-check').filter(function() { $(this).toggle($(this).text().toLowerCase().includes(val)); });
    });

    // Save Button Functionality
    $('#save-all-btn').click(function() {
        let changes = [];
        
        // For non-admin users, use session member state ID
        let memberStateId = $('#member_state').val();
        <?php if (!$is_admin): ?>
        memberStateId = <?= $this->session->userdata('memberstate_id') ?>;
        <?php endif; ?>
        
        $('.disease-checkbox:checked').each(function() {
            changes.push({
                disease_id: $(this).val(),
                member_state_id: memberStateId,
                thematic_area_id: $('.thematic-checkbox:checked').val() // Assuming one thematic area is selected
            });
        });

        if (changes.length > 0) {
            $.post('<?= base_url() ?>records/save_all_changes', { changes: changes }, function(response) {
                let res = JSON.parse(response);
                show_notification(res.message, res.status ? 'success' : 'error');
            });
        } else {
            show_notification('No changes to save!', 'warning');
        }
    });
});


</script>