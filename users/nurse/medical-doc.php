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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#medclear<?php echo $patientid; ?>">Export Clearance Slip</button>
                            <?php
                            }
                            include('modals/medclear_modal.php');

                            ?>
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
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                                    <td>
                                                        <select class="form-select status-field" aria-label="Default select example" name="status" disabled>
                                                            <option value="Approved" <?php echo ($data['status'] == 'Approved') ? "selected" : ""; ?>>Approved</option>
                                                            <option value="Disapproved" <?php echo ($data['status'] == 'Disapproved') ? "selected" : ""; ?>>Disapproved</option>
                                                            <option value="Pending" <?php echo ($data['status'] == 'Pending') ? "selected" : ""; ?>>Pending</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="doc-id" value="<?php echo $data['id'] ?>">
                                                        <input type="text" class="form-control remarks-field" name="remarks" value="<?php echo $data['remarks'] ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm update-btn">Update</button>
                                                        <button type="button" class="btn btn-success btn-sm save-btn" style="display: none;">Save</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel-btn" style="display: none;">Cancel</button>
                                                    </td>
                                                </tr>
                                            <?php
                                                include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="12">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
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
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                                    <td>
                                                        <select class="form-select status-field" aria-label="Default select example" name="status" disabled>
                                                            <option value="Approved" <?php echo ($data['status'] == 'Approved') ? "selected" : ""; ?>>Approved</option>
                                                            <option value="Disapproved" <?php echo ($data['status'] == 'Disapproved') ? "selected" : ""; ?>>Disapproved</option>
                                                            <option value="Pending" <?php echo ($data['status'] == 'Pending') ? "selected" : ""; ?>>Pending</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control remarks-field" name="remarks" value="<?php echo $data['remarks'] ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm update-btn" disabled>Update</button>
                                                    </td>
                                                </tr>
                                            <?php
                                                include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="12">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
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
                                <button type="button" class="btn btn-primary" onclick="window.open('reports/reports_medcert.php?patientid=<?php echo $patientid ?>');" target="_blank">Download Medical Certificate</button>
                            <?php }

                            ?>
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
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                                    <td>
                                                        <select class="form-select status-field" aria-label="Default select example" name="status" disabled>
                                                            <option value="Approved" <?php echo ($data['status'] == 'Approved') ? "selected" : ""; ?>>Approved</option>
                                                            <option value="Disapproved" <?php echo ($data['status'] == 'Disapproved') ? "selected" : ""; ?>>Disapproved</option>
                                                            <option value="Pending" <?php echo ($data['status'] == 'Pending') ? "selected" : ""; ?>>Pending</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="doc-id" value="<?php echo $data['id'] ?>">
                                                        <input type="text" class="form-control remarks-field" name="remarks" value="<?php echo $data['remarks'] ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm update-btn">Update</button>
                                                        <button type="button" class="btn btn-success btn-sm save-btn" style="display: none;">Save</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel-btn" style="display: none;">Cancel</button>
                                                    </td>
                                                </tr>
                                            <?php
                                                include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="12">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
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
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                                    <td>
                                                        <select class="form-select status-field" aria-label="Default select example" name="status" disabled>
                                                            <option value="Approved" <?php echo ($data['status'] == 'Approved') ? "selected" : ""; ?>>Approved</option>
                                                            <option value="Disapproved" <?php echo ($data['status'] == 'Disapproved') ? "selected" : ""; ?>>Disapproved</option>
                                                            <option value="Pending" <?php echo ($data['status'] == 'Pending') ? "selected" : ""; ?>>Pending</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control remarks-field" name="remarks" value="<?php echo $data['remarks'] ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm update-btn" disabled>Update</button>
                                                    </td>
                                                </tr>
                                            <?php
                                                include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="12">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
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
                                <button type="button" class="btn btn-primary" onclick="window.open('reports/reports_medcert.php?patientid=<?php echo $patientid ?>');" target="_blank">Download Medical Certificate</button>
                            <?php }
                            ?>
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
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                                    <td>
                                                        <select class="form-select status-field" aria-label="Default select example" name="status" disabled>
                                                            <option value="Approved" <?php echo ($data['status'] == 'Approved') ? "selected" : ""; ?>>Approved</option>
                                                            <option value="Disapproved" <?php echo ($data['status'] == 'Disapproved') ? "selected" : ""; ?>>Disapproved</option>
                                                            <option value="Pending" <?php echo ($data['status'] == 'Pending') ? "selected" : ""; ?>>Pending</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="doc-id" value="<?php echo $data['id'] ?>">
                                                        <input type="text" class="form-control remarks-field" name="remarks" value="<?php echo $data['remarks'] ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm update-btn">Update</button>
                                                        <button type="button" class="btn btn-success btn-sm save-btn" style="display: none;">Save</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel-btn" style="display: none;">Cancel</button>
                                                    </td>
                                                </tr>
                                            <?php
                                                include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="12">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
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
                                <button type="button" class="btn btn-primary" onclick="window.open('reports/reports_medcert.php?patientid=<?php echo $patientid ?>');" target="_blank">Download Medical Certificate</button>
                            <?php }
                            ?>
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
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_uploaded'])) ?></td>
                                                    <td><?php echo date("F d, Y", strtotime($data['dt_updated'])) ?></td>
                                                    <td>
                                                        <select class="form-select status-field" aria-label="Default select example" name="status" disabled>
                                                            <option value="Approved" <?php echo ($data['status'] == 'Approved') ? "selected" : ""; ?>>Approved</option>
                                                            <option value="Disapproved" <?php echo ($data['status'] == 'Disapproved') ? "selected" : ""; ?>>Disapproved</option>
                                                            <option value="Pending" <?php echo ($data['status'] == 'Pending') ? "selected" : ""; ?>>Pending</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="doc-id" value="<?php echo $data['id'] ?>">
                                                        <input type="text" class="form-control remarks-field" name="remarks" value="<?php echo $data['remarks'] ?>" disabled>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm update-btn">Update</button>
                                                        <button type="button" class="btn btn-success btn-sm save-btn" style="display: none;">Save</button>
                                                        <button type="button" class="btn btn-danger btn-sm cancel-btn" style="display: none;">Cancel</button>
                                                    </td>
                                                </tr>
                                            <?php
                                                include('modals/view-document-modal.php');
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="12">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
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
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="12">
                                            <?php
                                            include('../../includes/no-data.php');
                                            ?>
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

<script>
    $(document).ready(function() {
        $('.update-btn').click(function() {
            var $row = $(this).closest('tr');
            var id = $row.find('.doc-id').val();
            console.log("ID:", id);

            $row.find('.remarks-field').prop('disabled', false);
            $row.find('.status-field').prop('disabled', false);
            $row.find('.update-btn').hide();
            $row.find('.save-btn').show();
            $row.find('.cancel-btn').show();
        });

        $('.save-btn').click(function() {
            var $row = $(this).closest('tr');
            var remarks = $row.find('.remarks-field').val();
            var status = $row.find('.status-field').val();
            var id = $row.find('.doc-id').val(); // Get the ID again

            $.ajax({
                url: 'update-remarks.php',
                type: 'POST',
                data: {
                    remarks: remarks,
                    status: status, // Include status in the data
                    id: id
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });

            $row.find('.remarks-field').prop('disabled', true);
            $row.find('.status-field').prop('disabled', true);
            $row.find('.update-btn').show();
            $row.find('.save-btn').hide();
            $row.find('.cancel-btn').hide();
            location.reload();
        });

        $('.cancel-btn').click(function() {
            var $row = $(this).closest('tr');
            $row.find('.remarks-field').prop('disabled', true);
            $row.find('.status-field').prop('disabled', true);
            $row.find('.update-btn').show();
            $row.find('.save-btn').hide();
            $row.find('.cancel-btn').hide();
            location.reload();
        });
    });
</script>