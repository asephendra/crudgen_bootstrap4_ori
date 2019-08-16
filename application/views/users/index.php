
<?php if(in_array('createUser', $user_permission)): ?>
  <a href="<?php echo base_url('users/create') ?>" class="btn btn-primary">Add User</a>
  <br /> <br />
<?php endif; ?>


<div class="card">
<h5 class="card-header text-white bg-info mb-3">Judul Table</h5>
  <!-- /.card-header -->
  <div class="card-body">
    <table id="userTable" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Group</th>
        <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
        <th>Action</th>
        <?php endif; ?>
      </tr>
      </thead>
      <tbody>
        <?php if($user_data): ?>                  
          <?php foreach ($user_data as $k => $v): ?>
            <tr>
              <td><?php echo $v['user_info']['username']; ?></td>
              <td><?php echo $v['user_info']['email']; ?></td>
              <td><?php echo $v['user_info']['firstname'] .' '. $v['user_info']['lastname']; ?></td>
              <td><?php echo $v['user_info']['phone']; ?></td>
              <td><?php echo $v['user_group']['group_name']; ?></td>

              <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>

              <td>
                <?php if(in_array('updateUser', $user_permission)): ?>
                  <a href="<?php echo base_url('users/edit/'.$v['user_info']['id']) ?>" class="btn btn-success">Edit</a>
                <?php endif; ?>
                <?php if(in_array('deleteUser', $user_permission)): ?>
                  <a href="<?php echo base_url('users/delete/'.$v['user_info']['id']) ?>" class="btn btn-warning">Hapus</a>
                <?php endif; ?>
              </td>
            <?php endif; ?>
            </tr>
          <?php endforeach ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#userTable').DataTable();

      $("#mainUserNav").addClass('active');
      $("#manageUserNav").addClass('active');
    });
  </script>
