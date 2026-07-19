<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_PDF_Grid_Widget extends \Elementor\Widget_Base {

	public function get_style_depends() {
		return array( 'elementor-pdf-grid' );
	}

	public function get_name() {
		return 'pdf_grid';
	}

	public function get_title() {
		return esc_html__( 'PDF Grid', 'elementor-pdf-grid' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		// ==========================
		// CONTENT TAB: PDF Items
		// ==========================
		$this->start_controls_section(
			'content_section',[
				'label' => esc_html__( 'PDF Items', 'elementor-pdf-grid' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',[
				'label' => esc_html__( 'Title', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'PDF Title' , 'elementor-pdf-grid' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',[
				'label' => esc_html__( 'Description', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 3,
			]
		);

		$repeater->add_control(
			'pdf_file',[
				'label' => esc_html__( 'PDF File', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_type' => 'application/pdf',
			]
		);

		$repeater->add_control(
			'image',[
				'label' => esc_html__( 'Custom Thumbnail', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__( 'Leave empty to auto-use the PDF 1st page (Requires ImageMagick on server).', 'elementor-pdf-grid' ),
			]
		);

		$this->add_control(
			'pdf_list',[
				'label' => esc_html__( 'PDFs', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [[ 'title' => esc_html__( 'Sample Brochure', 'elementor-pdf-grid' ) ]],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		// ==========================
		// CONTENT TAB: Grid Settings
		// ==========================
		$this->start_controls_section(
			'layout_section',[
				'label' => esc_html__( 'Grid Settings', 'elementor-pdf-grid' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'columns',[
				'label' => esc_html__( 'Columns', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'default' => 4,
				'selectors' =>[
					'{{WRAPPER}} .epg-grid-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',[
				'label' => esc_html__( 'Column Gap', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'default' =>[ 'unit' => 'px', 'size' => 30 ],
				'selectors' =>[ '{{WRAPPER}} .epg-grid-container' => 'column-gap: {{SIZE}}{{UNIT}};'],
			]
		);

		$this->add_responsive_control(
			'row_gap',[
				'label' => esc_html__( 'Row Gap', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' =>[ 'px', 'em', 'rem', '%' ],
				'default' =>[ 'unit' => 'px', 'size' => 30 ],
				'selectors' =>[ '{{WRAPPER}} .epg-grid-container' => 'row-gap: {{SIZE}}{{UNIT}};'],
			]
		);

		$this->add_control(
			'content_position',[
				'label' => esc_html__( 'Text Position', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' =>[ 'title' => 'Top', 'icon' => 'eicon-v-align-top' ],
					'bottom' =>[ 'title' => 'Bottom', 'icon' => 'eicon-v-align-bottom' ],
				],
				'default' => 'bottom',
			]
		);

		$this->add_control(
			'text_align',[
				'label' => esc_html__( 'Text Alignment', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' =>[
					'left' =>[ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
					'center' =>[ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
					'right' =>[ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
				],
				'default' => 'center',
				'selectors' =>[ '{{WRAPPER}} .epg-item-content' => 'text-align: {{VALUE}};'],
			]
		);

		$this->end_controls_section();

		// ==========================
		// STYLE TAB: Box Model
		// ==========================
		$this->start_controls_section(
			'style_box_section',[
				'label' => esc_html__( 'Box', 'elementor-pdf-grid' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'box_padding',[
				'label' => esc_html__( 'Padding', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' =>[ 'px', 'em', '%' ],
				'selectors' =>[ '{{WRAPPER}} .epg-item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->start_controls_tabs( 'box_style_tabs' );

		// Box Normal
		$this->start_controls_tab( 'box_normal_tab', [ 'label' => esc_html__( 'Normal', 'elementor-pdf-grid' ) ] );

		$this->add_control(
			'box_bg_color',[
				'label' => esc_html__( 'Background Color', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' =>[ '{{WRAPPER}} .epg-item-link' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .epg-item-link',
			]
		);

		$this->add_responsive_control(
			'box_border_radius',[
				'label' => esc_html__( 'Border Radius', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' =>[ '{{WRAPPER}} .epg-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .epg-item-link',
			]
		);

		$this->end_controls_tab();

		// Box Hover
		$this->start_controls_tab( 'box_hover_tab',[ 'label' => esc_html__( 'Hover', 'elementor-pdf-grid' ) ] );

		$this->add_control(
			'box_bg_color_hover',[
				'label' => esc_html__( 'Background Color', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' =>[ '{{WRAPPER}} .epg-item-link:hover' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'box_border_color_hover',[
				'label' => esc_html__( 'Border Color', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' =>[ '{{WRAPPER}} .epg-item-link:hover' => 'border-color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),[
				'name' => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .epg-item-link:hover',
			]
		);

		$this->add_control(
			'box_hover_animation',[
				'label' => esc_html__( 'Hover Animation (Float)', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor-pdf-grid' ),
				'label_off' => esc_html__( 'No', 'elementor-pdf-grid' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		// ==========================
		// STYLE TAB: Image
		// ==========================
		$this->start_controls_section(
			'style_image_section',[
				'label' => esc_html__( 'Image', 'elementor-pdf-grid' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_spacing',[
				'label' => esc_html__( 'Spacing (Gap)', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'selectors' =>[
					'{{WRAPPER}} .epg-img-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',[
				'label' => esc_html__( 'Border Radius', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' =>[ 
					'{{WRAPPER}} .epg-img-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
					'{{WRAPPER}} .epg-item-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
				],
			]
		);

		$this->start_controls_tabs( 'image_style_tabs' );

		// Image Normal
		$this->start_controls_tab( 'image_normal_tab',[ 'label' => esc_html__( 'Normal', 'elementor-pdf-grid' ) ] );

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),[
				'name' => 'image_css_filters',
				'selector' => '{{WRAPPER}} .epg-item-img',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .epg-item-img',
			]
		);

		$this->end_controls_tab();

		// Image Hover
		$this->start_controls_tab( 'image_hover_tab',[ 'label' => esc_html__( 'Hover', 'elementor-pdf-grid' ) ] );

		$this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),[
				'name' => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .epg-item-link:hover .epg-item-img',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),[
				'name' => 'image_box_shadow_hover',
				'selector' => '{{WRAPPER}} .epg-item-link:hover .epg-item-img',
			]
		);

		$this->add_control(
			'image_zoom_hover',[
				'label' => esc_html__( 'Zoom In on Hover', 'elementor-pdf-grid' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'selectors' =>[
					'{{WRAPPER}} .epg-item-link:hover .epg-item-img' => 'transform: scale(1.05);',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		// ==========================
		// STYLE TAB: Title
		// ==========================
		$this->start_controls_section(
			'style_title_section',[
				'label' => esc_html__( 'Title', 'elementor-pdf-grid' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(),[ 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .epg-item-title' ] );

		$this->start_controls_tabs( 'title_style_tabs' );
		$this->start_controls_tab( 'title_normal_tab',[ 'label' => esc_html__( 'Normal', 'elementor-pdf-grid' ) ] );
		$this->add_control( 'title_color',[ 'label' => 'Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' =>[ '{{WRAPPER}} .epg-item-title' => 'color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'title_hover_tab',[ 'label' => esc_html__( 'Hover', 'elementor-pdf-grid' ) ] );
		$this->add_control( 'title_color_hover',[ 'label' => 'Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' =>[ '{{WRAPPER}} .epg-item-link:hover .epg-item-title' => 'color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control( 'title_spacing',[ 'label' => 'Margin Bottom', 'type' => \Elementor\Controls_Manager::SLIDER, 'selectors' =>[ '{{WRAPPER}} .epg-item-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ], 'separator' => 'before' ] );

		$this->end_controls_section();

		// ==========================
		// STYLE TAB: Description
		// ==========================
		$this->start_controls_section(
			'style_desc_section',[
				'label' => esc_html__( 'Description', 'elementor-pdf-grid' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(),[ 'name' => 'desc_typography', 'selector' => '{{WRAPPER}} .epg-item-desc' ] );

		$this->start_controls_tabs( 'desc_style_tabs' );
		$this->start_controls_tab( 'desc_normal_tab',[ 'label' => esc_html__( 'Normal', 'elementor-pdf-grid' ) ] );
		$this->add_control( 'desc_color',[ 'label' => 'Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' =>[ '{{WRAPPER}} .epg-item-desc' => 'color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		
		$this->start_controls_tab( 'desc_hover_tab',[ 'label' => esc_html__( 'Hover', 'elementor-pdf-grid' ) ] );
		$this->add_control( 'desc_color_hover',[ 'label' => 'Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' =>[ '{{WRAPPER}} .epg-item-link:hover .epg-item-desc' => 'color: {{VALUE}};' ] ] );
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Helper function to attempt to get the WP Auto-generated PDF Thumbnail
	 */
	private function get_pdf_auto_thumbnail( $attachment_id ) {
		// wp_get_attachment_image_src returns an array. 
		// For PDFs, it returns a generic icon UNLESS the server has ImageMagick and generated a real thumbnail.
		$image = wp_get_attachment_image_src( $attachment_id, 'large', false );
		
		if ( $image ) {
			// Check if it's the generic WP document fallback icon
			if ( strpos( $image[0], 'wp-includes/images/media/document.png' ) === false && strpos( $image[0], 'wp-includes/images/media/default.png' ) === false ) {
				return $image[0]; // It's a real thumbnail!
			}
		}
		return false; // Failed to get real thumbnail
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['pdf_list'] ) ) {
			return;
		}

		// Dynamically assign classes based on settings
		$box_animation_class = ( 'yes' === $settings['box_hover_animation'] ) ? 'epg-hover-float' : '';
		$text_pos = $settings['content_position'];

		echo '<div class="epg-grid-container">';

		foreach ( $settings['pdf_list'] as $item ) {
			$pdf_url = ! empty( $item['pdf_file']['url'] ) ? $item['pdf_file']['url'] : '#';
			
			// THUMBNAIL LOGIC
			$img_url = '';
			// 1. User uploaded a custom thumb
			if ( ! empty( $item['image']['url'] ) ) {
				$img_url = $item['image']['url'];
			} 
			// 2. Try WP Auto-Generated PDF First Page
			elseif ( ! empty( $item['pdf_file']['id'] ) ) {
				$auto_thumb = $this->get_pdf_auto_thumbnail( $item['pdf_file']['id'] );
				if ( $auto_thumb ) {
					$img_url = $auto_thumb;
				}
			}
			// 3. Fallback generic placeholder
			if ( empty( $img_url ) ) {
				$img_url = includes_url( 'images/media/document.png' );
			}

			// Begin Item
			echo '<div class="epg-grid-item">';
			echo '<a href="' . esc_url( $pdf_url ) . '" target="_blank" rel="noopener noreferrer" class="epg-item-link ' . esc_attr( $box_animation_class ) . '">';
			
			// Define Image HTML
			$image_html = '<div class="epg-img-wrapper"><img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $item['title'] ) . '" class="epg-item-img" /></div>';
			
			// Define Text Content HTML
			$text_html = '<div class="epg-item-content">';
			$text_html .= '<h4 class="epg-item-title">' . esc_html( $item['title'] ) . '</h4>';
			if ( ! empty( $item['description'] ) ) {
				$text_html .= '<p class="epg-item-desc">' . wp_kses_post( $item['description'] ) . '</p>';
			}
			$text_html .= '</div>';

			// Render based on Top/Bottom position setting
			if ( 'top' === $text_pos ) {
				echo $text_html;
				echo $image_html;
			} else {
				echo $image_html;
				echo $text_html;
			}
			
			echo '</a>';
			echo '</div>';
		}

		echo '</div>';
	}
}
