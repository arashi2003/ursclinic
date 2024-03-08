<?php
$rowCounter = 0;

$sql = "SELECT * FROM patient_info p INNER JOIN account a ON a.accountid=p.patientid WHERE p.patientid='$patientid'";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        foreach ($result as $data) {
?>
            <?php if ($data['yearlevel'] == 1) : ?>

                <div class="content">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Freshmen Medical Documents</h3>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-primary" hidden>Download Medical Certificate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>   
                                        <th>Medical Documents</th>
                                        <th>Status</th>
                                        <th>Date & Time Submitted</th>
                                        <th>Last Updated</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM meddoc WHERE applicant='$patientid' and type='FRESHMEN'";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            foreach ($result as $data) {
                                                $rowCounter++;
                                    ?>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewdocument<?php echo $data['id'] ?>"><i class='bx bx-show'></i></button>
                                                    </td>
                                                    <td><?php echo $data['doc_desc'] ?></td>
                                                    <td><?php echo $data['status'] ?> </td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo $data['remarks'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>">update</button>
                                                    </td>
                                                </tr>
                                            <?php
                                            include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="7">
                                                    <h4>No Record Found</h4>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php elseif ($data['yearlevel'] == 2 or $data['yearlevel'] == 3) : ?>

                <div class="content">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Freshmen Medical Documents</h3>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-primary" hidden>Download Medical Certificate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Medical Documents</th>
                                        <th>Status</th>
                                        <th>Date & Time Submitted</th>
                                        <th>Last Updated</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM meddoc WHERE applicant='$patientid' and type='FRESHMEN'";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            foreach ($result as $data) {
                                                $rowCounter++;
                                    ?>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewdocument<?php echo $data['id'] ?>"><i class='bx bx-show'></i></button>
                                                    </td>
                                                    <td><?php echo $data['doc_desc'] ?></td>
                                                    <td><?php echo $data['status'] ?> </td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo $data['remarks'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>" disabled>Update</button>
                                                    </td>
                                                </tr>
                                            <?php
                                            include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="7">
                                                    <h4>No Record Found</h4>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Athlete Medical Documents</h3>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-primary" hidden>Download Medical Certificate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Medical Documents</th>
                                        <th>Status</th>
                                        <th>Date & Time Submitted</th>
                                        <th>Last Updated</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM meddoc WHERE applicant='$patientid' and type='ATHLETE'";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            foreach ($result as $data) {
                                                $rowCounter++;
                                    ?>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewdocument<?php echo $data['id'] ?>"><i class='bx bx-show'></i></button>
                                                    </td>
                                                    <td><?php echo $data['doc_desc'] ?></td>
                                                    <td><?php echo $data['status'] ?> </td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo $data['remarks'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>">Update</button>
                                                    </td>
                                                </tr>
                                            <?php
                                            include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="7">
                                                    <h4>No Record Found</h4>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            <?php elseif ($data['yearlevel'] == 4) : ?>

                <div class="content">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Freshmen Medical Documents</h3>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-primary" hidden>Download Medical Certificate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Medical Documents</th>
                                        <th>Status</th>
                                        <th>Date & Time Submitted</th>
                                        <th>Last Updated</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM meddoc WHERE applicant='$patientid' and type='FRESHMEN'";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            foreach ($result as $data) {
                                                $rowCounter++;
                                    ?>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewdocument<?php echo $data['id'] ?>"><i class='bx bx-show'></i></button>
                                                    </td>
                                                    <td><?php echo $data['doc_desc'] ?></td>
                                                    <td><?php echo $data['status'] ?> </td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo $data['remarks'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>" disabled>Update</button>
                                                    </td>
                                                </tr>
                                            <?php
                                            include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="7">
                                                    <h4>No Record Found</h4>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Athlete Medical Documents</h3>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-primary" hidden>Download Medical Certificate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Medical Documents</th>
                                        <th>Status</th>
                                        <th>Date & Time Submitted</th>
                                        <th>Last Updated</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM meddoc WHERE applicant='$patientid' and type='ATHLETE'";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            foreach ($result as $data) {
                                                $rowCounter++;
                                    ?>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewdocument<?php echo $data['id'] ?>"><i class='bx bx-show'></i></button>
                                                    </td>
                                                    <td><?php echo $data['doc_desc'] ?></td>
                                                    <td><?php echo $data['status'] ?> </td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo $data['remarks'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>">Update</button>
                                                    </td>
                                                </tr>
                                            <?php
                                            include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="7">
                                                    <h4>No Record Found</h4>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>OJT Medical Documents</h3>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-primary" hidden>Download Medical Certificate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Medical Documents</th>
                                        <th>Status</th>
                                        <th>Date & Time Submitted</th>
                                        <th>Last Updated</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM meddoc WHERE applicant='$patientid' and type='OJT'";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            foreach ($result as $data) {
                                                $rowCounter++;
                                    ?>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewdocument<?php echo $data['id'] ?>"><i class='bx bx-show'></i></button>
                                                    </td>
                                                    <td><?php echo $data['doc_desc'] ?></td>
                                                    <td><?php echo $data['status'] ?> </td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo $data['remarks'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>">Update</button>
                                                    </td>
                                                </tr>
                                            <?php
                                            include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="7">
                                                    <h4>No Record Found</h4>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php else : ?>

                <div class="content">
                    <div class="d-flex justify-content-between">
                        <div class="p-2">
                            <h3>Medical Documents</h3>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-primary" hidden>Download Medical Certificate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Medical Documents</th>
                                        <th>Status</th>
                                        <th>Date & Time Submitted</th>
                                        <th>Last Updated</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7">
                                            <h4>No Record Found</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php endif ?>
<?php
        }
    }
}

?>