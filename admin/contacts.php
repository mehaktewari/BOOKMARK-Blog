<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php
date_default_timezone_set('Asia/Kolkata');

$full_name = $email_id = $message = $subject ='';


$users = [];
$result = mysqli_query($conn, "SELECT id, full_name, email_id, subject , message,send_on FROM contacts ORDER BY send_on ASC ");
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>
<body class="">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <?php include("include/navBar.php"); ?>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="m-b-10">CONTACT</h5>
                            </div>
                            <div class="card">
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="contactTable">
                                            <thead >
                                                <tr>
                                                    <th>S.NO</th>
                                                    <th>Full Name</th>
                                                    <th>Email Address</th>
                                                    <th>Subject</th>
                                                    <th>message</th>
                                                    <th>CREATED</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($users)): ?>
                                                    <?php foreach ($users as $index => $user): ?>
                                                        <tr>
                                                            <td><?= $index + 1 ?></td>
                                                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                                                            <td><?= htmlspecialchars($user['email_id']) ?></td>
                                                            <td><?= htmlspecialchars($user['subject']) ?></td>
                                                            <td><?php 
                                                            $shortmess = $user['message'];
                                                            
                                                            echo $message = substr($shortmess, 0, 50) . '...';

                                                            ?></td>
                                                            <td><?= date('d-m-Y h:i A', strtotime($user['send_on'])) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No Contacts found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
    <?php include("include/adminFooter.php"); ?>
</body>
<style>
    #contactTable thead th {
        background-color: #343a40 !important;
        color: white !important;
    }
</style>
<script>
    $(document).ready(function() {
        $('#contactTable').DataTable({
            paging: true,
            pageLength: 10,
            lengthChange: false,
            ordering: false,
            info: true,
            searching: true,
        });
    });
</script>