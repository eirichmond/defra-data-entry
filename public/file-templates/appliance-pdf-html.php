

<page>


<br>
<br>
<br>
<br>
					
    <table style="width: 100%;"  cellspacing="20">
            <tr>
                <td width="25%"><strong>Appliance name</strong></td>
                <td><?php echo $data["appliance_name"]; ?></td>
            </tr>
            <tr>
                <td><strong>Output</strong></td>
                <td><?php echo $data["output"]; ?></td>
            </tr>
            <tr>
                <td><strong>Fuel Type</strong></td>
                <td><?php echo $data["fuel_types"]; ?></td>
            </tr>

            <tr>
                <td><strong>Appliance Type</strong></td>
                <td><?php echo $data["appliance_type"]; ?></td>
            </tr>

            <tr>
                <td><strong>Manufacturer</strong></td>
                <td>
                    <div style="width: 70%; text-align: left;">
                    <?php echo $data["manufacturer"]; ?>
                    </div>
                </td>
            </tr>

            <tr>
                <th colspan=2>
                    <div style="width: 70%; text-align: left;">
                    The fireplace must be installed, maintained and operated in accordance with the following specifications:
                    </div>
                </th>
            </tr>

            <tr>
                <td><strong>Instruction manual title</strong></td>
                <td><?php echo $data["instructions_instruction_manual_title"]; ?></td>
            </tr>

            <tr>
                <td><strong>Instruction manual date</strong></td>
                <td><?php echo $data["instructions_instruction_manual_date"]; ?></td>
            </tr>

            <tr>
                <td><strong>Instruction manual reference</strong></td>
                <td><?php echo $data["instructions_instruction_manual_reference"]; ?></td>
            </tr>

            <tr>
                <td><strong>Installation manual title</strong></td>
                <td><?php echo $data["servicing_and_installation_servicing_install_manual_title"]; ?></td>
            </tr>

            <tr>
                <td><strong>Installation manual date</strong></td>
                <td><?php echo $data["servicing_and_installation_servicing_install_manual_date"]; ?></td>
            </tr>

            <tr>
                <td><strong>Installation manual reference</strong></td>
                <td><?php echo $data["servicing_and_installation_servicing_install_manual_reference"]; ?></td>
            </tr>
            
            <tr>
                <td width="25%"><strong>Additional conditions</strong></td>
                <td width="25%">
                    <div style="width: 70%; text-align: left;">
                        <?php echo esc_html( $data["additional_conditions_additional_condition_comment"] ); ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td><strong>Permitted fuels</strong></td>
                <td>
                    <div style="width:85%; text-align: left;">
                    <?php echo $data["permitted_fuels"]; ?>
                    </div>
                </td>
            </tr>


            <tr>
                <td><strong>England Status<br>
                Date first exempt</strong></td>

                <td>

                    <?php if($data["exempt_england"]) { ?>

                        <?php foreach ($data["statutory_instruments_england"] as $si_england) { ?>
                            <span>Exempt (<?php 
                                
                                if(strpos($si_england['title'], 'Footnote') !== false) {
                                    echo $si_england['title'];
                                } else {
                                    echo '<a href="'.$si_england['url'].'" target="_blank">'.$si_england['title'].'</a>';
                                }
                                ?>)
                            See Footnotes or SI Link</span>
                        <?php } ?>

                    <?php } else { ?>

                        <span>No<br>
                        n/a</span>

                    <?php } ?>

                </td>

            </tr>
        
            <tr>
                <td><strong>Wales Status<br>
                Date first exempt</strong></td>

                <td>

                    <?php if($data["exempt_wales"]) { ?>

                        <?php foreach ($data["statutory_instruments_wales"] as $si_wales) { ?>
                            <span>Exempt (<?php 
                                
                                if(strpos($si_wales['title'], 'Footnote') !== false) {
                                    echo $si_wales['title'];
                                } else {
                                    echo '<a href="'.$si_wales['url'].'" target="_blank">'.$si_wales['title'].'</a>';
                                }
                                ?>)<br>
                            See Footnotes or SI Link</span>
                        <?php } ?>

                    <?php } else { ?>

                        <span>No<br>
                        n/a</span>

                    <?php } ?>

                </td>

            </tr>

        
            <tr>
                <td><strong>Scotland Status<br>
                    Date first exempt</strong></td>

                    <td>

                    <?php if($data["exempt_n_ireland"]) { ?>

                        <?php foreach ($data["statutory_instruments_n_ireland"] as $si_n_ireland) { ?>
                            <span>Exempt (<?php 
                                
                                if(strpos($si_n_ireland['title'], 'Footnote') !== false) {
                                    echo $si_n_ireland['title'];
                                } else {
                                    echo '<a href="'.$si_n_ireland['url'].'" target="_blank">'.$si_n_ireland['title'].'</a>';
                                }
                                ?>)<br>
                            See Footnotes or SI Link</span>
                        <?php } ?>

                    <?php } else { ?>

                        <span>No<br>
                        n/a</span>

                    <?php } ?>

                    </td>

            </tr>

        
            <tr>
                <td><strong>N. Ireland Status<br>
                    Date first exempt</strong></td>

                    <td>

                    <?php if($data["exempt_scotland"]) { ?>

                        <?php foreach ($data["statutory_instruments_scotland"] as $si_scotland) { ?>
                            <span>Exempt (<?php 
                                
                                if(strpos($si_scotland['title'], 'Footnote') !== false) {
                                    echo $si_scotland['title'];
                                } else {
                                    echo '<a href="'.$si_scotland['url'].'" target="_blank">'.$si_scotland['title'].'</a>';
                                }
                                ?>)<br>
                            See Footnotes or SI Link</span>
                        <?php } ?>

                    <?php } else { ?>

                        <span>No<br>
                        n/a</span>

                    <?php } ?>

                    </td>

                </tr>

    </table>


    <div style="width: 90%; text-align: left;">
        Footnotes

        <ol class="smalltext">
            <li id="footnote1">The fuel must not contain halogenated organic compounds or heavy metals as a result of treatment with wood-preservatives or coatings.</li>
            <li id="footnote2">The conditions of exemption have been amended to remove references to fuels which are either no longer available or which cannot be used without contravening the Environmental Permitting (England and Wales) Regulations 2010 (S.I. 2010/675) or the Pollution Prevention and Control (Industrial Emissions) Regulations (Northern Ireland) 2013 (S.R. 2013 No. 160)</li>
            <li id="footnote3">The Environmental Permitting Regulations (England and Wales) 2010 (SI 2010/675) may apply to the burning of some of these wastes.</li>
            <li id="footnote4">Previously exempted by The Smoke Control Areas (Exempted Fireplaces) (England) Order 2015 (SI 2015/307), no longer in force as of 1 October 2015.  Now exempted by publication of this list by the Secretary of State in accordance with changes made to sections 20 and 21 of the Clean Air Act 1993 by section 15 of the Deregulation Act 2015.</li>
            <li id="footnote5">Exempted for use in England by publication of this list by the Secretary of State in accordance with changes made to sections 20 and 21 of the Clean Air Act 1993 by section 15 of the Deregulation Act 2015.</li>
            <li id="footnote6">Previously exempted by The Smoke Control Areas (Exempted Fireplaces) (Scotland) Regulations 2014 (SI 2014/316), no longer in force as of 30th June 2014.  Now exempted by publication of this list by Scottish Ministers under section 50 of the Regulatory Reform (Scotland) Act 2014.</li>
            <li id="footnote7">Exempted for use in Scotland by publication of this list by Scottish Ministers under section 50 of the Regulatory Reform (Scotland) Act 2014.</li>
            <li id="footnote8">Previously exempted by the Smoke Control Areas (Exempted Fireplaces) (No. 2) Regulations (Northern Ireland) 2013 (S.R. 2013 No. 292), as amended, no longer in force as of 10th October 2016. Now exempted by the publication of this list by the Department of Agriculture, Environment and Rural Affairs in accordance with changes made to Article 17(7) of the Clean Air (Northern Ireland) Order 1981 by section 16 of the Environmental Better Regulation Act (Northern Ireland) 2016.</li>
            <li id="footnote9">Exempted for use in Northern Ireland by publication of this list by the Department of Agriculture, Environment and Rural Affairs in accordance with changes made to Article 17(7) of the Clean Air (Northern Ireland) Order 1981 by section 16 of the Environmental Better Regulation Act (Northern Ireland) 2016.</li>
        </ol>

    </div>



</page>

