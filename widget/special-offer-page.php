<?php

class SpecialOfferPage extends \Elementor\Widget_Base
{

	public function __construct($data = [], $args = null) {

		$special_offer_page = true;

		parent::__construct($data, $args);
		
		wp_register_script( 'special-offer-page_js',  plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/special-offer-page.js'), [ 'elementor-frontend' ], '1.0.0', true );

		// Prevent calling this files twice

		wp_register_script( 'searchbar_special_offer_js',  plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/searchbar.js'), [], '1.0.0', true );

		if ( is_home() || is_front_page()  == false ) {
			wp_register_script( 'zcalendar_special_offer_js',  plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/zcalendar.js'), [], '1.0.0', true ); 
		} 

		wp_register_script( 'basket_js',  plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/basket.js'), [], '1.0.0', true );

		wp_register_style( 'special-offer-page_css', plugins_url( '/OBPress_SpecialOffersPage/widget/assets/css/special-offer-page.css') );  

		wp_localize_script('special-offer-page_js', 'specialOfferAjax', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));


	}

	public function get_script_depends()
	{
		return [ 'special-offer-page_js', 'basket_js' , 'zcalendar_special_offer_js' , 'searchbar_special_offer_js' ];
	}

	public function get_style_depends()
	{
		return ['special-offer-page_css'];
	}
	
	public function get_name()
	{
		return 'SpecialOfferPage';
	}

	public function get_title()
	{
		return __('Special Offers Page', 'plugin-name');
	}

	public function get_icon()
	{
		return 'fa fa-calendar';
	}

	public function get_categories()
	{
		return ['OBPress'];
	}
	
	protected function _register_controls()
	{

		$this->start_controls_section(
			'color_section',
			[
				'label' => __('Package Main Image Style', 'OBPress_SpecialOffers'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'package_image_height',
			[
				'label' => esc_html__( 'Package Image Height', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 128,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 318,
				],
				'selectors' => [
					'.single-package .single-package-img-holder' => 'height: {{SIZE}}px!important',
					'.single-package .single-package-img' => 'height: {{SIZE}}px!important',
				],
			]
		);

		$this->add_control(
			'package_image_margin',
			[
				'label' => __( 'Package Image Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '28',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-img-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_partial_payment_padding',
			[
				'label' => __( 'Partial Payment Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '11',
					'right' => '10.85',
					'bottom' => '10',
					'left' => '12',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .MaxPartialPaymentParcel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_partial_payment_color',
			[
				'label' => __('Package Partial Payment Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .MaxPartialPaymentParcel' => 'color: {{package_partial_payment_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_partial_payment_typography',
				'label' => __('Package Partial Payment Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .MaxPartialPaymentParcel',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '19',
						],
					],
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_partial_payment_typography_value',
				'label' => __('Package Partial Payment Value Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .MaxPartialPaymentParcel span',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '19',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_partial_payment_bg_color',
			[
				'label' => __('Package Partial Payment Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .MaxPartialPaymentParcel' => 'background-color: {{package_partial_payment_bg_color}}'
				],
			]
		);

		$this->add_control(
			'package_partial_package_name_padding',
			[
				'label' => __( 'Package Name Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '18.75',
					'right' => '35',
					'bottom' => '22.76',
					'left' => '35',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-name-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'package_partial_package_name_bg_color',
			[
				'label' => __('Package Name Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .single-package-name-holder' => 'background-color: {{package_partial_package_name_bg_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Package Name Box Shadow', 'OBPress_SpecialOffers' ),
				'selector' => '{{WRAPPER}} .single-package .single-package-name-holder',
			]
		);

		$this->add_control(
			'package_hotel_name_color',
			[
				'label' => __('Hotel Name Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-package .single-package-hotel-name' => 'color: {{package_hotel_name_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'hotel_name_typography',
				'label' => __('Hotel Name Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-hotel-name',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_name_color',
			[
				'label' => __('Package Name Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .single-package-name' => 'color: {{package_hotel_name_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_name_typography',
				'label' => __('Package Name Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-name',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '24',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '29',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'package_info_section',
			[
				'label' => __('Package Info Style', 'OBPress_SpecialOffers'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'package_info_padding',
			[
				'label' => __( 'Package Info Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '22',
					'right' => '42',
					'bottom' => '25',
					'left' => '26',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-info-holder' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_info_bg_color',
			[
				'label' => __('Package Info Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .single-package-info-holder' => 'background-color: {{package_info_bg_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'package_info_box_shadows',
				'label' => esc_html__( 'Package Info Box Shadow', 'OBPress_SpecialOffers' ),
				'selector' => '{{WRAPPER}} .single-package .single-package-info-holder',
			]
		);

		$this->add_control(
			'package_message_text_color',
			[
				'label' => __('Package Message Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .single-package-included-msg' => 'color: {{package_message_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_message_typography',
				'label' => __('Package Message Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-included-msg',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_message_text_align',
			[
				'label' => __( 'Packages Message Text Align', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_SpecialOffers' ),
					'center'  => __( 'Center', 'OBPress_SpecialOffers' ),
					'right'  => __( 'Right', 'OBPress_SpecialOffers' ),
				],
				'selectors' => [
					'.single-package .single-package-included-msg' => 'text-align: {{package_message_text_align}}'
				],
			]
		);

		$this->add_control(
			'package_message_margin',
			[
				'label' => __( 'Package Message Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '22.91',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-included-msg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_included_message_margin',
			[
				'label' => __( 'Package Included Message Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '44',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-included-holder' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_included_text_color',
			[
				'label' => __('Package Included Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .single-package-included' => 'color: {{package_included_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_included_typography',
				'label' => __('Package Included Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-included',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_included_text_margin',
			[
				'label' => __( 'Package Included Text Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '40',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-included' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_included_margin',
			[
				'label' => __( 'Package Included Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '41.5',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-info-categories-bars' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_categories_text_color',
			[
				'label' => __('Package Categories Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#9C9C9C',
				'selectors' => [
					'.single-package .single-package-info-categories-bar' => 'color: {{package_categories_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_categories_typography',
				'label' => __('Package Categories Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-info-categories-bar',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_included_categories_active_text_color',
			[
				'label' => __('Package Categories Active Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000000',
				'selectors' => [
					'.single-package .single-package-info-categories-bar.active-bar' => 'color: {{package_included_categories_active_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_included_active_typography',
				'label' => __('Package Categories Active Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-info-categories-bar.active-bar',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_included_categories_text_margin',
			[
				'label' => __( 'Package Included Categories Text Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '40',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-info-categories-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_included_categories_margin',
			[
				'label' => __( 'Package Included Categories Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '41.5',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-info-categories-bars' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_description_text_color',
			[
				'label' => __('Package Description Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-package .package-description-short' => 'color: {{package_included_categories_active_text_color}}',
					'.single-package .package-description-long' => 'color: {{package_included_categories_active_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_description_typography',
				'label' => __('Package Description Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .package-description-short, .single-package .package-description-long',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_description_text_align',
			[
				'label' => __( 'Packages Description Text Align', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_SpecialOffers' ),
					'center'  => __( 'Center', 'OBPress_SpecialOffers' ),
					'right'  => __( 'Right', 'OBPress_SpecialOffers' ),
				],
				'selectors' => [
					'.single-package .single-package-info-category-section' => 'text-align: {{package_description_text_align}}'
				],
			]
		);

		$this->add_control(
			'package_see_more_text_color',
			[
				'label' => __('Package See More Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#4B8CF4',
				'selectors' => [
					'.single-package .package-more-description' => 'color: {{package_see_more_text_color}}',
					'.single-package .package-less-description' => 'color: {{package_see_more_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_see_more_typography',
				'label' => __('Package Description Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .package-more-description, .single-package .package-less-description',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '17',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'searchbar_color_section',
			[
				'label' => __('Package Searchbar Style', 'OBPress_SpecialOffers'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'package_searchbar_margin',
			[
				'label' => __( 'Searchbar Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '20',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .package-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_searchbar_padding',
			[
				'label' => __( 'Searchbar Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '30',
					'bottom' => '0',
					'left' => '30',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .ob-searchbar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
				],
			]
		);

		$this->add_control(
			'package_searchbar_justify_content',
			[
				'label' => __( 'Searchbar Justify Content', 'OBPress_SpecialOffersList' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'space-between',
				'options' => [
					'space-between'  => __( 'Space Between', 'OBPress_SpecialOffersList' ),
					'space-around'  => __( 'Space Around', 'OBPress_SpecialOffersList' ),
					'space-evenly'  => __( 'Space Evenly', 'OBPress_SpecialOffersList' ),
					'center' => __( 'Center', 'OBPress_SpecialOffersList' ),
					'flex-end'  => __( 'Flex End', 'OBPress_SpecialOffersList' ),
					'flex-start'  => __( 'Flex Start', 'OBPress_SpecialOffersList' ),
				],
				'selectors' => [
					'.single-package .ob-searchbar' => 'justify-content: {{package_searchbar_justify_content}}'
				],
			]
		);

		$this->add_control(
			'package_searchbar_elements_padding',
			[
				'label' => __( 'Searchbar Elements Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '20',
					'right' => '10',
					'bottom' => '20',
					'left' => '10',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .ob-searchbar-hotel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.single-package .ob-searchbar-calendar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.single-package .ob-searchbar-guests' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.single-package .ob-searchbar-promo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_searchbar_title_text_color',
			[
				'label' => __('Searchbar Title Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .ob-searchbar-hotel > p' => 'color: {{package_searchbar_title_text_color}}',
					'.single-package .ob-searchbar-calendar > p' => 'color: {{package_searchbar_title_text_color}}',
					'.single-package .ob-searchbar-guests > p' => 'color: {{package_searchbar_title_text_color}}',
					'.single-package .ob-searchbar-promo > p' => 'color: {{package_searchbar_title_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_searchbar_title_text_typography',
				'label' => __('Searchbar Title Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .ob-searchbar-hotel > p, .single-package .ob-searchbar-calendar > p, .single-package .ob-searchbar-guests > p, .single-package .ob-searchbar-promo > p',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '19',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_searchbar_inputs_text_color',
			[
				'label' => __('Searchbar Inputs Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .ob-searchbar-guests input' => 'color: {{package_searchbar_inputs_text_color}}',
					'.single-package .ob-searchbar-calendar input' => 'color: {{package_searchbar_inputs_text_color}}',
					'.single-package .ob-searchbar-promo input::placeholder' => 'color: {{package_searchbar_inputs_text_color}}',
					'.single-package .ob-searchbar-hotel input::placeholder' => 'color: {{package_searchbar_inputs_text_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_searchbar_inputs_text_typography',
				'label' => __('Searchbar Inputs Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .ob-searchbar-calendar input, .single-package .ob-searchbar-guests input, .single-package .ob-searchbar-promo input, .single-package .ob-searchbar-hotel input',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_searchbar_button_padding',
			[
				'label' => __( 'Searchbar Button Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '30',
					'right' => '10',
					'bottom' => '30',
					'left' => '10',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .ob-searchbar-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'package_searchbar_buutton_text_color',
			[
				'label' => __('Searchbar Button Text Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .ob-searchbar-submit' => 'color: {{package_searchbar_buutton_text_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'package_searchbar_buutton_text_typography',
				'label' => __('Searchbar Button Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .ob-searchbar-submit',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '800',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
				],
			]
		);

		$this->add_control(
			'package_searchbar_buutton_bg_color',
			[
				'label' => __('Searchbar Button Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .ob-searchbar-submit' => 'background-color: {{package_searchbar_buutton_bg_color}}'
				],
			]
		);

		$this->add_control(
			'package_searchbar_buutton_border_color',
			[
				'label' => __('Searchbar Button Border Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .ob-searchbar-submit' => 'border-color: {{package_searchbar_buutton_border_color}}'
				],
			]
		);

		$this->add_control(
			'package_searchbar_buutton_border_width',
			[
				'label' => __( 'Searchbar Button Border Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 10,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .ob-searchbar-submit' => 'border-width: {{SIZE}}px',
				],
			]
		);
		
		$this->add_control(
			'package_searchbar_buutton_text_hover_color',
			[
				'label' => __('Searchbar Button Text Hover Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .ob-searchbar-submit:hover' => 'color: {{package_searchbar_buutton_text_hover_color}}'
				],
			]
		);

		$this->add_control(
			'package_searchbar_buutton_hover_bg_color',
			[
				'label' => __('Searchbar Button Background Hover Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .ob-searchbar-submit:hover' => 'background-color: {{package_searchbar_buutton_hover_bg_color}}'
				],
			]
		);

		$this->add_control(
			'package_searchbar_buutton_hover_border_color',
			[
				'label' => __('Searchbar Button Border Hover Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .ob-searchbar-submit:hover' => 'border-color: {{package_searchbar_buutton_hover_border_color}}'
				],
			]
		);

		$this->add_control(
			'package_searchbar_buutton_width',
			[
				'label' => __( 'Button Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
						'step' => 1,
					],
				],
				'devices' => [ 'desktop', 'mobile' ],
				'desktop_default' => [
					'size' => 148,
				],
				'mobile_default' => [
					'size' => 100,
					'unit' => '%',
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .ob-searchbar-submit' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'package_searchbar_buutton_height',
			[
				'label' => __( 'Button Height', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 60,
				],
				'range' => [
					'px' => [
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .ob-searchbar-submit' => 'height: {{SIZE}}px',
				],
			]
		);


		$this->add_control(
			'package_searchbar_buutton_transition',
			[
				'label' => __( 'Button Transition Duration', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .ob-searchbar-submit' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'related_packages_style_section',
			[
				'label' => __('Related Packages Style', 'OBPress_SpecialOffers'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'relate_packages_title_color',
			[
				'label' => __('Related Packages Title Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#222222',
				'selectors' => [
					'.single-package .rooms-message-header' => 'color: {{relate_packages_title_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'relate_packages_title_typography',
				'label' => __('Related Packages Title Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .rooms-message-header',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '32',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '39',
						],
					],
				],
			]
		);

		$this->add_control(
			'relate_packages_title_margin',
			[
				'label' => __( 'Related Packages Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '69.85',
					'right' => '0',
					'bottom' => '43.77',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .rooms-message-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'relate_packages_text_align_title',
			[
				'label' => __( 'Related Packages Title Align', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'left'  => __( 'Left', 'OBPress_SpecialOffers' ),
					'center'  => __( 'Center', 'OBPress_SpecialOffers' ),
					'right'  => __( 'Right', 'OBPress_SpecialOffers' ),
				],
				'selectors' => [
					'.single-package .rooms-message-header' => 'text-align: {{relate_packages_text_align_title}}'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'related_packages_cards_section',
			[
				'label' => __('Related Cards Style', 'OBPress_SpecialOffers'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'releted_packages_between_cards_padding',
			[
				'label' => __( 'Between Cards Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '25',
					'right' => '50',
					'bottom' => '25',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-room-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_width',
			[
				'label' => __( 'Cards Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .single-package-room-container' => 'width: {{SIZE}}%',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_bg_color',
			[
				'label' => __('Cards Backgroung Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .single-package-room-rate-info' => 'background-color: {{releted_packages_cards_bg_color}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_padding',
			[
				'label' => __( 'Cards Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '54',
					'right' => '32',
					'bottom' => '31',
					'left' => '32',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-room-rate-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'cards_box_shadow',
				'label' => esc_html__( 'Cardse Box Shadow', 'OBPress_SpecialOffers' ),
				'selector' => '.single-package .single-package-room',
				'fields_options' => [
					'box_shadow_type' => [ 
						'default' =>'yes' 
					],
					'box_shadow' => [
						'default' =>[
							'horizontal' => 0,
							'vertical' => 4,
							'blur' => 7,
							'color' => '#0000001c'
						]
					]
				]
			]
		);

		$this->add_control(
			'releted_packages_cards_margin',
			[
				'label' => __( 'Cards Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '20',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-room' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_img_height',
			[
				'label' => __( 'Cards Image Height', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 254,
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'.single-package .single-package-room-img' => 'height: {{SIZE}}px; max-height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenities_padding',
			[
				'label' => __( 'Cards Amenities Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '29',
					'bottom' => '0',
					'left' => '29',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .room-amenities' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'amenities_box_shadow',
				'label' => esc_html__( 'Cards Amenities Box Shadow', 'OBPress_SpecialOffers' ),
				'selector' => '.single-package .room-amenities',
				'fields_options' => [
					'box_shadow_type' => [ 
						'default' =>'yes' 
					],
					'box_shadow' => [
						'default' =>[
							'horizontal' => 0,
							'vertical' => 14,
							'blur' => 24,
							'color' => '#bead8e30'
						]
					]
				]
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_justify_content',
			[
				'label' => __( 'Cards Amenities Horizontal Align', 'OBPress_SpecialOffersList' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'space-between',
				'options' => [
					'space-between'  => __( 'Space Between', 'OBPress_SpecialOffersList' ),
					'space-around'  => __( 'Space Around', 'OBPress_SpecialOffersList' ),
					'space-evenly'  => __( 'Space Evenly', 'OBPress_SpecialOffersList' ),
					'center' => __( 'Center', 'OBPress_SpecialOffersList' ),
					'flex-end'  => __( 'Flex End', 'OBPress_SpecialOffersList' ),
					'flex-start'  => __( 'Flex Start', 'OBPress_SpecialOffersList' ),
				],
				'selectors' => [
					'.single-package .room-amenities' => 'justify-content: {{releted_packages_cards_amenitites_justify_content}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_bg_color',
			[
				'label' => __('Cards Amenities Bg Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .room-amenities' => 'background-color: {{releted_packages_cards_amenitites_bg_color}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_align_items',
			[
				'label' => __( 'Cards Amenities Vertical Align', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center'  => __( 'Center', 'OBPress_SpecialOffers' ),
					'flex-end'  => __( 'Bottom', 'OBPress_SpecialOffers' ),
					'flex-start'  => __( 'Top', 'OBPress_SpecialOffers' ),
				],
				'selectors' => [
					'.single-package .room-amenities' => 'align-items: {{releted_packages_cards_amenitites_align_items}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_width',
			[
				'label' => __( 'Cards Amenities Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 103,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'.single-package .room-amenities' => 'width: calc(100% - {{SIZE}}px)',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_height',
			[
				'label' => __( 'Cards Amenities Height', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 53,
				],
				'range' => [
					'px' => [
						'min' => 24,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'.single-package .room-amenities' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_horizontal_position',
			[
				'label' => __( 'Cards Amenities Horizontal Positon', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 32,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 103,
						'step' => 1,
					],
				],
				'selectors' => [
					'.single-package .room-amenities' => 'left: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_vertical_position',
			[
				'label' => __( 'Cards Amenities Vertical Positon', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => -26,
				],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'.single-package .room-amenities' => 'top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_icon_width',
			[
				'label' => __( 'Cards Amenities Icon Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 24,
				],
				'range' => [
					'px' => [
						'min' => 12,
						'max' => 60,
						'step' => 1,
					],
				],
				'selectors' => [
					'.single-package .room-amenity' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_amenitites_icon_height',
			[
				'label' => __( 'Cards Amenities Icon Height', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 24,
				],
				'range' => [
					'px' => [
						'min' => 12,
						'max' => 60,
						'step' => 1,
					],
				],
				'selectors' => [
					'.single-package .room-amenity' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_name_color',
			[
				'label' => __('Cards Room Name Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#222222',
				'selectors' => [
					'.single-package .single-package-room-name' => 'color: {{releted_packages_cards_room_name_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_room_name_typography',
				'label' => __('Cards Room Name Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-room-name',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '24',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '24',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_name_text_align',
			[
				'label' => __( 'Cards Room Name Text Align', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_SpecialOffers' ),
					'center'  => __( 'Center', 'OBPress_SpecialOffers' ),
					'right'  => __( 'Right', 'OBPress_SpecialOffers' ),
				],
				'selectors' => [
					'.single-package .single-package-room-name' => 'text-align: {{releted_packages_cards_room_name_text_align}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_name_margin',
			[
				'label' => __( 'Cards Room Name Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '20',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-room-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_icon_height',
			[
				'label' => __( 'Cards Room Icon Height', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 12,
				],
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 20,
						'step' => 1,
					],
				],
				'selectors' => [
					'.single-package .single-package-room-icons-type img' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_icons_color',
			[
				'label' => __('Cards Room Icons Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-package .single-package-room-icon-name' => 'color: {{releted_packages_cards_room_icons_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_room_icons_typography',
				'label' => __('Cards Room Icons Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-room-icon-name',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
				],
			]
		);
		
		$this->add_control(
			'releted_packages_cards_room_icons_justify_content',
			[
				'label' => __( 'Cards Room Icons Justify Content', 'OBPress_SpecialOffersList' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => [
					'flex-start'  => __( 'Flex Start', 'OBPress_SpecialOffersList' ),
					'space-between'  => __( 'Space Between', 'OBPress_SpecialOffersList' ),
					'space-around'  => __( 'Space Around', 'OBPress_SpecialOffersList' ),
					'space-evenly'  => __( 'Space Evenly', 'OBPress_SpecialOffersList' ),
					'center' => __( 'Center', 'OBPress_SpecialOffersList' ),
					'flex-end'  => __( 'Flex End', 'OBPress_SpecialOffersList' ),
				],
				'selectors' => [
					'.single-package .single-package-room-icons-type' => 'justify-content: {{releted_packages_cards_room_icons_justify_content}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_icons_margin',
			[
				'label' => __( 'Cards Room Icons Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '23',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-room-icons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_between_icons_margin',
			[
				'label' => __( 'Cards Room Between Icons Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '8',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-room-icons-type' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_icons_value_color',
			[
				'label' => __('Cards Room Icons Value Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-package .single-package-room-icon-name span' => 'color: {{releted_packages_cards_room_icons_value_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_room_icons_value_typography',
				'label' => __('Cards Room Icons Value Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-room-icon-name span',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '600',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_icon_text_margin',
			[
				'label' => __( 'Cards Room Icons Name Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '8',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .single-package-room-icon-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_full_price_color',
			[
				'label' => __('Cards Room Full Price Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#9C9C9C',
				'selectors' => [
					'.single-package .price-before' => 'color: {{releted_packages_cards_room_full_price_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_full_price_typography',
				'label' => __('Cards Room Full Price Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .price-before',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_full_price_margin',
			[
				'label' => __( 'Cards Room Full Price Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '5',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .price-before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_full_price_text_align',
			[
				'label' => __( 'Cards Room Full Price Text Align', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => __( 'Left', 'OBPress_SpecialOffers' ),
					'center'  => __( 'Center', 'OBPress_SpecialOffers' ),
					'right'  => __( 'Right', 'OBPress_SpecialOffers' ),
				],
				'selectors' => [
					'.single-package .price-before' => 'text-align: {{releted_packages_cards_full_price_text_align}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_price_button_justify_content',
			[
				'label' => __( 'Cards Room Price Button Horizontal Align', 'OBPress_SpecialOffersList' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'space-between',
				'options' => [
					'space-between'  => __( 'Space Between', 'OBPress_SpecialOffersList' ),
					'space-around'  => __( 'Space Around', 'OBPress_SpecialOffersList' ),
					'space-evenly'  => __( 'Space Evenly', 'OBPress_SpecialOffersList' ),
					'center' => __( 'Center', 'OBPress_SpecialOffersList' ),
					'flex-end'  => __( 'Flex End', 'OBPress_SpecialOffersList' ),
					'flex-start'  => __( 'Flex Start', 'OBPress_SpecialOffersList' ),
				],
				'selectors' => [
					'.single-package .single-package-room-price-and-button' => 'justify-content: {{releted_packages_cards_room_price_button_justify_content}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_price_button_align_items',
			[
				'label' => __( 'Cards Room Price Button Vertical Align', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-end',
				'options' => [
					'flex-end'  => __( 'Bottom', 'OBPress_SpecialOffers' ),
					'flex-start'  => __( 'Top', 'OBPress_SpecialOffers' ),
					'center'  => __( 'Center', 'OBPress_SpecialOffers' ),
				],
				'selectors' => [
					'.single-package .single-package-room-price-and-button' => 'align-items: {{releted_packages_cards_room_price_button_align_items}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_lowest_price_color',
			[
				'label' => __('Cards Room Lowest Price Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#82B789',
				'selectors' => [
					'.single-package .price-after.best-price' => 'color: {{releted_packages_cards_room_lowest_price_color}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_price_color',
			[
				'label' => __('Cards Room Price Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#BEAD8E',
				'selectors' => [
					'.single-package .price-after' => 'color: {{releted_packages_cards_room_price_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_price_typography',
				'label' => __('Cards Room Price Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .price-after',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '25',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '25',
						],
					],
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_price_symbol_decimal_typography',
				'label' => __('Cards Room Price Symbol Decimal Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .price-after .currency_symbol_price, .single-package .price-after .decimal_value_price',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '20',
						],
					],
					'font_weight' => [
						'default' => '700',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '25',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_room_tax_color',
			[
				'label' => __('Cards Room Tax Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-package .single-package-tax-msg' => 'color: {{releted_packages_cards_room_tax_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_tax_typography',
				'label' => __('Cards Room Tax Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .single-package-tax-msg',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'related_packages_cards_buttons_section',
			[
				'label' => __('Related Cards Buttons Style', 'OBPress_SpecialOffers'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'releted_packages_cards_book_btn_padding',
			[
				'label' => __( 'Book Button Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '16',
					'right' => '17',
					'bottom' => '16',
					'left' => '16',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .room-btn-add' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_book_btn_bg_color',
			[
				'label' => __('Book Button Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .room-btn-add' => 'background-color: {{releted_packages_cards_book_btn_bg_color}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_book_btn_color',
			[
				'label' => __('Book Button Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .room-btn-add' => 'color: {{releted_packages_cards_book_btn_color}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_book_btn_typography',
				'label' => __('Book Button Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .room-btn-add',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '500',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
					'letter_spacing' => [
						'default' => [
							'unit' => 'px',
							'size' => '0.7',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_book_btn_bg_hover_color',
			[
				'label' => __('Book Button Hover Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .room-btn-add:hover' => 'background-color: {{releted_packages_cards_book_btn_bg_hover_color}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_book_btn_hover_color',
			[
				'label' => __('Book Button Hover Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .room-btn-add:hover' => 'color: {{releted_packages_cards_book_btn_hover_color}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_book_btn_transition',
			[
				'label' => __( 'Button Transition Duration', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .room-btn-add' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_number_rooms_color',
			[
				'label' => __('Number Rooms Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .text-number-of-rooms' => 'color: {{releted_packages_cards_number_rooms_color}}'
				],
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_number_rooms_typography',
				'label' => __('Number Rooms Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .text-number-of-rooms',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '14',
						],
					],
					'font_weight' => [
						'default' => '500',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
					'letter_spacing' => [
						'default' => [
							'unit' => 'px',
							'size' => '0.7',
						],
					],
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_number_rooms_padding',
			[
				'label' => __( 'Number Rooms Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '5',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .text-number-of-rooms' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_btn_minus_plus_justify_content',
			[
				'label' => __( 'Add Remove Buttons Justify Content', 'OBPress_SpecialOffersList' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => [
					'flex-start'  => __( 'Flex Start', 'OBPress_SpecialOffersList' ),
					'center' => __( 'Center', 'OBPress_SpecialOffersList' ),
					'flex-end'  => __( 'Flex End', 'OBPress_SpecialOffersList' ),
				],
				'selectors' => [
					'.single-package .obpress-hotel-results-button-bottom' => 'justify-content: {{releted_packages_cards_btn_minus_plus_justify_content}}'
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_btn_minus_plus_bg_color',
			[
				'label' => __('Add Remove Buttons Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .room-btn-minus, .single-package .room-btn-plus' => 'background-color: {{releted_packages_cards_btn_minus_plus_bg_color}}',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_btn_minus_plus_hover_bg_color',
			[
				'label' => __('Add Remove Buttons Hover Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#000',
				'selectors' => [
					'.single-package .room-btn-minus:hover, .single-package .room-btn-plus:hover' => 'background-color: {{releted_packages_cards_btn_minus_plus_hover_bg_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'releted_packages_cards_btn_minus_plus_border',
				'label' => __( 'Add Remove Buttons Border', 'OBPress_SpecialOffers' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#000',
					],
				],
				'selector' => '.single-package .room-btn-minus, .single-package .room-btn-plus',
			]
		);

		$this->add_control(
			'releted_packages_cards_btn_minus_plus_color',
			[
				'label' => __('Add Remove Buttons Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .room-btn-minus, .single-package .room-btn-plus' => 'color: {{releted_packages_cards_btn_minus_plus_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'add_remove_buttons_typography',
				'label' => __('Add Remove Buttons Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .room-btn-minus, .single-package .room-btn-minus',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '24',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_btn_minus_plus_width',
			[
				'label' => __( 'Add Remove Buttons Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 20,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .room-btn-minus, .single-package .room-btn-plus' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_selected_rooms_value_width',
			[
				'label' => __( 'Selected Rooms Value Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 20,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .room-btn-value' => 'width: {{SIZE}}px',
				],
			]
		);


		$this->add_control(
			'releted_packages_cards_btn_minus_plus_height',
			[
				'label' => __( 'Add Remove Buttons Height', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 20,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .room-btn-minus, .single-package .room-btn-plus, .single-package .room-btn-value' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_btn_minus_plus_transition',
			[
				'label' => __( 'Add Remove Buttons Transition Duration', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'min' => 0,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .room-btn-minus, .single-package .room-btn-plus' => 'transition: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_selected_rooms_value_color',
			[
				'label' => __('Add Remove Buttons Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-package .room-btn-value' => 'color: {{releted_packages_cards_selected_rooms_value_color}}',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_selected_rooms_value_hover_color',
			[
				'label' => __('Add Remove Buttons Hover Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#2C2F33',
				'selectors' => [
					'.single-package .room-btn-value:hover' => 'color: {{releted_packages_cards_selected_rooms_value_hover_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_selected_rooms_value_typography',
				'label' => __('Add Remove Buttons Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .room-btn-value',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_restricted_color',
			[
				'label' => __('Restricted Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#FF0000',
				'selectors' => [
					'.single-package .restricted_text_holder' => 'color: {{releted_packages_cards_restricted_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_restricted_typography',
				'label' => __('Restricted Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .restricted_text_holder, .single-package .restricted_text_holder .restriction',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '500',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '18',
						],
					],
					
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_change_search_btn_padding',
			[
				'label' => __( 'Change Search Button Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '10',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .restricted_modify_search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		
		$this->add_control(
			'releted_packages_cards_change_search_btn_color',
			[
				'label' => __('Change Search Button Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#4B8CF4',
				'selectors' => [
					'.single-package .restricted_modify_search' => 'color: {{releted_packages_cards_change_search_btn_color}}',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_change_search_btn_hover_color',
			[
				'label' => __('Change Search Button Hover Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#4B8CF4',
				'selectors' => [
					'.single-package .restricted_modify_search:hover' => 'color: {{releted_packages_cards_change_search_btn_hover_color}}',
				],
			]
		);

		$this->add_control(
			'releted_packages_cards_change_search_btn_transition',
			[
				'label' => __( 'Change Search Button Transition Duration', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'max' => 3,
						'min' => 0,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'.single-package .restricted_modify_search' => 'transition: {{SIZE}}s',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'releted_packages_cards_restricted_typography',
				'label' => __('Change Search Button Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .restricted_modify_search',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '12',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '15',
						],
					],
					
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'basket_section',
			[
				'label' => __('Basket Style', 'OBPress_SpecialOffers'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'basket_vertical_position',
			[
				'label' => esc_html__( 'Basket Vertical Position', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 160,
						'max' => 350,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 265,
				],
				'selectors' => [
					'.obpress-body-admin-bar-shown .single-package .obpress-hotel-results-basket' => 'top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'basket_margin',
			[
				'label' => __( 'Basket Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '25',
					'right' => '0',
					'bottom' => '45',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .obpress-hotel-results-basket' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'basket_width',
			[
				'label' => esc_html__( 'Basket Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 313,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 336,
				],
				'selectors' => [
					'.single-package .obpress-hotel-results-basket' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'basket_background_color',
			[
				'label' => __('Baket Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#fff',
				'selectors' => [
					'.single-package .obpress-hotel-results-basket, .obpress-hotel-results-basket-info, .single-package .obpress-hotel-results-basket-price' => 'background-color: {{basket_background_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'basket_box_shadow',
				'label' => esc_html__( 'Basket Box Shadow', 'OBPress_SpecialOffers' ),
				'selector' => '.single-package .obpress-hotel-results-basket',
				'fields_options' => [
					'box_shadow_type' => [ 
						'default' =>'yes' 
					],
					'box_shadow' => [
						'default' =>[
							'horizontal' => 0,
							'vertical' => 4,
							'blur' => 7,
							'color' => '#00000029'
						]
					]
				]
			]
		);

		$this->add_control(
			'basket_hotel_result_background_color',
			[
				'label' => __('Baket Hotel Result Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#F9F9F9',
				'selectors' => [
					'.single-package .obpress-hotel-results-basket-cart' => 'background-color: {{basket_hotel_result_background_color}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'basket_info_section',
			[
				'label' => __('Basket Info Style', 'OBPress_SpecialOffers'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'basket_info_padding',
			[
				'label' => __( 'Basket Info Padding', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '17',
					'right' => '0',
					'bottom' => '14',
					'left' => '25',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .obpress-hotel-results-basket-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'basket_hotel_stars_color',
			[
				'label' => __('Baket Hotel Result Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#ffc70e',
				'selectors' => [
					'.single-package .hotel-stars .star-full path' => 'fill: {{basket_hotel_stars_color}}',
					'.single-package .star-lines g .c' => 'stroke: {{basket_hotel_stars_color}}',
				],
			]
		);

		$this->add_control(
			'basket_hotel_stars_justify_content',
			[
				'label' => __( 'Basket Hotel Stars Justify Content', 'OBPress_SpecialOffersList' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => [
					'center' => __( 'Center', 'OBPress_SpecialOffersList' ),
					'flex-end'  => __( 'Flex End', 'OBPress_SpecialOffersList' ),
					'flex-start'  => __( 'Flex Start', 'OBPress_SpecialOffersList' ),
				],
				'selectors' => [
					'.single-package .obpress-hotel-stars-holder' => 'justify-content: {{basket_hotel_stars_justify_content}}'
				],
			]
		);

		$this->add_control(
			'basket_hotel_stars_margin',
			[
				'label' => __( 'Basket Hotel Stars Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '7',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .hotel-stars' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'basket_hotel_stars_width',
			[
				'label' => esc_html__( 'Basket Hotel Stars Width', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 60,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors' => [
					'.single-package .hotel-stars svg' => 'width: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'basket_hotel_stars_height',
			[
				'label' => esc_html__( 'Basket Hotel Stars Height', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 40,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors' => [
					'.single-package .hotel-stars svg' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'basket_hotel_name_margin',
			[
				'label' => __( 'Basket Hotel Name Margin', 'OBPress_SpecialOffers' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '19',
					'left' => '0',
					'isLinked' => false
				],
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.single-package .obpress-hotel-basket-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'basket_hotel_name_background_color',
			[
				'label' => __('Baket Hotel Name Background Color', 'OBPress_SpecialOffers'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'input_type' => 'color',
				'default' => '#F9F9F9',
				'selectors' => [
					'.single-package .obpress-hotel-basket-title' => 'background-color: {{basket_hotel_result_background_color}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'basket_hotel_name_typography',
				'label' => __('Basket Hotel Name Typography', 'OBPress_SpecialOffers'),
				'selector' => '.single-package .obpress-hotel-basket-title',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_family' => [
						'default' => 'Montserrat',
					],
					'font_size' => [
						'default' => [
							'unit' => 'px',
							'size' => '16',
						],
					],
					'font_weight' => [
						'default' => '400',
					],
					'line_height' => [
						'default' => [
							'unit' => 'px',
							'size' => '19',
						],
					],
					
				],
			]
		);


		$this->end_controls_section();

		// $this->start_controls_section(
		// 	'so_button_section',
		// 	[
		// 		'label' => __('Button', 'OBPress_SpecialOffers'),
		// 		'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		// 	]
		// );

		// $this->add_control(
		// 	'obpress_so_button_background_color',
		// 	[
		// 		'label' => __('Button Background Color', 'OBPress_SpecialOffers'),
		// 		'type' => \Elementor\Controls_Manager::COLOR,
		// 		'input_type' => 'color',
		// 		'default' => '#000',
		// 		'selectors' => [
		// 			'.obpress-offer-more' => 'background-color: {{obpress_so_button_background_color}}'
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'obpress_so_button_text_color',
		// 	[
		// 		'label' => __('Button Text Color', 'OBPress_SpecialOffers'),
		// 		'type' => \Elementor\Controls_Manager::COLOR,
		// 		'input_type' => 'color',
		// 		'default' => '#fff',
		// 		'selectors' => [
		// 			'.obpress-offer-more' => 'color: {{obpress_so_button_text_color}}'
		// 		],
		// 	]
		// );

		// $this->add_group_control(
		// 	\Elementor\Group_Control_Typography::get_type(),
		// 	[
		// 		'name' => 'so_buttons_typography',
		// 		'label' => __('Typography', 'OBPress_SpecialOffers'),
		// 		'selector' => '.obpress-offer-more',
		// 	]
		// );

		// $this->add_group_control(
		// 	\Elementor\Group_Control_Border::get_type(),
		// 	[
		// 		'name' => 'border',
		// 		'label' => __('Border', 'OBPress_SearchBarPlugin'),
		// 		'selector' => '.obpress-offer-more',
		// 	]
		// );

		// $this->end_controls_section();

		// $this->start_controls_section(
		// 	'so_slider_section',
		// 	[
		// 		'label' => __('Slider', 'OBPress_SpecialOffers'),
		// 		'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		// 	]
		// );


		// $this->add_control(
		// 	'so_allow_loop',
		// 	[
		// 		'label' => __('Allow Image Looping', 'OBPress_SpecialOffers'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('On', 'OBPress_SpecialOffers'),
		// 		'label_off' => __('Off', 'OBPress_SpecialOffers'),
		// 		'return_value' => 'true',
		// 		'default' => 'true',
		// 	]
		// );

		// $this->add_control(
		// 	'so_center_slides',
		// 	[
		// 		'label' => __('Centered Slides', 'OBPress_SpecialOffers'),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'label_on' => __('On', 'OBPress_SpecialOffers'),
		// 		'label_off' => __('Off', 'OBPress_SpecialOffers'),
		// 		'return_value' => 'true',
		// 		'default' => 'true',
		// 	]
		// );

		// $this->add_control(
		// 	'so_slides_per_view',
		// 	[
		// 		'label' => __('Slides Per View', 'OBPress_SpecialOffers'),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'size_units' => ['slides'],
		// 		'range' => [
		// 			'slides' => [
		// 				'min' => 1,
		// 				'max' => 10,
		// 				'step' => 0.1,
		// 			]
		// 		],
		// 		'default' => [
		// 			'unit' => 'slides',
		// 			'size' => 2.7,
		// 		]
		// 	]
		// );

		// $this->add_control(
		// 	'so_slider_space_between',
		// 	[
		// 		'label' => __( 'Space Between Slides', 'OBPress_SpecialOffers' ),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'size_units' => [ 'px'],
		// 		'range' => [
		// 			'px' => [
		// 				'min' => 0,
		// 				'max' => 200,
		// 				'step' => 10,
		// 			],
		// 		],
		// 		'default' => [
		// 			'unit' => 'px',
		// 			'size' => 40,
		// 		]
		// 	]
		// );

		// $this->add_control(
		// 	'obpress_slider_transition',
		// 	[
		// 		'label' => __( 'Slider Transition(seconds)', 'OBPress_SearchBarPlugin' ),
		// 		'type' => \Elementor\Controls_Manager::SLIDER,
		// 		'size_units' => [ 's'],
		// 		'range' => [
		// 			's' => [
		// 				'min' => 0,
		// 				'max' => 5,
		// 				'step' => 0.1,
		// 			]
		// 		],
		// 		'default' => [
		// 			'unit' => 's',
		// 			'size' => 1,
		// 		]
		// 	]
		// );

		// $this->add_control(
		// 	'so_slide_pagination',
		// 	[
		// 		'label' => __( 'Slider Pagination', 'OBPress_SearchBarPlugin' ),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'default' => 'lines',
		// 		'options' => [
		// 			'lines'  => __( 'Lines', 'plugin-domain' ),
		// 			'bullets' => __( 'Bullets', 'plugin-domain' ),
		// 			'disabled' => __( 'Disabled', 'plugin-domain')
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'so_number_of_slides',
		// 	[
		// 		'label' => __( 'Number of Pagination Bullets', 'OBPress_SearchBarPlugin' ),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'default' => '5',
		// 		'options' => [
		// 			'2'  => __( '2', 'plugin-domain' ),
		// 			'3' => __( '3', 'plugin-domain' ),
		// 			'4' => __( '4', 'plugin-domain'),
		// 			'5' => __( '5', 'plugin-domain')
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'obpress_so_pagination_bullet_color',
		// 	[
		// 		'label' => __('Pagination Bullet Color', 'OBPress_SpecialOffers'),
		// 		'type' => \Elementor\Controls_Manager::COLOR,
		// 		'input_type' => 'color',
		// 		'default' => '#000',
		// 		'selectors' => [
		// 			'.obpress-swiper-nav .swiper-pagination-bullet' => 'background-color: {{obpress_so_pagination_bullet_color}}'
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'obpress_so_pagination_bullet_back_icon',
		// 	[
		// 		'label' => __( 'Back Icon', 'text-domain' ),
		// 		'type' => \Elementor\Controls_Manager::ICONS,
		// 	]
		// );

		// $this->add_control(
		// 	'obpress_so_pagination_bullet_next_icon',
		// 	[
		// 		'label' => __( 'Next Icon', 'text-domain' ),
		// 		'type' => \Elementor\Controls_Manager::ICONS,
		// 	]
		// );

		// $this->end_controls_section();
	}

	protected function render()
	{
		// ini_set("xdebug.var_display_max_children", '-1');
		// ini_set("xdebug.var_display_max_data", '-1');
		// ini_set("xdebug.var_display_max_depth", '-1');

		// require_once(WP_CONTENT_DIR . '/plugins/obpress_plugin_manager/BeApi/BeApi.php');
		// require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-lang-curr-functions.php');
		// new Lang_Curr_Functions();
		// Lang_Curr_Functions::chainOrHotel($id);

		// $settings_so = $this->get_settings_for_display();
		// $chain = get_option('chain_id');

		// $languages = Lang_Curr_Functions::getLanguagesArray();
		// $language = Lang_Curr_Functions::getLanguage();
		// $language_object = Lang_Curr_Functions::getLanguageObject();        
		// $currencies = Lang_Curr_Functions::getCurrenciesArray();
		// $currency = Lang_Curr_Functions::getCurrency();

		// foreach ($currencies as $currency_from_api) {
		// 	if ($currency_from_api->UID == $currency) {
		// 		$currency_string = $currency_from_api->CurrencySymbol;
		// 		break;
		// 	}
		// }

  //       $hotels_in_chain = [];
  //       $hotels = BeApi::ApiCache('hotel_search_chain_'.$chain.'_'.$language.'_true', BeApi::$cache_time['hotel_search_chain'], function() use ($chain, $language){
  //           return BeApi::getHotelSearchForChain($chain, "true",$language);
  //       });

  //       foreach($hotels->PropertiesType->Properties as $Property) {
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["HotelCode"] = $Property->HotelRef->HotelCode;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["HotelName"] = $Property->HotelRef->HotelName;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["ChainName"] = $Property->HotelRef->ChainName;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["Country"] = $Property->Address->CountryCode;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["City"] = $Property->Address->CityCode;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["StateProvCode"] = $Property->Address->StateProvCode;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["AddressLine"] = $Property->Address->AddressLine;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["Latitude"] = $Property->Position->Latitude;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["Longitude"] = $Property->Position->Longitude;
  //           $hotels_in_chain[$Property->HotelRef->HotelCode]["MaxPartialPaymentParcel"] = $Property->MaxPartialPaymentParcel;
  //       }

  //       if(isset($_GET["mobile"]) && $_GET["mobile"] != null && $_GET["mobile"] == true) {
  //           $mobile = true;
  //       }
  //       else {
  //           $mobile = false;
  //       }

  //       $available_packages = BeApi::ApiCache('available_packages_'.$chain.'_'.$currency.'_'.$language.'_'.$mobile, BeApi::$cache_time['available_packages'], function() use ($chain, $currency, $language, $mobile){
  //           return BeApi::getClientAvailablePackages($chain, $currency, $language, null, $mobile);
  //       });

  //       function sortByPrice($param1, $param2) {
		//     return strcmp($param1->Total->AmountBeforeTax, $param2->Total->AmountBeforeTax);
		// }

		// $hotels_from_packages = [];
  //       //sort packages by price
  //       if(isset($available_packages->RoomStaysType) && $available_packages->RoomStaysType != null) {
  //           foreach($available_packages->RoomStaysType->RoomStays as $RoomStay) {
  //               $RoomRates = $RoomStay->RoomRates;
  //               usort($RoomRates, "sortByPrice");
  //               $RoomStay->RoomRates = $RoomRates;
  //               $hotels_from_packages[] = $RoomStay->BasicPropertyInfo->HotelRef->HotelCode;
  //           }
  //       }
  //       $hotels_from_packages = array_unique($hotels_from_packages);

  //       $rateplans = [];
  //       $package_offers = [];
  //       $rateplans_per_hotel = [];

  //       if(isset($available_packages->RoomStaysType) && $available_packages->RoomStaysType != null) {
            
  //           foreach ($hotels_from_packages as $hotel_from_packages) {
  //               $rateplans[] = BeApi::ApiCache('rateplans_array_'.$hotel_from_packages.'_'.$language, BeApi::$cache_time['rateplans_array'], function() use ($hotel_from_packages, $language){
  //                   return BeApi::getHotelRatePlans($hotel_from_packages, $language);
  //               });
  //           }


  //           foreach ($rateplans as $rateplan) {
  //               if($rateplan->RatePlans != null) {
  //                   foreach ($rateplan->RatePlans->RatePlan as $RatePlan) {
  //                       if ($RatePlan->RatePlanTypeCode == 11) {
  //                           $rateplans_per_hotel[$rateplan->RatePlans->HotelRef->HotelCode][$RatePlan->RatePlanID] = $RatePlan;
  //                       }
  //                   }
  //               }
  //           }
                
  //           foreach ($available_packages->RoomStaysType->RoomStays as $RoomStay) {
  //               foreach ($RoomStay->RoomRates as $RoomRate) {
  //                   $package_offers[$RoomStay->BasicPropertyInfo->HotelRef->HotelCode][$RoomRate->RatePlanID]["room_rate"] = $RoomRate;
  //               }
  //               foreach ($RoomStay->RatePlans as $RatePlan) {
  //                   $package_offers[$RoomStay->BasicPropertyInfo->HotelRef->HotelCode][$RatePlan->RatePlanID]["rate_plan"] = $RatePlan;
  //               }  
  //           }

  //           if($available_packages->TPA_Extensions != null) {
  //               foreach ($available_packages->TPA_Extensions->MultimediaDescriptionsType->MultimediaDescriptions as  $MultimediaDescription) {
  //                   foreach ($package_offers as $hotel_code => $package_offer) {
  //                       foreach ($package_offer as $rate_plan_code => $offer) {
  //                           if ($MultimediaDescription->ID == $rate_plan_code) {
  //                               $package_offers[$hotel_code][$rate_plan_code]["image"] = $MultimediaDescription;
  //                           }
  //                       }
  //                   }
  //               }
  //           }

  //           foreach ($package_offers as $hotel_code => $package_offer) {
  //               foreach ($package_offer as $rate_plan_code => $offer) {
  //                   foreach ($rateplans_per_hotel as $hotel_code2 => $per_hotel) {
  //                       foreach ($per_hotel as $rate_plan_code2 => $rateplan) {
  //                           if($rate_plan_code2 == $rate_plan_code) {

  //                               $package_offers[$hotel_code][$rate_plan_code]["get_rate_plans"] = $rateplan;

  //                           }
  //                       }
  //                   }
  //               }
  //           }
  //       }

  //       $plugin_directory_path = plugins_url( '', __FILE__ );


	//NEW CODE

		ini_set("xdebug.var_display_max_children", '-1');
		ini_set("xdebug.var_display_max_data", '-1');
		ini_set("xdebug.var_display_max_depth", '-1');

		require_once(WP_CONTENT_DIR . '/plugins/obpress_plugin_manager/BeApi/BeApi.php');
		require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-lang-curr-functions.php');
		require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-analyze-avail.php');
		require_once(WP_PLUGIN_DIR . '/obpress_plugin_manager/class-analyze-descriptive-infos-response.php');

		new Lang_Curr_Functions();

		Lang_Curr_Functions::chainOrHotel($id);

		if(isset($_GET["package_id"]) && $_GET["package_id"] != null) {
			$promotion_id = $_GET["package_id"];
			$redirect = false;
            $redirect_route = null;
		}
		else {
			$promotion_id = null;
			$redirect = true;
            $redirect_route = home_url()."/packages";
		}

		$settings_so = $this->get_settings_for_display();
		$chain = get_option('chain_id');

		$languages = Lang_Curr_Functions::getLanguagesArray();
		$language = Lang_Curr_Functions::getLanguage();
		$language_object = Lang_Curr_Functions::getLanguageObject();        
		$currencies = Lang_Curr_Functions::getCurrenciesArray();
		$currency = Lang_Curr_Functions::getCurrency();

		foreach ($currencies as $currency_from_api) {
			if ($currency_from_api->UID == $currency) {
				$currency_string = $currency_from_api->CurrencySymbol;
				break;
			}
		}


        //get check in and out times or set default ones
        Lang_Curr_Functions::getCheckTimes($_GET['CheckIn'], $_GET['CheckOut']);
        $CheckIn = Lang_Curr_Functions::getCheckIn();
        $CheckOut = Lang_Curr_Functions::getCheckOut();

        $hotels_in_chain = [];
        $hotels = BeApi::ApiCache('hotel_search_chain_'.$chain.'_'.$language.'_true', BeApi::$cache_time['hotel_search_chain'], function() use ($chain, $language){
            return BeApi::getHotelSearchForChain($chain, "true",$language);
        });


        foreach($hotels->PropertiesType->Properties as $Property) {
            $hotels_in_chain[$Property->HotelRef->HotelCode]["HotelCode"] = $Property->HotelRef->HotelCode;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["HotelName"] = $Property->HotelRef->HotelName;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["ChainName"] = $Property->HotelRef->ChainName;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["Country"] = $Property->Address->CountryCode;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["City"] = $Property->Address->CityCode;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["StateProvCode"] = $Property->Address->StateProvCode;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["AddressLine"] = $Property->Address->AddressLine;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["Latitude"] = $Property->Position->Latitude;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["Longitude"] = $Property->Position->Longitude;
            $hotels_in_chain[$Property->HotelRef->HotelCode]["MaxPartialPaymentParcel"] = $Property->MaxPartialPaymentParcel;
        }

        if(isset($_GET["mobile"]) && $_GET["mobile"] != null && $_GET["mobile"] == true) {
            $mobile = "true";
        }
        else {
            $mobile = "false";
        }

        $available_packages = BeApi::ApiCache('available_packages_'.$chain.'_'.$currency.'_'.$language.'_'.$mobile, BeApi::$cache_time['available_packages'], function() use ($chain, $currency, $language, $mobile){
            return BeApi::getClientAvailablePackages($chain, $currency, $language, null, $mobile);
        });

        foreach ($available_packages->RoomStaysType->RoomStays as $RoomStay) {
            foreach ($RoomStay->RatePlans as $RatePlan) {
                if($promotion_id == $RatePlan->RatePlanID) {
                    $hotel_from_package = $RoomStay->BasicPropertyInfo->HotelRef->HotelCode;
                }
            }
        }
        $property = $hotel_from_package;

        $rateplans = [];
        $rateplans_per_hotel = [];
        $hotel_id = null;

        $rateplans[$hotel_from_package] = BeApi::ApiCache('rateplans_array_'.$hotel_from_package.'_'.$language, BeApi::$cache_time['rateplans_array'], function() use ($hotel_from_package, $language){
            return BeApi::getHotelRatePlans($hotel_from_package, $language);
        });

        $hotel_search = BeApi::ApiCache('hotel_search_property_'.$property.'_'.$language.'_true', BeApi::$cache_time['hotel_search_property'], function() use ($property, $language) {
            return BeApi::getHotelSearchForProperty($property, "true", $language);
        });

        foreach ($rateplans as $rateplan) {
            if($rateplan->RatePlans != null) {
                foreach ($rateplan->RatePlans->RatePlan as $RatePlan) {
                    if ($RatePlan->RatePlanTypeCode == 11) {
                        $rateplans_per_hotel[$rateplan->RatePlans->HotelRef->HotelCode][$RatePlan->RatePlanID] = $RatePlan;
                    }
                }
            }
        }


        foreach ($available_packages->RoomStaysType->RoomStays as $RoomStay) {
            foreach ($RoomStay->RoomRates as $RoomRate) {
                $package_offers[$RoomStay->BasicPropertyInfo->HotelRef->HotelCode][$RoomRate->RatePlanID]["room_rate"] = $RoomRate;
            }
            foreach ($RoomStay->RatePlans as $RatePlan) {
                $package_offers[$RoomStay->BasicPropertyInfo->HotelRef->HotelCode][$RatePlan->RatePlanID]["rate_plan"] = $RatePlan;
            }  
        }

        if($available_packages->TPA_Extensions != null) {
            foreach ($available_packages->TPA_Extensions->MultimediaDescriptionsType->MultimediaDescriptions as  $MultimediaDescription) {
                foreach ($package_offers as $hotel_code => $package_offer) {
                    foreach ($package_offer as $rate_plan_code => $offer) {
                        if ($MultimediaDescription->ID == $rate_plan_code) {
                            $package_offers[$hotel_code][$rate_plan_code]["image"] = $MultimediaDescription;
                        }
                    }
                }
            }
        }


        if(isset($package_offers)) {
            foreach ($package_offers as $hotel_code => $package_offer) {
                foreach ($package_offer as $rate_plan_code => $offer) {
                    foreach ($rateplans_per_hotel as $hotel_code2 => $per_hotel) {
                        foreach ($per_hotel as $rate_plan_code2 => $rateplan) {
                            if($rate_plan_code2 == $rate_plan_code) {

                                $package_offers[$hotel_code][$rate_plan_code]["get_rate_plans"] = $rateplan;

                            }
                        }
                    }
                }
            }
        }
        else {
            $package_offers = null;
        }

        if($_GET['ad'] == null) {
        	$adults = 1;
        }
        else {
            $adults = $_GET['ad'];
        }


        if($_GET["CheckIn"] == null) {


            $package_active_periods = [];
            if(isset($package_offers[$property][$promotion_id]["get_rate_plans"]->Guarantees)) {
                foreach($package_offers[$property][$promotion_id]["get_rate_plans"]->Guarantees as $Guarantee) {
                    if($Guarantee->GuaranteeCode == -1) {
                        $package_active_periods[] = $Guarantee;
                    }
                }
            }
            if(!empty($package_active_periods)) {
                foreach($package_active_periods as $package_active_period) {
                    $start = new DateTime($package_active_period->Start);
                    $now = new DateTime('NOW');

                    if($now->diff($start)->days > 0 && $now->diff($start)->invert == 0) {
                    	$newCheckIn = strtotime($package_active_period->Start);
                        $newCheckOut = strtotime($package_active_period->Start . '+1 day');

                        $CheckIn = date('d.m.Y', $newCheckIn);
                        $CheckInUrlParam = date('dmY', $newCheckIn);
                        $CheckOut = date('d.m.Y', $newCheckOut);
                        $CheckOutUrlParam = date('dmY', $newCheckOut);

                        $redirect = true;
                        $redirect_route = home_url()."?CheckIn=".$CheckInUrlParam."&CheckOut=".$CheckOutUrlParam."&ad=".$adults;
                        // return redirect(request()->fullUrlWithQuery(['CheckIn' => $CheckInUrlParam, 'CheckOut' => $CheckOutUrlParam, "ad" => $adults]));

						$host  = $_SERVER['HTTP_HOST'];
						$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
						$page = 'package';
						$params = $_SERVER['QUERY_STRING'];
						$params.= "&CheckIn=".$CheckInUrlParam."&CheckOut=".$CheckOutUrlParam;
						if(!isset($_GET["ad"])) {
							$params.= "&ad=".$adults;
						}
						wp_redirect("https://$host$uri/$page?$params");
						exit;
                    }
                }
            }
        }

       
        $promocode = "";
        if($_GET['Code'] != null && $_GET['Code'] != '') {
            $promocode = $_GET['Code'];
        }

        $groupcode = "";
        if ($_GET['group_code'] != null && $_GET['group_code'] != '') {
            $groupcode = $_GET['group_code'];
        }


        $data = BeApi::getChainData($chain, $CheckIn, $CheckOut, $adults, ($_GET['ch'] != null && $_GET["ch"] > 0) ? $_GET['ch'] : 0, $_GET['ag'], $property, "false", $currency, $language, $promocode, $groupcode, $mobile);
        $data = new AnalyzeAvailRes($data);

        $descriptive_info = BeApi::ApiCache('hotel_descriptive_info_'.$property.'_'.$language, BeApi::$cache_time['hotel_descriptive_info'], function() use ($property, $language) {
            return BeApi::getHotelDescriptiveInfo($property, $language);
        });
        $descriptive_info = new AnalyzeDescriptiveInfosRes($descriptive_info);

        $style = BeApi::ApiCache('style_'.$property.'_'.$currency.'_'.$language, BeApi::$cache_time['omnibees.style'], function () use ($property, $currency, $language) {
            return BeApi::getPropertyStyle($property, $currency, $language);
        });

        $plugin_directory_path = plugins_url( '', __FILE__ );
        $plugins_directory = plugins_url();


		require_once(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/widget/assets/templates/template.php');

	}
}
