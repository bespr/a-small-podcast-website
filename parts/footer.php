        <p>

        <?php if (!empty($config['footerLinkUrl'])) { ?>
        <a href="<?php echo $config['footerLinkUrl']; ?>"><?php echo $config['footerLinkText']; ?></a>
        <?php } ?>

        <?php if (!empty($config['email'])) { ?>
        <a href="mailto:<?php echo $config['email']; ?>"><?php echo $config['email']; ?></a>
        <?php } ?>
        
        <?php if (!empty($config['twitter'])) { ?>
        <a href="<?php echo $config['twitter']; ?>">Twitter</a>
        <?php } ?>
        
        <?php if (!empty($config['instagram'])) { ?>
        <a href="<?php echo $config['instagram']; ?>">Instagram</a>
        <?php } ?>
        
        <?php if (!empty($config['facebook'])) { ?>
        <a href="<?php echo $config['facebook']; ?>">Facebook</a>
        <?php } ?>
        
    </p>