<div class="modal fade" id="updatesup<?php echo $data['supid']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Supply Entry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/update_supply.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="supply" class="form-label">Medical Supply:</label>
                        <input type="text" value="<?php echo $data['supid']?>" hidden>
                        <input type="text" class="form-control" name="supply" value="<?php echo $data['supply']?>" id="supply">
                    </div>
                    <div class="mb-2">
                        <label for="volume" class="form-label">Volume:</label>
                        <input type="number" class="form-control" name="volume" value="<?php echo $data['volume']?>" id="volume" step=".01">
                    </div>
                    <div class="mb-2">
                        <label for="um" class="form-label">Unit Measure:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="unit_measure" id="unit_measure" required>
                            <option value="" disabled selected>-Select Unit Measure-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM unit_measure WHERE type = 'set' ORDER BY unit_measure";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                if ($data['unit_measure'] == $row['unit_measure'])
                                {
                            ?>
                                <option value="<?= $row['unit_measure']; ?>" selected><?= $row['unit_measure']; ?></option>
                            <?php } else
                            {?>
                                <option value="<?= $row['unit_measure']; ?>"><?= $row['unit_measure']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="um" class="form-label">Issuance:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="state" id="state" required>
                            <option value="" disabled selected>-Select Issuance State-</option>
                            <?php 
                            if($data['state'] == 'open-close')
                            {?>
                                <option value="per piece">Per Piece</option>
                                <option value="open-close" selected>Opened/Close</option>
                            <?php } else
                            {?>
                                <option value="per piece" selected>Per Piece</option>
                                <option value="open-close">Opened/Close</option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>