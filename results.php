<?php
require('./include/header.php');

// Fetch all test results
$sql_results = "SELECT * FROM `persons` 
INNER JOIN `results` ON `persons`.person_id = `results`.person_id
INNER JOIN `tests` ON `tests`.test_id = `results`.test_id
LEFT JOIN `logins` ON `persons`.person_id = `logins`.person_id
LEFT JOIN `genders` ON `persons`.gender_id = `genders`.gender_id
LEFT JOIN `maritial_statuses` ON `persons`.ms_id = `maritial_statuses`.ms_id
";
$all_results = mysqli_query($conn, $sql_results);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Manage Test Results</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Results</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Test Results</h5>
                        <a href="addtestresult.php" class="btn btn-primary mb-3">Add New Result</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Lab #</th>
                                    <th scope="col">Dept #</th>
                                    <th scope="col">Test Date</th>
                                    <th scope="col">Result Date</th>
                                    <th scope="col">Test</th>
                                    <th scope="col">Result</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Marital Status</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($result = mysqli_fetch_assoc($all_results)) { ?>
                                    <tr>
                                        <td><?php echo $result['lab_no']; ?></td>
                                        <td><?php echo $result['dept_no']; ?></td>
                                        <td><?php echo $result['test_date']; ?></td>
                                        <td><?php echo $result['result_date']; ?></td>
                                        <td><?php echo $result['test_name']; ?></td>
                                        <td><?php echo $result['result_value']; ?></td>
                                        <td><?php echo $result['name']; ?></td>
                                        <td><?php echo $result['gender']; ?></td>
                                        <td><?php echo $result['status']; ?></td>
                                        <td><?php echo $result['contact']; ?></td>
                                        <td>
                                            <a href="edittestresult.php?id=<?php echo $result['result_id']; ?>" class="btn btn-warning">Edit</a>
                                            <a href="deletetestresult.php?id=<?php echo $result['result_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<?php require('./include/footer.php'); ?>