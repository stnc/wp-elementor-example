<?php
//plugins\elementor\includes\widgets\icon-list.php  -- for repeater 
// plugins\elementor\includes\widgets\video.php
//plugins\elementor\includes\widgets\image-gallery.php
//plugins\elementor\includes\widgets\image-box.php

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
class Elementor_Test_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'TVS-featured-videos';
    }

    public function get_title() {
        return __( 'TVS Featured Videos', 'debatelang' );
    }

    public function get_icon() {
        return 'fa fa-podcast';
    }

    public function get_categories() {
        return [ 'basic' ];
    }



    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'elementor-castos-extension' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
		$gallery_columns = range( 1, 10 );
		$gallery_columns = array_combine( $gallery_columns, $gallery_columns );

		$this->add_control(
			'gallery_columns',
			[
				'label' => esc_html__( 'Columns', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 4,
				'options' => $gallery_columns,
			]
		);
        $this->add_control(
			'view',
			[
				'label' => esc_html__( 'Layout', 'elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'traditional',
				'options' => [
					'traditional' => [
						'title' => esc_html__( 'Default', 'elementor' ),
						'icon' => 'eicon-editor-list-ul',
					],
					// 'inline' => [
					// 	'title' => esc_html__( 'Inline', 'elementor' ),
					// 	'icon' => 'eicon-ellipsis-h',
					// ],
				],
				'render_type' => 'template',
				'classes' => 'elementor-control-start-end',
				'style_transfer' => true,
				'prefix_class' => 'elementor-icon-list--layout-',
			]
		);
        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Video Item', 'elementor' ),
				'default' => esc_html__( 'Video Item', 'elementor' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

        $repeater->add_control(
			'subText',
			[
				'label' => esc_html__( 'Sub Text', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Video Item', 'elementor' ),
				'default' => esc_html__( 'Video Item', 'elementor' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);


        $repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
			]
		);

		$repeater->add_control(
			'selected_image',
			[
				'label' => esc_html__( 'Image', 'elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'youtube_url',
			[
				'label' => esc_html__( 'Link', 'elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your URL', 'elementor' ) . ' (YouTube)',
				'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'ai' => [
					'active' => false,
				],
				'frontend_available' => true,
			]
		);


		$this->add_control(
			'icon_list',
			[
				'label' => esc_html__( 'Items', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => esc_html__( 'Video Item #1', 'elementor' ),
						'selected_icon' => [
							'value' => 'fas fa-check',
							'library' => 'fa-solid',
						],
					],
					[
						'text' => esc_html__( 'Video Item #2', 'elementor' ),
						'selected_icon' => [
							'value' => 'fas fa-times',
							'library' => 'fa-solid',
						],
					],
					[
						'text' => esc_html__( 'Video Item #3', 'elementor' ),
						'selected_icon' => [
							'value' => 'fas fa-dot-circle',
							'library' => 'fa-solid',
						],
					],
				],
				'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
			]
		);

		// $this->add_control(
		// 	'link_click',
		// 	[
		// 		'label' => esc_html__( 'Apply Link On', 'elementor' ),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'options' => [
		// 			'full_width' => esc_html__( 'Full Width', 'elementor' ),
		// 			'inline' => esc_html__( 'Inline', 'elementor' ),
		// 		],
		// 		'default' => 'full_width',
		// 		'separator' => 'before',
		// 		'prefix_class' => 'elementor-list-item-link-',
		// 	]
		// );

        $this->end_controls_section();
    }

//     protected function render() {
//         $settings = $this->get_settings_for_display();
//    // echo "<pre>";
//    //  echo print_r($settings['icon_list'], true);
//         foreach ( $settings['icon_list'] as $element ) {
//             echo '<div>' . $element . '</div>';
//         }

//     }

//     protected function _content_template() {
//         
//         <# _.each( settings.icon_list, function( element ) { #>
//         <div>{{{ element }}}</div>
//         <# } ) #>
//         <?php
//     }


	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$fallback_defaults = [
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		];


		?>

<div class="container-fluid">
<div class="row row-cols-2 row-cols-sm-4 row-cols-md-3 g-3">
                                                  <div class="col">
                            <div class="card- shadow-sm-">
                              <a href="#inline-video0" class="debateBox" data-glightbox="width: 700; height: auto;">
                                                                  <img src="http://debates.test/wp-content/uploads/2024/08/f5t-Pi_maBU-HD-150x150.jpg" style="max-width:none!important; height: 120px !important; width: 120px !important; padding:2px" alt="Highlights">
                                                                <span class="w-100  float-left"> Highlights </span>
                              </a>

                              <div id="inline-video0" style="display: none">
                                <div class="inline-inner">
                                  <h4 class="text-center"> Highlights </h4>
                                  <div class="text-center">

                                    <iframe width="600" height="400" src="https://www.youtube.com/embed/f5t-Pi_maBU?autoplay=0&amp;mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                                    <p>
                                      DC Democratic Mayoral Debate hosted by FOX 5 DC and Georgetown University It was debate night in the District. FOX 5 and the Georgetown University Institute of Politics teamed up for the D.C. Democratic Mayoral Debate. D.C. Mayor Muriel Bowser, and Councilmembers Trayon White and Robert White Jr. squared off over a range of issues. READ MORE: https://bit.ly/3zfeB30                                    </p>
                                  </div>
                                  <a class="gtrigger-close inline-close-btn" href="#">Close</a>
                                </div>
                              </div>
                            </div>

                          </div>
                                                  <div class="col">
                            <div class="card- shadow-sm-">
                              <a href="#inline-video1" class="debateBox" data-glightbox="width: 700; height: auto;">
                                                                  <img src="http://debates.test/wp-content/uploads/2024/07/debate1-150x150.webp" style="max-width:none!important; height: 120px !important; width: 120px !important; padding:2px" alt="">
                                                                <span class="w-100  float-left">  </span>
                              </a>

                              <div id="inline-video1" style="display: none">
                                <div class="inline-inner">
                                  <h4 class="text-center">  </h4>
                                  <div class="text-center">

                                    <iframe width="600" height="400" src="https://www.youtube.com/embed/jmGcO4kvD3s?autoplay=0&amp;mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                                    <p>
                                      Example 2 Lorem ipsum odor amet, consectetuer adipiscing elit. Quis in mus ridiculus; imperdiet magnis gravida mi. Ipsum duis fringilla sollicitudin pharetra habitasse. Arcu diam nunc nibh leo a. Vulputate felis curabitur pulvinar dictum nulla primis class aptent. Torquent turpis sagittis sit habitasse venenatis himenaeos pretium ridiculus.                                    </p>
                                  </div>
                                  <a class="gtrigger-close inline-close-btn" href="#">Close</a>
                                </div>
                              </div>
                            </div>

                          </div>
                                              </div>
</div>
        
		<ul <?php $this->print_render_attribute_string( 'icon_list' ); ?>>
			<?php
			foreach ( $settings['icon_list'] as $index => $item ) :
				$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );

				$this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-icon-list-text' );

				$this->add_inline_editing_attributes( $repeater_setting_key );
				$migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();
				?>
				<li <?php $this->print_render_attribute_string( 'list_item' ); ?>>
					<?php
					if ( ! empty( $item['link']['url'] ) ) {
						$link_key = 'link_' . $index;

						$this->add_link_attributes( $link_key, $item['link'] );
						?>
						<a <?php $this->print_render_attribute_string( $link_key ); ?>>

						<?php
					}

					// add old default
					if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
						$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
					}

					$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
					$is_new = ! isset( $item['icon'] ) && $migration_allowed;
					if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) :
						?>
						<span class="elementor-icon-list-icon">
							<?php
							if ( $is_new || $migrated ) {
								\Elementor\Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
							} else { ?>
									<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
							<?php } ?>
						</span>
					<?php endif; ?>
					<span <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>><?php $this->print_unescaped_setting( 'text', 'icon_list', $index ); ?></span>
					<?php if ( ! empty( $item['link']['url'] ) ) : ?>
						</a>
					<?php endif; ?>
				</li>
				<?php
			endforeach;
			?>
		</ul>
		<?php
	}

	/**
	 * Render icon list widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
			view.addRenderAttribute( 'icon_list', 'class', 'elementor-icon-list-items' );
			view.addRenderAttribute( 'list_item', 'class', 'elementor-icon-list-item' );

			if ( 'inline' == settings.view ) {
				view.addRenderAttribute( 'icon_list', 'class', 'elementor-inline-items' );
				view.addRenderAttribute( 'list_item', 'class', 'elementor-inline-item' );
			}
			var iconsHTML = {},
				migrated = {};
		#>
		<# if ( settings.icon_list ) { #>
			<ul {{{ view.getRenderAttributeString( 'icon_list' ) }}}>
			<# _.each( settings.icon_list, function( item, index ) {

					var iconTextKey = view.getRepeaterSettingKey( 'text', 'icon_list', index );

					view.addRenderAttribute( iconTextKey, 'class', 'elementor-icon-list-text' );

					view.addInlineEditingAttributes( iconTextKey ); #>

					<li {{{ view.getRenderAttributeString( 'list_item' ) }}}>
						<# if ( item.link && item.link.url ) { #>
							<a href="{{ elementor.helpers.sanitizeUrl( item.link.url ) }}">
						<# } #>
						<# if ( item.icon || item.selected_icon.value ) { #>
						<span class="elementor-icon-list-icon">
							<#
								iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
								migrated[ index ] = elementor.helpers.isIconMigrated( item, 'selected_icon' );
								if ( iconsHTML[ index ] && iconsHTML[ index ].rendered && ( ! item.icon || migrated[ index ] ) ) { #>
									{{{ iconsHTML[ index ].value }}}
								<# } else { #>
									<i class="{{ item.icon }}" aria-hidden="true"></i>
								<# }
							#>
						</span>
						<# } #>
						<span {{{ view.getRenderAttributeString( iconTextKey ) }}}>{{{ item.text }}}</span>
						<# if ( item.link && item.link.url ) { #>
							</a>
						<# } #>
					</li>
				<#
				} ); #>
			</ul>
		<#	} #>

		<?php
	}



}