<?php
	$RatePlanID = $promotion_id;
	$roomtypes = $data->getAllRoomTypes();
	$canidates = $data->getAllRoomStayCandidates();
	$prices_filter = $data->getPricesInfo($style, $promotion_id);
	$availableRooms =  count( $prices_filter['prices'] );
?>

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

			//var_dump($AllRoomRates);

			//var_dump($AllRoomRates["34058"]->Total->AmountBeforeTax);

			$AllRoomsEmpty = false;

			$first_roomrate = true;

			$today = new \DateTime('now');
			$CheckInPolicy = \DateTime::createFromFormat('d.m.Y', $CheckIn);
		?>

		<?php if ($data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ["AvailableForSale"]) !== null): ?>
			<?php foreach ($data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ["AvailableForSale"]) as $key => $roomrate): ?>
				<?php foreach($roomtypes as $roomtype): ?>
					<?php if($roomrate->RoomID == $roomtype->RoomID): ?>
						<?php 
							if ($descriptive_info->getAmenitiesByRoomV4($roomtype->RoomID) !== null) {
								$room_amenities = $descriptive_info->getAmenitiesByRoomV4($roomtype->RoomID);
							}
							else {
								$room_amenities = [];
							}
						?>

						<div class="single-package-room-container">

							<div class="single-package-room roomrate">
							<img class="single-package-room-img" src="<?= @$descriptive_info->getImagesForRoom($roomtype->RoomID)[0] ?>">

							<div class="single-package-room-rate-info roomrateinfo" 
							data-price="<?php echo $roomrate->Total->AmountBeforeTax; ?>" 
							data-quantity="0" 
							data-max-quantity="<?php echo $roomtype->MaxOccupancy; ?>" 
							data-nights="1" 
							data-discount="<?= isset($roomrate->Total->TPA_Extensions->TotalDiscountValue) ? $roomrate->Total->TPA_Extensions->TotalDiscountValue : "" ?>"  
                            data-price-before-discount="<?= isset($roomrate->Total->TPA_Extensions->TotalDiscountValue) ? (@$roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax)/$nights : "" ?>" 
                            data-tax-policy-name="Taxas de Servi??o e ISS" 
                            data-total-price-after-tax="<?php echo $roomrate->Total->AmountAfterTax; ?>"
                            data-children-ages="" 
                            data-rate-id="<?= $roomrate->RatePlanID ?>"
                            data-room-id="<?php echo $roomtype->RoomID; ?>"
                            data-currency-symbol="<?= $currencies[0]->CurrencySymbol ?>" 
                            data-rph="<?= $roomrate->RoomStayCandidateRPH ?>" 
                            data-start="<?= $roomrate->EffectiveDate ?>" 
                            data-end="<?= $roomrate->ExpireDate ?>" 


                            data-name="<?= $roomtype->RoomName ?>"
                            data-rate-name="<?= $rate_plan->RatePlanName ?>"
                            data-adults="<?= $adults?>" 
                            data-children="<?= $children?>" 
                            data-children-ages="<?= $children_ages?>"


                            data-policy="<?php if($rate_plan->CancelPenalties != null): ?>
                                                    <?php foreach($rate_plan->CancelPenalties as $cancellation): ?>
                                                        <?php if($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount == 0 && $cancellation->AmountPercent->Percent == 0 && $cancellation->AmountPercent->NmbrOfNights == 0)): ?>
                                                            <?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
                                                                Cancelamento Gr??tis
                                                            <?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d < $cancellation->DeadLine->OffsetUnitMultiplier): ?>
                                                                N??o Reembols??vel
                                                            <?php else: ?>
                                                                Cancelamento Gr??tis
                                                            <?php endif; ?>
                                                        <?php elseif($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount != 0 || $cancellation->AmountPercent->Percent != 0 || $cancellation->AmountPercent->NmbrOfNights != 0)): ?>
                                                            <?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
                                                                Permite Cancelamento    
                                                            <?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d <= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
                                                                N??o Reembols??vel
                                                            <?php else: ?>
                                                                Permite Cancelamento
                                                            <?php endif; ?>
                                                        <?php elseif($cancellation->NonRefundable == true): ?>
                                                            N??o Reembols??vel
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
										">
                                            
								<?php if(!empty($room_amenities)): ?>
									<div class="room-amenities">
										<?php foreach($room_amenities as $room_amenity): ?>
											<?php if($room_amenity->Image != null): ?>
												<img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/".$room_amenity->Image ?>">
											<?php endif; ?>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
								<div class="single-package-room-name">
									<?= substr($roomtype->RoomName, 0, 20) ?>
									<?php if(strlen($roomtype->RoomName) > 20): ?>
										...
									<?php endif; ?>
								</div>
								<div class="single-package-room-icons">

									<?php if(isset($descriptive_info->getRoomsViewTypes()[$property][$roomtype->RoomID])): ?>
										<?php foreach($descriptive_info->getRoomsViewTypes()[$property][$roomtype->RoomID] as $room_view): ?>
											<span class="single-package-room-icons-type">
												<img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/".$room_view->URL ?>"> 
												<span class="single-package-room-icon-name">
													<?php _e('View', 'OBPress_SpecialOffersPage') ?>: <span><?= $room_view->RoomAmenity ?></span>
												</span>
											</span>
										<?php endforeach; ?>
									<?php endif; ?>

									<?php if(isset($descriptive_info->getRoomsBedTypes()[$property][$roomtype->RoomID])): ?>
										<?php foreach($descriptive_info->getRoomsBedTypes()[$property][$roomtype->RoomID] as $room_bed): ?>
											<span class="single-package-room-icons-type">
												<img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/".$room_bed->URL ?>"> 
												<span class="single-package-room-icon-name">
													<?php _e('Bed type', 'OBPress_SpecialOffersPage') ?>: <span><?= $room_bed->RoomAmenity ?></span>
												</span>
											</span>
										<?php endforeach; ?>
									<?php endif; ?>

									<?php if(isset($roomtype->MaxOccupancy)): ?>
										<span class="single-package-room-icons-type">
											<img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/ocup-max.svg" ?>"> 
											<span class="single-package-room-icon-name">
												<?php _e('Ocup.max', 'OBPress_SpecialOffersPage') ?>:  <span><?= $roomtype->MaxOccupancy ?> <?php _e('People', 'OBPress_SpecialOffersPage') ?></span>
											</span>
										</span>
									<?php endif; ?>
									
									<?php if($descriptive_info->getRoomArea($property, $roomtype->RoomID, $language) != null): ?>
										<span class="single-package-room-icons-type">
											<img class="single-package-room-icon" src="<?= $plugins_directory. "/OBPress_SpecialOffersPage/widget/assets/icons/area.svg" ?>">
											<span class="single-package-room-icon-name">
												<?php _e('Area', 'OBPress_SpecialOffersPage') ?>: <span><?= $descriptive_info->getRoomArea($property, $roomtype->RoomID, $language) ?></span>
											</span>
										</span>
									<?php endif; ?>
								</div>
								<?php if(isset($roomrate->Total->TPA_Extensions->TotalDiscountValue)): ?>
									<p class="price-before">
										<del>
											<?= Lang_Curr_Functions::ValueAndCurrencyCultureV4($roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
										</del>
									</p>
								<?php endif; ?>
								<div class="single-package-room-price-and-button">
									<div class="single-package-room-price">
										<p class="price-after <?php if($first_roomrate == true) echo 'best-price'; ?>">
											<?= Lang_Curr_Functions::ValueAndCurrencyCultureV4(@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
										</p>
										<span class="single-package-tax-msg"><?php _e('Includes taxes and fees', 'OBPress_SpecialOffersPage') ?></span>
										<?php 
											if($first_roomrate == true) {
												$first_roomrate = false;
											}
										?>
									</div>

									<div class="single-package-room-button">
										<div class="text-number-of-rooms"><?php _e('N?? of rooms', 'OBPress_SpecialOffersPage') ?></div>
										<div class="obpress-hotel-results-button-bottom">
											<button class="room-btn-add btn-ic custom-action-border custom-action-text custom-action-bg"><?php _e('Book now', 'OBPress_SpecialOffersPage') ?></button>     
											<button href="#" class="room-btn-minus btn-ic custom-action-border custom-action-text custom-action-bg">-</button><span class="room-btn-value custom-action-border-top custom-action-border-bottom">0</span><button href="#" class="room-btn-plus btn-ic custom-action-border custom-action-text custom-action-bg">+</button>
										</div>
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

		
		<?php if ($data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ["LOS_Restricted"]) !== null): ?>
			<?php foreach ($data->getRoomRatesByRoomAvailabilityWithRateId($property, $RatePlanID, ["LOS_Restricted"]) as $key => $roomrate): ?>
				<?php foreach($roomtypes as $roomtype): ?>
					<?php if($roomrate->RoomID == $roomtype->RoomID): ?>
						<?php 
							if ($descriptive_info->getAmenitiesByRoomV4($roomtype->RoomID) !== null) {
								$room_amenities = $descriptive_info->getAmenitiesByRoomV4($roomtype->RoomID);
							}
							else {
								$room_amenities = [];
							}
						?>

						<div class="single-package-room-container">

							<div class="single-package-room roomrate">
							<img class="single-package-room-img" src="<?= @$descriptive_info->getImagesForRoom($roomtype->RoomID)[0] ?>">

							<div class="single-package-room-rate-info roomrateinfo" 
							data-price="<?php echo $roomrate->Total->AmountBeforeTax; ?>" 
							data-quantity="0" 
							data-max-quantity="<?php echo $roomtype->MaxOccupancy; ?>" 
							data-nights="1" 
							data-discount="<?= isset($roomrate->Total->TPA_Extensions->TotalDiscountValue) ? $roomrate->Total->TPA_Extensions->TotalDiscountValue : "" ?>"  
                            data-price-before-discount="<?= isset($roomrate->Total->TPA_Extensions->TotalDiscountValue) ? (@$roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax)/$nights : "" ?>" 
                            data-tax-policy-name="Taxas de Servi??o e ISS" 
                            data-total-price-after-tax="<?php echo $roomrate->Total->AmountAfterTax; ?>"
                            data-children-ages="" data-rate-id="<?= $roomrate->RatePlanID ?>"
                            data-room-id="<?php echo $roomtype->RoomID; ?>"
                            data-currency-symbol="<?= $currencies[0]->CurrencySymbol ?>"  
                            data-name="<?= $roomtype->RoomName ?>"
                            data-rate-name="<?= $rate_plan->RatePlanName ?>"
                            data-adults="<?= $adults?>" 
                            data-children="<?= $children?>" 
                            data-children-ages="<?= $children_ages?>"
                            data-rph="<?= $roomrate->RoomStayCandidateRPH ?>" 
                            data-policy="<?php if($rate_plan->CancelPenalties != null): ?>
                                                    <?php foreach($rate_plan->CancelPenalties as $cancellation): ?>
                                                        <?php if($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount == 0 && $cancellation->AmountPercent->Percent == 0 && $cancellation->AmountPercent->NmbrOfNights == 0)): ?>
                                                            <?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
                                                                Cancelamento Gr??tis
                                                            <?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d < $cancellation->DeadLine->OffsetUnitMultiplier): ?>
                                                                N??o Reembols??vel
                                                            <?php else: ?>
                                                                Cancelamento Gr??tis
                                                            <?php endif; ?>
                                                        <?php elseif($cancellation->NonRefundable == false && ($cancellation->AmountPercent->Amount != 0 || $cancellation->AmountPercent->Percent != 0 || $cancellation->AmountPercent->NmbrOfNights != 0)): ?>
                                                            <?php if($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d >= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
                                                                Permite Cancelamento    
                                                            <?php elseif($cancellation->DeadLine != null && $today->diff($CheckInPolicy)->d <= $cancellation->DeadLine->OffsetUnitMultiplier): ?>
                                                                N??o Reembols??vel
                                                            <?php else: ?>
                                                                Permite Cancelamento
                                                            <?php endif; ?>
                                                        <?php elseif($cancellation->NonRefundable == true): ?>
                                                            N??o Reembols??vel
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
										">
                                            
								<?php if(!empty($room_amenities)): ?>
									<div class="room-amenities">
										<?php foreach($room_amenities as $room_amenity): ?>
											<?php if($room_amenity->Image != null): ?>
												<img class="room-amenity" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/".$room_amenity->Image ?>">
											<?php endif; ?>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
								<div class="single-package-room-name">
									<?= substr($roomtype->RoomName, 0, 20) ?>
									<?php if(strlen($roomtype->RoomName) > 20): ?>
										...
									<?php endif; ?>
								</div>
								<div class="single-package-room-icons">

								<?php if(isset($descriptive_info->getRoomsViewTypes()[$property][$roomtype->RoomID])): ?>
									<?php foreach($descriptive_info->getRoomsViewTypes()[$property][$roomtype->RoomID] as $room_view): ?>
											<span class="single-package-room-icons-type">
												<img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/".$room_view->URL ?>"> 
												<span class="single-package-room-icon-name">
													<?php _e('View', 'OBPress_SpecialOffersPage') ?>: <span><?= $room_view->RoomAmenity ?></span>
												</span>
											</span>
										<?php endforeach; ?>
									<?php endif; ?>

									<?php if(isset($descriptive_info->getRoomsBedTypes()[$property][$roomtype->RoomID])): ?>
										<?php foreach($descriptive_info->getRoomsBedTypes()[$property][$roomtype->RoomID] as $room_bed): ?>
											<span class="single-package-room-icons-type">
												<img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/".$room_bed->URL ?>"> 
												<span class="single-package-room-icon-name">
												<?php _e('Bed type', 'OBPress_SpecialOffersPage') ?>: <span><?= $room_bed->RoomAmenity ?></span>
												</span>
											</span>
										<?php endforeach; ?>
									<?php endif; ?>

									<?php if(isset($roomtype->MaxOccupancy)): ?>
										<span class="single-package-room-icons-type">
											<img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/ocup-max.svg" ?>"> 
											<span class="single-package-room-icon-name">
											<?php _e('Ocup.max.', 'OBPress_SpecialOffersPage') ?>:  <span><?= $roomtype->MaxOccupancy ?> <?php _e('People', 'OBPress_SpecialOffersPage') ?></span>
											</span>
										</span>
									<?php endif; ?>
									
									<?php if($descriptive_info->getRoomArea($property, $roomtype->RoomID, $language) != null): ?>
										<span class="single-package-room-icons-type">
											<img class="single-package-room-icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/area.svg" ?>">
											<span class="single-package-room-icon-name">
												<?php _e('Area', 'OBPress_SpecialOffersPage') ?>: <span><?= $descriptive_info->getRoomArea($property, $roomtype->RoomID, $language) ?></span>
											</span>
										</span>
									<?php endif; ?>
								</div>
								<?php if(isset($roomrate->Total->TPA_Extensions->TotalDiscountValue)): ?>
									<p class="price-before">
										<del>
											<?= Lang_Curr_Functions::ValueAndCurrencyCultureV4($roomrate->Total->TPA_Extensions->TotalDiscountValue+@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
										</del>
									</p>
								<?php endif; ?>
								<div class="single-package-room-price-and-button">
									<div class="single-package-room-price">
										<p class="price-after <?php if($first_roomrate == true) echo 'best-price'; ?>">
											<?= Lang_Curr_Functions::ValueAndCurrencyCultureV4(@$roomrate->Total->AmountBeforeTax, $currencies, $currency, $language) ?>
										</p>
										<span class="single-package-tax-msg"><?php _e('Includes taxes and fees', 'OBPress_SpecialOffersPage') ?></span>
										<?php 
											if($first_roomrate == true) {
												$first_roomrate = false;
											}
										?>
									</div>

									<div class="single-package-room-button">
										<?php require(WP_PLUGIN_DIR . '/OBPress_SpecialOffersPage/widget/assets/templates/restrictions.php'); ?>
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
				<img class="error_info_icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/information-button-white.svg" ?>">
				<div class="error_message">
					<div class="error_message_description">
						<?php _e('There are no rooms available for the dates indicated.', 'OBPress_SpecialOffersPage') ?>
					</div>
				</div>
			</div>
			<button class="error_message_btn_calendar">
				<?php _e('Change your search', 'OBPress_SpecialOffersPage') ?>
			</button>
		</div>

	<!-- 4. Hotel with no room available for the selected occupancy -->
	<?php elseif(@$unavail_room_rate->Availability[0]->WarningRPH == 397 || @$unavail_room_rate->Availability[0]->WarningRPH == 138 || @$unavail_room_rate->Availability[0]->WarningRPH == 142): ?>
		<div class="error_message_holder">
			<div class="error_message_left">
				<img class="error_info_icon" src="<?= $plugins_directory."/OBPress_SpecialOffersPage/widget/assets/icons/information-button-white.svg" ?>">
				<div class="error_message">
					<div class="error_message_description">
					<?php _e('There are no rooms available for the dates indicated.', 'OBPress_SpecialOffersPage') ?>
					</div>
				</div>
			</div>
			<button class="error_message_btn_occupancy">
				<?php _e('Change your search', 'OBPress_SpecialOffersPage') ?>
			</button>
		</div>
	<?php endif; ?>

<?php endif; ?>

</div>