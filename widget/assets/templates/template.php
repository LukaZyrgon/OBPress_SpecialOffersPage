<?php
	$elementor_edit_active = \Elementor\Plugin::$instance->editor->is_edit_mode();
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




					<form action="" name="index_form" class="custom-bg" id="rate_plan_form-lp">
						<div class="" id="autocomplete">
							<input type="hidden" name="c" value="<?= $chain ?>" class="chain">
							<input type="hidden" name="q" id="hotel_code" value="<?= $property ?>">
							<input type="hidden" name="currencyId" value="<?= $currency ?>">
							<input type="hidden" name="lang" value="<?= $language_object->Code ?>">
						</div>

						<div class="" id="dates">
							<?php

								//if set, if today or later
								$todayDateTime = new \DateTime('today');

								$start_date = \DateTime::createFromFormat('dmY', $_GET["CheckIn"]);
								//if set, valid datetime, and not in past
								if(isset($_GET["CheckIn"]) && $start_date && !$todayDateTime->diff($start_date)->invert){
									$CheckInString = $start_date->format('dmY');
									$CheckInShow = $start_date->format('d/m/Y');
									$tomorrow = $start_date->modify('+1 day');
								}else{
									$CheckInString = $todayDateTime->format('dmY');
									$CheckInShow = $todayDateTime->format('d/m/Y');
									$tomorrow = $todayDateTime->modify('+1 day');
								}

								$end_date = \DateTime::createFromFormat('dmY', $_GET["CheckOut"]);

								if(isset($_GET["CheckOut"]) && $end_date && !$tomorrow->diff($end_date)->invert){
									$CheckOutString = $end_date->format('dmY');
									$CheckOutShow = $end_date->format('d/m/Y');
								}else{
									$CheckOutString = $tomorrow->format('dmY');
									$CheckOutShow = $tomorrow->format('d/m/Y');
								}

								if($_GET["ad"] && intval($_GET["ad"])>0){
									$adults = intval($_GET["ad"]);
								}

								if($_GET["ch"] && intval($_GET["ch"])>=0){
									$children = intval($_GET["ch"]);
								}
							?>
							<p class="input-title custom-text">DATAS DA ESTADIA</p>
							<input class="calendarToggle" type="text" id="calendar_dates" value="<?= $CheckInShow .'-'. $CheckOutShow ?>" readonly>
							<input class="calendarToggle" type="hidden" id="date_from" name="CheckIn" value="<?= $CheckIn ?>">
							<input class="calendarToggle" type="hidden" id="date_to" name="CheckOut" value="<?= $CheckOut ?>">
						</div>

						<div class="guests_number" id="guests_div">

		                    <p class="input-title custom-text">QUARTOS E HÓSPEDES</p>

		                    <input type="text" id="guests"
		                    data-room="Quarto"
		                    data-rooms="Quartos"
		                    data-guest="Hóspede"
		                    data-guests="Hóspedes"
		                    data-remove-room="Remover quarto"
		                    data-max-adults="" 
		                    data-max-children="" 
		                    data-max-children-age="
		                        <?php
		                        if(isset($childrenMaxAge) && $childrenMaxAge != null){
		                            echo $childrenMaxAge; 
		                        }
		                        else { 
		                            echo 17;
		                        }
		                        ?>
		                    "
		                    readonly>

		                    <input type="hidden" id="ad" name="ad" value="<?= $adults ?>">
		                    <input type="hidden" id="ch" name="ch" value="">
		                    <input type="hidden" id="ag" name="ag" value="">

		                    <div id="occupancy_dropdown" class="position-absolute custom-bg custom-text">

		                        <div class="add-room-holder">
		                            <p class="add-room-title select-room-title custom-text">Nº DE QUARTOS</p>
		                            <div class="select-room-buttons">
		                                <button class="select-button select-button-minus select-room-minus" type="button" disabled>
		                                    <span>
		                                        <svg xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
		                                        </svg>                                              
		                                    </span>
		                                </button>
		                                <span class="select-value select-room-value">1</span>
		                                <button class="select-button select-button-plus select-room-plus" type="button">
		                                    <span>
		                                        <svg xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>     
		                                    </span>
		                                </button>
		                            </div>                          
		                        </div>                        
		                        <div class="select-room-holder">
		                            <div class="select-room" data-room-counter="0">
		                                <p class="select-room-title custom-text">Quarto <span class="select-room-counter">1</span></p>
		                                <div class="select-guests-holder">
		                                    <div class="select-adults-holder">
		                                        <div class="select-adults-title">Adultos</div>
		                                        <div class="select-adults-buttons">
		                                            <button class="select-button select-button-minus select-adult-minus" type="button" <?php if(isset($property) && !in_array($property, $two_adults_hotels)) echo "disabled" ?>>
		                                                <span>
		                                                    <svg xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
		                                                    </svg>                                              
		                                                </span>                                                
		                                            </button>
		                                            <span class="select-value select-adults-value"><?= $adults ?></span>
		                                            <button class="select-button select-button-plus select-adult-plus" type="button">
		                                                <span>
		                                                    <svg xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>  
		                                                </span>                                                
		                                            </button>
		                                        </div>
		                                    </div>
		                                    <div class="select-child-holder">
		                                        <div class="select-child-title">
		                                        <span>Crianças</span>
		                                        <span class="select-child-title-max-age">
		                                            0 aos
		                                            <?php if(isset($childrenMaxAge) && $childrenMaxAge != null): ?>
		                                                <span class="children_max_age_string"><?= $childrenMaxAge ?></span> Anos
		                                            <?php else: ?> 
		                                                <span class="children_max_age_string">17</span> Anos
		                                            <?php endif; ?>
		                                        </span>
		                                        </div>
		                                        <div class="select-child-buttons">
		                                            <button class="select-button select-button-minus select-child-minus" type="button" disabled>
		                                                <span>
		                                                    <svg xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
		                                                    </svg>                                              
		                                                </span>                                                
		                                            </button>
		                                            <span class="select-value select-child-value">0</span>
		                                            <button class="select-button select-button-plus select-child-plus" type="button">
		                                                <span>
		                                                    <svg xmlns="http://www.w3.org/2000/svg"   viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
		                                                </span>
		                                            </button>                             
		                                        </div>                          
		                                    </div>
		                                    <div class="select-child-ages-holder" data-children-empty-value="Idade">
		                                        <div class="select-child-ages-clone">
		                                            <p class="select-child-ages-title custom-text">Criança <span class="select-child-ages-number"></span></p>
		                                            <select class="select-child-ages-input-clone" data-string-sing="Ano" data-string-plu="Anos">
		                                               
		                                                <?php if(isset($childrenMaxAge) && $childrenMaxAge != null): ?>
		                                                        <option data-value="/" selected>Idade</option>
		                                                    <?php for($i=0;$i<$childrenMaxAge+1;$i++): ?>
		                                                        <option data-value="<?= $i ?>"><?= $i ?> <?php if($i==1) {echo "Ano";} else {echo "Anos";} ?></option>
		                                                    <?php endfor; ?>
		                                                <?php else: ?>
		                                                        <option data-value="/" selected>Idade</option>
		                                                    <?php for($i=0;$i<18;$i++): ?>
		                                                        <option data-value="<?= $i ?>"><?= $i ?> <?php if($i==1) {echo "Ano";} else {echo "Anos";} ?></option>
		                                                    <?php endfor; ?>
		                                                <?php endif; ?>                                                
		                                            </select>
		                                            <p class="incorect-age custom-text">Idade Incorrecta</p>

		                                        </div>                                                                                                                      

		                                    </div>
		                                    <hr class="select-room-divider">
		                                </div>
		                            </div>
		                        </div>
		                        <button class="btn-ic custom-action-bg custom-action-border custom-action-text select-occupancy-apply" type="button">
		                            <span>
		                                Aplicar
		                            </span>
		                            <span class="select-occupancy-apply-info">
		                                <span class="select-occupancy-apply-info-rooms" data-rooms="1">1</span>
		                                <span class="select-occupancy-apply-info-rooms-string"></span>
		                                ,
		                                <span class="select-occupancy-apply-info-guests" data-guests="1">1</span>
		                                <span class="select-occupancy-apply-info-guests-string"></span>
		                            </span>                            
		                        </button>          
		                    </div>
		                </div>




						<div class="promo_code">
							<p class="input-title custom-text">TENHO UM CÓDIGO</p>
							<input type="text" id="promo_code" placeholder="" readonly>
							

		                    <div id="promo_code_dropdown" class="position-absolute custom-bg custom-text">
		                        <div class="mb-3 mt-2">
		                            <p class="input-title">CÓDIGO DE GRUPO</p>
		                            <input type="text" id="group_code" name="group_code" value="<?= $_GET["group_code"] ?>">
		                        </div>

		                        <div class="mb-3">
		                            <p class="input-title">CÓDIGO PROMOCIONAL</p>
		                            <input type="text" id="Code" name="Code" value="<?= $_GET["Code"] ?>">
		                        </div>

		                        <div class="mb-3">
		                            <p class="input-title">CARTÃO DE FIDELIZAÇÃO</p>
		                            <input type="text" id="loyalty_code" name="loyalty_code">
		                        </div>

		                        <div class="text-right">
		                            <button id="promo_code_apply" class="custom-action-bg custom-action-text custom-action-border btn-ic">APLICAR</button>
		                        </div>
		                    </div>
						</div>

						<div id="search" class="search">
							<button type="button" class="btn btn-ic custom-action-bg custom-action-text custom-action-border search-button">Pesquisar</button>
						</div>
					</form>


					<?php
						$calendar_string = '';
					?>

					<div class="zcalendar-wrap">
						<div class="zcalendar" data-restrictions="Dias com restrições" data-promotional="Ofertas especiais para si" data-promo="Oferta Especial" data-unavilable="<?= $calendar_string ?>" data-lang="<?= $language_object->Code ?>"  data-night="Noite" data-nights="Noites" data-notavailable="Sem disponibilidade" data-closedonarrival="Fechado para check-in"  data-closedondeparture="Fechado para check-out"data-minimum-string="Mínimo"  data-maximum-string="Máximo" data-adult="adulto" data-adults="adultos"></div>
					</div>


					<div id="package-results">
						<?php require_once(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/widget/assets/templates/template-rooms.php'); ?>
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