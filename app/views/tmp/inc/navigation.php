<nav class="sidebar" >
    <div class="sidebar-header" style="background-color: #285430;">
    <a href="#" class="sidebar-brand">
        <span class="text-white"><?php echo COMPANY_NAME?></span>
    </a>
    <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
    </div>
    </div>
    <div class="sidebar-body">
    <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
            <a href="<?php echo _route('dashboard:index')?>" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo _route('classroom:index')?>" class="nav-link">
                <i class="link-icon" data-feather="message-square"></i>
                <span class="link-title">Classroom</span>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a href="<?php echo _route('dashboard:index')?>" class="nav-link">
                <i class="link-icon" data-feather="message-square"></i>
                <span class="link-title">Announcements</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo _route('dashboard:index')?>" class="nav-link">
                <i class="link-icon" data-feather="message-square"></i>
                <span class="link-title">NewsFeed</span>
            </a>
        </li> -->
        <?php if(isEqual(whoIs('user_type'),'admin')) :?>
            <li class="nav-item">
                <a href="<?php echo _route('user:index', ['user_type' => 'teacher'])?>" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Teachers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo _route('user:index', ['user_type' => 'student'])?>" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo _route('user:index', ['user_type' => 'parent'])?>" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Parents</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo _route('user:index', ['user_type' => 'admin'])?>" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Staff</span>
                </a>
            </li>
        <?php endif?>
    </ul>
    </div>
</nav>