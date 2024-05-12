<?php
    require_once "includes/login_view.inc.php";
?>
<header>
    <div class="logo">ScholarMS</div>
    <nav>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/conference_lookup/conference_lookup.php">Conference & Paper</a></li>
            <li><a href="/paper_management/paper_management.php">Paper Management</a></li>
            <li><a href="/conference_registrations/conf_reg_user_display.php">Attend Conference</a></li>
        </ul>
    </nav>
    <div class="user-actions">
        <?php set_login_section();?>
        
    </div>
</header>