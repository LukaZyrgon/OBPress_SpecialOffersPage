<div class="obpress-hotel-results-basket-holder">

        <div class="obpress-hotel-results-basket <?php if(is_admin_bar_showing() == true){echo 'obpress-admin-bar-shown-basket';} ?>"  id="basket">
            <div class="obpress-hotel-results-basket-info-holder">
                <div class="obpress-hotel-results-basket-info">
                    <div class="obpress-hotel-stars-holder">
                        <div class="hotel-stars">
								<?php for ($i = 0; $i < 5; $i++) : ?>
									<?php if ($i < $hotel_search->PropertiesType->Properties[0]->Award->Rating) : ?>
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
                        <!-- <span class="obpress-hotel-edit-search" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</span> -->
                    </div> 
                    <p class="obpress-hotel-basket-title">
                        <?= $hotel_search->PropertiesType->Properties[0]->HotelRef->HotelName ?>
                    </p>
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
                                <span class="obpress-hotel-basket-stay-guests-string">Hóspedes</span>
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


                        </div>

    <!--                     <div class="obpress-hotel-results-item-discount">
                            <span class="obpress-hotel-results-item-discount-string">
                                Desconto 10%
                            </span>
                            <span class="obpress-hotel-results-item-discount-price">
                                - <span class="font-weight-regular">R$</span> 100,00
                            </span>
                        </div>

                        <div class="obpress-hotel-results-item-taxes">
                            <p class="obpress-hotel-results-item-taxes-title">
                                Taxas
                            </p>
                            <div class="obpress-hotel-results-item-taxes-type">
                                <span class="obpress-hotel-results-item-tax-type">Imposto ISS</span>
                                <span class="obpress-hotel-results-item-tax-val"><span class="font-weight-regular">R$</span> 220,00</span>
                            </div>
                        </div>
    -->
                    </div>
                </div>
            </div>


            <div class="obpress-hotel-results-basket-price">
                <div class="obpress-hotel-total-price-holder">
                    <span class="obpress-hotel-total-price-string">Total</span>
                    <span class="obpress-hotel-total-price">
                    	<span class="font-weight-regular obpress-hotel-total-price-currency">R$</span> 
                    	<span class="obpress-hotel-total-price-value">0,00</span>
                    </span>
                    <?php if(isset($hotel['MaxPartialPaymentParcel'])) : ?>
                        <!-- <span class="obpress-hotel-results-pay-up-to">Pay up to <?= $hotel['MaxPartialPaymentParcel']; ?>x</span> -->
                    <?php endif; ?>
                </div>
                <button class="obpress-hotel-submit" id="basket-send" type="button" disabled>Proximo Passo</button>
            </div>


        </div>
</div> 




<!-- Div for cloning -->
<div class="basket-room-div-clone">
	<div class="basket-room-div">

	    <div class="obpress-hotel-results-item-title-price">
	        <span class="obpress-hotel-results-item-title">
	            
	        </span>
            <span class="obpress-hotel-results-total-room-selected">
                x
                <span class="obpress-hotel-results-total-room-counter">1</span>
            </span>
	        <span class="obpress-hotel-results-item-price">
	            <span class="obpress-hotel-results-item-curr"></span>
	            <span class="obpress-hotel-results-item-value"></span>
	        </span>
	    </div>

	    <div class="obpress-hotel-results-item-promo-edit">
	        <span class="obpress-hotel-results-item-promo"></span>
	        <span class="obpress-hotel-results-item-edit">Remover</span>
	    </div>
        
        <div class="obpress-hotel-results-discount-holder">
            <div class="obpress-hotel-results-discount-message">Discount <span class="obpress-hotel-results-discount-percent"></span></div>
            <div class="obpress-hotel-results-discount-total">
                <span class="obpress-hotel-results-discount-currency">-R$</span>    
                <span class="obpress-hotel-results-discount-price">123</span>
            </div>
        </div>

        <div class="obpress-hotel-results-tax-holder">
            <p class="obpress-hotel-results-tax-title">
                Taxas
                <svg xmlns="http://www.w3.org/2000/svg" width="14.545" height="14.545" viewBox="0 0 20.545 20.545"><path d="M12.245,18.409H14.3V12.245H12.245ZM13.272,3A10.272,10.272,0,1,0,23.545,13.272,10.276,10.276,0,0,0,13.272,3Zm0,18.49a8.218,8.218,0,1,1,8.218-8.218A8.229,8.229,0,0,1,13.272,21.49Zm-1.027-11.3H14.3V8.136H12.245Z" transform="translate(-3 -3)"/></svg>
            </p>
            <div class="obpress-hotel-results-tax-bottom">
                <div class="obpress-hotel-results-tax-message"></div>
                <div class="obpress-hotel-results-tax-total">
                    <span class="obpress-hotel-results-tax-currency">R$</span>
                    <span class="obpress-hotel-results-tax-price"></span>
                </div>
            </div>
        </div>

	</div>
</div>