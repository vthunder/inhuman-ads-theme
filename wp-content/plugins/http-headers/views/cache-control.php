<tr>
	<th scope="row">Cache-Control
		<p class="description">The Cache-Control general-header field is used to specify directives for caching mechanisms in both, requests and responses. Caching directives are unidirectional, meaning that a given directive in a request is not implying that the same directive is to be given in the response.</p>
	</th>
	<td>
        <fieldset>
        	<legend class="screen-reader-text">Cache-Control</legend>
	    <?php
        $cache_control = get_option('hh_cache_control', 0);
        foreach ($bools as $k => $v)
        {
        	?><p><label><input type="radio" class="http-header" name="hh_cache_control" value="<?php echo $k; ?>"<?php checked($cache_control, $k); ?> /> <?php echo $v; ?></label></p><?php
        }
        ?>
		</fieldset>
	</td>
	<td>
		<?php settings_fields( 'http-headers-cc' ); ?>
		<?php do_settings_sections( 'http-headers-cc' ); ?>
		<?php 
		$items = array(
			'must-revalidate' => 'bool',
			'no-cache' => 'bool',
			'no-store' => 'bool',
			'no-transform' => 'bool',
			'public' => 'bool',
			'private' => 'bool',
			'proxy-revalidate' => 'bool',
			'max-age' => 'int',
			's-maxage' => 'int',
		);
		?>
		<table>
		<?php 
		$cache_control_value = get_option('hh_cache_control_value');
		if (!$cache_control_value)
		{
			$cache_control_value = array();
		}
		foreach ($items as $item => $type)
		{
			?>
			<tr>
				<td><label for="hh_cache_control_value_<?php echo $item; ?>"><?php echo $item; ?></label></td>
				<td><?php
				switch ($type) {
					case 'bool':
						?><input type="checkbox" class="http-header-value" name="hh_cache_control_value[<?php echo $item; ?>]" id="hh_cache_control_value_<?php echo $item; ?>" value="1"<?php checked(array_key_exists($item, $cache_control_value), 1, true); ?>><?php
						break;
					case 'int':
						?><input type="text" class="http-header-value" name="hh_cache_control_value[<?php echo $item; ?>]" id="hh_cache_control_value_<?php echo $item; ?>" value="<?php echo array_key_exists($item, $cache_control_value) && strlen($cache_control_value[$item]) > 0 ? (int) $cache_control_value[$item] : NULL; ?>"> seconds<?php
						break;
				}
				?>	
				</td>
			</tr>
			<?php 
		}
		?>
		</table>
	</td>
</tr>