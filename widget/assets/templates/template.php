<?php
	$elementor_edit_active = \Elementor\Plugin::$instance->editor->is_edit_mode();
	$CheckInFormated = str_replace(".","",$CheckIn);
	$CheckOutFormated = str_replace(".","",$CheckOut);
?>

<?php if(isset($_GET["package_id"])): ?>
	<div class="single-package" data-redirect="<?= $redirect ?>" data-redirect-url="<?= $redirect_route ?>" data-package-id="<?= $promotion_id ?>">
		<?php if($package_offers != null): ?>
			<?php foreach($package_offers as $key => $package_offer): ?>
				<?php foreach($package_offer as $rateplan => $offer): ?>
					<?php if($rateplan == $promotion_id): ?>
						<div class="single-package-img-holder">
							<?php if(@$hotels_in_chain[$key]["MaxPartialPaymentParcel"] != null): ?>
	                            <div class="MaxPartialPaymentParcel" data-toggle="modal" data-target="#partial-modal-payment">
	                                Pay up to <span><?= @$hotels_in_chain[$key]["MaxPartialPaymentParcel"] ?>x</span>
	                            </div>
	                        <?php endif; ?>

	                        <?php if(isset($offer["image"])): ?>
	                            <img class="single-package-img" src="<?= $offer["image"]->ImageItemsType->ImageItems[0]->URL->Address?>" onError="this.onerror=null;this.src='/img/placeholderNewWhite.svg';" alt="<?=@$offer["get_rate_plans"]->RatePlanName?>">
	                        <?php else: ?>
	                            <img class="single-package-img" src="<?= $plugin_directory_path . '/assets/icons/placeholderNewWhite.svg' ?>" alt="promotion">
	                        <?php endif; ?>

	                        <div class="single-package-name-holder">
	                	        <div class="single-package-hotel-name"><?= @$hotels_in_chain[$key]["HotelName"] ?></div>
	                            <div class="single-package-name"><?= $offer["get_rate_plans"]->RatePlanName ?></div>
	                        </div>

						</div>

						<div class="single-package-info-holder">
							<?php if(isset($offer["get_rate_plans"]->RatePlanInclusions)): ?>
	                            <?php if($offer["get_rate_plans"]->RatePlanInclusions != null): ?>
	                            	<p class="single-package-included-msg">Esse pacote especial oferece:</p>
	                            	<div class="single-package-included-holder">
		                                <?php foreach($offer["get_rate_plans"]->RatePlanInclusions as $included): ?>
		                                    <span class="single-package-included"><?= $included->RatePlanInclusionDesciption->Name ?></span>
		                                <?php endforeach; ?>
		                            </div>
	                            <?php endif; ?>
	                        <?php endif; ?>

	                        <?php
	                        	foreach($descriptive_info->get()->HotelDescriptiveContentsType->HotelDescriptiveContents[0]->HotelInfo->HotelAmenities as $HotelAmenity) {
	                        		$amenity_categories[$HotelAmenity->HotelAmenityCategory][] = $HotelAmenity;
	                        	}
	                        ?>

	                        <div class="single-package-info-categories">
	                        	<div class="single-package-info-categories-bars">
	                        		<span class="single-package-info-categories-bar active-bar" data-category="package-description">Descrição</span>
	                        		<?php foreach($amenity_categories as $key => $amenity_category): ?>
	                        			<span class="single-package-info-categories-bar" data-category="<?= $key ?>"><?= $key ?></span>
	                        		<?php endforeach; ?>
	                        	</div>

	                        	<div class="single-package-info-category-section active-section" data-category="package-description">
	                        		<span class="package-description-short">
	                        			<?= substr(nl2br($offer["get_rate_plans"]->RatePlanDescription->Description),0, 200) ?>
	                        			<?php if(strlen($offer["get_rate_plans"]->RatePlanDescription->Description) > 200): ?>
	                        				<span class="kurac">...</span>
	                        			<?php endif; ?>
	                        		</span>
	                        		<?php if(strlen($offer["get_rate_plans"]->RatePlanDescription->Description) > 200): ?>
	                        			<span class="package-description-long"><?= nl2br($offer["get_rate_plans"]->RatePlanDescription->Description) ?></span>
	                        		
		                        		<span class="package-more-description">ler mais</span>
		                        		<span class="package-less-description">ler menos</span>
		                        	<?php endif; ?>
	                        	</div>
	                        	<?php foreach($amenity_categories as $key => $amenity_category): ?>
	                    			<div class="single-package-info-category-section" data-category="<?= $key ?>">
	                    				<?php foreach($amenity_category as $amenity): ?>
	                    					<div><?= $amenity->HotelAmenity ?></div>
	                    				<?php endforeach; ?>
	                    			</div>
	                    		<?php endforeach; ?>
	                        </div>
						</div>


						<?php echo $hotelFolders ; ?>

    <form type="POST" action="" class="package-form">
        <div class="ob-searchbar obpress-hotel-searchbar-custom container<?php if ($settings_searchbar['obpress_searchbar_vertical_view'] == "yes") echo ' ob-searchbar-vertical'; ?><?php if ($settings_searchbar['obpress_searchbar_alignment'] == "left") echo ' ob-mr-auto'; ?><?php if ($settings_searchbar['obpress_searchbar_alignment'] == "center") echo ' ob-m-auto'; ?><?php if ($settings_searchbar['obpress_searchbar_alignment'] == "right") echo ' ob-ml-auto'; ?>" id="index" data-hotel-folders="<?php echo htmlspecialchars(json_encode($hotelFolders), ENT_QUOTES, 'UTF-8'); ?>">
            <div class="ob-searchbar-hotel">
                <p>
                <?php
                    printf(
                        _n(
                            'Hotel',
                            'Destination or Hotel',
                            $counter_for_hotel,
                            'obpress'
                        ),
                        number_format_i18n( $counter_for_hotel )
                    );     

                ?>
                </p>
                <input type="text" value="" readonly placeholder="<?php if ( $data->getHotels()[$property]['HotelName'] ) {
                    echo $data->getHotels()[$property]['HotelName'];
                    } else {
                    _e('All Hotels', 'obpress');
                    }  ?>" id="hotels" class="<?php if (!empty(get_option('hotel_id'))) {
                                            echo 'single-hotel';
                                        } ?>" spellcheck="false" autocomplete="off">
                <input type="hidden" name="c" value="<?php echo get_option('chain_id') ?>">
                <input type="hidden" name="q" id="hotel_code" value="<?php echo $data->getHotels()[$property]['HotelCode'] ?>">
                <input type="hidden" name="currencyId" value="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                <input type="hidden" name="lang" value="<?= (isset($_GET['lang'])) ? $_GET['lang'] : get_option('default_language_id') ?>">
                <input type="hidden" name="hotel_folder" id="hotel_folder">
                <input type="hidden" name="NRooms" id="NRooms" value="<?php echo $_GET['NRooms'] ?>">
                <div class="hotels_dropdown">
                    <div class="obpress-mobile-close-hotels-dropdown-holder">
                        <span>Selecione destino ou hotel</span>
                        <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                    </div>
                    <div class="obpress-mobile-search-hotels-input-holder">
                        <input class="obpress-mobile-search-hotels-input" type="text" placeholder="Digite o nome ou cidade do hotel" id="search-hotels-input">
                    </div>
                    <div class="hotels_all custom-bg custom-text" data-id="0"><?php _e('All Hotels', 'obpress'); ?></div>
                    <div class="hotels_folder custom-bg custom-text" hidden></div>
                    <div class="hotels_hotel custom-bg custom-text" data-id="" hidden></div>
                </div>

            </div>
            <div class="ob-searchbar-calendar">

                <p><?php _e('DATES OF STAY', 'obpress'); ?></p>
                <input class="calendarToggle" type="text" id="calendar_dates" value="<?php echo $CheckInShow ?? date("d/m/Y") ?> - <?php echo $CheckOutShow ?? date("d/m/Y", strtotime("+1 day")) ?>"  readonly>

                <input class="calendarToggle" type="hidden" id="date_from" name="CheckIn" value="<?php echo $CheckInFormated ?? date("dmY") ?>">
                <input class="calendarToggle" type="hidden" id="date_to" name="CheckOut" value="<?php echo $CheckOutFormated ?? date("dmy", strtotime("+1 day")) ?>">            
            </div>
            <div class="ob-searchbar-guests">
                <p><?php _e('ROOMS AND GUESTS', 'obpress'); ?></p>
                <input type="text" id="guests" data-room="<?php _e('Room', 'obpress'); ?>" data-rooms="<?php _e('Rooms', 'obpress'); ?>" data-guest="<?php _e('Guest', 'obpress'); ?>" data-guests="<?php _e('Guests', 'obpress'); ?>" data-remove-room="<?php _e('Remove room', 'obpress'); ?>" readonly>
                <input type="hidden" id="ad" name="ad" value="1">
                <input type="hidden" id="ch" name="ch" value="">
                <input type="hidden" id="ag" name="ag" value="">

                <div id="occupancy_dropdown" class="position-absolute custom-bg custom-text" data-default-currency="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                    <div class="add-room-holder">
                        <p class="add-room-title select-room-title custom-text"><?php _e('NUMBER OF ROOMS', 'obpress') ?></p>
                        <div class="select-room-buttons">
                            <button class="select-button select-button-minus select-room-minus" type="button" disabled>

                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                 </svg>
                                
                            </button>
                            <span class="select-value select-room-value">1</span>
                            <button class="select-button select-button-plus select-room-plus" type="button">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                
                            </button>
                        </div>
                    </div>
                    <div class="select-room-holder">
                        <div class="select-room" data-room-counter="0">
                            <p class="select-room-title custom-text"><?php _e('Room', 'obpress');?> <span class="select-room-counter">1</span></p>
                            <div class="select-guests-holder">
                                <div class="select-adults-holder">
                                    <div class="select-adults-title">
                                        <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/adults.svg" alt="">
                                        <?php _e('Adults', 'obpress'); ?>
                                    </div>
                                    <div class="select-adults-buttons">
                                        <button class="select-button select-button-minus select-adult-minus" type="button" disabled>
                                            
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>

                                        </button>
                                        <span class="select-value select-adults-value">1</span>
                                        <button class="select-button select-button-plus select-adult-plus" type="button">

                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>

                                        </button>
                                    </div>
                                </div>
                                <div class="select-child-holder">
                                    <div class="select-child-title">
                                        <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/children.svg" alt="">
                                        <div>
                                            <span><?php _e('Children', 'obpress') ?></span>
                                            <span class="select-child-title-max-age">
                                                0 <?php 
                                                _e('to the', 'obpress') ; 
                                                echo " " ; 
                                                ?>
                                                <span class='child-max-age'> <?php echo $childrenMaxAge ; ?> </span>
                                            </span> 
                                        </div>
                                    </div>
                                    <div class="select-child-buttons">
                                        <button class="select-button select-button-minus select-child-minus" type="button" disabled>
                                            
                                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>

                                        </button>
                                        <span class="select-value select-child-value">0</span>
                                        <button class="select-button select-button-plus select-child-plus" type="button">

                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            
                                        </button>
                                    </div>
                                </div>
                                <div class="select-child-ages-holder">
                                    <div class="select-child-ages-clone">


                                        <p class="select-child-ages-title custom-text"><?php _e('Age', 'obpress'); ?> <span class="select-child-ages-number"></span></p>

                                        <div class="age-picker"> 
                                            <span class="age-picker-value">0</span> 

                                            <div class="age-picker-options">
                                                <?php for ($i = 0; $i < 18; $i++) : ?>
                                                     <div data-age="<?= $i; ?>"> <?= $i; ?> anos de idade</div>
                                                <?php endfor; ?>

                                            </div>

                                            <select class="select-child-ages-input-clone">
                                                    <?php for ($i = 0; $i < 18; $i++) : ?>
                                                        <option data-value="<?= $i; ?>" <?php if ($i == 0) { echo "selected";} ?>><?= $i; ?></option>
                                                    <?php endfor; ?>
                                            </select>

                                        </div>

                                       

                                        <div class="child-ages-input">
                                            
                                        </div>

                                        <p class="incorect-age custom-text"><?php _e('Incorrect Age', 'obpress') ?></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn-ic custom-action-bg custom-action-border custom-action-text select-occupancy-apply" type="button">
                            <?php _e('Apply', 'obpress') ?>

                            <span class="select-occupancy-apply-info">
                                    <span class="select-occupancy-apply-info-rooms" data-rooms="1">1</span>
                                    <span class="select-occupancy-apply-info-rooms-string">Room</span>
                                    ,
                                    <span class="select-occupancy-apply-info-guests" data-guests="1">1</span>
                                    <span class="select-occupancy-apply-info-guests-string">Guest</span>
                            </span>
                    </button>

                </div>
            </div>
                <div class="ob-searchbar-promo">
                    <p><?php _e('I HAVE A CODE', 'obpress'); ?></p>
                    <input type="text" id="promo_code" value="" placeholder="Escolha o tipo" readonly>

                    <div id="promo_code_dropdown" class="position-absolute custom-bg custom-text">
                        <div class="mb-3 mt-2">
                            <p class="input-title"><?php _e('GROUP CODE', 'obpress') ?></p>
                            <!-- <input type="text" id="group_code" name="group_code" placeholder="Digite seu código"> -->
                            <div class="material-textfield">
                                <input type="text" id="group_code" name="group_code" placeholder="Digite seu código">
                                <span class="label-title"><?php _e('GROUP CODE', 'obpress') ?></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="input-title"><?php _e('PROMO CODE', 'obpress'); ?></p>
                            <!-- <input type="text" id="Code" name="Code" placeholder="Digite seu código"> -->
                            <div class="material-textfield">
                                <input type="text" id="Code" name="Code" placeholder="Digite seu código">
                                <span class="label-title"><?php _e('PROMO CODE', 'obpress'); ?></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="input-title"><?php _e('LOYALTY CODE', 'obpress') ?></p>
                            <!-- <input type="text" id="loyalty_code" name="loyalty_code" placeholder="Digite seu código"> -->
                            <div class="material-textfield">
                                <input type="text" id="loyalty_code" name="loyalty_code" placeholder="Digite seu código">
                                <span class="label-title"><?php _e('LOYALTY CODE', 'obpress') ?></span>
                            </div>
                        </div>

                        <div class="text-right">
                            <button id="promo_code_apply" class="custom-action-bg custom-action-text custom-action-border btn-ic"><?php _e('Apply', 'obpress'); ?></button>
                        </div>
                    </div>
                </div>
            <div class="ob-searchbar-button">
                <button class="ob-searchbar-submit" type="button"><?php _e('Search', 'obpress'); ?></button>
            </div>       
        </div>






        <div class="zcalendar-wrap">

            <div class="ob-zcalendar-top">
                <div class="ob-zcalendar-title">
                    Selecione a data de estadia
                    <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                </div>
                <div class="ob-mobile-weekdays">
                    <div>
                        <span>sun</span>
                        <span>mon</span>
                        <span>tue</span>
                        <span>wed</span>
                        <span>thu</span>
                        <span>fri</span>
                        <span>sat</span>
                    </div>
                </div>
            </div>
            <div class="zcalendar-holder" id="calendar-holder">
                <div class="zcalendar data-allow-unavail="<?= get_option('allow_unavail_dates') ?> data-allow-unavail="<?= get_option('allow_unavail_dates') ?>" data-promotional="<?php _e('Offers for you', 'obpress'); ?>" data-promo="<?php _e('Special Offer', 'obpress'); ?>" data-lang="{{$lang->Code}}"  data-night="<?php _e('Night', 'obpress') ?>" data-nights="<?php _e('Nights', 'obpress') ?>" data-price-for="<?php _e('*Price for', 'obpress') ?>" data-adult="<?php _e('adult', 'obpress') ?>" data-adults="<?php _e('adults', 'obpress') ?>" data-restriction="<?php _e('Restricted Days', 'obpress') ?>" data-notavailable="<?php _e('index_no_availability_v4', 'obpress') ?>" data-closedonarrival="<?php _e('calendar_closed_on_arrival', 'obpress') ?>"  data-closedondeparture="<?php _e('calendar_closed_on_departure', 'obpress') ?>" data-minimum-string="<?php _e('system_min', 'obpress') ?>" data-maximum-string="<?php _e('system_max', 'obpress') ?>" ></div>
            </div>
            
            <div class="ob-zcalendar-bottom">
                <div> <span class='mobile-accept-dates-from-to'>Seg, 14 Nov - Sex, 18 Nov</span> <span class="number_of_nights-mobile-span"> ( <span class="number_of_nights-mobile"> 4 Noites</span> )</span> </div>
                <div id="mobile-accept-date"> Aplicar </div>
            </div>
    	</div>  




    </form>


					<?php
						$calendar_string = '';
					?>

	<!-- 				<div class="zcalendar-wrap">
						<div class="zcalendar" data-restrictions="Dias com restrições" data-promotional="Ofertas especiais para si" data-promo="Oferta Especial" data-unavilable="<?= $calendar_string ?>" data-lang="<?= $language_object->Code ?>"  data-night="Noite" data-nights="Noites" data-notavailable="Sem disponibilidade" data-closedonarrival="Fechado para check-in"  data-closedondeparture="Fechado para check-out"data-minimum-string="Mínimo"  data-maximum-string="Máximo" data-adult="adulto" data-adults="adultos"></div>
					</div> -->



                    <?php

                            $RatePlanID = $promotion_id;
                            $roomtypes = $data->getAllRoomTypes();
                            $canidates = $data->getAllRoomStayCandidates();
                            $lng_str = $language_object->Path;
                            $rate_plan = $data->getRatePlan($RatePlanID);
                            $hotel = @$data->getHotels()[$property];

                            $prices_filter = $data->getPricesInfo($style, $promotion_id);
                            $availableRooms =  count( $prices_filter['prices'] ) ;

                    ?>

                    <?php if($availableRooms > 0): ?>
                        <p class="rooms-message-header">Quartos relacionados</p>
                    <?php endif; ?>



                    <div class="obpress-package-rooms-basket"> 


    					<div id="package-results">
    						<?php require_once(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/widget/assets/templates/template-rooms.php'); ?>
    					</div>

                          <!--  Get basket html -->

                        <?php require_once( WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/widget/assets/templates/basket.php'); ?>

                    </div>



					<?php endif; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
		<?php endif;?>
	</div>
<?php elseif($elementor_edit_active == true): ?>
	<div class="single-package" data-redirect="<?= $redirect ?>" data-redirect-url="<?= $redirect_route ?>">

		<div class="single-package-img-holder">
            <div class="MaxPartialPaymentParcel" data-toggle="modal" data-target="#partial-modal-payment">
                Pay up to <span>10x</span>
            </div>


            <img class="single-package-img" src="<?= $plugin_directory_path . '/assets/images/package_photo.png' ?>">


            <div class="single-package-name-holder">
    	        <div class="single-package-hotel-name">Hilton Rio de Janeiro Copacabana</div>
                <div class="single-package-name">Spring Season</div>
            </div>

		</div>

		<div class="single-package-info-holder">

        	<p class="single-package-included-msg">Esse pacote especial oferece:</p>
        	<div class="single-package-included-holder">
                <span class="single-package-included">Free wifi all hotel</span>
                <span class="single-package-included">Bike Rental</span>
                <span class="single-package-included">Shopping nearby</span>
                <span class="single-package-included">Free wifi all hotel</span>
                <span class="single-package-included">Free Coffee</span>
                <span class="single-package-included">24 Hour reception</span>
                <span class="single-package-included">Great little-lunch</span>
            </div>




            <div class="single-package-info-categories">
            	<div class="single-package-info-categories-bars">
            		<span class="single-package-info-categories-bar active-bar" data-category="package-description">Descrição</span>
            		<span class="single-package-info-categories-bar" data-category="Serviços Gerais">Serviços Gerais</span>
            		<span class="single-package-info-categories-bar" data-category="Restaurantes e Bares">Restaurantes e Bares</span>
            		<span class="single-package-info-categories-bar" data-category="Bem-estar e Desporto">Bem-estar e Desporto</span>
            		<span class="single-package-info-categories-bar" data-category="Produtos de casa e banho">Produtos de casa e banho</span>
            		<span class="single-package-info-categories-bar" data-category="Atrações">Atrações</span>
            	</div>

            	<div class="single-package-info-category-section active-section" data-category="package-description">
            		<span class="package-description-short">
            			<?= nl2br("O Hilton Copacabana Rio De Janeiro, De 5 Estrelas, Está Idealmente Localizado Em Frente Às Águas Azuis Da Praia De Copacabana. Disponibiliza Um Spa Elegante E Uma Piscina No Último Piso, Ambos Com Vistas Mar Magníficas.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.") ?>
            			
            				<span>...</span>
            		</span>
                	<span class="package-description-long">
						<?= nl2br("O Hilton Copacabana Rio De Janeiro, De 5 Estrelas, Está Idealmente Localizado Em Frente Às Águas Azuis Da Praia De Copacabana. Disponibiliza Um Spa Elegante E Uma Piscina No Último Piso, Ambos Com Vistas Mar Magníficas.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televisão E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobiliário Em Madeira, Uma Decoração Contemporânea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fantásticas Para O Oceano.") ?>                		
                	</span>
        		
            		<span class="package-more-description">ler mais</span>
            		<span class="package-less-description">ler menos</span>
            	</div>
            	
    			<div class="single-package-info-category-section" data-category="Serviços Gerais">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
    			<div class="single-package-info-category-section" data-category="Restaurantes e Bares">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
    			<div class="single-package-info-category-section" data-category="Bem-estar e Desporto">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
    			<div class="single-package-info-category-section" data-category="Produtos de casa e banho">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
    			<div class="single-package-info-category-section" data-category="Atrações">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
            </div>
		</div>

	</div>


<?php endif; ?>