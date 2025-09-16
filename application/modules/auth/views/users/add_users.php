<?php $usergroups = $this->db->get('user_groups')->result(); 


?>
<?php $member_states = $this->db->query('SELECT * FROM member_states ORDER BY member_state ASC')->result(); ?>
<?php $levels = $this->db->get('priotisation_category')->result(); ?>

<div class="row">
  <div class="col-lg-12">
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Add New User</h5>
      </div>
      <?php //dd($this->session->userdata('user')); ?>
      <div class="card-body">
        <?= form_open_multipart(base_url('auth/adduser'), ['id' => 'userform', 'class' => 'user_form']) ?>
        <div class="form-row mb-3">
          <div class="col-md-6 col-lg-4">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
          </div>
          <div class="col-md-6 col-lg-4">
            <label>User Group</label>
            <select name="role" class="form-control select2" required>
              <option value="" disabled selected>Select User Group</option>
              <?php foreach ($usergroups as $group): ?>
                <option value="<?= $group->id ?>"><?= $group->group_name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6 col-lg-4">
            <label>Email (Default Password: mycountry$$)</label>
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            <input type="hidden" name="password" value="<?= htmlspecialchars(setting()->default_password, ENT_QUOTES, 'UTF-8') ?>" readonly>
          </div>
          <div class="col-md-6 col-lg-4">
            <label>Member State</label>
            <select name="memberstate_id" class="form-control select2" required>
              <option value="" disabled selected>Select Member State</option>
              <?php foreach ($member_states as $state): ?>
                <option value="<?= $state->id ?>"><?= $state->member_state ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6 col-lg-4">
            <label>Level of Prioritisation</label>
            <select name="priotisation_level" class="form-control select2" required>
              <option value="" disabled selected>Select Level</option>
              <?php foreach ($levels as $level): ?>
                <option value="<?= $level->id ?>"><?= $level->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6 col-lg-4">
            <label>Organisation</label>
            <input type="text" name="organization_name" class="form-control" placeholder="Organization Name">
          </div>
        </div>
        <div class="form-group text-right">
          <button type="submit" class="btn btn-primary btn-sm">Save</button>
          <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
        </div>
        <div class="status text-center text-info"></div>
        <?= form_close() ?>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">User List</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="usersTable" class="table table-striped table-bordered table-hover">
            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Member State</th>
                <th>Level</th>
                <th>Organization</th>
                <th>User Group</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Data will be loaded via AJAX -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Shared Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <?= form_open_multipart(base_url('auth/updateUser'), ['class' => 'update_user']) ?>
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="status text-center text-info mb-3"></div>
        <input type="hidden" name="id" id="edit_id">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Name</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label>Email</label>
            <input type="email" name="email" id="edit_email" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label>User Group</label>
            <select name="role" id="edit_role" class="form-control select2" required>
              <option value="">-- Select --</option>
              <?php foreach ($usergroups as $group): ?>
                <option value="<?= $group->id ?>"><?= $group->group_name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Organization</label>
            <input type="text" name="organization_name" id="edit_org" class="form-control">
          </div>
          <div class="form-group col-md-6">
            <label>Member State</label>
            <select name="memberstate_id" id="edit_state" class="form-control select2" required>
              <?php foreach ($member_states as $state): ?>
                <option value="<?= $state->id ?>"><?= $state->member_state ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Prioritisation Level</label>
            <select name="priotisation_level" id="edit_level" class="form-control select2" required>
              <?php foreach ($levels as $level): ?>
                <option value="<?= $level->id ?>"><?= $level->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-info btn-sm">Update</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<!-- Dynamic Confirmation Modals -->
<!-- Reset Password Modal -->
<div class="modal fade" id="resetModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="reset" action="<?php echo base_url(); ?>auth/resetPass" method="post">
        <div class="modal-body">
          <h4>Reset password for <b id="resetUserName"></b>?</h4>
          <span class="status" style="margin:0 auto;"></span>
          <input type="hidden" name="id" id="resetUserId">
          <input type="hidden" name="password" value="<?php echo setting()->default_password; ?>">
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-danger" value="Yes, Reset">
          <a href="#" data-dismiss="modal" class="btn">Close</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Block User Modal -->
<div class="modal fade" id="blockModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="block" action="<?php echo base_url(); ?>auth/blockUser" method="post">
        <div class="modal-body">
          <h4>Block user <b id="blockUserName"></b>?</h4>
          <span class="status" style="margin:0 auto;"></span>
          <input type="hidden" name="user_id" id="blockUserId">
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-danger" value="Yes, Block">
          <a href="#" data-dismiss="modal" class="btn">Close</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Unblock User Modal -->
<div class="modal fade" id="unblockModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="unblock" action="<?php echo base_url(); ?>auth/unblockUser" method="post">
        <div class="modal-body">
          <h4>Activate user <b id="unblockUserName"></b>?</h4>
          <span class="status" style="margin:0 auto;"></span>
          <input type="hidden" name="user_id" id="unblockUserId">
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-success" value="Yes, Activate">
          <a href="#" data-dismiss="modal" class="btn">Close</a>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
/* Organization column styling */
#usersTable td:nth-child(6) {
  max-width: 300px !important;
  word-wrap: break-word;
  word-break: break-word;
  white-space: normal;
  overflow-wrap: break-word;
  line-height: 1.4;
  padding: 8px 4px;
}

/* Ensure table doesn't break layout */
#usersTable {
  table-layout: fixed;
  width: 100%;
}

/* DataTables specific styling */
#usersTable.dataTable td {
  vertical-align: top;
}

/* Make table responsive */
@media (max-width: 768px) {
  #usersTable td:nth-child(6) {
    max-width: 200px !important;
  }
}

/* Ensure proper text wrapping in all cells */
#usersTable td {
  word-wrap: break-word;
  overflow-wrap: break-word;
}
</style>

<script>
// Ensure jQuery is loaded before running our script
if (typeof jQuery === 'undefined') {
  console.error('jQuery is not loaded, waiting for it...');
  document.addEventListener('DOMContentLoaded', function() {
    // Wait for jQuery to be available with timeout
    var attempts = 0;
    var maxAttempts = 50; // 5 seconds max wait
    var checkJQuery = setInterval(function() {
      attempts++;
      if (typeof jQuery !== 'undefined') {
        clearInterval(checkJQuery);
        console.log('jQuery loaded after', attempts * 100, 'ms');
        initializeUsersPage();
      } else if (attempts >= maxAttempts) {
        clearInterval(checkJQuery);
        console.error('jQuery failed to load after 5 seconds');
        var tableBody = document.querySelector('#usersTable tbody');
        if (tableBody) {
          tableBody.innerHTML = '<tr><td colspan="8" class="text-center">jQuery failed to load. Please refresh the page.</td></tr>';
        }
      }
    }, 100);
  });
} else {
$(document).ready(function () {
    initializeUsersPage();
  });
}

function initializeUsersPage() {
  console.log('Document ready - initializing users page');
  
  // Check if the table element exists
  if ($('#usersTable').length === 0) {
    console.error('Users table element not found');
    return;
  }
  
  // Initialize Select2
  if ($.fn.select2) {
    $('.select2').select2({
      width: '100%'
    });
  }

  // Wait for DataTables to be available with a timeout
  var attempts = 0;
  var maxAttempts = 50; // 5 seconds max wait
  
  function checkDataTables() {
    attempts++;
    console.log('Checking for DataTables, attempt:', attempts);
    
    if (typeof $.fn.DataTable !== 'undefined') {
      console.log('DataTables is available, initializing table...');
      console.log('Table element found:', $('#usersTable').length);
      initializeUsersTable();
    } else if (attempts < maxAttempts) {
      setTimeout(checkDataTables, 100);
    } else {
      console.error('DataTables failed to load after 5 seconds');
      $('#usersTable tbody').html('<tr><td colspan="8" class="text-center">DataTables library failed to load. Please refresh the page.</td></tr>');
    }
  }
  
  checkDataTables();
}

function initializeUsersTable() {

  // Initialize DataTable
  try {
    // First, let's test with a simple static table
    $('#usersTable tbody').html('<tr><td>1</td><td>Test User</td><td>test@example.com</td><td>Test Country</td><td>Test Level</td><td>Test Org</td><td>Test Role</td><td><button class="btn btn-sm btn-info">Edit</button></td></tr>');
    
    var usersTable = $('#usersTable').DataTable({
      "processing": true,
      "serverSide": true,
      "autoWidth": false,
      "scrollX": true,
      "ajax": {
        "url": "<?= base_url('auth/getUsersData') ?>",
        "type": "POST",
        "error": function(xhr, error, thrown) {
          console.error('DataTables AJAX error:', error, thrown);
          console.error('Response:', xhr.responseText);
        }
      },
      "columns": [
        { "data": 0, "orderable": false, "searchable": false, "width": "50px" },
        { "data": 1, "width": "150px" },
        { "data": 2, "width": "200px" },
        { "data": 3, "width": "150px" },
        { "data": 4, "width": "100px" },
        { "data": 5, "width": "300px" },
        { "data": 6, "width": "120px" },
        { "data": 7, "orderable": false, "searchable": false, "width": "200px" }
      ],
      "order": [[1, "asc"]],
      "pageLength": 10,
      "responsive": true,
      "language": {
        "processing": "Loading users...",
        "emptyTable": "No users found",
        "zeroRecords": "No matching users found"
      }
    });
    console.log('DataTable initialized successfully');
  } catch (error) {
    console.error('Error initializing DataTable:', error);
    // Fallback: Show a simple message
    $('#usersTable tbody').html('<tr><td colspan="8" class="text-center">Error loading users. Please refresh the page.</td></tr>');
  }

  // Handle dynamic modal data binding
  $(document).on('click', '.editBtn', function () {
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_email').val($(this).data('email'));
    $('#edit_org').val($(this).data('org'));
    $('#edit_role').val($(this).data('role')).trigger('change');
    $('#edit_state').val($(this).data('memberstate')).trigger('change');
    $('#edit_level').val($(this).data('level')).trigger('change');
  });

  // Handle reset password modal
  $(document).on('click', '.resetBtn', function () {
    var userId = $(this).data('id');
    var userName = $(this).data('name');
    $('#resetUserId').val(userId);
    $('#resetUserName').text(userName);
    $('#resetModal').modal('show');
  });

  // Handle block user modal
  $(document).on('click', '.blockBtn', function () {
    var userId = $(this).data('id');
    var userName = $(this).data('name');
    $('#blockUserId').val(userId);
    $('#blockUserName').text(userName);
    $('#blockModal').modal('show');
  });

  // Handle unblock user modal
  $(document).on('click', '.unblockBtn', function () {
    var userId = $(this).data('id');
    var userName = $(this).data('name');
    $('#unblockUserId').val(userId);
    $('#unblockUserName').text(userName);
    $('#unblockModal').modal('show');
  });

  // Handle form submission with AJAX
  $('.update_user').on('submit', function(e) {
    e.preventDefault();
    
    var form = $(this);
    var formData = form.serialize();
    var statusDiv = form.find('.status');
    
    // Show loading state
    statusDiv.html('<i class="fa fa-spinner fa-spin"></i> Updating user...').removeClass('text-info text-success text-danger').addClass('text-info');
    
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          statusDiv.html('<i class="fa fa-check"></i> ' + response.message).removeClass('text-info text-danger').addClass('text-success');
          
          // Close modal after 2 seconds
          setTimeout(function() {
            $('#editUserModal').modal('hide');
            usersTable.ajax.reload(); // Reload DataTable
          }, 2000);
        } else {
          statusDiv.html('<i class="fa fa-times"></i> ' + response.message).removeClass('text-info text-success').addClass('text-danger');
        }
      },
      error: function(xhr, status, error) {
        statusDiv.html('<i class="fa fa-times"></i> Error updating user. Please try again.').removeClass('text-info text-success').addClass('text-danger');
        console.error('AJAX Error:', error);
      }
    });
  });

  // Reset form when modal is closed
  $('#editUserModal').on('hidden.bs.modal', function() {
    $('.update_user')[0].reset();
    $('.status').html('').removeClass('text-info text-success text-danger');
    $('.select2').val(null).trigger('change');
  });

  // Handle reset password form submission
  $('.reset').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    var statusDiv = form.find('.status');
    
    statusDiv.html('<i class="fa fa-spinner fa-spin"></i> Resetting password...').removeClass('text-info text-success text-danger').addClass('text-info');
    
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: formData,
      success: function(response) {
        statusDiv.html('<i class="fa fa-check"></i> ' + response).removeClass('text-info text-danger').addClass('text-success');
        setTimeout(function() {
          $('#resetModal').modal('hide');
          usersTable.ajax.reload();
        }, 2000);
      },
      error: function() {
        statusDiv.html('<i class="fa fa-times"></i> Error resetting password. Please try again.').removeClass('text-info text-success').addClass('text-danger');
      }
    });
  });

  // Handle block user form submission
  $('.block').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    var statusDiv = form.find('.status');
    
    statusDiv.html('<i class="fa fa-spinner fa-spin"></i> Blocking user...').removeClass('text-info text-success text-danger').addClass('text-info');
    
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: formData,
      success: function(response) {
        statusDiv.html('<i class="fa fa-check"></i> ' + response).removeClass('text-info text-danger').addClass('text-success');
        setTimeout(function() {
          $('#blockModal').modal('hide');
          usersTable.ajax.reload();
        }, 2000);
      },
      error: function() {
        statusDiv.html('<i class="fa fa-times"></i> Error blocking user. Please try again.').removeClass('text-info text-success').addClass('text-danger');
      }
    });
  });

  // Handle unblock user form submission
  $('.unblock').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    var statusDiv = form.find('.status');
    
    statusDiv.html('<i class="fa fa-spinner fa-spin"></i> Activating user...').removeClass('text-info text-success text-danger').addClass('text-info');
    
    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: formData,
      success: function(response) {
        statusDiv.html('<i class="fa fa-check"></i> ' + response).removeClass('text-info text-danger').addClass('text-success');
        setTimeout(function() {
          $('#unblockModal').modal('hide');
          usersTable.ajax.reload();
        }, 2000);
      },
      error: function() {
        statusDiv.html('<i class="fa fa-times"></i> Error activating user. Please try again.').removeClass('text-info text-success').addClass('text-danger');
      }
    });
  });

  // Reset confirmation modals when closed
  $('#resetModal, #blockModal, #unblockModal').on('hidden.bs.modal', function() {
    $(this).find('.status').html('').removeClass('text-info text-success text-danger');
  });
}
</script>