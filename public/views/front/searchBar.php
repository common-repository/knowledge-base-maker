<?php
$savedOptions = get_option('ykb_save_config');
$searchHeaderText = $this->getOptionValue('ykb-search-header');
$inProgressLabel = $this->getOptionValue('ykb-search-button-progress-label');
$label = $this->getOptionValue('ykb-search-button-label');
?>
<div class="ykb-wrapper">
	<div class="ykb-content-wrapper">
		<div class="ykb-content-header">
			<h2><?php echo $searchHeaderText; ?></h2>
		</div>
		<div class="ykb-content">
			<div class="ykb-inputs-wrapper">
				<div class="ykb-search-input-wrapper">
					<input type="text" name="ykb-search-text" placeholder="<?php echo esc_attr($this->getOptionValue('ykb-search-input-placeholder')); ?>" class="ykb-search-input" value="">
				</div>
				<div class="ykb-search-button-wrapper">
					<button class="ykb-search-button" data-label="<?php echo esc_attr($label);?>" data-progress-label="<?php echo esc_attr($inProgressLabel);?>"><?php echo esc_attr($label); ?></button>
				</div>
			</div>
			<div class="ykb-search-result ykb-hide"></div>
		</div>
	</div>
</div>