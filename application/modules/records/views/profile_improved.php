<?php
// Profile page for disease prioritization - Improved version
?>

<!-- Page Header -->
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <div class="page-icon page-icon-primary">
                <i class="fa fa-heartbeat"></i>
            </div>
            <div>
                <h1 class="page-title text-white">Disease Profile Management</h1>
                <p class="page-subtitle">Assign and prioritize diseases for your country</p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- User Data Scope (for non-admin users) -->
    <?php if (!$is_admin && isset($user_region) && isset($user_memberstate)): ?>
    <div class="data-scope-subtle mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <span class="au-icon au-icon-blue" style="width: 20px; height: 20px; font-size: 12px; margin-right: 8px;">
                    <i class="fa fa-map-marker-alt"></i>
                </span>
                <span class="text-muted small">Your Data Scope:</span>
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

    <!-- Step 1: Region and Country Selection (Admin only) -->
    <?php if ($is_admin): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <span class="au-icon au-icon-red" style="width: 20px; height: 20px; font-size: 12px; margin-right: 8px;">
                    <i class="fa fa-flag"></i>
                </span>
                Step 1: Select Region and Country
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="au-icon au-icon-green" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                                <i class="fa fa-globe-africa"></i>
                            </span>
                            Choose Region
                        </label>
                        <select id="region" class="form-control">
                            <option value="">-- Select Region --</option>
                            <?php foreach ($regions as $region): ?>
                                <option value="<?= $region['id'] ?>" 
                                    <?php if ($this->session->userdata('region_id') == $region['id']): ?>
                                        selected
                                    <?php endif; ?>>
                                    <?= $region['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="au-icon au-icon-red" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                                <i class="fa fa-flag"></i>
                            </span>
                            Choose Country
                        </label>
                        <select id="member_state" class="form-control">
                            <option value="">-- Select Country --</option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?= $country['id'] ?>" 
                                    <?php if ($this->session->userdata('memberstate_id') == $country['id']): ?>
                                        selected
                                    <?php endif; ?>>
                                    <?= $country['member_state'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <input type="hidden" id="member_state" value="<?= $this->session->userdata('memberstate_id') ?>">
    <?php endif; ?>

    <!-- Step 2: Thematic Area Selection -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <span class="au-icon au-icon-orange" style="width: 20px; height: 20px; font-size: 12px; margin-right: 8px;">
                    <i class="fa fa-layer-group"></i>
                </span>
                Step 2: Select Thematic Areas
            </h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label mb-0">Choose Thematic Areas</label>
                    <div class="form-check">
                        <input type="checkbox" id="select_all_thematic" class="form-check-input">
                        <label class="form-check-label" for="select_all_thematic">Select All</label>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($thematic_areas as $area): ?>
                    <div class="col-md-6 col-lg-4 mb-2">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input thematic-checkbox" value="<?= $area->id ?>" id="thematic_<?= $area->id ?>">
                            <label class="form-check-label" for="thematic_<?= $area->id ?>"><?= $area->name ?></label>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3: Disease Selection -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <span class="au-icon au-icon-green" style="width: 20px; height: 20px; font-size: 12px; margin-right: 8px;">
                    <i class="fa fa-virus"></i>
                </span>
                Step 3: Select Diseases
            </h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label mb-0">Choose Diseases to Assign</label>
                    <div class="form-check">
                        <input type="checkbox" id="select_all_diseases" class="form-check-input">
                        <label class="form-check-label" for="select_all_diseases">Select All</label>
                    </div>
                </div>
                
                <!-- Search Box -->
                <div class="mb-3">
                    <input type="text" id="disease-search" class="form-control" placeholder="Search diseases...">
                </div>
                
                <!-- Disease List -->
                <div id="disease-list-container" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                    <div id="disease-list" class="disease-grid">
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-info-circle"></i> Please select thematic areas first to load diseases
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 4: Actions -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <span class="au-icon au-icon-blue" style="width: 20px; height: 20px; font-size: 12px; margin-right: 8px;">
                    <i class="fa fa-cogs"></i>
                </span>
                Step 4: Actions
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-modern btn-primary" id="assign-btn">
                        <span class="au-icon au-icon-green" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                            <i class="fa fa-plus"></i>
                        </span>
                        Assign Selected Diseases
                    </button>
                    <button class="btn btn-modern btn-info" id="show-summary-btn">
                        <span class="au-icon au-icon-blue" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                            <i class="fa fa-list"></i>
                        </span>
                        View Assigned Diseases
                    </button>
                </div>
                <div class="col-md-6 text-right">
                    <?php if ($is_admin): ?>
                    <button class="btn btn-modern btn-danger" id="unassign-btn">
                        <span class="au-icon au-icon-red" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                            <i class="fa fa-trash"></i>
                        </span>
                        Remove Selected
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Diseases Summary -->
    <div class="card" id="summary-card" style="display: none;">
        <div class="card-header">
            <h5 class="mb-0">
                <span class="au-icon au-icon-green" style="width: 20px; height: 20px; font-size: 12px; margin-right: 8px;">
                    <i class="fa fa-check-circle"></i>
                </span>
                Currently Assigned Diseases
            </h5>
        </div>
        <div class="card-body">
            <!-- Filter by Thematic Area -->
            <div class="mb-3">
                <label class="form-label">Filter by Thematic Area:</label>
                <select id="thematic-filter" class="form-control">
                    <option value="">All Thematic Areas</option>
                    <?php foreach ($thematic_areas as $area): ?>
                        <option value="<?= $area->id ?>"><?= $area->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div id="assigned-diseases-list">
                <!-- Assigned diseases will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
.thematic-group {
    border-left: 3px solid #007bff;
    padding-left: 15px;
    margin-bottom: 20px;
}

.thematic-group h6 {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 8px;
    margin-bottom: 15px;
}

.thematic-group .form-check {
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 4px;
    margin-bottom: 5px;
    border: 1px solid #e9ecef;
}

.thematic-group .form-check:hover {
    background: #e9ecef;
}

.thematic-group .form-check-label {
    font-weight: 500;
    color: #495057;
}
</style>

<script>
$(document).ready(function() {
    let showCheckboxes = false;
    let assignedDiseases = [];

    // Region-Country chaining for admin users
    <?php if ($is_admin): ?>
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
    <?php endif; ?>

    // Notification function
    function showNotification(message, type) {
        let icon = 'bx bx-check-circle';
        if (type === 'error') {
            icon = 'bx bx-error-circle';
        } else if (type === 'warning') {
            icon = 'bx bx-error';
        } else if (type === 'info') {
            icon = 'bx bx-info-circle';
        }
        
        Lobibox.notify(type, {
            pauseDelayOnHover: true,
            position: 'top right',
            icon: icon,
            msg: message
        });
    }

    // Load diseases based on selected thematic areas
    function loadDiseases() {
        let thematicIds = $('.thematic-checkbox:checked').map(function() { 
            return $(this).val(); 
        }).get();
        
        if (thematicIds.length > 0) {
            $.post('<?= base_url() ?>lists/get_diseases_by_theme', 
                { thematic_ids: thematicIds }, 
                function(response) {
                    renderDiseases(JSON.parse(response), true);
                }
            );
        } else {
            $('#disease-list').html(`
                <div class="text-center text-muted py-4">
                    <i class="fa fa-info-circle"></i> Please select thematic areas first to load diseases
                </div>
            `);
        }
    }

    // Render diseases in the list
    function renderDiseases(diseases, showCheckboxes = true) {
        if (diseases.length === 0) {
            $('#disease-list').html(`
                <div class="text-center text-muted py-4">
                    <i class="fa fa-exclamation-triangle"></i> No diseases found for selected thematic areas
                </div>
            `);
            return;
        }

        $('#disease-list').html(diseases.map(d => `
            <div class="form-check mb-2">
                ${showCheckboxes ? `<input type="checkbox" class="form-check-input disease-checkbox" id="disease_${d.id}" value="${d.id}">` : ''}
                <label class="form-check-label" for="disease_${d.id}">${d.name}</label>
            </div>
        `).join(''));
    }

    // Load assigned diseases
    function loadAssignedDiseases() {
        let memberStateId = $('#member_state').val();
        <?php if (!$is_admin): ?>
        memberStateId = <?= $this->session->userdata('memberstate_id') ?>;
        <?php endif; ?>

        $.post('<?= base_url() ?>records/get_assigned_diseases', 
            { member_state_id: memberStateId }, 
            function(diseases) {
                assignedDiseases = diseases;
                renderAssignedDiseases(diseases, showCheckboxes);
            }, 'json'
        );
    }

    // Render assigned diseases grouped by thematic area
    function renderAssignedDiseases(diseases, showCheckboxes = true) {
        if (diseases.length === 0) {
            $('#assigned-diseases-list').html(`
                <div class="text-center text-muted py-4">
                    <i class="fa fa-info-circle"></i> No diseases assigned yet
                </div>
            `);
            return;
        }

        // Group diseases by thematic area
        const groupedDiseases = {};
        diseases.forEach(disease => {
            const thematicArea = disease.thematic_area || 'Uncategorized';
            if (!groupedDiseases[thematicArea]) {
                groupedDiseases[thematicArea] = [];
            }
            groupedDiseases[thematicArea].push(disease);
        });

        // Render grouped diseases
        let html = '';
        Object.keys(groupedDiseases).sort().forEach(thematicArea => {
            html += `
                <div class="thematic-group mb-4" data-thematic-area="${groupedDiseases[thematicArea][0].thematic_area_id || ''}">
                    <h6 class="text-primary mb-3">
                        <span class="au-icon au-icon-orange" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                            <i class="fa fa-layer-group"></i>
                        </span>
                        ${thematicArea}
                        <span class="badge badge-light ml-2">${groupedDiseases[thematicArea].length} disease(s)</span>
                    </h6>
                    <div class="row">
                        ${groupedDiseases[thematicArea].map(d => `
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="form-check">
                                    ${showCheckboxes ? `<input type="checkbox" class="form-check-input assigned-disease-checkbox" id="assigned_disease_${d.id}" value="${d.id}">` : ''}
                                    <label class="form-check-label" for="assigned_disease_${d.id}">${d.name}</label>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        });

        $('#assigned-diseases-list').html(html);
    }

    // Event handlers
    $('#select_all_thematic').change(function() {
        $('.thematic-checkbox').prop('checked', this.checked);
        loadDiseases();
    });

    $('.thematic-checkbox').change(loadDiseases);

    $('#select_all_diseases').change(function() {
        $('.disease-checkbox').prop('checked', this.checked);
    });

    $('#disease-search').keyup(function() {
        let val = $(this).val().toLowerCase();
        $('.disease-checkbox').closest('.form-check').filter(function() { 
            $(this).toggle($(this).text().toLowerCase().includes(val)); 
        });
    });

    // Assign diseases
    $('#assign-btn').click(function() {
        let memberStateId = $('#member_state').val();
        <?php if (!$is_admin): ?>
        memberStateId = <?= $this->session->userdata('memberstate_id') ?>;
        <?php endif; ?>
        
        let selectedDiseases = $('.disease-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedDiseases.length === 0) {
            showNotification('Please select diseases to assign', 'warning');
            return;
        }

        // Show loading notification
        showNotification(`Assigning ${selectedDiseases.length} disease(s)...`, 'info');

        let data = { 
            member_state_id: memberStateId, 
            diseases: selectedDiseases 
        };

        $.post('<?= base_url() ?>records/assign_diseases', data, function(response) {
            let res = JSON.parse(response);
            if (res.status) {
                showNotification(`Successfully assigned ${selectedDiseases.length} disease(s)`, 'success');
                loadAssignedDiseases();
                $('.disease-checkbox:checked').prop('checked', false);
            } else {
                showNotification(res.message || 'Failed to assign diseases', 'error');
            }
        }).fail(function() {
            showNotification('Network error occurred while assigning diseases', 'error');
        });
    });

    // Show summary
    $('#show-summary-btn').click(function() {
        showCheckboxes = !showCheckboxes;
        $(this).html(`
            <span class="au-icon au-icon-blue" style="width: 16px; height: 16px; font-size: 10px; margin-right: 8px;">
                <i class="fa fa-list"></i>
            </span>
            ${showCheckboxes ? 'Hide Checkboxes' : 'View Assigned Diseases'}
        `);
        
        loadAssignedDiseases();
        $('#summary-card').toggle();
    });

    // Unassign diseases
    $('#unassign-btn').click(function() {
        let selectedDiseases = $('.assigned-disease-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedDiseases.length === 0) {
            showNotification('Please select diseases to remove', 'warning');
            return;
        }

        // Show loading notification
        showNotification(`Removing ${selectedDiseases.length} disease(s)...`, 'info');

        let memberStateId = $('#member_state').val();
        let data = { 
            member_state_id: memberStateId, 
            diseases: selectedDiseases 
        };

        $.post('<?= base_url() ?>records/unassign_diseases', data, function(response) {
            let res = JSON.parse(response);
            if (res.status) {
                showNotification(`Successfully removed ${selectedDiseases.length} disease(s)`, 'success');
                loadAssignedDiseases();
            } else {
                showNotification(res.message || 'Failed to remove diseases', 'error');
            }
        }).fail(function() {
            showNotification('Network error occurred while removing diseases', 'error');
        });
    });

    // Thematic area filtering
    $('#thematic-filter').change(function() {
        const selectedThematicId = $(this).val();
        
        if (selectedThematicId === '') {
            // Show all diseases
            $('.thematic-group').show();
        } else {
            // Show only diseases from selected thematic area
            $('.thematic-group').hide();
            $(`.thematic-group[data-thematic-area="${selectedThematicId}"]`).show();
        }
    });

    // Load assigned diseases on page load
    loadAssignedDiseases();
});
</script>
