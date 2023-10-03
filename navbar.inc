        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard">Dashboard</span>
            </div>
            <div class="profile-details">
                <img src="./assets/images/ava2.png" alt="" />
                <span class="admin_name"><?php
                                            $customer_name = $_SESSION["customer_name"];

                                            echo $customer_name;
                                            ?></span>

            </div>
        </nav>