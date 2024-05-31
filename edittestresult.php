<?php
require('./include/header.php');

// Fetch gender options
$sql_gender = "SELECT * FROM `genders`";
$genders = mysqli_query($conn, $sql_gender);

// Fetch marital status options
$sql_ms = "SELECT * FROM `maritial_statuses`";
$maritial_statuses = mysqli_query($conn, $sql_ms);

// Initialize variables
$person = $results = [];

if (isset($_GET['id'])) {
    $person_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch person details
    $sql_person = "SELECT * FROM persons WHERE person_id = $person_id";
    $person_result = mysqli_query($conn, $sql_person);
    $person = mysqli_fetch_assoc($person_result);

    // Fetch test results
    $sql_test_results = "SELECT * FROM results WHERE person_id = $person_id";
    $results_result = mysqli_query($conn, $sql_test_results);
    while ($row = mysqli_fetch_assoc($results_result)) {
        $results[$row['test_id']] = $row['result_value'];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lab_no = mysqli_real_escape_string($conn, $_POST['lab_no']);
    $dept_no = mysqli_real_escape_string($conn, $_POST['dept_no']);
    $test_date = mysqli_real_escape_string($conn, $_POST['test_date']);
    $result_date = mysqli_real_escape_string($conn, $_POST['result_date']);
    $result_desc = mysqli_real_escape_string($conn, $_POST['result_desc']);
    $test_values = [];

    // Test results
    $tests = ['RBC', 'WBC', 'HB', 'PCV', 'MCV', 'MCH', 'MCHC', 'Platelets'];

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        if (isset($_POST['person_id'])) {
            // Update person and test results
            $person_id = mysqli_real_escape_string($conn, $_POST['person_id']);

            // Update person
            $sql_update_person = "UPDATE persons SET name=?, dob=?, gender_id=?, ms_id=?, contact=? WHERE person_id=?";
            $stmt_update_person = mysqli_prepare($conn, $sql_update_person);
            mysqli_stmt_bind_param($stmt_update_person, 'ssissi', $_POST['name'], $_POST['dob'], $_POST['gender'], $_POST['maritial_status'], $_POST['contact'], $person_id);
            mysqli_stmt_execute($stmt_update_person);

            // Delete existing results
            $sql_delete_results = "DELETE FROM results WHERE person_id=?";
            $stmt_delete_results = mysqli_prepare($conn, $sql_delete_results);
            mysqli_stmt_bind_param($stmt_delete_results, 'i', $person_id);
            mysqli_stmt_execute($stmt_delete_results);

            // Insert new test results
            foreach ($tests as $test_name) {
                $test_values[] = mysqli_real_escape_string($conn, $_POST[$test_name]);
            }

            // Fetch the test_ids
            $test_ids = [];
            $sql_test_ids = "SELECT test_id FROM tests";
            $result_test_ids = mysqli_query($conn, $sql_test_ids);
            while ($row = mysqli_fetch_assoc($result_test_ids)) {
                $test_ids[] = $row['test_id'];
            }

            // Insert test results using last inserted person_id
            $sql_insert_results = "INSERT INTO results (lab_no, dept_no, test_date, result_date, result_desc, test_id, result_value, person_id)
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert_results = mysqli_prepare($conn, $sql_insert_results);
            mysqli_stmt_bind_param($stmt_insert_results, 'sssssssi', $lab_no, $dept_no, $test_date, $result_date, $result_desc, $test_id, $test_value, $person_id);

            foreach ($test_ids as $index => $test_id) {
                $test_value = $test_values[$index];
                mysqli_stmt_execute($stmt_insert_results);
            }

            // Commit transaction
            mysqli_commit($conn);
            echo "Record updated successfully!";
        }
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Test Result</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="index.php">Results</a></li>
                <li class="breadcrumb-item active">Edit Test Results</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Test Result</h5>

                        <!-- General Form Elements -->
                        <form method="POST" action="">
                            <input type="hidden" name="person_id" value="<?php echo isset($person['person_id']) ? $person['person_id'] : ''; ?>">
                            <!-- Form fields for updating a result -->
                            <!-- Include form fields from the original form here -->
                            <div class="row mb-3">
                                <label for="lab_no" class="col-sm-2 col-form-label">Lab #</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="lab_no" id="lab_no" value="<?php echo isset($person['lab_no']) ? $person['lab_no'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="dept_no" class="col-sm-2 col-form-label">Dept #</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="dept_no" id="dept_no" value="<?php echo isset($person['dept_no']) ? $person['dept_no'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="test_date" class="col-sm-2 col-form-label">Test Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="test_date" id="test_date" value="<?php echo isset($person['test_date']) ? $person['test_date'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="result_date" class="col-sm-2 col-form-label">Result Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="result_date" id="result_date" value="<?php echo isset($person['result_date']) ? $person['result_date'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo isset($person['name']) ? $person['name'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="dob" class="col-sm-2 col-form-label">Date of Birth</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="dob" id="dob" value="<?php echo isset($person['dob']) ? $person['dob'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Gender</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="gender" required>
                                        <?php while ($gender = mysqli_fetch_assoc($genders)) { ?>
                                            <option value="<?php echo $gender['gender_id']; ?>" <?php echo (isset($person['gender_id']) && $person['gender_id'] == $gender['gender_id']) ? 'selected' : ''; ?>>
                                                <?php echo $gender['gender_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Marital Status</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="maritial_status" required>
                                        <?php while ($ms = mysqli_fetch_assoc($maritial_statuses)) { ?>
                                            <option value="<?php echo $ms['ms_id']; ?>" <?php echo (isset($person['ms_id']) && $person['ms_id'] == $ms['ms_id']) ? 'selected' : ''; ?>>
                                                <?php echo $ms['ms_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="contact" id="contact" value="<?php echo isset($person['contact']) ? $person['contact'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="RBC" class="col-sm-2 col-form-label">RBC</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="RBC" id="RBC" value="<?php echo isset($results[1]) ? $results[1] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="WBC" class="col-sm-2 col-form-label">WBC</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="WBC" id="WBC" value="<?php echo isset($results[2]) ? $results[2] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="HB" class="col-sm-2 col-form-label">HB</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="HB" id="HB" value="<?php echo isset($results[3]) ? $results[3] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="PCV" class="col-sm-2 col-form-label">PCV</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="PCV" id="PCV" value="<?php echo isset($results[4]) ? $results[4] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="MCV" class="col-sm-2 col-form-label">MCV</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="MCV" id="MCV" value="<?php echo isset($results[5]) ? $results[5] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="MCH" class="col-sm-2 col-form-label">MCH</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="MCH" id="MCH" value="<?php echo isset($results[6]) ? $results[6] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="MCHC" class="col-sm-2 col-form-label">MCHC</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="MCHC" id="MCHC" value="<?php echo isset($results[7]) ? $results[7] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Platelets" class="col-sm-2 col-form-label">Platelets</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="Platelets" id="Platelets" value="<?php echo isset($results[8]) ? $results[8] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="result_desc" class="col-sm-2 col-form-label">Result Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="result_desc" id="result_desc" rows="3" required><?php echo isset($person['result_desc']) ? $person['result_desc'] : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form><!-- End General Form Elements -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php require('./include/footer.php'); ?>
