<?php
error_reporting(0);
session_start();
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
     http_response_code(404);
     die();
}else{
    
    // Modified: Added isset($_POST['captcha']) to the main condition
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['captcha'])) { 
    include("assets/config.php");

    if ($conn) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $user_captcha = mysqli_real_escape_string($conn, $_POST['captcha']); // Get user entered captcha

        // CAPTCHA verification logic
        if (!isset($_SESSION['captcha']) || strtolower($user_captcha) !== strtolower($_SESSION['captcha'])) {
            $response['status'] = 'error';
            $response['message'] = 'CAPTCHA verification failed!';
            echo json_encode($response);
            exit(); // Stop execution if CAPTCHA is incorrect
        }

        // Unset CAPTCHA after successful verification to prevent reuse
        unset($_SESSION['captcha']);

        $sql = "SELECT id, role, password_hash FROM users WHERE email=?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    if (password_verify($password, $row['password_hash'])) {
                        $_SESSION['uid'] = $row['id'];
                        $response['status'] = 'success';
                        $response['role'] = $row['role'];
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = 'Invalid email or password!';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Invalid email or password!';
                }

                mysqli_stmt_close($stmt);
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error fetching result';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error preparing statement';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Database connection error';
    }

    
} else {
    // Modified: Updated message to include captcha field
    $response['status'] = 'error';
    $response['message'] = 'All fields (email, password, captcha) are required';
}

// Return the response
echo json_encode($response);
    
}

?>