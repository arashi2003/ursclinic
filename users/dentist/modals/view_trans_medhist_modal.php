<div class="modal fade" id="viewtrans<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Medical Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label for="datetime" class="form-label">Date and Time:</label>
                    <input type="text" class="form-control" name="datetime" value="<?php echo date("F d, Y", strtotime($data['datetime'])) . " | " . date("g:i A", strtotime($data['datetime']  . "+ 8 hours")); ?>" id="datetime" disabled>
                </div>
                <div class="row">
                    <div class="col mb-2">
                        <label for="height" class="form-label">Height:</label>
                        <input type="text" class="form-control" name="height" value="<?php echo $data['height'] ?>" id="height" disabled>
                    </div>
                    <div class="col mb-2">
                        <label for="weight" class="form-label">Weight:</label>
                        <input type="text" class="form-control" name="weight" value="<?php echo $data['weight'] ?>" id="weight" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-2">
                        <label for="bp" class="form-label">Blood Pressure:</label>
                        <input type="text" class="form-control" name="bp" value="<?php echo $data['bp'] ?>" id="bp" disabled>
                    </div>
                    <div class="col mb-2">
                        <label for="pr" class="form-label">Pulse Rate:</label>
                        <input type="text" class="form-control" name="pr" value="<?php echo $data['pr'] ?>" id="pr" disabled>
                    </div>
                    <div class="col mb-2">
                        <label for="temp" class="form-label">Temperature:</label>
                        <input type="text" class="form-control" name="temp" value="<?php echo $data['temp'] ?>" id="temp" disabled>
                    </div>
                </div>
                <div class="mb-2">
                    <label for="heent" class="form-label">H.E.E.N.T.:</label>
                    <input type="text" class="form-control" name="heent" value="<?php echo $data['heent'] ?>" id="heent" disabled>
                </div>
                <div class="mb-2">
                    <label for="chest_lungs" class="form-label">Chest/Lungs:</label>
                    <input type="text" class="form-control" name="chest_lungs" value="<?php echo $data['chest_lungs'] ?>" id="chest_lungs" disabled>
                </div>
                <div class="mb-2">
                    <label for="heart" class="form-label">Heart:</label>
                    <input type="text" class="form-control" name="heart" value="<?php echo $data['heart'] ?>" id="heart" disabled>
                </div>
                <div class="mb-2">
                    <label for="abdomen" class="form-label">Abdomen:</label>
                    <input type="text" class="form-control" name="abdomen" value="<?php echo $data['abdomen'] . " " . $data['abdomen'] ?>" id="medcase" disabled>
                </div>
                <div class="mb-2">
                    <label for="extremities" class="form-label">Extremities:</label>
                    <input type="text" class="form-control" name="extremities" value="<?php echo $data['extremities'] ?>" id="extremities" disabled>
                </div>
                <div class="mb-2">
                    <label for="lmp" class="form-label">Last Menstrual Period:</label>
                    <input type="text" class="form-control" name="lmp" value="<?php echo date("F d, Y", strtotime($data['lmp'])) ?>" id="lmp" disabled>
                </div>
                <div class="row"> <!-- conditional if mga date tong anim -->
                    <div class="col mb-2">
                        <label for="bronchial_asthma" class="form-label">Bronchial Asthma:</label>
                        <input type="text" class="form-control" name="bronchial_asthma" value="<?php echo $data['bronchial_asthma'] ?>" id="bronchial_asthma" disabled>
                    </div>
                    <div class="col mb-2">
                        <label for="surgery" class="form-label">Surgery:</label>
                        <input type="text" class="form-control" name="surgery" value="<?php echo $data['surgery'] ?>" id="surgery" disabled>
                    </div>
                    <div class="col mb-2">
                        <label for="heart_disease" class="form-label">Heart Disease:</label>
                        <input type="text" class="form-control" name="heart_disease" value="<?php echo $data['heart_disease'] ?>" id="heart_disease" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-2">
                        <label for="allergies" class="form-label">Allergies:</label>
                        <input type="text" class="form-control" name="allergies" value="<?php echo $data['allergies'] ?>" id="allergies" disabled>
                    </div>
                    <div class="col mb-2">
                        <label for="epilepsy" class="form-label">Epilepsy:</label>
                        <input type="text" class="form-control" name="epilepsy" value="<?php echo $data['epilepsy'] ?>" id="epilepsy" disabled>
                    </div>
                    <div class="col mb-2">
                        <label for="hernia" class="form-label">Hernia:</label>
                        <input type="text" class="form-control" name="hernia" value="<?php echo $data['hernia'] ?>" id="hernia" disabled>
                    </div>
                </div>
                <div class="col mb-2">
                    <label for="ddefects">Dental:</label>
                </div>
                <?php
                if ($data['ddefects'] == "x") {
                ?>
                    <div class="mb-2">
                        <input type="checkbox" id="ddefects" name="ddefects" checked="checked" disabled>
                        <label for="ddefects"> No Dental Defects</label>
                    </div>
                <?php
                } else {
                ?>
                    <div class="mb-2">
                        <input type="checkbox" id="ddefects" name="ddefects" disabled>
                        <label for="ddefects"> No Dental Defects</label>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($data['dcs'] == "x") {
                ?>
                    <div class="mb-2">
                        <input type="checkbox" id="dcs" name="dcs" checked="checked" disabled>
                        <label for="dcs"> Presence of Oral Debris, Calculi (tartar) deposits, Stains/discoloration</label>
                    </div>
                <?php
                } else {
                ?>
                    <div class="mb-2">
                        <input type="checkbox" id="dcs" name="dcs" disabled>
                        <label for="dcs"> Presence of Oral Debris, Calculi (tartar) deposits, Stains/discoloration</label>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($data['gp'] == "x") {
                ?>
                    <div class="mb-2">
                        <input type="checkbox" id="gp" name="gp" checked="checked" disabled>
                        <label for="gp"> Presence of GINGIVITIS and/or PERIODONTITIS</label>
                    </div>
                <?php
                } else {
                ?>
                    <div class="mb-2">
                        <input type="checkbox" id="gp" name="gp" disabled>
                        <label for="gp"> Presence of GINGIVITIS and/or PERIODONTITIS</label>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($data['scaling_polish'] == "x") {
                ?>
                    <div class="mb-2">
                        <input type="checkbox" id="scaling_polish" name="scaling_polish" checked="checked" disabled>
                        <label for="scaling_polish"> For Tooth Scaling and Polishing</label>
                    </div>
                <?php
                } else {
                ?>
                    <div class="mb-2">
                        <input type="checkbox" id="scaling_polish" name="scaling_polish" disabled>
                        <label for="scaling_polish"> For Tooth Scaling and Polishing</label>
                    </div>
                <?php
                }
                ?>
                <div class="mb-2">
                    <label for="dento_facial" class="form-label">Other Dento-Facial Findings:</label>
                    <input type="text" class="form-control" name="dento_facial" value="<?php echo $data['dento_facial'] ?>" id="dento_facial" disabled>
                </div>
                <div class="mb-2">
                    <label for="remarks" class="form-label">Remarks:</label>
                    <input type="text" class="form-control" name="remarks" value="<?php echo $data['remarks'] ?>" id="remarks" disabled>
                </div>
                <div class="mb-2">
                    <label for="referral" class="form-label">Recommendations:</label>
                    <input type="text" class="form-control" name="referral" value="<?php echo $data['referral'] ?>" id="referral" disabled>
                </div>
                
                <div class="modal-footer">
                    <input type="reset" class="btn btn-danger" value="Close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </div>
        </div>
    </div>
</div>