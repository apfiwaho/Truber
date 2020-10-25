<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
       <br>
       <br>
      </div>
      <div class="pull-left info">
        <p><?php echo $admin['firstname'].' '.$admin['lastname']; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">WELCOME</li>
      <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class="header">MANAGE</li>
      <li><a href="#"><i class="fa fa-users"></i> <span>Go Online</span></a></li>
      <li><a href="#"><i class="fa fa-car"></i> <span>View Vehicle</span></a></li>
      <li><a href="#"><i class="fa fa-search-plus"></i> <span>View Rides </span></a></li>
      
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>