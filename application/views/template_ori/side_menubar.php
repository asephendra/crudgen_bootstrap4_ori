<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php if($user_permission): ?>
          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
            <li class="treeview" id="mainUserNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createUser', $user_permission)): ?>
              <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-circle-o"></i> Add User</a></li>
              <?php endif; ?>

              <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> Manage Users</a></li>
            <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li class="treeview" id="mainGroupxNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Groups</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createGroup', $user_permission)): ?>
                  <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-circle-o"></i> Add Group</a></li>
                <?php endif; ?>
                <?php if(in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i> Manage Groups</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
<!-- ************************************************************************* -->
          <?php if(in_array('createBrand', $user_permission) || in_array('updateBrand', $user_permission) || in_array('updateCategory', $user_permission)  || in_array('createCategory', $user_permission)  || in_array('createStore', $user_permission) || in_array('createAttribute', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Master</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createBrand', $user_permission) || in_array('updateBrand', $user_permission) || in_array('viewBrand', $user_permission) || in_array('deleteBrand', $user_permission)): ?>
                  <li id="brandNav">
                    <a href="<?php echo base_url('brands/') ?>">
                      <i class="glyphicon glyphicon-tags"></i> <span>Brands</span>
                    </a>
                  </li>
                <?php endif; ?>
                <?php if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
                  <li id="categoryNav">
                    <a href="<?php echo base_url('category/') ?>">
                      <i class="fa fa-files-o"></i> <span>Category</span>
                    </a>
                  </li>
                <?php endif; ?>

                <?php if(in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission)): ?>
                  <li id="storeNav">
                    <a href="<?php echo base_url('stores/') ?>">
                      <i class="fa fa-files-o"></i> <span>Stores</span>
                    </a>
                  </li>
                <?php endif; ?>

                <?php if(in_array('createAttribute', $user_permission) || in_array('updateAttribute', $user_permission) || in_array('viewAttribute', $user_permission) || in_array('deleteAttribute', $user_permission)): ?>
                <li id="attributeNav">
                  <a href="<?php echo base_url('attributes/') ?>">
                    <i class="fa fa-files-o"></i> <span>Attributes</span>
                  </a>
                </li>
                <?php endif; ?>

                <?php if(in_array('createKelompok', $user_permission) || in_array('updateKelompok', $user_permission) || in_array('viewKelompok', $user_permission) || in_array('deleteKelompok', $user_permission)): ?>
                  <li id="kelompokNav">
                    <a href="<?php echo base_url('kelompok/') ?>">
                      <i class="fa fa-files-o"></i> <span>Kelompok</span>
                    </a>
                  </li>
                <?php endif; ?>

                  <li id="kelompokNav">
                    <a href="<?php echo base_url('cabang') ?>">
                      <i class="fa fa-files-o"></i> <span>Cabang</span>
                    </a>
                  </li>
              </ul>
            </li>
          <?php endif; ?>

        
        <?php if(in_array('updateSetting', $user_permission)): ?>

            <li class="treeview" id="mainSetting">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Setting</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>Setting</span></a></li>
                <?php if(in_array('viewProfile', $user_permission)): ?>
                <li><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>Profile</span></a></li>
              <?php endif; ?>
             <?php if(in_array('updateCompany', $user_permission)): ?>
            <li id="companyNav"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-files-o"></i> <span>Company</span></a></li>
          <?php endif; ?>
          <?php if(in_array('viewReports', $user_permission)): ?>
            <li id="reportNav">
              <a href="<?php echo base_url('reports/') ?>"><i class="glyphicon glyphicon-stats"></i> <span>Reports</span></a>
            </li>
          <?php endif; ?>

          <?php if(in_array('view_contoh', $user_permission)): ?>
            <li id="reportNav">
              <a href="<?php echo base_url('Contoh/') ?>"><i class="glyphicon glyphicon-stats"></i> <span>Reports</span></a>
            </li>
          <?php endif; ?>
            </ul>
            </li>
        <?php endif; ?>


<!-- ******************************************* -->
<?php if(in_array('modul', $user_permission)): ?>
<li class="treeview" id="modulNav">
<a href="#"><i class="fa fa-files-o"></i><span> Modul</span>
<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
  <ul class="treeview-menu">

    <!-- Modul **************** -->
    <?php if(in_array('view_contoh', $user_permission)): ?>
    <li id="contohNav">
    <a href="<?php echo base_url('contoh/') ?>"><i class="glyphicon glyphicon-stats"></i><span>Contoh</span></a>
    </li>
    <?php endif; ?>
    <!-- ******************* -->

    <?php if(in_array('view_buku', $user_permission)): ?>
    <li id="bukuNav">
    <a href="<?php echo base_url('buku/') ?>"><i class="glyphicon glyphicon-stats"></i><span>Buku</span></a>
    </li>
    <?php endif; ?>
    <!-- ******************* -->



  </ul>
</li>
<?php endif; ?>


<!-- ************************************* -->





        <?php endif; ?>
        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>
        <li><a href="<?php echo base_url('crudgen') ?>" target="_blank"><i class="glyphicon glyphicon-log-out"></i> <span>Crudgen</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>