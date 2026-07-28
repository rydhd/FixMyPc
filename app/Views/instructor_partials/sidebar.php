<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <img src="<?= base_url('assets/compiled/png/cms.png') ?>" alt="logo">
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            </div>
            <ul class="menu">
                <li class="sidebar-item">
                    <a href="/instructor/dashboard" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Home</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="/instructor/students" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Student</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/instructor/profile" class='sidebar-link'>
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="<?= site_url('logout') ?>" class='sidebar-link'>
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>