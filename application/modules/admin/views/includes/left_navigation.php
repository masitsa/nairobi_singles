
    <!-- Sidebar -->
    <div class="sidebar sidebar-fixed">
        <div class="sidebar-dropdown"><a href="#">Navigation</a></div>

        <div class="sidebar-inner">
        
            <!--- Sidebar navigation -->
            <!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
            <ul class="navi">

                <!-- Use the class nred, ngreen, nblue, nlightblue, nviolet or norange to add background color. You need to use this in <li> tag. -->

                <li><a href="<?php echo base_url()."admin";?>"><i class="icon-desktop"></i> Dashboard</a></li>

                <!-- Start: Admin Menu -->
                <li class="has_submenu">
                    <a href="#">
                        <!-- Menu name with icon -->
                        <i class="icon-th"></i> Admin
                        <!-- Icon for dropdown -->
                    </a>
                    <ul>
                        <!--<li><a href="<?php echo base_url()."admin/sales";?>">Sales Reports</a></li>
                        <li><a href="<?php echo base_url()."admin/products";?>">Product Reports</a></li>
                        <li><a href="<?php echo base_url()."admin/usage";?>">Usage Reports</a></li>-->
                        <li><a href="<?php echo base_url()."all-users";?>">Users</a></li>
                    </ul>
                </li>
				<!-- End: Admin Menu -->

                <!-- Start: Products Menu -->
                <li class="has_submenu">
                    <a href="#">
                        <!-- Menu name with icon -->
                        <i class="icon-th"></i> Profiles
                        <!-- Icon for dropdown -->
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url()."all-clients";?>">Clients</a></li>
                        <li><a href="<?php echo base_url()."all-messages";?>">Messages</a></li>
                    </ul>
                </li>
				<!-- End: Products Menu -->
                <li><a href="#"><i class="icon-desktop"></i> Subscriptions</a></li>

                <!-- Start: Products Menu -->
                <li>
                    <a href="<?php echo base_url()."email-campaign";?>">
                        <!-- Menu name with icon -->
                        <i class="icon-th"></i> Email Campaign
                        <!-- Icon for dropdown -->
                    </a>
                </li>
				<!-- End: Products Menu -->

            </ul>
        </div>
    </div>
    <!-- Sidebar ends -->
