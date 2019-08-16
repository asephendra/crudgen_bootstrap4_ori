<div class="card">
  <h5 class="card-header text-white bg-info mb-3">Tambah Users</h5>
    <form role="form" action="<?php base_url('users/create') ?>" method="post">
      <div class="card-body">

        <?php echo validation_errors(); ?>

        <div class="form-group">
          <label for="groups">Groups</label>
          <select class="form-control" id="groups" name="groups">
            <option value="">Select Groups</option>
            <?php foreach ($group_data as $k => $v): ?>
              <option value="<?php echo $v['id'] ?>"><?php echo $v['group_name'] ?></option>
            <?php endforeach ?>
          </select>
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off">
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="text" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
        </div>

        <div class="form-group">
          <label for="cpassword">Confirm password</label>
          <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
        </div>

        <div class="form-group">
          <label for="fname">First name</label>
          <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" autocomplete="off">
        </div>

        <div class="form-group">
          <label for="lname">Last name</label>
          <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" autocomplete="off">
        </div>

        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" autocomplete="off">
        </div>

        <div class="form-group">
          <label for="gender">Gender</label>
          <div class="radio">
            <label>
              <input type="radio" name="gender" id="male" value="1">
              Male
            </label>
            <label>
              <input type="radio" name="gender" id="female" value="2">
              Female
            </label>
          </div>
        </div>

      </div>
      <!-- /.box-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="<?php echo base_url('users/') ?>" class="btn btn-warning">Back</a>
      </div>
    </form>
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#groups").select2();

    $("#mainUserNav").addClass('active');
    $("#createUserNav").addClass('active');
  
  });
</script>
