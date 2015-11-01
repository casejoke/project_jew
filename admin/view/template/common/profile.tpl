<div class="profile-menu">
    <a href="">
        <div class="profile-pic">
            <img src="<?php echo $image; ?>" alt="<?php echo $firstname; ?> <?php echo $lastname; ?>">
        </div>
        <div class="profile-info">
            <?php echo $firstname; ?> <?php echo $lastname; ?>
            <i class="md md-arrow-drop-down"></i>
        </div>
    </a>
    
    <ul class="main-menu">
        <li>
            <a href="<?php echo $logout; ?>"><i class="md md-exit-to-app"></i> <?php echo $text_logout; ?></a>
        </li>
    </ul>
</div>
