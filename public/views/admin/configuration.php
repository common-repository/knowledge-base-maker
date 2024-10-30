<div class="ykb-bootstrap-wrapper">
	<?php if(!empty($_GET['saved'])) : ?>
        <div id="default-message" class="updated notice notice-success is-dismissible">
            <p>Configuration updated.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
	<?php endif; ?>
	<div class="row">
		<div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><?php _e('Settings', YKB_TEXT_DOMAIN);?></div>
                <div class="panel-body">
                    <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label><?php _e('Search header text', YKB_TEXT_DOMAIN); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" name="ykb-search-header" value="<?php echo esc_attr($typeObj->getOptionValue('ykb-search-header')); ?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="ykb-search-button-label"><?php _e('Search Button label', YKB_TEXT_DOMAIN); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" name="ykb-search-button-label" id="ykb-search-button-label" value="<?php echo esc_attr($typeObj->getOptionValue('ykb-search-button-label')); ?>">
                            </div>
                        </div>
	                    <div class="row form-group">
                            <div class="col-md-6">
                                <label for="ykb-search-button-progress-label"><?php _e('In Progress Label', YKB_TEXT_DOMAIN); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" name="ykb-search-button-progress-label" id="ykb-search-button-progress-label" value="<?php echo esc_attr($typeObj->getOptionValue('ykb-search-button-progress-label')); ?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="ykb-search-input-placeholder"><?php _e('Search Input label', YKB_TEXT_DOMAIN); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" name="ykb-search-input-placeholder" id="ykb-search-input-placeholder" value="<?php echo esc_attr($typeObj->getOptionValue('ykb-search-input-placeholder')); ?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="ykb-search-input-placeholder"><?php _e('Not Found Title', YKB_TEXT_DOMAIN); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" name="ykb-search-notfound-title" id="ykb-search-notfound-title" value="<?php echo esc_attr($typeObj->getOptionValue('ykb-search-notfound-title')); ?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="ykb-search-for-text"><?php _e('Search For Text', YKB_TEXT_DOMAIN); ?></label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" name="ykb-search-for-text" id="ykb-search-for-text" value="<?php echo esc_attr($typeObj->getOptionValue('ykb-search-for-text')); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="<?php _e('Save', YKB_TEXT_DOMAIN); ?>">
                            </div>
                        </div>
                        <input name='action' type="hidden" value='ykb_save_configuration'>
                    </form>
                </div>
                </div>
            </div>
		<div class="col-md-2"></div>
	</div>
</div>
