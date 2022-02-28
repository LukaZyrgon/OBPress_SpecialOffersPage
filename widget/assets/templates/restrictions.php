<?php
    $restriction = 0;
    $restriction_type = null;

    if(current($roomrate->RatesType->Rates)->MinLOS != null && current($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)) {
        $restriction++;
        if(current($roomrate->RatesType->Rates)->MinLOS == 1) {
            $restriction_type = "Minimum " . @current($roomrate->RatesType->Rates)->MinLOS . " Night!";
        }
        elseif(current($roomrate->RatesType->Rates)->MinLOS > 1) {
            $restriction_type = "Minimum " . @current($roomrate->RatesType->Rates)->MinLOS . " Nights!";
        }
    }
    elseif(end($roomrate->RatesType->Rates)->MinLOS != null && end($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)) {
        $restriction++;
        if(end($roomrate->RatesType->Rates)->MinLOS == 1) {
            $restriction_type = "Minimum " . @end($roomrate->RatesType->Rates)->MinLOS . " Night!";
        }
        elseif(end($roomrate->RatesType->Rates)->MinLOS > 1) {
            $restriction_type = "Minimum " . @end($roomrate->RatesType->Rates)->MinLOS . " Nights!";
        }
    }

    if($roomrate->RatesType->Rates[0]->MaxLOS != null && $roomrate->RatesType->Rates[0]->MaxLOS < count($roomrate->RatesType->Rates)) {
        $restriction++;
        if($roomrate->RatesType->Rates[0]->MaxLOS == 1) {
            $restriction_type = "Maximum " . @$roomrate->RatesType->Rates[0]->MaxLOS . " Night!";
        }
        elseif($roomrate->RatesType->Rates[0]->MaxLOS > 1) {
            $restriction_type = "Maximum " . @$roomrate->RatesType->Rates[0]->MaxLOS . " Nights!";
        }
    }

    if($roomrate->RatesType->Rates[0]->StayThrough != null){
        $restriction++;
        $restriction_type = 'Stay through';
    }

    if(isset(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset) && current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset != null){
        $restriction++;
        if(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset == 1) {
            $restriction_type = "Release days " . current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset . " Day";
        }
        else {
            $restriction_type = "Release days " . current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset . " Days";
        }
    }

    if(isset($roomrate->Availability)) {
        foreach($roomrate->Availability as $availability) {
            if($availability->WarningRPH != null && $availability->WarningRPH == 346) {
                $restriction++;
                $restriction_type = 'Closed on arrival';
            }
            if($availability->WarningRPH != null && $availability->WarningRPH == 563) {
                $restriction++;
                $restriction_type = 'Closed on departure';
            }
        }
    }
?>

<?php if($restriction > 0): ?>
    <div class="restricted_text_holder">
        <div class="los_restricted red-text t-tip__in">
            <?php if($restriction > 1): ?>
                    <!-- Rate with restrictions! -->

                    <!-- List restrictions because we are missing tooltips -->
                    <?php if(current($roomrate->RatesType->Rates)->MinLOS != null && current($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                        <div class="restriction">
                            <span>
                                - Stay a minimum of 
                                <?php
                                    echo current($roomrate->RatesType->Rates)->MinLOS;
                                    if(current($roomrate->RatesType->Rates)->MinLOS == 1){
                                        echo ' '.strtolower('Night');
                                    }
                                    else {
                                        echo ' '.strtolower('Nights');
                                    }
                                ?>
                            </span>
                        </div>
                    <?php elseif(end($roomrate->RatesType->Rates)->MinLOS != null && end($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                        <div class="restriction">
                            <span>
                                - Stay a minimum of 
                                <?php
                                    echo end($roomrate->RatesType->Rates)->MinLOS;
                                    if(end($roomrate->RatesType->Rates)->MinLOS == 1) {
                                        echo ' '.strtolower('Night');
                                    }
                                    else {
                                        echo ' '.strtolower('Nights');
                                    }
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if(end($roomrate->RatesType->Rates)->MaxLOS != null && end($roomrate->RatesType->Rates)->MaxLOS < count($roomrate->RatesType->Rates)): ?>
                        <div class="restriction">
                            <span>Stay a maximum of </span>
                            <span>
                                <?php
                                    echo end($roomrate->RatesType->Rates)->MaxLOS;
                                    if(current($roomrate->RatesType->Rates)->MaxLOS == 1) {
                                        echo ' '.strtolower('Night');
                                    }
                                    else {
                                        echo ' '.strtolower('Nights');
                                    }
                                ?>                                        
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if($roomrate->RatesType->Rates[0]->StayThrough != null): ?>
                        <div class="restriction">   
                            <span>
                                - Stay a minimum of 
                                <?php 
                                    echo $roomrate->RatesType->Rates[0]->StayThrough;
                                    if($roomrate->RatesType->Rates[0]->StayThrough == 1) {
                                        echo ' '.strtolower('Night');
                                    }   
                                    else {
                                        echo ' '.strtolower('Nights');
                                    }   
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if(isset(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset)): ?>
                        <?php if(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset != null): ?>
                            <div class="restriction days-in-advance">
                                <span>
                                    - Book 
                                    <?= current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset ?>
                                    nights in advance
                                </span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(isset($roomrate->Availability)): ?>
                        <?php foreach($roomrate->Availability as $availability): ?>
                            <?php if($availability->WarningRPH != null && $availability->WarningRPH == 346): ?>
                                <div class="restriction closed-on-arival">
                                    <span>Closed on arrival</span>
                                    <span class="tooltip-yes">YES</span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(isset($roomrate->Availability)): ?>
                        <?php foreach($roomrate->Availability as $availability): ?>
                            <?php if($availability->WarningRPH != null && $availability->WarningRPH == 563): ?>
                                <div class="restriction closed-on-departure">
                                    <span>Closed on departure</span>
                                    <span class="tooltip-yes">YES</span>
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>


                <!-- WP DOES NOT HAVE TOOLTIPS -->
                <!-- <span class="t-tip">
                    <span class="t-tip__text">
                        <span class="font-weight-bold">To book this rate, you must:</span>
                        <?php if(current($roomrate->RatesType->Rates)->MinLOS != null && current($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                            <span class="col-12 restriction-tooltip">
                                <span>
                                    - Stay a minimum of 
                                    <?php
                                        echo current($roomrate->RatesType->Rates)->MinLOS;
                                        if(current($roomrate->RatesType->Rates)->MinLOS == 1){
                                            echo strtolower('Night');
                                        }
                                        else {
                                            echo strtolower('Nights');
                                        }
                                    ?>
                                </span>
                            </span>
                        <?php elseif(end($roomrate->RatesType->Rates)->MinLOS != null && end($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                            <span class="col-12 restriction-tooltip">
                                <span>
                                    - Stay a minimum of 
                                    <?php
                                        echo end($roomrate->RatesType->Rates)->MinLOS;
                                        if(end($roomrate->RatesType->Rates)->MinLOS == 1) {
                                            echo strtolower('Night');
                                        }
                                        else {
                                            echo strtolower('Nights');
                                        }
                                    ?>
                                </span>
                            </span>
                        <?php endif; ?>
                        <?php if(end($roomrate->RatesType->Rates)->MaxLOS != null && end($roomrate->RatesType->Rates)->MaxLOS < count($roomrate->RatesType->Rates)): ?>
                            <span class="col-12 restriction-tooltip">
                                <span>Stay a maximum of </span>
                                <span>
                                    <?php
                                        echo end($roomrate->RatesType->Rates)->MaxLOS;
                                        if(current($roomrate->RatesType->Rates)->MaxLOS == 1) {
                                            echo strtolower('Night');
                                        }
                                        else {
                                            echo strtolower('Nights');
                                        }
                                    ?>                                        
                                </span>
                            </span>
                        <?php endif; ?>
                        <?php if($roomrate->RatesType->Rates[0]->StayThrough != null): ?>
                            <span class="col-12 restriction-tooltip">   
                                <span>
                                    - Stay a minimum of 
                                    <?php 
                                        echo $roomrate->RatesType->Rates[0]->StayThrough;
                                        if($roomrate->RatesType->Rates[0]->StayThrough == 1) {
                                            echo strtolower('Night');
                                        }   
                                        else {
                                            echo strtolower('Nights');
                                        }   
                                    ?>
                                </span>
                            </span>
                        <?php endif; ?>
                        <?php if(isset(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset)): ?>
                            <?php if(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset != null): ?>
                                <span class="col-12 restriction-tooltip days-in-advance">
                                    <span>
                                        - Book 
                                        <?= current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset ?>
                                        nights in advance
                                    </span>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(isset($roomrate->Availability)): ?>
                            <?php foreach($roomrate->Availability as $availability): ?>
                                <?php if($availability->WarningRPH != null && $availability->WarningRPH == 346): ?>
                                    <span class="col-12 restriction-tooltip closed-on-arival">
                                        <span>Closed on arrival</span>
                                        <span class="tooltip-yes">YES</span>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if(isset($roomrate->Availability)): ?>
                            <?php foreach($roomrate->Availability as $availability): ?>
                                <?php if($availability->WarningRPH != null && $availability->WarningRPH == 563): ?>
                                    <span class="col-12 restriction-tooltip closed-on-departure">
                                        <span>Closed on departure</span>
                                        <span class="tooltip-yes">YES</span>
                                    </span>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                    </span>
                </span> -->
            <?php elseif($restriction_type != null): ?>
                <span class="align-middle">
                    <?= $restriction_type ?>
                </span>

                <!-- WP DOES NOT HAVE TOOLTIPS -->
                <!-- <span class="t-tip">
                    <span class="t-tip__text">
                        <?php if(current($roomrate->RatesType->Rates)->MinLOS != null && current($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                            <span class="col-12 restriction-tooltip single-restriction">
                                <span>
                                    To book this rate, you must stay a minimum of
                                    <?php 
                                        echo current($roomrate->RatesType->Rates)->MinLOS;
                                        if(current($roomrate->RatesType->Rates)->MinLOS == 1) {
                                            echo strtolower('Night');
                                        }
                                        else {
                                            echo strtolower('Nights');
                                        }
                                    ?>
                                </span>
                                <span>Modify your search by adjusting the dates.</span>
                            </span>
                        <?php elseif(end($roomrate->RatesType->Rates)->MinLOS != null && end($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                            <span class="col-12 restriction-tooltip single-restriction">
                                <span>
                                    To book this rate, you must stay a minimum of
                                    <?php
                                        echo end($roomrate->RatesType->Rates)->MinLOS;
                                        if(end($roomrate->RatesType->Rates)->MinLOS == 1) {
                                            echo strtolower('Night');
                                        }
                                        else {
                                            echo strtolower('Nights');
                                        }
                                    ?>
                                </span>
                                <span>Modify your search by adjusting the dates.</span>
                            </span>
                        <?php endif; ?>
                        <?php if(end($roomrate->RatesType->Rates)->MaxLOS != null && end($roomrate->RatesType->Rates)->MaxLOS < count($roomrate->RatesType->Rates)): ?>
                            <span class="col-12 restriction-tooltip single-restriction">
                                <span>
                                    To book this rate, you must stay a maximum of
                                    <?php
                                        echo end($roomrate->RatesType->Rates)->MaxLOS;
                                        if(end($roomrate->RatesType->Rates)->MaxLOS == 1){
                                            echo strtolower('Night');
                                        }
                                        else{
                                            echo strtolower('Nights');
                                        }
                                    ?>
                                </span>
                                <span>Modify your search by adjusting the dates.</span>
                            </span>
                        <?php endif; ?>
                        <?php if($roomrate->RatesType->Rates[0]->StayThrough != null): ?>
                            <span class="col-12 restriction-tooltip single-restriction">
                                <span>
                                    To book this rate, you must stay for
                                    <?php 
                                        echo $roomrate->RatesType->Rates[0]->StayThrough;
                                        if($roomrate->RatesType->Rates[0]->StayThrough == 1){
                                            echo strtolower('Night');
                                        }
                                        else{
                                            echo strtolower('Nights');
                                        }
                                    ?>
                                </span>
                                <span>Modify your search by adjusting the dates.</span>
                            </span>
                        <?php endif; ?>
                        <?php if(isset(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset)): ?>
                            <?php if(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset != null): ?>
                                <span class="col-12 restriction-tooltip days-in-advance single-restriction">
                                    <span>
                                        To book this rate, you must book 
                                        <?= current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset ?>
                                        nights in advance.
                                    </span>
                                    <span>Modify your search by adjusting the dates.</span>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(isset($roomrate->Availability)): ?>
                            <?php foreach($roomrate->Availability as $availability): ?>
                                <?php if($availability->WarningRPH != null && $availability->WarningRPH == 346): ?>
                                    <span class="col-12 restriction-tooltip closed-on-arival">
                                        <span>Closed on arrival</span>
                                        <span class="tooltip-yes">YES</span>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if(isset($roomrate->Availability)): ?>
                            <?php foreach($roomrate->Availability as $availability): ?>
                                <?php if($availability->WarningRPH != null && $availability->WarningRPH == 563): ?>
                                    <span class="col-12 restriction-tooltip closed-on-departure">
                                        <span>Closed on departure</span>
                                        <span class="tooltip-yes">YES</span>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>                                                         
                    </span>
                </span> -->

            <?php endif; ?>

        </div>
        
        <!-- WP PENDING MOBILE VERSION -->
        <!-- <div class="mobile-restriction">
            <?php if(current($roomrate->RatesType->Rates)->MinLOS != null && current($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                <span class="">
                    <span>Minimum days to book</span>
                    <span>
                        <?= current($roomrate->RatesType->Rates)->MinLOS ?>
                        <?php if(current($roomrate->RatesType->Rates)->MinLOS == 1): ?>
                            Day
                        <?php else: ?>
                            Days
                        <?php endif; ?>
                    </span>
                </span>
            <?php elseif(end($roomrate->RatesType->Rates)->MinLOS != null && end($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                <span class="">
                    <span>Minimum days to book</span>
                    <span>
                        <?= end($roomrate->RatesType->Rates)->MinLOS ?>
                        <?php if(end($roomrate->RatesType->Rates)->MinLOS == 1): ?>
                            Day
                        <?php else: ?>
                            Days
                        <?php endif; ?>
                    </span>
                </span>
            <?php endif; ?>
            <?php if(end($roomrate->RatesType->Rates)->MaxLOS != null && end($roomrate->RatesType->Rates)->MaxLOS < count($roomrate->RatesType->Rates)): ?>
                <span class="">
                    <span>Maximum days to book</span>
                    <span>
                        <?= end($roomrate->RatesType->Rates)->MaxLOS ?>
                        <?php if(end($roomrate->RatesType->Rates)->MaxLOS == 1): ?>
                            Day
                        <?php else: ?>
                            Days
                        <?php endif; ?>
                    </span>
                </span>
            <?php endif; ?>
            <?php if($roomrate->RatesType->Rates[0]->StayThrough != null): ?>
                <span class="">   
                    <span>Stay through</span>
                    <span>
                        <?= $roomrate->RatesType->Rates[0]->StayThrough ?>
                        <?php if($roomrate->RatesType->Rates[0]->StayThrough == 1): ?>
                            Day
                        <?php else: ?>
                            Days
                        <?php endif; ?>
                    </span>
                </span>
            <?php endif; ?>
            <?php if(isset(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset)): ?>
                <?php if(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset != null): ?>
                    <span class="">
                        <span>Release days</span>
                        <span>
                            <?= current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset ?>
                            <?php if(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset == 1): ?>
                                Day
                            <?php else: ?>
                                Days
                            <?php endif; ?>
                        </span>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(isset($roomrate->Availability)): ?>
                <?php foreach($roomrate->Availability as $availability): ?>
                    <?php if($availability->WarningRPH != null && $availability->WarningRPH == 346): ?>
                        <span class="">
                            <span>Closed on arrival</span>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if(isset($roomrate->Availability)): ?>
                <?php foreach($roomrate->Availability as $availability): ?>
                    <?php if($availability->WarningRPH != null && $availability->WarningRPH == 563): ?>
                        <span class="">
                            <span>Closed on departure</span>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div> --> 

        <!-- WP PENDING MOBILE VERSION -->
        <!-- <span class="restricted_tooltip_mobile" data-toggle="modal" data-target="#mobile_modal_restrictions_<?= $roomrate->RoomID ?>_<?= $roomrate->RatePlanID ?>" >
            More about
        </span> -->
        <span class="restricted_modify_search">
            Change Search
        </span>


        <!-- WP PENDING MOBILE VERSION -->
        <!-- Modal mobile restrictions -->
        <!-- <div class="modal fade mobile_modal_restrictions" id="mobile_modal_restrictions_<?= $roomrate->RoomID ?>_<?= $roomrate->RatePlanID ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        Rate Restrictions
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <img src="/icons/icons_GreyLight/iconGreyLight_Xclose.svg">
                        </button>
                    </div>
                    <div class="mobile_restrictions_modal_header">
                        To book this rate, you must:
                    </div>


                    <?php if(current($roomrate->RatesType->Rates)->MinLOS != null && current($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                        <div class="mobile_restrictions_tooltip_option">
                            - Stay a minimum of 
                            <?= current($roomrate->RatesType->Rates)->MinLOS ?>
                            <?php if(current($roomrate->RatesType->Rates)->MinLOS == 1): ?>
                                <?= strtolower('Night') ?>
                            <?php else: ?>
                                <?= strtolower('Nights') ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif(end($roomrate->RatesType->Rates)->MinLOS != null && end($roomrate->RatesType->Rates)->MinLOS > count($roomrate->RatesType->Rates)): ?>
                        <div class="mobile_restrictions_tooltip_option">
                            - Stay a minimum of 
                            <?= end($roomrate->RatesType->Rates)->MinLOS ?>
                            <?php if(end($roomrate->RatesType->Rates)->MinLOS == 1): ?>
                                <?= strtolower('Night') ?>
                            <?php else: ?>
                                <?= strtolower('Nights') ?>
                            <?php endif; ?>
                        </div> 
                    <?php endif; ?>
                    <?php if(end($roomrate->RatesType->Rates)->MaxLOS != null && end($roomrate->RatesType->Rates)->MaxLOS < count($roomrate->RatesType->Rates)): ?>
                        <div class="mobile_restrictions_tooltip_option">
                            - Stay a maximum of 
                            <?= end($roomrate->RatesType->Rates)->MaxLOS ?>
                            <?php if(end($roomrate->RatesType->Rates)->MaxLOS == 1): ?>
                                <?= strtolower('Night') ?>
                            <?php else: ?>
                                <?= strtolower('Nights') ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if($roomrate->RatesType->Rates[0]->StayThrough != null): ?>
                        <div class="mobile_restrictions_tooltip_option">
                            - Stay a minimum of 
                            <?php $roomrate->RatesType->Rates[0]->StayThrough ?>
                            <?php if($roomrate->RatesType->Rates[0]->StayThrough == 1): ?>
                                <?php strtolower('Night') ?>
                            <?php else: ?>
                                <?php strtolower('Nights') ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset)): ?>
                        <?php if(current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset != null): ?>
                            <div class="mobile_restrictions_tooltip_option">
                                - Book 
                                <?= current($roomrate->RatesType->Rates)->MinAdvancedBookingOffset ?>
                                nights in advance
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(isset($roomrate->Availability)): ?>
                        <?php foreach($roomrate->Availability as $availability): ?>
                            <?php if($availability->WarningRPH != null && $availability->WarningRPH == 346): ?>
                                <div class="mobile_restrictions_tooltip_option">
                                    - Closed on arrival
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(isset($roomrate->Availability)): ?>
                        <?php foreach($roomrate->Availability as $availability): ?>
                            <?php if($availability->WarningRPH != null && $availability->WarningRPH == 563): ?>
                                <div class="mobile_restrictions_tooltip_option">
                                    - Closed on departure
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="mobile_restrictions_tooltip_advice">
                        Modify your search by adjusting the dates.
                    </div>
                </div>
            </div>
        </div> -->


    </div>
<?php endif; ?>