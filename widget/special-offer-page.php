<?php

class SpecialOfferPage extends \Elementor\Widget_Base
{

	public function __construct($data = [], $args = null) {

		$special_offer_page = true;

		parent::__construct($data, $args);
		
		wp_register_script( 'moment_plugin_min_js', plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/vendor/moment.min.js'));

		wp_register_script( 'moment_plugin_tz_js', plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/vendor/moment.tz.js'));

		wp_register_script( 'special-offer-page_js',  plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/special-offer-page.js'), [ 'elementor-frontend' ], '1.0.0', true );

		// Prevent calling this files twice

		wp_register_script( 'searchbar_special_offer_js',  plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/searchbar.js'), [], '1.0.0', true );
		wp_register_script( 'zcalendar_special_offer_js',  plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/zcalendar.js'), [], '1.0.0', true ); 


		wp_register_script( 'basket_js',  plugins_url( '/OBPress_SpecialOffersPage/widget/assets/js/basket.js'), [], '1.0.0', true );

		wp_register_style( 'special-offer-page_css', plugins_url( '/OBPress_SpecialOffersPage/widget/assets/css/special-offer-page.css'));  
		wp_register_style( 'zcalendar_special_css', plugins_url( '/OBPress_SpecialOffersPage/widget/assets/css/zcalendar.css') );
		wp_register_style( 'searchbar_special_css', plugins_url( '/OBPress_SpecialOffersPage/widget/assets/css/searchbar.css') );



		wp_localize_script('special-offer-page_js', 'specialOfferAjax', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));


	}

	public function get_script_depends()
	{
		return [ 'moment_plugin_min_js', 'moment_plugin_tz_js', 'special-offer-page_js', 'basket_js' , 'zcalendar_special_offer_js' , 'searchbar_special_offer_js' ];
	}

	public function get_style_depends()
	{
		return ['special-offer-page_css', 'zcalendar_special_css', 'searchbar_special_css'];
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
