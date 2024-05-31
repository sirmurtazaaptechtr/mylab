<?php
require('./include/header.php');

if (isset($_GET['id'])) {
    $person_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete results
        $sql_delete_results = "DELETE FROM results WHERE person_id = ?";
        $stmt_delete_results = mysqli_prepare($conn, $sql_delete_results);
        mysqli_stmt_bind_param($stmt_delete_results, 'i', $person_id);
        mysqli_stmt_execute($stmt_delete_results);

        // Delete person
        $sql_delete_person = "DELETE FROM persons WHERE person_id = ?";
        $stmt_delete_person = mysqli_prepare($conn, $sql_delete_person);
        mysqli_stmt_bind_param($stmt_delete_person, 'i', $person_id);
        mysqli_stmt_execute($stmt_delete_person);

        // Commit transaction
        mysqli_commit($conn);

        echo "Record deleted successfully!";
        header("Location: results.php");
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}

require('./include/footer.php');
?>
