

<div class="right_class">
    <ul class="list-inline">
        <li><a href="logout.php">Logout</a></li>
        <li><a href="change_password.php">Change Password</a></li>
        <?php if (un_hash_val($_SESSION['current_user_type']) == constantss::$user_type_admin) { ?>
            <li><a href="manage_courses.php">Your Home Page</a></li>
        <?php }else{ ?>
            <li><a href="main_page.php">Your Home Page</a></li>
        <?php }?>
    </ul>
</div>
<br/>
<!--</div>-->

