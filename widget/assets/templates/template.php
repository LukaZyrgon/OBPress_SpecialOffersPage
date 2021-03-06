<?php
	$elementor_edit_active = \Elementor\Plugin::$instance->editor->is_edit_mode();
	$CheckInFormated = str_replace(".","",$CheckIn);
	$CheckOutFormated = str_replace(".","",$CheckOut);
    $CheckInT = strtotime($CheckIn);
    $CheckOutT = strtotime($CheckOut);
    $nights =  ( $CheckOutT - $CheckInT ) / 86400 ;

?>


<?php if(!is_null($promotion_id)): ?>
	<div class="single-package" data-redirect="<?= $redirect ?>" data-redirect-url="<?= $redirect_route ?>" data-package-id="<?= $promotion_id ?>">
		<?php if($package_offers != null): ?>
			<?php foreach($package_offers as $key => $package_offer): ?>
				<?php foreach($package_offer as $rateplan => $offer): ?>
					<?php if($rateplan == $promotion_id): ?>

						<div class="single-package-img-holder">
							<?php if(@$hotels_in_chain[$key]["MaxPartialPaymentParcel"] != null): ?>
	                            <div class="MaxPartialPaymentParcel" data-toggle="modal" data-target="#partial-modal-payment">
                                    <?php _e('Pay up to', 'OBPress_SpecialOffersPage') ?> <span><?= @$hotels_in_chain[$key]["MaxPartialPaymentParcel"] ?>x</span> 
	                            </div>
	                        <?php endif; ?>

	                        <?php if(isset($offer["image"])): ?>
	                            <img class="single-package-img" src="<?= $offer["image"]->ImageItemsType->ImageItems[0]->URL->Address?>" onError="this.onerror=null;this.src='/img/placeholderNewWhite.svg';" alt="<?=@$offer["get_rate_plans"]->RatePlanName?>">
	                        <?php else: ?>
	                            <img class="single-package-img" src="<?= $plugin_directory_path . '/assets/icons/placeholderNewWhite.svg' ?>" alt="promotion">
	                        <?php endif; ?>

	                        <div class="single-package-name-holder date-range"

                            <?php  
                               
                                if ( isset($offer["get_rate_plans"]->Guarantees) ) { 
                                    foreach($offer["get_rate_plans"]->Guarantees as $Guarantee) { 
                                        if($Guarantee->GuaranteeCode == -1) { 
                                            echo "data-start='" . $Guarantee->Start . "'"; 
                                            echo "data-end='" . $Guarantee->End . "'";
                                        }
                                    }
                                }
                            ?> 

                            >
	                	        <div class="single-package-hotel-name"><?= @$hotels_in_chain[$key]["HotelName"] ?></div>
	                            <div class="single-package-name"><?= $offer["get_rate_plans"]->RatePlanName ?></div>
	                        </div>

						</div>

						<div class="single-package-info-holder">

                            <?php
                                $package_stay_period_exist = false;
                                if(isset($offer["get_rate_plans"]->Guarantees)) {
                                    foreach($offer["get_rate_plans"]->Guarantees as $Guarantee) {
                                        if($Guarantee->GuaranteeCode == -1) {
                                            $package_stay_period_exist = true;
                                        }
                                    }
                                }
                            ?>
                            
                            <?php if($package_stay_period_exist == true): ?>
                                <p class="stay-period-header"><?php _e('Package Stay Period', 'OBPress_SpecialOffersPage') ?></p> 
                                <ul class="stay-period-list">
                                    <?php if($offer["get_rate_plans"]->Guarantees): ?>
                                        <?php foreach($offer["get_rate_plans"]->Guarantees as $Guarantee): ?>
                                            <?php if($Guarantee->GuaranteeCode == -1): ?>
                                                <li class="stay-period-range" data-start="<?= $Guarantee->Start; ?>" data-end="<?= $Guarantee->End; ?>">  
                                                    <?= Lang_Curr_Functions::dateFormatCulture($Guarantee->Start, $language, 9); ?> <?php _e('until', 'OBPress_SpecialOffersPage') ?> <?= Lang_Curr_Functions::dateFormatCulture($Guarantee->End, $language, 9); ?>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>						
                                </ul>
                            <?php endif; ?>
                            <?php if(isset($offer["get_rate_plans"]->MealsIncluded) || isset($offer["get_rate_plans"]->RatePlanInclusions)) : ?>
                                <p class="single-package-included-msg"><?php _e('This special package offers', 'OBPress_SpecialOffersPage') ?>:</p> 
                                <div class="single-package-included-holder">
                                    <?php if(isset($offer["get_rate_plans"]->MealsIncluded)) : ?>
                                        <?php if($offer["get_rate_plans"]->MealsIncluded != null) : ?>
                                            <div class="meals_included">
                                                <img class="" src="<?= get_template_directory_uri() ?>/templates/assets/icons/check_dark.svg" alt="">
                                                <?= $offer["get_rate_plans"]->MealsIncluded->Name ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if(isset($offer["get_rate_plans"]->RatePlanInclusions)): ?>
                                        <?php if($offer["get_rate_plans"]->RatePlanInclusions != null): ?>
                                            <?php foreach($offer["get_rate_plans"]->RatePlanInclusions as $included): ?>
                                                <div>
                                                    <img class="" src="<?= get_template_directory_uri() ?>/templates/assets/icons/check_dark.svg" alt="">
                                                    <span class="single-package-included"><?= $included->RatePlanInclusionDesciption->Name ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

	                        <?php
	                        	foreach($descriptive_info->get()->HotelDescriptiveContentsType->HotelDescriptiveContents[0]->HotelInfo->HotelAmenities as $HotelAmenity) {
	                        		$amenity_categories[$HotelAmenity->HotelAmenityCategory][] = $HotelAmenity;
	                        	}
	                        ?>

	                        <div class="single-package-info-categories desktop">
	                        	<ul class="single-package-info-categories-bars">
	                        		<li class="single-package-info-categories-bar active-bar" data-category="package-description"><?php _e('Description', 'OBPress_SpecialOffersPage') ?></li>
                                    <?php if(isset($offer["get_rate_plans"]->Guarantees)): ?>
                                        <li class="single-package-info-categories-bar" data-category="package-guaranties"><?php _e('Deposit / Guarantee Policies', 'OBPress_SpecialOffersPage') ?></li>
                                    <?php endif; ?>

                                    <?php if(isset($offer["get_rate_plans"]->CancelPenalties)): ?>
                                        <li class="single-package-info-categories-bar" data-category="package-cancellation"><?php _e('Cancellation Policies', 'OBPress_SpecialOffersPage') ?></li>
                                    <?php endif; ?>
                                    
	                        		<?php foreach($amenity_categories as $key => $amenity_category): ?>
	                        			<li class="single-package-info-categories-bar" data-category="<?= $key ?>"><?= $key ?>
                                            
                                        </li>
	                        		<?php endforeach; ?>
	                        	</ul>

	                        	<div class="single-package-info-category-section active-section" data-category="package-description">
	                        		<span class="package-description-short"> ??? 
	                        			<?= substr(nl2br($offer["get_rate_plans"]->RatePlanDescription->Description),0, 200) ?>
	                        			<?php if(strlen($offer["get_rate_plans"]->RatePlanDescription->Description) > 200): ?>
	                        				<span class="">...</span>
	                        			<?php endif; ?>
	                        		</span>
	                        		<?php if(strlen($offer["get_rate_plans"]->RatePlanDescription->Description) > 200): ?>
                                        ??? 
	                        			<span class="package-description-long"><?= nl2br($offer["get_rate_plans"]->RatePlanDescription->Description) ?></span>
	                        		
		                        		<span class="package-more-description"><?php _e('read more', 'OBPress_SpecialOffersPage') ?></span>
		                        		<span class="package-less-description"><?php _e('read less', 'OBPress_SpecialOffersPage') ?></span>
		                        	<?php endif; ?>
	                        	</div>

                                <?php if(isset($offer["get_rate_plans"]->Guarantees)): ?>
                                    <?php
                                        $Guarantees = $offer["get_rate_plans"]->Guarantees;
                                        $NewGuarantees = [];
                                        foreach($Guarantees as $key => $Guaranty) {
                                            if(is_null($Guaranty->GuaranteeDescription)) {
                                                unset($Guarantees[$key]);
                                            }
                                            else {
                                                $NewGuarantees[$Guaranty->GuaranteeDescription->Name][] = $Guaranty;
                                            }
                                        }
                                        $Guarantees = $NewGuarantees;
                                        $Guarantees = array_values($Guarantees);
                                        
                                        $first_element = array_shift($Guarantees);
                                        array_push($Guarantees, $first_element);
                                    ?>                                

                                    <div class="single-package-info-category-section" data-category="package-guaranties">
                                        <?php if(current($Guarantees) == null): ?>

                                        <?php elseif(current($Guarantees) != null && count($Guarantees) == 1 && count($Guarantees[0]) == 1 && $Guarantees[0][0]->Start == null && $Guarantees[0][0]->GuaranteeDescription != null): ?>
                                            <?= nl2br($Guarantees[0][0]->GuaranteeDescription->Description) ?>
                                        <?php else: ?>
                                            <?php foreach($Guarantees as $GuarantyByType): ?>
                                                <?php if(count($GuarantyByType) == 1 && $GuarantyByType[0]->Start == null && $GuarantyByType[0]->GuaranteeDescription != null): ?>
                                                    <span class="policy_dates"><?php _e('On other dates:', 'OBPress_SpecialOffersPage') ?></span>
                                                <?php elseif(count($GuarantyByType) > 1 && $GuarantyByType[0]->Start != null && $GuarantyByType[0]->GuaranteeDescription != null): ?>
                                                    <span class="policy_dates"><?php _e('Policy applicable on dates:', 'OBPress_SpecialOffersPage') ?></span>
                                                <?php else: ?>
                                                    <span class="policy_dates"><?php _e('Policy applicable on dates:', 'OBPress_SpecialOffersPage') ?></span><br>
                                                <?php endif; ?>
                                                <?php foreach($GuarantyByType as $Guaranty): ?>
                                                    <?php if($Guaranty->Start != null && $Guaranty->GuaranteeDescription != null): ?>
                                                        <span class="incentive-dates responsive-incentive-text-guarantee">
                                                            <?= Lang_Curr_Functions::dateFormatCulture($Guaranty->Start, $language, 9); ?> - <?php Lang_Curr_Functions::dateFormatCulture($Guaranty->End, $language, 9); ?> <br>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if($GuarantyByType[0]->GuaranteeDescription->Name): ?>
                                                    <p class="incentive-text responsive-incentive-text-guarantee"><?= nl2br($GuarantyByType[0]->GuaranteeDescription->Description) ?></p>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>

                                <?php endif; ?>

                                <?php if(isset($offer["get_rate_plans"]->CancelPenalties)): ?>
                                    <?php
                                        $CancelPenalties = $offer["get_rate_plans"]->CancelPenalties;

                                        $NewCancelPenalties = [];
                                        foreach($CancelPenalties as $key => $CancelPenalty) {
                                            if(is_null($CancelPenalty->PenaltyDescription)) {
                                                unset($CancelPenalties[$key]);
                                            }
                                            else {
                                                $NewCancelPenalties[$CancelPenalty->PenaltyDescription->Name][] = $CancelPenalty;
                                            }
                                        }
                                        $CancelPenalties = $NewCancelPenalties;
                                        $CancelPenalties = array_values($CancelPenalties);

                                        $first_element = array_shift($CancelPenalties);
                                        array_push($CancelPenalties, $first_element);
                                    ?>
                                    
                                    <div class="single-package-info-category-section" data-category="package-cancellation">
                                        <?php if(current($CancelPenalties) == null): ?>
                                        <?php elseif(current($CancelPenalties) != null && count($CancelPenalties) == 1 && count($CancelPenalties[0]) == 1 && $CancelPenalties[0][0]->Start == null && $CancelPenalties[0][0]->PenaltyDescription != null): ?>
                                            <div class="offer-text-holder">
                                                <span class="offer-text" data-open="false"><?= nl2br($CancelPenalties[0][0]->PenaltyDescription->Description); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <?php foreach($CancelPenalties as $CancelPenaltyByType): ?>
                                                <?php if(count($CancelPenaltyByType) == 1 && $CancelPenaltyByType[0]->Start == null): ?>
                                                    <span class="policy_dates"><?php _e('On other dates:', 'OBPress_SpecialOffersPage') ?></span><br>
                                                <?php else: ?>
                                                    <span class="policy_dates"><?php _e('Policy applicable on dates:', 'OBPress_SpecialOffersPage') ?></span><br>
                                                <?php endif; ?>
                                                <?php foreach($CancelPenaltyByType as $CancelPenaltyByPeriod): ?>
                                                    <?php if($CancelPenaltyByPeriod->Start != null && $CancelPenaltyByPeriod->PenaltyDescription != null): ?>
                                                        <span class="incentive-dates responsive-incentive-text-cancel">
                                                            <?php Lang_Curr_Functions::dateFormatCulture($CancelPenaltyByPeriod->Start, $language, 9); ?> - <?php Lang_Curr_Functions::dateFormatCulture($CancelPenaltyByPeriod->End, $language, 9); ?> <br>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if($CancelPenaltyByType[0]->PenaltyDescription->Name): ?>
                                                    <p class="incentive-text responsive-incentive-text-cancel"><?= nl2br($CancelPenaltyByType[0]->PenaltyDescription->Description); ?></p>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>

                                <?php endif; ?>

	                        	<?php foreach($amenity_categories as $key => $amenity_category): ?>
	                    			<div class="single-package-info-category-section" data-category="<?= $key ?>">
                                        <?php $loop_counter = 0; ?>
                                        <?php foreach($amenity_category as $amenity): ?>

                                            <?php if($loop_counter == 0): ?>
                                                <div class="amenity-4-group">
                                            <?php endif; ?>

	                    					        <div>??? <?= $amenity->HotelAmenity ?></div>
                                                    <?php $loop_counter++; ?>

                                            <?php if($loop_counter == 4): ?>
                                                </div>
                                                <?php $loop_counter = 0; ?>
                                            <?php endif; ?>

	                    				<?php endforeach; ?>

                                        <?php if($loop_counter != 0): ?>
                                            </div>
                                        <?php endif; ?>
	                    			</div>
	                    		<?php endforeach; ?>
	                        </div>
                            <div class="single-package-info-categories mobile">
                                <div class="single-package-info-category-holder">
                                    <div class="single-package-info-category-title"><?php _e('Description', 'OBPress_SpecialOffersPage') ?></div>
                                    <div class="single-package-info-description-holder">
                                        <?= nl2br($offer["get_rate_plans"]->RatePlanDescription->Description) ?>
                                    </div>
                                    <img class="single-package-info-description-arrow" src="<?= get_template_directory_uri() ?>/templates/assets/icons/arrow_down.svg" alt="">
                                </div>
                                <?php if(isset($offer["get_rate_plans"]->Guarantees)): ?>
                                    <div class="single-package-info-category-holder">
                                        <div class="single-package-info-category-title"><?php _e('Deposit / Guarantee Policies', 'OBPress_SpecialOffersPage') ?></div>
                                        <div class="single-package-info-description-holder">
                                            <?php if(isset($offer["get_rate_plans"]->Guarantees)): ?>
                                                <?php
                                                    $Guarantees = $offer["get_rate_plans"]->Guarantees;
                                                    $NewGuarantees = [];
                                                    foreach($Guarantees as $key => $Guaranty) {
                                                        if(is_null($Guaranty->GuaranteeDescription)) {
                                                            unset($Guarantees[$key]);
                                                        }
                                                        else {
                                                            $NewGuarantees[$Guaranty->GuaranteeDescription->Name][] = $Guaranty;
                                                        }
                                                    }
                                                    $Guarantees = $NewGuarantees;
                                                    $Guarantees = array_values($Guarantees);
                                                    
                                                    $first_element = array_shift($Guarantees);
                                                    array_push($Guarantees, $first_element);
                                                ?>                                

                                                <?php if(current($Guarantees) == null): ?>

                                                <?php elseif(current($Guarantees) != null && count($Guarantees) == 1 && count($Guarantees[0]) == 1 && $Guarantees[0][0]->Start == null && $Guarantees[0][0]->GuaranteeDescription != null): ?>
                                                    <?= nl2br($Guarantees[0][0]->GuaranteeDescription->Description) ?>
                                                <?php else: ?>
                                                    <?php foreach($Guarantees as $GuarantyByType): ?>
                                                        <?php if(count($GuarantyByType) == 1 && $GuarantyByType[0]->Start == null && $GuarantyByType[0]->GuaranteeDescription != null): ?>
                                                            <span class="policy_dates"><?php _e('On other dates:', 'OBPress_SpecialOffersPage') ?></span>
                                                        <?php elseif(count($GuarantyByType) > 1 && $GuarantyByType[0]->Start != null && $GuarantyByType[0]->GuaranteeDescription != null): ?>
                                                            <span class="policy_dates"><?php _e('Policy applicable on dates:', 'OBPress_SpecialOffersPage') ?></span>
                                                        <?php else: ?>
                                                            <span class="policy_dates"><?php _e('Policy applicable on dates:', 'OBPress_SpecialOffersPage') ?></span><br>
                                                        <?php endif; ?>
                                                        <?php foreach($GuarantyByType as $Guaranty): ?>
                                                            <?php if($Guaranty->Start != null && $Guaranty->GuaranteeDescription != null): ?>
                                                                <span class="incentive-dates responsive-incentive-text-guarantee">
                                                                    <?= Lang_Curr_Functions::dateFormatCulture($Guaranty->Start, $language, 9); ?> - <?php Lang_Curr_Functions::dateFormatCulture($Guaranty->End, $language, 9); ?> <br>
                                                                </span>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php if($GuarantyByType[0]->GuaranteeDescription->Name): ?>
                                                            <p class="incentive-text responsive-incentive-text-guarantee"><?= nl2br($GuarantyByType[0]->GuaranteeDescription->Description) ?></p>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <img class="single-package-info-description-arrow" src="<?= get_template_directory_uri() ?>/templates/assets/icons/arrow_down.svg" alt="">
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($offer["get_rate_plans"]->CancelPenalties)): ?>
                                    <div class="single-package-info-category-holder">
                                        <div class="single-package-info-category-title"><?php _e('Cancellation Policies', 'OBPress_SpecialOffersPage') ?></div>
                                        <div class="single-package-info-description-holder">
                                            <?php if(isset($offer["get_rate_plans"]->CancelPenalties)): ?>
                                                <?php
                                                    $CancelPenalties = $offer["get_rate_plans"]->CancelPenalties;

                                                    $NewCancelPenalties = [];
                                                    foreach($CancelPenalties as $key => $CancelPenalty) {
                                                        if(is_null($CancelPenalty->PenaltyDescription)) {
                                                            unset($CancelPenalties[$key]);
                                                        }
                                                        else {
                                                            $NewCancelPenalties[$CancelPenalty->PenaltyDescription->Name][] = $CancelPenalty;
                                                        }
                                                    }
                                                    $CancelPenalties = $NewCancelPenalties;
                                                    $CancelPenalties = array_values($CancelPenalties);

                                                    $first_element = array_shift($CancelPenalties);
                                                    array_push($CancelPenalties, $first_element);
                                                ?>
                                                
                                                <?php if(current($CancelPenalties) == null): ?>
                                                <?php elseif(current($CancelPenalties) != null && count($CancelPenalties) == 1 && count($CancelPenalties[0]) == 1 && $CancelPenalties[0][0]->Start == null && $CancelPenalties[0][0]->PenaltyDescription != null): ?>
                                                    <div class="offer-text-holder">
                                                        <img class="" src="<?= get_template_directory_uri() ?>/templates/assets/icons/check_dark.svg" alt="">
                                                        <span class="offer-text" data-open="false"><?= nl2br($CancelPenalties[0][0]->PenaltyDescription->Description); ?></span>
                                                    </div>
                                                <?php else: ?>
                                                    <?php foreach($CancelPenalties as $CancelPenaltyByType): ?>
                                                        <img class="" src="<?= get_template_directory_uri() ?>/templates/assets/icons/check_dark.svg" alt="">
                                                        <?php if(count($CancelPenaltyByType) == 1 && $CancelPenaltyByType[0]->Start == null): ?>
                                                            <span class="policy_dates"><?php _e('On other dates:', 'OBPress_SpecialOffersPage') ?></span><br>
                                                        <?php else: ?>
                                                            <span class="policy_dates"><?php _e('Policy applicable on dates:', 'OBPress_SpecialOffersPage') ?></span><br>
                                                        <?php endif; ?>
                                                        <?php foreach($CancelPenaltyByType as $CancelPenaltyByPeriod): ?>
                                                            <?php if($CancelPenaltyByPeriod->Start != null && $CancelPenaltyByPeriod->PenaltyDescription != null): ?>
                                                                <span class="incentive-dates responsive-incentive-text-cancel">
                                                                    <?php Lang_Curr_Functions::dateFormatCulture($CancelPenaltyByPeriod->Start, $language, 9); ?> - <?php Lang_Curr_Functions::dateFormatCulture($CancelPenaltyByPeriod->End, $language, 9); ?> <br>
                                                                </span>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php if($CancelPenaltyByType[0]->PenaltyDescription->Name): ?>
                                                            <p class="incentive-text responsive-incentive-text-cancel"><?= nl2br($CancelPenaltyByType[0]->PenaltyDescription->Description); ?></p>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <img class="single-package-info-description-arrow" src="<?= get_template_directory_uri() ?>/templates/assets/icons/arrow_down.svg" alt="">
                                    </div>
                                <?php endif; ?>

                                <?php foreach($amenity_categories as $key => $amenity_category): ?>
                                    <div class="single-package-info-category-holder">
                                        <div class="single-package-info-category-title"><?= $key ?></div>
                                        <div class="single-package-info-description-holder">
                                            <div>
                                                <?php foreach($amenity_category as $amenity): ?>
                                                    <div>
                                                        <img class="" src="<?= get_template_directory_uri() ?>/templates/assets/icons/check_dark.svg" alt=""> 
                                                        <?= $amenity->HotelAmenity ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <img class="single-package-info-description-arrow" src="<?= get_template_directory_uri() ?>/templates/assets/icons/arrow_down.svg" alt="">
                                    </div>
                                <?php endforeach; ?>


                            </div>
						</div>

						<?php echo $hotelFolders ; ?>

                        <form type="POST" action="" class="package-form">

                            <div class="ob-searchbar-so obpress-hotel-searchbar-custom-so container" id="special-offer" data-hotel-folders="<?php echo htmlspecialchars(json_encode($hotelFolders), ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="ob-searchbar-so-hotel">
                                    <p>
                                    <?php
                                        printf(
                                            _n(
                                                'Hotel',
                                                'Destination or Hotel',
                                                $counter_for_hotel,
                                                'OBPress_SpecialOffersPage'
                                            ),
                                            number_format_i18n( $counter_for_hotel )
                                        );                
                                    ?>
                                    </p>

                                    <input type="text" value="" readonly placeholder="<?php if ( $data->getHotels()[$property]['HotelName'] ) {
                                            echo $data->getHotels()[$property]['HotelName'];
                                            } else {
                                            _e('All Hotels', 'OBPress_SpecialOffersPage');
                                            }  ?>" id="hotels-so" class="<?php if (!empty(get_option('hotel_id'))) {
                                                                    echo 'single-hotel-so';
                                                                } ?>" spellcheck="false" autocomplete="off">

                                    <input type="hidden" name="c" id="chain_code-so" value="<?php echo get_option('chain_id') ?>">
                                    <input type="hidden" name="q" id="hotel_code-so" value="<?php echo $data->getHotels()[$property]['HotelCode'] ?>">

                                    <input type="hidden" name="currencyId" value="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                                    <input type="hidden" name="lang" value="<?= (isset($_GET['lang'])) ? $_GET['lang'] : get_option('default_language_id') ?>">
                                    <input type="hidden" name="hotel_folder" id="hotel_folder-so">
                                    <input type="hidden" name="NRooms" id="NRooms-so" value="<?php echo $_GET['NRooms'] ?>">
                                    <div class="hotels_dropdown-so">
                                        <div class="obpress-mobile-close-hotels-dropdown-holder-so">
                                            <span><?php _e('Select destination or hotel', 'OBPress_SpecialOffersPage') ?></span>
                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                                        </div>
                                        <div class="obpress-mobile-search-hotels-input-holder-so">
                                            <input class="obpress-mobile-search-hotels-input-so" type="text" placeholder="Digite o nome ou cidade do hotel" id="search-hotels-input-so">
                                        </div>
                                    <!--  <div class="hotels_all custom-bg custom-text" data-id="0"><?php _e('All Hotels', 'OBPress_SpecialOffersPage'); ?></div> -->
                                        <div class="hotels_folder-so custom-bg custom-text" hidden></div>
                                        <div class="hotels_hotel-so custom-bg custom-text" data-id="" hidden></div>
                                    </div>

                                </div>
                                <div class="ob-searchbar-calendar-so">
                                    <p><?php _e('Dates of stay', 'OBPress_SpecialOffersPage'); ?></p>
                                    <input class="calendarToggle" type="text" id="calendar_dates-so" value="<?php echo $CheckInShow ?? date("d/m/Y") ?> - <?php echo $CheckOutShow ?? date("d/m/Y", strtotime("+1 day")) ?>"  readonly>
                                    <div class="ob-mobile-searchbar-calendar-holder-so">
                                        <div class="ob-mobile-searchbar-calendar-so">
                                            <p><?php _e('Check-in', 'OBPress_SpecialOffersPage') ?></p>
                                            <input class="calendarToggle" type="text" id="check_in_mobile-so" value="<?php echo $CheckInShowMobile ?? date("d M Y") ?>"  readonly>
                                        </div>
                                        <div class="ob-mobile-searchbar-calendar-so">
                                            <p><?php _e('Check-out', 'OBPress_SpecialOffersPage') ?></p>
                                            <input class="calendarToggle" type="text" id="check_out_mobile-so" value="<?php echo $CheckOutShowMobile ?? date("d M Y", strtotime("+1 day")) ?>"  readonly>
                                        </div>
                                    </div>
                                    <input class="calendarToggle" type="hidden" id="date_from-so" name="CheckIn" value="<?php echo $CheckIn ?? date("dmY") ?>">
                                    <input class="calendarToggle" type="hidden" id="date_to-so" name="CheckOut" value="<?php echo $CheckOut ?? date("dmy", strtotime("+1 day")) ?>">            
                                </div>
                                <div class="ob-searchbar-guests-so">
                                    <p><?php _e('Rooms and guests', 'OBPress_SpecialOffersPage'); ?></p>
                                    <input type="text" id="guests-so" data-room="<?php _e('Room', 'OBPress_SpecialOffersPage'); ?>" data-rooms="<?php _e('Rooms', 'OBPress_SpecialOffersPage'); ?>" data-guest="<?php _e('Guest', 'OBPress_SpecialOffersPage'); ?>" data-guests="<?php _e('Guests', 'OBPress_SpecialOffersPage'); ?>" data-remove-room="<?php _e('Remove room', 'OBPress_SpecialOffersPage'); ?>" readonly>
                                    <input type="hidden" id="ad-so" name="ad" value="<?= get_option('calendar_adults') ?>">
                                    <input type="hidden" id="ch-so" name="ch" value="">
                                    <input type="hidden" id="ag-so" name="ag" value="">

                                    <div id="occupancy_dropdown-so" class="position-absolute custom-bg custom-text" data-default-currency="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                                        <div class="add-room-holder-so">
                                            <p class="add-room-title-so select-room-title-so custom-text"><?php _e('NUMBER OF ROOMS', 'OBPress_SpecialOffersPage') ?></p>
                                            <div class="select-room-buttons-so">
                                                <button class="select-button-so select-button-minus-so select-room-minus-so" type="button" disabled>

                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                    </svg>
                                                    
                                                </button>
                                                <span class="select-value-so select-room-value-so">1</span>
                                                <button class="select-button-so select-button-plus-so select-room-plus-so" type="button">

                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                    
                                                </button>
                                            </div>
                                        </div>
                                        <div class="select-room-holder-so">
                                            <div class="select-room-so" data-room-counter="0">
                                                <p class="select-room-title-so custom-text"><?php _e('Room', 'OBPress_SpecialOffersPage');?> <span class="select-room-counter">1</span></p>

                                                <div class="remove-room-mobile-so"><?php _e('Remove room', 'OBPress_SpecialOffersPage') ?></div>

                                                <div class="select-guests-holder-so">
                                                    <div class="select-adults-holder-so">
                                                        <div class="select-adults-title-so">
                                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/adults.svg" alt="">
                                                            <?php _e('Adults', 'OBPress_SpecialOffersPage'); ?>
                                                        </div>
                                                        <div class="select-adults-buttons-so">
                                                            <button class="select-button-so select-button-minus-so select-adult-minus-so" type="button" disabled>
                                                                
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                                </svg>

                                                            </button>
                                                            <span class="select-value-so select-adults-value-so">1</span>
                                                            <button class="select-button-so select-button-plus-so select-adult-plus-so" type="button">

                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>

                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="select-child-holder-so">
                                                        <div class="select-child-title-so">
                                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/children.svg" alt="">
                                                            <div>
                                                                <span><?php _e('Children', 'OBPress_SpecialOffersPage') ?></span>
                                                                <span class="select-child-title-max-age-so">
                                                                    0 <?php 
                                                                    _e('to the', 'OBPress_SpecialOffersPage') ; 
                                                                    echo " " ; 
                                                                    ?>
                                                                    <span class='child-max-age-so'> <?php echo $childrenMaxAge ; ?> </span>
                                                                </span> 
                                                            </div>
                                                        </div>
                                                        <div class="select-child-buttons-so">
                                                            <button class="select-button-so select-button-minus-so select-child-minus-so" type="button" disabled>
                                                                
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                                </svg>

                                                            </button>
                                                            <span class="select-value-so select-child-value-so">0</span>
                                                            <button class="select-button-so select-button-plus-so select-child-plus-so" type="button">

                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                                
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="select-child-ages-holder-so">
                                                        <div class="select-child-ages-clone-so">

                                                            <p class="select-child-ages-title-so custom-text"><?php _e('Age', 'OBPress_SpecialOffersPage'); ?> <span class="select-child-ages-number-so"></span></p>

                                                            <div class="age-picker-so"> 
                                                                <span class="age-picker-value-so">0</span> 

                                                                <div class="age-picker-options-so">
                                                                    <?php for ($i = 0; $i < 18; $i++) : ?>
                                                                        <div data-age="<?= $i; ?>"> <?= $i; ?> <?php _e('years old', 'OBPress_SpecialOffersPage') ?></div>
                                                                    <?php endfor; ?>

                                                                </div>

                                                                <select class="select-child-ages-input-clone-so">
                                                                        <?php for ($i = 0; $i < 18; $i++) : ?>
                                                                            <option data-value="<?= $i; ?>" <?php if ($i == 0) { echo "selected";} ?>><?= $i; ?></option>
                                                                        <?php endfor; ?>
                                                                </select>

                                                            </div>

                                                            <div class="child-ages-input-so"></div>

                                                            <p class="incorect-age-so custom-text"><?php _e('Incorrect Age', 'OBPress_SpecialOffersPage') ?></p>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="add-room-mobile-so">+ <?php _e('Add another room', 'OBPress_SpecialOffersPage') ?></div>
                                                
                                            </div>
                                        </div>

                                        <button class="btn-ic custom-action-bg custom-action-border custom-action-text select-occupancy-apply-so" type="button">
                                                <?php _e('Apply', 'OBPress_SpecialOffersPage') ?>

                                                <span class="select-occupancy-apply-info-so">
                                                        <span class="select-occupancy-apply-info-rooms-so" data-rooms="1">1</span>
                                                        <span class="select-occupancy-apply-info-rooms-string-so"><?php _e('Room', 'OBPress_SpecialOffersPage') ?></span>
                                                        ,
                                                        <span class="select-occupancy-apply-info-guests-so" data-guests="<?= get_option('calendar_adults') ?>"><?= get_option('calendar_adults') ?></span>
                                                        <span class="select-occupancy-apply-info-guests-string-so"><?php _e('Guest', 'OBPress_SpecialOffersPage') ?></span>
                                                </span>
                                        </button>

                                    </div>
                                </div>
                                    <div class="ob-searchbar-promo-so">
                                        <p><?php _e('I have a code', 'OBPress_SpecialOffersPage'); ?></p>
                                        <input type="text" id="promo_code-so" value="" placeholder="<?php _e('Choose type', 'OBPress_SpecialOffersPage') ?>" readonly>
                                        <div class="material-check custom-checkbox-holde ob-mobile-i-have-a-code-so">
                                            <div class="mdc-touch-target-wrapper">
                                                <div class="mdc-checkbox mdc-checkbox--touch">
                                                    <input class="board_check mdc-checkbox__native-control checkbox-custom checkbox-custom ob-mobile-i-have-a-code-input-so" type="checkbox" name="1" id="i_have_a_code-so">
                                                    <div class="mdc-checkbox__background">
                                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                                        </svg>
                                                        <div class="mdc-checkbox__mixedmark"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="form-check-label" for="i_have_a_code-so">
                                                <span class="checkbox-custom-label"><?php _e('I HAVE A CODE', 'OBPress_SpecialOffersPage'); ?></span>
                                            </label>
                                        </div>
                                        <div id="promo_code_dropdown-so" class="position-absolute custom-bg custom-text">
                                            <div class="mb-3 mt-2">
                                                <p class="input-title-so"><?php _e('GROUP CODE', 'OBPress_SpecialOffersPage') ?></p>
                                                <div class="material-textfield">
                                                    <input type="text" id="group_code-so" name="group_code" placeholder="<?php _e('Enter your code', 'OBPress_SpecialOffersPage') ?>">
                                                    <span class="label-title-so"><?php _e('GROUP CODE', 'OBPress_SpecialOffersPage') ?></span>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <p class="input-title-so"><?php _e('PROMO CODE', 'OBPress_SpecialOffersPage'); ?></p>
                                                <div class="material-textfield">
                                                    <input type="text" id="Code-so" name="Code" placeholder="<?php _e('Enter your code', 'OBPress_SpecialOffersPage') ?>">
                                                    <span class="label-title-so"><?php _e('PROMO CODE', 'OBPress_SpecialOffersPage'); ?></span>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <p class="input-title-so"><?php _e('LOYALTY CODE', 'OBPress_SpecialOffersPage') ?></p>
                                                <div class="material-textfield">
                                                    <input type="text" id="loyalty_code-so" name="loyalty_code" placeholder="<?php _e('Enter your code', 'OBPress_SpecialOffersPage') ?>">
                                                    <span class="label-title-so"><?php _e('LOYALTY CODE', 'OBPress_SpecialOffersPage') ?></span>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <button id="promo_code_apply-so" class="custom-action-bg custom-action-text custom-action-border btn-ic"><?php _e('Apply', 'OBPress_SpecialOffersPage'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="ob-searchbar-button-so">
                                        <button class="ob-searchbar-submit-so" type="button"><?php _e('Search', 'OBPress_SpecialOffersPage'); ?></button>
                                    </div> 

                            </div>
                            <div class="zcalendar-wrap-so">

                                <div class="ob-zcalendar-top-so">
                                    <div class="ob-zcalendar-title-so">
                                        <?php _e('Select date of stay', 'OBPress_SpecialOffersPage') ?>
                                        <span>
                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                                        </span>
                                    </div>
                                    <div class="ob-mobile-weekdays-so">
                                        <div>
                                            <span><?php _e('sun', 'OBPress_SpecialOffersPage') ?></span>
                                            <span><?php _e('mon', 'OBPress_SpecialOffersPage') ?></span>
                                            <span><?php _e('tue', 'OBPress_SpecialOffersPage') ?></span>
                                            <span><?php _e('wed', 'OBPress_SpecialOffersPage') ?></span>
                                            <span><?php _e('thu', 'OBPress_SpecialOffersPage') ?></span>
                                            <span><?php _e('fri', 'OBPress_SpecialOffersPage') ?></span>
                                            <span><?php _e('sat', 'OBPress_SpecialOffersPage') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="zcalendar-holder-so" id="calendar-holder">
                                    <div class="zcalendar-so" data-allow-unavail="<?= get_option('allow_unavail_dates') ?>" data-allow-unavail="<?= get_option('allow_unavail_dates') ?>" data-promotional="<?php _e('Offers for you', 'OBPress_SpecialOffersPage'); ?>" data-promo="<?php _e('Special Offer', 'OBPress_SpecialOffersPage'); ?>" data-lang="<?php $lang->Code ?>"  data-night="<?php _e('Night', 'OBPress_SpecialOffersPage') ?>" data-nights="<?php _e('Nights', 'OBPress_SpecialOffersPage') ?>" data-price-for="<?php _e('*Price for', 'OBPress_SpecialOffersPage') ?>" data-adult="<?php _e('adult', 'OBPress_SpecialOffersPage') ?>" data-adults="<?php _e('adults', 'OBPress_SpecialOffersPage') ?>" data-restriction="<?php _e('Restricted Days', 'OBPress_SpecialOffersPage') ?>" data-notavailable="<?php _e('index_no_availability_v4', 'OBPress_SpecialOffersPage') ?>" data-closedonarrival="<?php _e('calendar_closed_on_arrival', 'OBPress_SpecialOffersPage') ?>"  data-closedondeparture="<?php _e('calendar_closed_on_departure', 'OBPress_SpecialOffersPage') ?>" data-minimum-string="<?php _e('system_min', 'OBPress_SpecialOffersPage') ?>" data-maximum-string="<?php _e('system_max', 'OBPress_SpecialOffersPage') ?>" ></div>
                                </div>
                                
                                <div class="ob-zcalendar-bottom-so">
                                    <div> <span class='mobile-accept-dates-from-to-so'>Seg, 14 Nov - Sex, 18 Nov</span> <span class="number_of_nights-mobile-span-so"> ( <span class="number_of_nights-mobile-so"> 4 <?php _e('Nights', 'OBPress_SpecialOffersPage') ?></span> )</span> </div>
                                    <div id="mobile-accept-date-so"> <?php _e('Apply', 'OBPress_SpecialOffersPage') ?> </div>
                                </div>
                            </div>     

                        </form>

                        <?php
                            $calendar_string = '';
                        ?>

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
                            <p class="rooms-message-header"><?php _e('Related rooms', 'OBPress_SpecialOffersPage') ?></p>
                        <?php endif; ?>

                        <div class="obpress-package-rooms-basket"> 

                            <div id="package-results" data-max-rooms="<?php if ( isset( $style->Result->MaxRooms) ) { 
                                echo $style->Result->MaxRooms; }?>">
                                <?php require_once(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/widget/assets/templates/template-rooms.php'); ?>
                            </div>


                            <div class="next-step-loader">
                                <div class="gooey">
                                    <span class="dot"></span>
                                    <div class="dots">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
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

            <p class="stay-period-header">Package Stay Period</p>
            <ul class="stay-period-list">
                <li class="stay-period-range" data-start="2022-01-13T00:00:00Z" data-end="2022-01-30T00:00:00Z">    
                    1/13/2022 until 11/30/2022
                </li>				
            </ul>

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
            	<ul class="single-package-info-categories-bars">
            		<li class="single-package-info-categories-bar active-bar" data-category="package-description">Descri????o</li>

                    <li class="single-package-info-categories-bar" data-category="package-guaranties">Deposit / Guarantee Policies</li>
                    <li class="single-package-info-categories-bar" data-category="package-cancellation">Cancellation Policies</li>

            		<li class="single-package-info-categories-bar" data-category="Servi??os Gerais">Servi??os Gerais</li>
            		<li class="single-package-info-categories-bar" data-category="Restaurantes e Bares">Restaurantes e Bares</li>
            		<li class="single-package-info-categories-bar" data-category="Bem-estar e Desporto">Bem-estar e Desporto</li>
            		<li class="single-package-info-categories-bar" data-category="Produtos de casa e banho">Produtos de casa e banho</li>
            		<li class="single-package-info-categories-bar" data-category="Atra????es">Atra????es</li>
            	</ul>

            	<div class="single-package-info-category-section active-section" data-category="package-description">
            		<span class="package-description-short">
            			<?= nl2br("O Hilton Copacabana Rio De Janeiro, De 5 Estrelas, Est?? Idealmente Localizado Em Frente ??s ??guas Azuis Da Praia De Copacabana. Disponibiliza Um Spa Elegante E Uma Piscina No ??ltimo Piso, Ambos Com Vistas Mar Magn??ficas.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televis??o E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobili??rio Em Madeira, Uma Decora????o Contempor??nea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fant??sticas Para O Oceano.") ?>
            			
            				<span>...</span>
            		</span>
                	<span class="package-description-long">
						<?= nl2br("O Hilton Copacabana Rio De Janeiro, De 5 Estrelas, Est?? Idealmente Localizado Em Frente ??s ??guas Azuis Da Praia De Copacabana. Disponibiliza Um Spa Elegante E Uma Piscina No ??ltimo Piso, Ambos Com Vistas Mar Magn??ficas.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televis??o E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobili??rio Em Madeira, Uma Decora????o Contempor??nea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fant??sticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televis??o E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobili??rio Em Madeira, Uma Decora????o Contempor??nea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fant??sticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televis??o E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobili??rio Em Madeira, Uma Decora????o Contempor??nea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fant??sticas Para O Oceano.

            			O Hilton Copacabana Rio De Janeiro Possui Quartos Luminosos E Sofisticados Com Ar Condicionado, Uma Televis??o E Um Minibar. Todos Os Quartos Apresentam Um Estilo Elegante Com Mobili??rio Em Madeira, Uma Decora????o Contempor??nea E Acolhedores Tons Naturais. A Maioria Dos Quartos Oferece Vistas Fant??sticas Para O Oceano.") ?>                		
                	</span>
        		
            		<span class="package-more-description">ler mais</span>
            		<span class="package-less-description">ler menos</span>
            	</div>

                <div class="single-package-info-category-section" data-category="package-guaranties">
                    This is guarantee descripton!
                </div>

                <div class="single-package-info-category-section" data-category="package-cancellation">
                    This is cancel penalties descripton!
                </div>
            	
    			<div class="single-package-info-category-section" data-category="Servi??os Gerais">
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
    			<div class="single-package-info-category-section" data-category="Atra????es">
    				<div>Lorem</div>
    				<div>ipsum</div>
    				<div>dolor</div>
    				<div>consectetur</div>
    			</div>
            </div>
		</div>

        <form type="POST" action="" class="package-form">

            <div class="ob-searchbar-so obpress-hotel-searchbar-custom container" id="special-offer" data-hotel-folders="<?php echo htmlspecialchars(json_encode($hotelFolders), ENT_QUOTES, 'UTF-8'); ?>">
                <div class="ob-searchbar-so-hotel">
                    <p>
                    <?php
                        printf(
                            _n(
                                'Hotel',
                                'Destination or Hotel',
                                $counter_for_hotel,
                                'OBPress_SpecialOffersPage'
                            ),
                            number_format_i18n( $counter_for_hotel )
                        );                
                    ?>
                    </p>





                    <input type="text" value="" readonly placeholder="<?php if ( $data->getHotels()[$property]['HotelName'] ) {
                            echo $data->getHotels()[$property]['HotelName'];
                            } else {
                            _e('All Hotels', 'OBPress_SpecialOffersPage');
                            }  ?>" id="hotels-so" class="<?php if (!empty(get_option('hotel_id'))) {
                                                    echo 'single-hotel-so';
                                                } ?>" spellcheck="false" autocomplete="off">



                    <input type="hidden" name="c" id="chain_code-so" value="<?php echo get_option('chain_id') ?>">
                    <input type="hidden" name="q" id="hotel_code-so" value="<?php echo $data->getHotels()[$property]['HotelCode'] ?>">



                    <input type="hidden" name="currencyId" value="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                    <input type="hidden" name="lang" value="<?= (isset($_GET['lang'])) ? $_GET['lang'] : get_option('default_language_id') ?>">
                    <input type="hidden" name="hotel_folder" id="hotel_folder-so">
                    <input type="hidden" name="NRooms" id="NRooms-so" value="<?php echo $_GET['NRooms'] ?>">
                    <div class="hotels_dropdown-so">
                        <div class="obpress-mobile-close-hotels-dropdown-holder-so">
                            <span>Selecione destino ou hotel</span>
                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                        </div>
                        <div class="obpress-mobile-search-hotels-input-holder-so">
                            <input class="obpress-mobile-search-hotels-input" type="text" placeholder="Digite o nome ou cidade do hotel" id="search-hotels-input">
                        </div>
                    <!--  <div class="hotels_all custom-bg custom-text" data-id="0"><?php _e('All Hotels', 'OBPress_SpecialOffersPage'); ?></div> -->
                        <div class="hotels_folder custom-bg custom-text" hidden></div>
                        <div class="hotels_hotel custom-bg custom-text" data-id="" hidden></div>
                    </div>

                </div>
                <div class="ob-searchbar-calendar">
                    <p><?php _e('Dates of stay', 'OBPress_SpecialOffersPage'); ?></p>
                    <input class="calendarToggle" type="text" id="calendar_dates" value="<?php echo $CheckInShow ?? date("d/m/Y") ?> - <?php echo $CheckOutShow ?? date("d/m/Y", strtotime("+1 day")) ?>"  readonly>
                    <div class="ob-mobile-searchbar-calendar-holder">
                        <div class="ob-mobile-searchbar-calendar">
                            <p>Check-in</p>
                            <input class="calendarToggle" type="text" id="check_in_mobile" value="<?php echo $CheckInShowMobile ?? date("d M Y") ?>"  readonly>
                        </div>
                        <div class="ob-mobile-searchbar-calendar">
                            <p>Check-out</p>
                            <input class="calendarToggle" type="text" id="check_out_mobile" value="<?php echo $CheckOutShowMobile ?? date("d M Y", strtotime("+1 day")) ?>"  readonly>
                        </div>
                    </div>
                    <input class="calendarToggle" type="hidden" id="date_from" name="CheckIn" value="<?php echo $CheckIn ?? date("dmY") ?>">
                    <input class="calendarToggle" type="hidden" id="date_to" name="CheckOut" value="<?php echo $CheckOut ?? date("dmy", strtotime("+1 day")) ?>">            
                </div>
                <div class="ob-searchbar-guests">
                    <p><?php _e('Rooms and guests', 'OBPress_SpecialOffersPage'); ?></p>
                    <input type="text" id="guests" data-room="<?php _e('Room', 'OBPress_SpecialOffersPage'); ?>" data-rooms="<?php _e('Rooms', 'OBPress_SpecialOffersPage'); ?>" data-guest="<?php _e('Guest', 'OBPress_SpecialOffersPage'); ?>" data-guests="<?php _e('Guests', 'OBPress_SpecialOffersPage'); ?>" data-remove-room="<?php _e('Remove room', 'OBPress_SpecialOffersPage'); ?>" readonly>
                    <input type="hidden" id="ad" name="ad" value="<?= get_option('calendar_adults') ?>">
                    <input type="hidden" id="ch" name="ch" value="">
                    <input type="hidden" id="ag" name="ag" value="">

                    <div id="occupancy_dropdown" class="position-absolute custom-bg custom-text" data-default-currency="<?= (isset($_GET['currencyId'])) ? $_GET['currencyId'] : get_option('default_currency_id') ?>">
                        <div class="add-room-holder">
                            <p class="add-room-title select-room-title custom-text"><?php _e('NUMBER OF ROOMS', 'OBPress_SpecialOffersPage') ?></p>
                            <div class="select-room-buttons">
                                <button class="select-button select-button-minus select-room-minus" type="button" disabled>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    
                                </button>
                                <span class="select-value select-room-value">1</span>
                                <button class="select-button select-button-plus select-room-plus" type="button">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    
                                </button>
                            </div>
                        </div>
                        <div class="select-room-holder">
                            <div class="select-room" data-room-counter="0">
                                <p class="select-room-title custom-text"><?php _e('Room', 'OBPress_SpecialOffersPage');?> <span class="select-room-counter">1</span></p>

                                <div class="remove-room-mobile">Remover quarto</div>

                                <div class="select-guests-holder">
                                    <div class="select-adults-holder">
                                        <div class="select-adults-title">
                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/adults.svg" alt="">
                                            <?php _e('Adults', 'OBPress_SpecialOffersPage'); ?>
                                        </div>
                                        <div class="select-adults-buttons">
                                            <button class="select-button select-button-minus select-adult-minus" type="button" disabled>
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>

                                            </button>
                                            <span class="select-value select-adults-value">1</span>
                                            <button class="select-button select-button-plus select-adult-plus" type="button">

                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>

                                            </button>
                                        </div>
                                    </div>
                                    <div class="select-child-holder">
                                        <div class="select-child-title">
                                            <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/children.svg" alt="">
                                            <div>
                                                <span><?php _e('Children', 'OBPress_SpecialOffersPage') ?></span>
                                                <span class="select-child-title-max-age">
                                                    0 <?php 
                                                    _e('to the', 'OBPress_SpecialOffersPage') ; 
                                                    echo " " ; 
                                                    ?>
                                                    <span class='child-max-age'> <?php echo $childrenMaxAge ; ?> </span>
                                                </span> 
                                            </div>
                                        </div>
                                        <div class="select-child-buttons">
                                            <button class="select-button select-button-minus select-child-minus" type="button" disabled>
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>

                                            </button>
                                            <span class="select-value select-child-value">0</span>
                                            <button class="select-button select-button-plus select-child-plus" type="button">

                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                
                                            </button>
                                        </div>
                                    </div>
                                    <div class="select-child-ages-holder">
                                        <div class="select-child-ages-clone">


                                            <p class="select-child-ages-title custom-text"><?php _e('Age', 'OBPress_SpecialOffersPage'); ?> <span class="select-child-ages-number"></span></p>

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

                                            <p class="incorect-age custom-text"><?php _e('Incorrect Age', 'OBPress_SpecialOffersPage') ?></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="add-room-mobile">+ Adicionar outro quarto</div>
                                
                            </div>
                        </div>

                        <button class="btn-ic custom-action-bg custom-action-border custom-action-text select-occupancy-apply" type="button">
                                <?php _e('Apply', 'OBPress_SpecialOffersPage') ?>

                                <span class="select-occupancy-apply-info">
                                        <span class="select-occupancy-apply-info-rooms" data-rooms="1">1</span>
                                        <span class="select-occupancy-apply-info-rooms-string">Room</span>
                                        ,
                                        <span class="select-occupancy-apply-info-guests" data-guests="<?= get_option('calendar_adults') ?>"><?= get_option('calendar_adults') ?></span>
                                        <span class="select-occupancy-apply-info-guests-string">Guest</span>
                                </span>
                        </button>

                    </div>
                </div>



                    <div class="ob-searchbar-promo">
                        <p><?php _e('I have a code', 'OBPress_SpecialOffersPage'); ?></p>
                        <input type="text" id="promo_code" value="" placeholder="Escolha o tipo" readonly>
                        <div class="material-check custom-checkbox-holde ob-mobile-i-have-a-code">
                            <div class="mdc-touch-target-wrapper">
                                <div class="mdc-checkbox mdc-checkbox--touch">
                                    <input class="board_check mdc-checkbox__native-control checkbox-custom checkbox-custom ob-mobile-i-have-a-code-input" type="checkbox" name="1" id="i_have_a_code">
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                </div>
                            </div>
                            <label class="form-check-label" for="i_have_a_code">
                                <span class="checkbox-custom-label"><?php _e('I HAVE A CODE', 'OBPress_SpecialOffersPage'); ?></span>
                            </label>
                        </div>
                        <div id="promo_code_dropdown" class="position-absolute custom-bg custom-text">
                            <div class="mb-3 mt-2">
                                <p class="input-title"><?php _e('GROUP CODE', 'OBPress_SpecialOffersPage') ?></p>
                                <!-- <input type="text" id="group_code" name="group_code" placeholder="Digite seu c??digo"> -->
                                <div class="material-textfield">
                                    <input type="text" id="group_code" name="group_code" placeholder="Digite seu c??digo">
                                    <span class="label-title"><?php _e('GROUP CODE', 'OBPress_SpecialOffersPage') ?></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <p class="input-title"><?php _e('PROMO CODE', 'OBPress_SpecialOffersPage'); ?></p>
                                <!-- <input type="text" id="Code" name="Code" placeholder="Digite seu c??digo"> -->
                                <div class="material-textfield">
                                    <input type="text" id="Code" name="Code" placeholder="Digite seu c??digo">
                                    <span class="label-title"><?php _e('PROMO CODE', 'OBPress_SpecialOffersPage'); ?></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <p class="input-title"><?php _e('LOYALTY CODE', 'OBPress_SpecialOffersPage') ?></p>
                                <!-- <input type="text" id="loyalty_code" name="loyalty_code" placeholder="Digite seu c??digo"> -->
                                <div class="material-textfield">
                                    <input type="text" id="loyalty_code" name="loyalty_code" placeholder="Digite seu c??digo">
                                    <span class="label-title"><?php _e('LOYALTY CODE', 'OBPress_SpecialOffersPage') ?></span>
                                </div>
                            </div>

                            <div class="text-right">
                                <button id="promo_code_apply" class="custom-action-bg custom-action-text custom-action-border btn-ic"><?php _e('Apply', 'OBPress_SpecialOffersPage'); ?></button>
                            </div>
                        </div>
                    </div>
                    
        

                    <div class="ob-searchbar-button">
                        <button class="ob-searchbar-submit" type="button"><?php _e('Search', 'OBPress_SpecialOffersPage'); ?></button>
                    </div> 

            </div>
            <div class="zcalendar-wrap">

                <div class="ob-zcalendar-top">
                    <div class="ob-zcalendar-title">
                        <?php _e('Select date of stay', 'OBPress_SpecialOffersPage') ?>
                        <img src="<?= get_template_directory_uri() ?>/templates/assets/icons/cross_medium.svg" alt="">
                    </div>
                    <div class="ob-mobile-weekdays">
                        <div>
                            <span><?php _e('sun', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('mon', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('tue', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('wed', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('thu', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('fri', 'OBPress_SpecialOffersPage') ?></span>
                            <span><?php _e('sat', 'OBPress_SpecialOffersPage') ?></span>
                        </div>
                    </div>
                </div>
                <div class="zcalendar-holder" id="calendar-holder">
                    <div class="zcalendar data-allow-unavail="<?= get_option('allow_unavail_dates') ?> data-allow-unavail="<?= get_option('allow_unavail_dates') ?>" data-promotional="<?php _e('Offers for you', 'OBPress_SpecialOffersPage'); ?>" data-promo="<?php _e('Special Offer', 'OBPress_SpecialOffersPage'); ?>" data-lang="{{$lang->Code}}"  data-night="<?php _e('Night', 'OBPress_SpecialOffersPage') ?>" data-nights="<?php _e('Nights', 'OBPress_SpecialOffersPage') ?>" data-price-for="<?php _e('*Price for', 'OBPress_SpecialOffersPage') ?>" data-adult="<?php _e('adult', 'OBPress_SpecialOffersPage') ?>" data-adults="<?php _e('adults', 'OBPress_SpecialOffersPage') ?>" data-restriction="<?php _e('Restricted Days', 'OBPress_SpecialOffersPage') ?>" data-notavailable="<?php _e('index_no_availability_v4', 'OBPress_SpecialOffersPage') ?>" data-closedonarrival="<?php _e('calendar_closed_on_arrival', 'OBPress_SpecialOffersPage') ?>"  data-closedondeparture="<?php _e('calendar_closed_on_departure', 'OBPress_SpecialOffersPage') ?>" data-minimum-string="<?php _e('system_min', 'OBPress_SpecialOffersPage') ?>" data-maximum-string="<?php _e('system_max', 'OBPress_SpecialOffersPage') ?>" ></div>
                </div>
                
                <div class="ob-zcalendar-bottom">
                    <div> <span class='mobile-accept-dates-from-to'>Seg, 14 Nov - Sex, 18 Nov</span> <span class="number_of_nights-mobile-span"> ( <span class="number_of_nights-mobile"> 4 Noites</span> )</span> </div>
                    <div id="mobile-accept-date"> Aplicar </div>
                </div>
            </div>     

        </form>
        <p class="rooms-message-header">Quartos relacionados</p>
        <div class="obpress-package-rooms-basket">
            <div id="package-results">
                <div class="package_rooms">
                    <div class="single-package-room-container">

                        <div class="single-package-room roomrate">
                            <img class="single-package-room-img" src="<?= $plugin_directory_path . "/assets/images/package_image.webp" ?>">

                            <div class="single-package-room-rate-info roomrateinfo">
                                            

                                <div class="room-amenities">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Ac_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Telephone_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Safe_box_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Non_smoking_room_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Internet_access_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Wifi_room_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Mini_bar_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Fridge_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Bathroom_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Tv_v4.svg" ?>">
                                </div>
                                <div class="single-package-room-name">Superior Double</div>
                                <div class="single-package-room-icons">
                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/iconGreyDarkest_View_Lake.svg" ?>"> 
                                        <span class="single-package-room-icon-name">
                                            Vista: <span>Lake View</span>
                                        </span>
                                    </span>

                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugin_directory_path."/assets/icons/ocup-max.svg" ?>"> 
                                        <span class="single-package-room-icon-name">
                                        Ocup.max.:  <span>3 Pessoas</span>
                                        </span>
                                    </span>

                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugin_directory_path. "/assets/icons/area.svg" ?>">
                                        <span class="single-package-room-icon-name">
                                            ??rea: <span>301.4 ft2</span>
                                        </span>
                                    </span>
                                </div>
                                <p class="price-before">
                                    <del>
                                        <span class="currency_symbol_price">R$</span> 600.<span class="decimal_value_price">00</span>	
                                    </del>
                                </p>
                                <div class="single-package-room-price-and-button">
                                    <div class="single-package-room-price">
                                        <p class="price-after best-price">
                                            <span class="currency_symbol_price">R$</span> 460.<span class="decimal_value_price">00</span>										
                                        </p>
                                        <span class="single-package-tax-msg">Inclui impostos e taxas</span>
                                    </div>
                                        
                                    <div class="single-package-room-button">
                                        <div class="text-number-of-rooms">N?? de quartos</div>
                                        <div class="obpress-hotel-results-button-bottom">
                                            <button class="room-btn-add btn-ic custom-action-border custom-action-text custom-action-bg">Reservar agora</button>     
                                            <button href="#" class="room-btn-minus btn-ic custom-action-border custom-action-text custom-action-bg">-</button>
                                            <span class="room-btn-value custom-action-border-top custom-action-border-bottom">0</span>
                                            <button href="#" class="room-btn-plus btn-ic custom-action-border custom-action-text custom-action-bg">+</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-package-room-container">
                        <div class="single-package-room roomrate">
                            <img class="single-package-room-img" src="<?= $plugin_directory_path . "/assets/images/package_image.webp" ?>">
                            <div class="single-package-room-rate-info roomrateinfo">
                                <div class="room-amenities">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Ac_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Telephone_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Safe_box_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Non_smoking_room_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Internet_access_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Wifi_room_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Mini_bar_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Fridge_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Bathroom_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Tv_v4.svg" ?>">
                                </div>
                                <div class="single-package-room-name">Superior Double</div>
                                <div class="single-package-room-icons">
                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/iconGreyDarkest_View_Lake.svg" ?>"> 
                                        <span class="single-package-room-icon-name">
                                            Vista: <span>Lake View</span>
                                        </span>
                                    </span>
                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugin_directory_path."/assets/icons/ocup-max.svg" ?>"> 
                                        <span class="single-package-room-icon-name">
                                        Ocup.max.:  <span>3 Pessoas</span>
                                        </span>
                                    </span>
                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugin_directory_path. "/assets/icons/area.svg" ?>">
                                        <span class="single-package-room-icon-name">
                                            ??rea: <span>301.4 ft2</span>
                                        </span>
                                    </span>
                                </div>
                                <p class="price-before">
                                    <del>
                                        <span class="currency_symbol_price">R$</span> 600.<span class="decimal_value_price">00</span>	
                                    </del>
                                </p>
                                <div class="single-package-room-price-and-button">
                                    <div class="single-package-room-price">
                                        <p class="price-after">
                                            <span class="currency_symbol_price">R$</span> 480.<span class="decimal_value_price">00</span>										
                                        </p>
                                        <span class="single-package-tax-msg">Inclui impostos e taxas</span>
                                    </div>
                                    <div class="single-package-room-button">
                                        <div class="text-number-of-rooms" style="display: block;">N?? de quartos</div>
                                        <div class="obpress-hotel-results-button-bottom" style="pointer-events: none;">
                                            <!-- <button class="room-btn-add btn-ic custom-action-border custom-action-text custom-action-bg">Reservar agora</button>      -->
                                            <button href="#" class="room-btn-minus btn-ic custom-action-border custom-action-text custom-action-bg" style="display: flex;">-</button>
                                            <span class="room-btn-value custom-action-border-top custom-action-border-bottom" style="display: flex;">1</span>
                                            <button href="#" class="room-btn-plus btn-ic custom-action-border custom-action-text custom-action-bg" style="display: flex;">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-package-room-container">
                        <div class="single-package-room roomrate">
                            <img class="single-package-room-img" src="<?= $plugin_directory_path . "/assets/images/package_image.webp" ?>">

                            <div class="single-package-room-rate-info roomrateinfo">
                                        
                                <div class="room-amenities">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Ac_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Telephone_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Safe_box_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Non_smoking_room_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Internet_access_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Wifi_room_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Mini_bar_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Fridge_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Bathroom_v4.svg" ?>">
                                    <img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/Tv_v4.svg" ?>">
                                </div>
                                <div class="single-package-room-name">Master Suite</div>
                                <div class="single-package-room-icons">
                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/iconGreyDarkest_View_Lake.svg" ?>"> 
                                        <span class="single-package-room-icon-name">
                                            Vista: <span>Lake View</span>
                                        </span>
                                    </span>

                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugin_directory_path."/assets/icons/ocup-max.svg" ?>"> 
                                        <span class="single-package-room-icon-name">
                                        Ocup.max.:  <span>6 Pessoas</span>
                                        </span>
                                    </span>

                                    <span class="single-package-room-icons-type">
                                        <img class="single-package-room-icon" src="<?= $plugin_directory_path. "/assets/icons/area.svg" ?>">
                                        <span class="single-package-room-icon-name">
                                            ??rea: <span>914.9 ft2</span>
                                        </span>
                                    </span>
                                </div>
                                <p class="price-before">
                                    <del>
                                        <span class="currency_symbol_price">R$</span> 600.<span class="decimal_value_price">00</span>	
                                    </del>
                                </p>
                                <div class="single-package-room-price-and-button">
                                    <div class="single-package-room-price">
                                        <p class="price-after">
                                            <span class="currency_symbol_price">R$</span> 480.<span class="decimal_value_price">00</span>										
                                        </p>
                                        <span class="single-package-tax-msg">Inclui impostos e taxas</span>
                                    </div>

                                    <div class="single-package-room-button">
                                        <div class="restricted_text_holder">
                                            <div class="los_restricted red-text t-tip__in">
                                                <div class="restriction">
                                                    <span>- Stay a minimum of 3 nights</span>
                                                </div>
                                                <div class="restriction days-in-advance">
                                                    <span>- Book 2 nights in advance</span>
                                                </div>
                                            </div>
                                            <span class="restricted_modify_search">Change Search</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="error_message_holder">
                    <div class="error_message_left">
                        <img class="error_info_icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/information-button-white.svg" ?>">
                        <div class="error_message">
                            <div class="error_message_description">
                                <?php _e('There are no rooms available for the dates indicated.', 'OBPress_RoomPage') ?>
                            </div>
                        </div>
                    </div>
                    <button class="error_message_btn_calendar">
                        <?php _e('Change your search', 'OBPress_RoomPage') ?>
                    </button>
                </div>
            </div>
            <div class="obpress-hotel-results-basket-holder">
                <div class="obpress-hotel-results-basket <?php if(is_admin_bar_showing() == true){echo 'obpress-admin-bar-shown-basket';} ?>"  id="basket">
                    <div class="obpress-hotel-results-basket-info-holder">
                        <div class="obpress-hotel-results-basket-info">
                            <div class="obpress-hotel-stars-holder">
                                <div class="hotel-stars">
                                    <?php for ($i = 0; $i < 5; $i++) : ?>
                                        <?php if ($i < 3) : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23.001" height="21.231" viewBox="0 0 23.001 21.231" class="star-full">
                                                <defs>
                                                    <style>
                                                        .a {
                                                            fill: #ffc70e;
                                                        }
                                                    </style>
                                                </defs>
                                                <path class="a" d="M11.5,0l4.025,6.359L23,8.11,18.013,13.79l.595,7.441L11.5,18.383,4.393,21.232l.595-7.441L0,8.11l7.475-1.75Z" />
                                            </svg>
                                        <?php else : ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23.001" height="21.231" viewBox="0 0 23.001 21.231" class="star-lines">
                                                <defs>
                                                    <style>
                                                        .a {
                                                            fill: none;
                                                        }

                                                        .b,
                                                        .c {
                                                            stroke: none;
                                                        }

                                                        .c {
                                                            fill: #ffc70e;
                                                        }
                                                    </style>
                                                </defs>
                                                <g class="a">
                                                    <path class="b" d="M11.5,0l4.025,6.359L23,8.11,18.013,13.79l.595,7.441L11.5,18.383,4.393,21.232l.595-7.441L0,8.11l7.475-1.75Z" />
                                                    <path class="c" d="M 11.50043106079102 1.869796752929688 L 8.10150146484375 7.239782333374023 L 1.851781845092773 8.703174591064453 L 6.018121719360352 13.44847297668457 L 5.518131256103516 19.7032413482666 L 11.50043106079102 17.30573272705078 L 17.48273086547852 19.7032413482666 L 16.98274040222168 13.44847297668457 L 21.14908027648926 8.703174591064453 L 14.89936065673828 7.239782333374023 L 11.50043106079102 1.869796752929688 M 11.50043106079102 1.9073486328125e-06 L 15.52558135986328 6.359362602233887 L 23.0008602142334 8.109732627868652 L 18.01325988769531 13.79041290283203 L 18.60809135437012 21.23156356811523 L 11.50043106079102 18.38305282592773 L 4.392770767211914 21.23156356811523 L 4.987600326538086 13.79041290283203 L 1.9073486328125e-06 8.109732627868652 L 7.47528076171875 6.359362602233887 L 11.50043106079102 1.9073486328125e-06 Z" />
                                                </g>
                                            </svg>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div> 
                            <p class="obpress-hotel-basket-title">Windsor Florida Hotel</p>
                            <div class="obpress-hotel-basket-stay-info">
                                <div class="obpress-hotel-basket-stay-dates">
                                    <span class="obpress-hotel-basket-stay-checkin">
                                        <span class="obpress-hotel-basket-stay-checkin-string">Check-in</span>
                                        <span class="obpress-hotel-basket-stay-checkin-date"><?php  $CheckInBasket = date("d M", strtotime($CheckIn)); echo $CheckInBasket; ?></span>
                                    </span>
                                    <span class="obpress-hotel-searchbar-arrow">
                                        <svg class="arrow-right-dates_v4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <defs>
                                                <style>
                                                    .a {
                                                        fill: #fff;
                                                    }

                                                    .b,
                                                    .c {
                                                        fill: none;
                                                        stroke: #000000;
                                                        stroke-linecap: round;
                                                        stroke-width: 1.5px;
                                                    }

                                                    .b {
                                                        stroke-linejoin: round;
                                                    }
                                                </style>
                                            </defs>
                                            <g transform="translate(151 262) rotate(180)">
                                                <rect class="a" width="16" height="16" transform="translate(135 246)" />
                                                <g transform="translate(150 259) rotate(180)">
                                                    <path class="b" d="M4312.563,10990.207l4.563,4.828-4.562,4.172" transform="translate(-4304.125 -10990.207)" />
                                                    <path class="c" d="M4315.25,10994.979h-11" transform="translate(-4303.25 -10990.295)" />
                                                </g>
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="obpress-hotel-basket-stay-checkout">
                                        <span class="obpress-hotel-basket-stay-checkout-string">Check-out</span>
                                        <span class="obpress-hotel-basket-stay-checkout-date"><?php  $CheckOutBasket = date("d M", strtotime($CheckOut)); echo $CheckOutBasket; ?></span>                            
                                    </span>
                                </div>
                                <div class="obpress-hotel-basket-stay-room-info">
                                    <span class="obpress-hotel-basket-stay-rooms">
                                        <span class="obpress-hotel-basket-stay-rooms-string">Quartos</span>
                                        <span class="obpress-hotel-basket-stay-rooms-num"> 1 </span>
                                    </span>
                                    <span class="obpress-hotel-basket-stay-nights">
                                        <span class="obpress-hotel-basket-stay-nights-string">Noites</span>
                                        <span class="obpress-hotel-basket-stay-nights-num"> <?php echo $nights; ?> </span>                            
                                    </span>
                                    <span class="obpress-hotel-basket-stay-guests">
                                        <span class="obpress-hotel-basket-stay-guests-string">H??spedes</span>
                                        <span class="obpress-hotel-basket-stay-guests-num"> <?= (isset($_GET['ad'])) ? $_GET['ad'] : "1" ?> </span>                               
                                    </span>
                                </div>
                                <div class="obpress-hotel-searchbar-button-holder">
                                    <button class="obpress-hotel-searchbar-button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <svg class="obpress-hotel-searchbar-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><defs><style>.a{fill:#fff;opacity:0;}.b{fill:none;stroke:#273240;stroke-linecap:round;stroke-width:1.5px;}</style></defs><g transform="translate(12030 20724)"><rect class="a" width="24" height="24" transform="translate(-12030 -20724)"></rect><g transform="translate(-12026 -20720)"><circle class="b" cx="6.5" cy="6.5" r="6.5"></circle></g><line class="b" x2="5.5" y2="5" transform="translate(-12014 -20709.5)"></line></g></svg>
                                        Modificar
                                    </button>
                                </div>
                            </div>   
                        </div>
                        <div class="obpress-hotel-results-basket-cart">
                            <div class="obpress-hotel-results-item-holder">
                                <div class="obpress-hotel-results-item-top">
                                    <div class="basket-room-div" rate-id="291171" room-id="38692">
                                        <div class="obpress-hotel-results-item-title-price">
                                            <span class="obpress-hotel-results-item-title">SUPERIOR DOUBLE</span>
                                            <span class="obpress-hotel-results-total-room-selected">
                                                x
                                                <span class="obpress-hotel-results-total-room-counter">1</span>
                                            </span>
                                            <span class="obpress-hotel-results-item-price">
                                                <span class="obpress-hotel-results-item-curr">R$</span>
                                                <span class="obpress-hotel-results-item-value">600.00</span>
                                            </span>
                                        </div>
                                        <div class="obpress-hotel-results-item-promo-edit">
                                            <span class="obpress-hotel-results-item-promo">N??o Reembols??vel</span>
                                            <span class="obpress-hotel-results-item-edit" style="pointer-events: none;">Remover</span>
                                        </div>
                                        <div class="obpress-hotel-results-discount-holder">
                                            <div class="obpress-hotel-results-discount-message">Discount <span class="obpress-hotel-results-discount-percent"></span></div>
                                            <div class="obpress-hotel-results-discount-total">
                                                <span class="obpress-hotel-results-discount-currency">-R$</span>    
                                                <span class="obpress-hotel-results-discount-price">120.00</span>
                                            </div>
                                        </div>
                                        <div class="obpress-hotel-results-tax-holder">
                                            <p class="obpress-hotel-results-tax-title">
                                                Taxas
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14.545" height="14.545" viewBox="0 0 20.545 20.545"><path d="M12.245,18.409H14.3V12.245H12.245ZM13.272,3A10.272,10.272,0,1,0,23.545,13.272,10.276,10.276,0,0,0,13.272,3Zm0,18.49a8.218,8.218,0,1,1,8.218-8.218A8.229,8.229,0,0,1,13.272,21.49Zm-1.027-11.3H14.3V8.136H12.245Z" transform="translate(-3 -3)"></path></svg>
                                            </p>
                                            <div class="obpress-hotel-results-tax-bottom">
                                                <div class="obpress-hotel-results-tax-message">Taxas de Servi??o e ISS</div>
                                                <div class="obpress-hotel-results-tax-total">
                                                    <span class="obpress-hotel-results-tax-currency">R$</span>
                                                    <span class="obpress-hotel-results-tax-price">86.78</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="obpress-hotel-results-basket-price">
                        <div class="obpress-hotel-total-price-holder">
                            <span class="obpress-hotel-total-price-string">Total</span>
                            <span class="obpress-hotel-total-price">
                                <span class="font-weight-regular obpress-hotel-total-price-currency">R$</span> 
                                <span class="obpress-hotel-total-price-value">566,78</span>
                            </span>
                            <?php if(isset($hotel['MaxPartialPaymentParcel'])) : ?>
                                <!-- <span class="obpress-hotel-results-pay-up-to">Pay up to <?= $hotel['MaxPartialPaymentParcel']; ?>x</span> -->
                            <?php endif; ?>
                        </div>
                        <button class="obpress-hotel-submit" id="basket-send" type="button">Proximo Passo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php endif; ?>


<div class="next-step-loader-next-page">
    <div class="gooey">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="search-loading-message">
        <?php _e("Please wait...", 'OBPressTheme') ?>
    </div>
</div>

<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
</script>