<?php
$rowCounter = 0;
?>

<?php if ($data['yearlevel'] == 1) : ?>
    <?php
    include('../../../includes/alert.php');
    ?>
    <div class="content">
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <h3>Freshmen Medical Documents</h3>
            </div>
            <div class="p-2">
                <?php
                // Check if all medical documents are approved
                $sql_check_approved = "SELECT COUNT(*) AS total_approved FROM meddoc WHERE applicant='$userid' AND type='FRESHMEN' AND status='Approved'";
                $result_check_approved = mysqli_query($conn, $sql_check_approved);
                $row_check_approved = mysqli_fetch_assoc($result_check_approved);
                $total_approved = $row_check_approved['total_approved'];

                // Fetch total number of medical documents for OJT of the user
                $sql_total_medical_docs = "SELECT COUNT(*) AS total_medical_docs FROM meddoc WHERE applicant='$userid' AND type='FRESHMEN'";
                $result_total_medical_docs = mysqli_query($conn, $sql_total_medical_docs);
                $row_total_medical_docs = mysqli_fetch_assoc($result_total_medical_docs);
                $total_medical_docs = $row_total_medical_docs['total_medical_docs'];

                if ($total_approved === $total_medical_docs && $total_medical_docs > 0) {
                    // If all medical documents are approved and there are documents available, show the button
                ?>
                    <button type="button" class="btn btn-primary">Download Medical Certificate</button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="head">
                        <tr>
                            <th></th>
                            <th>Medical Documents</th>
                            <th>Date & Time Submitted</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM meddoc WHERE applicant='$userid' and type='FRESHMEN'";
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
                                        <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                        <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                        <td><?php echo $data['status'] ?> </td>
                                        <td><?php echo $data['remarks'] ?></td>
                                        <td>
                                            <?php if ($data['status'] === 'Disapproved') : ?>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>">Update</button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploaddocument<?php echo $rowCounter; ?>">Upload</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Include modals with a unique id -->
                                    <?php include('modals/view-document-modal.php'); ?>
                                    <?php include('modals/upload-document-modal.php'); ?>
                                    <?php include('modals/update-document-modal.php'); ?>

                                <?php
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
    <?php
    include('../../../includes/alert.php');
    ?>
    <div class="content">
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <h3>Freshmen Medical Documents</h3>
            </div>
            <div class="p-2">
                <?php
                // Check if all medical documents are approved
                $sql_check_approved = "SELECT COUNT(*) AS total_approved FROM meddoc WHERE applicant='$userid' AND type='FRESHMEN' AND status='Approved'";
                $result_check_approved = mysqli_query($conn, $sql_check_approved);
                $row_check_approved = mysqli_fetch_assoc($result_check_approved);
                $total_approved = $row_check_approved['total_approved'];

                // Fetch total number of medical documents for OJT of the user
                $sql_total_medical_docs = "SELECT COUNT(*) AS total_medical_docs FROM meddoc WHERE applicant='$userid' AND type='FRESHMEN'";
                $result_total_medical_docs = mysqli_query($conn, $sql_total_medical_docs);
                $row_total_medical_docs = mysqli_fetch_assoc($result_total_medical_docs);
                $total_medical_docs = $row_total_medical_docs['total_medical_docs'];

                if ($total_approved === $total_medical_docs && $total_medical_docs > 0) {
                    // If all medical documents are approved and there are documents available, show the button
                ?>
                    <button type="button" class="btn btn-primary">Download Medical Certificate</button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="head">
                        <tr>
                            <th></th>
                            <th>Medical Documents</th>
                            <th>Date & Time Submitted</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM meddoc WHERE applicant='$userid' and type='FRESHMEN'";
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
                                        <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                        <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                        <td><?php echo $data['status'] ?> </td>
                                        <td><?php echo $data['remarks'] ?></td>
                                        <td>
                                            <?php if ($data['status'] === 'Disapproved') : ?>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>" disabled>Update</button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploaddocument<?php echo $rowCounter; ?>" disabled>Upload</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Include modals with a unique id -->
                                    <?php include('modals/view-document-modal.php'); ?>
                                    <?php include('modals/upload-document-modal.php'); ?>
                                    <?php include('modals/update-document-modal.php'); ?>

                                <?php
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
                <?php
                // Check if all medical documents are approved
                $sql_check_approved = "SELECT COUNT(*) AS total_approved FROM meddoc WHERE applicant='$userid' AND type='ATHLETE' AND status='Approved'";
                $result_check_approved = mysqli_query($conn, $sql_check_approved);
                $row_check_approved = mysqli_fetch_assoc($result_check_approved);
                $total_approved = $row_check_approved['total_approved'];

                // Fetch total number of medical documents for OJT of the user
                $sql_total_medical_docs = "SELECT COUNT(*) AS total_medical_docs FROM meddoc WHERE applicant='$userid' AND type='ATHLETE'";
                $result_total_medical_docs = mysqli_query($conn, $sql_total_medical_docs);
                $row_total_medical_docs = mysqli_fetch_assoc($result_total_medical_docs);
                $total_medical_docs = $row_total_medical_docs['total_medical_docs'];

                if ($total_approved === $total_medical_docs && $total_medical_docs > 0) {
                    // If all medical documents are approved and there are documents available, show the button
                ?>
                    <button type="button" class="btn btn-primary">Download Medical Certificate</button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="head">
                        <tr>
                            <th></th>
                            <th>Medical Documents</th>
                            <th>Date & Time Submitted</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM meddoc WHERE applicant='$userid' and type='ATHLETE'";
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
                                        <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                        <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                        <td><?php echo $data['status'] ?> </td>
                                        <td><?php echo $data['remarks'] ?></td>
                                        <td>
                                            <?php if ($data['status'] === 'Disapproved') : ?>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>">Update</button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploaddocument<?php echo $rowCounter; ?>">Upload</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Include modals with a unique id -->
                                    <?php include('modals/view-document-modal.php'); ?>
                                    <?php include('modals/upload-document-modal.php'); ?>
                                    <?php include('modals/update-document-modal.php'); ?>

                                <?php
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
    <?php
    include('../../../includes/alert.php');
    ?>
    <div class="content">
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <h3>Freshmen Medical Documents</h3>
            </div>
            <div class="p-2">
                <?php
                // Check if all medical documents are approved
                $sql_check_approved = "SELECT COUNT(*) AS total_approved FROM meddoc WHERE applicant='$userid' AND type='FRESHMEN' AND status='Approved'";
                $result_check_approved = mysqli_query($conn, $sql_check_approved);
                $row_check_approved = mysqli_fetch_assoc($result_check_approved);
                $total_approved = $row_check_approved['total_approved'];

                // Fetch total number of medical documents for OJT of the user
                $sql_total_medical_docs = "SELECT COUNT(*) AS total_medical_docs FROM meddoc WHERE applicant='$userid' AND type='FRESHMEN'";
                $result_total_medical_docs = mysqli_query($conn, $sql_total_medical_docs);
                $row_total_medical_docs = mysqli_fetch_assoc($result_total_medical_docs);
                $total_medical_docs = $row_total_medical_docs['total_medical_docs'];

                if ($total_approved === $total_medical_docs && $total_medical_docs > 0) {
                    // If all medical documents are approved and there are documents available, show the button
                ?>
                    <button type="button" class="btn btn-primary">Download Medical Certificate</button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="head">
                        <tr>
                            <th></th>
                            <th>Medical Documents</th>
                            <th>Date & Time Submitted</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM meddoc WHERE applicant='$userid' and type='FRESHMEN'";
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
                                        <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                        <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                        <td><?php echo $data['status'] ?> </td>
                                        <td><?php echo $data['remarks'] ?></td>
                                        <td>
                                            <?php if ($data['status'] === 'Disapproved') : ?>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>" disabled>Update</button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploaddocument<?php echo $rowCounter; ?>" disabled>Upload</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Include modals with a unique id -->
                                    <?php include('modals/view-document-modal.php'); ?>
                                    <?php include('modals/upload-document-modal.php'); ?>
                                    <?php include('modals/update-document-modal.php'); ?>

                                <?php
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
                <?php
                // Check if all medical documents are approved
                $sql_check_approved = "SELECT COUNT(*) AS total_approved FROM meddoc WHERE applicant='$userid' AND type='ATHLETE' AND status='Approved'";
                $result_check_approved = mysqli_query($conn, $sql_check_approved);
                $row_check_approved = mysqli_fetch_assoc($result_check_approved);
                $total_approved = $row_check_approved['total_approved'];

                // Fetch total number of medical documents for OJT of the user
                $sql_total_medical_docs = "SELECT COUNT(*) AS total_medical_docs FROM meddoc WHERE applicant='$userid' AND type='ATHLETE'";
                $result_total_medical_docs = mysqli_query($conn, $sql_total_medical_docs);
                $row_total_medical_docs = mysqli_fetch_assoc($result_total_medical_docs);
                $total_medical_docs = $row_total_medical_docs['total_medical_docs'];

                if ($total_approved === $total_medical_docs && $total_medical_docs > 0) {
                    // If all medical documents are approved and there are documents available, show the button
                ?>
                    <button type="button" class="btn btn-primary">Download Medical Certificate</button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="head">
                        <tr>
                            <th></th>
                            <th>Medical Documents</th>
                            <th>Date & Time Submitted</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM meddoc WHERE applicant='$userid' and type='ATHLETE'";
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
                                        <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                        <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                        <td><?php echo $data['status'] ?> </td>
                                        <td><?php echo $data['remarks'] ?></td>
                                        <td>
                                            <?php if ($data['status'] === 'Disapproved') : ?>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>">Update</button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploaddocument<?php echo $rowCounter; ?>" onclick="handleUploadSuccess()">Upload</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Include modals with a unique id -->
                                    <?php include('modals/view-document-modal.php'); ?>
                                    <?php include('modals/upload-document-modal.php'); ?>
                                    <?php include('modals/update-document-modal.php'); ?>

                                <?php
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
                <?php
                // Check if all medical documents are approved
                $sql_check_approved = "SELECT COUNT(*) AS total_approved FROM meddoc WHERE applicant='$userid' AND type='OJT' AND status='Approved'";
                $result_check_approved = mysqli_query($conn, $sql_check_approved);
                $row_check_approved = mysqli_fetch_assoc($result_check_approved);
                $total_approved = $row_check_approved['total_approved'];

                // Fetch total number of medical documents for OJT of the user
                $sql_total_medical_docs = "SELECT COUNT(*) AS total_medical_docs FROM meddoc WHERE applicant='$userid' AND type='OJT'";
                $result_total_medical_docs = mysqli_query($conn, $sql_total_medical_docs);
                $row_total_medical_docs = mysqli_fetch_assoc($result_total_medical_docs);
                $total_medical_docs = $row_total_medical_docs['total_medical_docs'];

                if ($total_approved === $total_medical_docs && $total_medical_docs > 0) {
                    // If all medical documents are approved and there are documents available, show the button
                ?>
                    <button type="button" class="btn btn-primary">Download Medical Certificate</button>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="head">
                        <tr>
                            <th></th>
                            <th>Medical Documents</th>
                            <th>Date & Time Submitted</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM meddoc WHERE applicant='$userid' and type='OJT'";
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
                                        <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                        <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                        <td><?php echo $data['status'] ?> </td>
                                        <td><?php echo $data['remarks'] ?></td>
                                        <td>
                                            <?php if ($data['status'] === 'Disapproved') : ?>
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#updatedocument<?php echo $rowCounter; ?>">Update</button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploaddocument<?php echo $rowCounter; ?>">Upload</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Include modals with a unique id -->
                                    <?php include('modals/view-document-modal.php'); ?>
                                    <?php include('modals/upload-document-modal.php'); ?>
                                    <?php include('modals/update-document-modal.php'); ?>

                                <?php
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
                <table class="table table-bordered">
                    <thead class="head">
                        <tr>
                            <th></th>
                            <th>Medical Documents</th>
                            <th>Date & Time Submitted</th>
                            <th>Last Updated</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7">
                                <?php
                                include('../../../includes/no-data.php');
                                ?>
                                <p style="margin-top: -40px"><strong>No Medical Found</strong></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php endif ?>