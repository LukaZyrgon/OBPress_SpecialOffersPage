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

<div class="package_rooms"> 

	<?php foreach($canidates as $canidate): ?>
	    <?php
	        $adults = 0;
	        $children = 0;
	        $children_ages = "";
	        $counter = 0;
	    ?>

	    <?php
	    foreach($canidate->GuestCountsType->GuestCounts as $GuestCount) {
	        if($GuestCount->AgeQualifyCode == 10) {
	            $adults = $GuestCount->Count;
	        }
	        elseif($GuestCount->AgeQualifyCode == 8) {
                $children++;
                $children_ages.=$GuestCount->Age;
                $children_ages.=";";
	        }
	    }
	    ?>

		<?php if(isset($roomtypes) && $data->get()->RoomStaysType != null ): ?>
			<?php
				$AllRoomRates = [];
				$AllRoomRatesCopy = [];
				$AllRoomRatesAvailableForSale = [];
				$AllRoomRatesLOS_Restricted = [];

				if($data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ['AvailableForSale']) != null) {
					$AllRoomRatesAvailableForSale = $data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ['AvailableForSale']);
				}
				if ($data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ['LOS_Restricted']) !== null) {
					$AllRoomRatesLOS_Restricted = $data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ['LOS_Restricted']);
				}

				$AllRoomRates = array_merge($AllRoomRatesAvailableForSale, $AllRoomRatesLOS_Restricted);
				foreach($AllRoomRates as $RoomRate) {
					$AllRoomRatesCopy[$RoomRate->RoomID] = $RoomRate;
				}
				$AllRoomRates = [];
				$AllRoomRates = $AllRoomRatesCopy;

				$AllRoomsEmpty = false;
			?>

			<?php if ($data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ["AvailableForSale"]) !== null): ?>
	            <?php foreach ($data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ["AvailableForSale"]) as $roomrate): ?>
	            	<?php foreach($roomtypes as $roomtype): ?>
	            		<?php if($roomrate->RoomID == $roomtype->RoomID): ?>
	            			<?php 
		            			if ($descriptive_info->getAmenitiesByRoom($roomtype->RoomID) !== null) {
					                $room_amenities = $descriptive_info->getAmenitiesByRoom($roomtype->RoomID);
					            }
					            else {
					                $room_amenities = [];
					            }
				            ?>
					        <div class="single-package-room">
					        	<img class="single-package-room-img" src="<?= @$descriptive_info->getImagesForRoom($roomtype->RoomID)[0] ?>">
					        	<div class="single-package-room-rate-info">
					        		<div class="single-package-room-name">
					        			<?= substr($roomtype->RoomName, 0, 22) ?>
					        			<?php if(strlen($roomtype->RoomName) > 22): ?>
					        				...
					        			<?php endif; ?>
					        		</div>
					        		<div class="single-package-room-icons">
				                        <?php if(isset($descriptive_info->getRoomsViewTypes()[$property][$roomtype->RoomID]) && isset($descriptive_info->getRoomsViewTypes()[$property][$roomtype->RoomID][0]->URL)): ?>
				                            <span class="single-package-room-icons-type">
				                                <img class="single-package-room-icon" src="<?= $plugins_directory."/obpress_plugin_manager/assets/view_icons/".$descriptive_info->getRoomsViewTypes()[$property][$roomtype->RoomID][0]->URL ?>"> 
				                                <span class="single-package-room-icon-name">
				                                    Vista: <span><?= $descriptive_info->getRoomsViewTypes()[$property][$roomtype->RoomID][0]->RoomAmenity ?></span>
				                                </span>
				                            </span>
				                        <?php endif; ?>

				                        <?php if(isset($roomtype->MaxOccupancy)): ?>
				                        	<span class="single-package-room-icons-type">
				                                <img class="single-package-room-icon" src="<?= $plugin_directory_path."/assets/icons/ocup-max.svg" ?>"> 
				                                <span class="single-package-room-icon-name">
				                                   Ocup.max.:  <span><?= $roomtype->MaxOccupancy ?> Pessoas</span>
				                                </span>
				                            </span>
				                        <?php endif; ?>
				                        
				                        <?php if($descriptive_info->getRoomArea($property, $roomtype->RoomID, $language) != null): ?>
				                            <span class="single-package-room-icons-type">
				                                <img class="single-package-room-icon" src="<?= $plugin_directory_path. "/assets/icons/area.svg" ?>">
				                                <span class="single-package-room-icon-name">
				                                    Área: <span><?= $descriptive_info->getRoomArea($property, $roomtype->RoomID, $language) ?></span>
				                                </span>
				                            </span>
				                        <?php endif; ?>
				                    </div>
				                    <div class="single-package-room-price-and-button">
				                    	<div class="single-package-room-price">
											<?php if(isset($roomrate->Total->TPA_Extensions->TotalDiscountValue)): ?>
	                                            <p class="price-before">
	                                                <del>
	                                                    <?= Lang_Curr_Functions::ValueAndCurrencyCultureV4($roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
	                                                </del>
	                                            </p>
	                                            <p class="price-after">
	                                                <?= Lang_Curr_Functions::ValueAndCurrencyCultureV4(@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
	                                            </p>
	                                        <?php elseif(!isset($roomrate->Total->TPA_Extensions->TotalDiscountValue)): ?>
		                                        <p class="price-after">
		                                            <?= Lang_Curr_Functions::ValueAndCurrencyCultureV4(@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
		                                        </p>
	                                        <?php endif; ?>
	                                        <span class="single-package-tax-msg">Inclui impostos e taxas</span>
	                                    </div>

                                        <div class="single-package-room-button">
	                                        <div class="text-number-of-rooms">Nº de quartos</div>
	                                        <div class="button-div-holder">
	                                            <button class="room-btn-add btn-ic custom-action-border custom-action-text custom-action-bg">Reservar agora</button>     
	                                            <button href="#" class="room-btn-minus btn-ic custom-action-border custom-action-text custom-action-bg">-</button><span class="room-btn-value custom-action-border-top custom-action-border-bottom">0</span><button href="#" class="room-btn-plus btn-ic custom-action-border custom-action-text custom-action-bg">+</button>
	                                        </div>
	                                    </div>

				                    </div>
					        	</div>
					        </div>
					        <?php break; ?>
					    <?php endif; ?>
				    <?php endforeach; ?>
			    <?php endforeach; ?>
			<?php endif; ?>



			



		<?php endif; ?>
	<?php endforeach; ?>


	<?php if($availableRooms == 0): ?>

	   	<?php
	        $all_room_rates = $data->getHotelsRoomRates2($property, $style);
	        if($all_room_rates != null) {

	            foreach($all_room_rates as $roomrate) {
	            	if($roomrate->RatePlanID == $RatePlanID) {
	            		$unavail_room_rate = $roomrate;
	            		break;
	            	}
	            }
	            if(!isset($unavail_room_rate)) {
	            	$unavail_room_rate = null;
	            }
	        }
	        else {
	            $unavail_room_rate = null;
	        }
	    ?>

	    <!-- Rates without prices set for a certain period of time - Hotel -->
	    <?php if(@$unavail_room_rate->Availability[0]->WarningRPH == 407 || $unavail_room_rate == null): ?>
			<div class="error_message_holder">
				<div class="error_message_left">
					<img class="error_info_icon" src="{{url('icons/icons_White/iconWhite_Information.svg')}}">
					<div class="error_message">
						<div class="error_message_description">
							Não existem quartos disponíveis para as datas indicadas.
						</div>
					</div>
				</div>
				<button class="error_message_btn_calendar">
					Altere a sua pesquisa
				</button>
			</div>

	    <!-- 4. Hotel with no room available for the selected occupancy -->
	    <?php elseif(@$unavail_room_rate->Availability[0]->WarningRPH == 397 || @$unavail_room_rate->Availability[0]->WarningRPH == 138 || @$unavail_room_rate->Availability[0]->WarningRPH == 142): ?>
			<div class="error_message_holder">
				<div class="error_message_left">
					<img class="error_info_icon" src="{{url('icons/icons_White/iconWhite_Information.svg')}}">
					<div class="error_message">
						<div class="error_message_description">
							Não existem quartos disponíveis para a ocupação indicada.
						</div>
					</div>
				</div>
				<button class="error_message_btn_occupancy">
					Altere a sua pesquisa
				</button>
			</div>
	    <?php endif; ?>

	<?php endif; ?>

</div>