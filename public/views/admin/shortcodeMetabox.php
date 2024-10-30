<div class="ykb-bootstrap-wrapper">
    <label>
		<?php _e('Shortcode'); ?>
    </label>
    <input type="text" onfocus="this.select();" readonly="" value="[ykb_knowledge_base]" class="large-text code">
    
    <label>
        <?php _e('Current version'); ?>
    </label>
    <p class="current-version-text" style="color: #3474ff;"><?php echo YKB_VERSION_TEXT; ?></p>
    <label>
        <?php _e('Last update date'); ?>
    </label>
    <p style="color: #11ca79;"><?php echo YKB_LAST_UPDATE; ?></p>
    <label>
        <?php _e('Next update date'); ?>
    </label>
    <p style="color: #efc150;"><?php echo YKB_NEXT_UPDATE; ?></p>
</div>