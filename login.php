<?php
error_reporting(0);
session_start();

if (isset($_SESSION['uid'])) {
  $uid = $_SESSION['uid'];
  include('assets/config.php');

  $query = "SELECT `role` FROM `users` WHERE `users`.`id`=?";
  $stmt = mysqli_prepare($conn, $query);

  mysqli_stmt_bind_param($stmt, "s", $uid);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_array($result);

  mysqli_stmt_close($stmt);

  if ($row && isset($row['role'])) {
    if ($row['role'] == "admin") {
      header('Location: admin_panel/dashboard.php');
      exit();
    } else if ($row['role'] == "owner") {
      header('Location: owner_panel/index.php');
      exit();
    } else if ($row['role'] == "teacher") {
      header('Location: teacher_panel/dashboard.php');
      exit();
    } else if ($row['role'] == "student") {
      header('Location: student_panel/index.php');
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>School Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="login-form-style.css">
  <link rel="icon" type="image/x-icon" href="images/2.png">
</head>

<body>
  <div class="container">
    <div class="cover">
      <div class="front">
        <img src="images/log.jpg" alt=""><br>
        <div class="text">
          <span class="text-1" style="font-size:1.6rem;font-weight:bold;margin-bottom:30px;">SCHOOL MANAGEMENT SYSTEM<br></span><br>
      
          <img src="images/2.png" alt="Website Logo" class="small-a" display:flex; style="margin-bottom: 15px;height: 45px; width: 45px; ">
        </style>
          <span class="text-2" style="margin-right:23px;">Service Before Self</span>
        </div>
      </div>

    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">

          <div class="title" id='board-title' style="margin-top:25px;">Login</div>

          <div class="alert-box">
            <div class="alert alert-danger text-center mt-3" role="alert" id="error-msg">

            </div>
          </div>

          <form action="index.php" id="login-form" method="post">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email" id='loginEmail' required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" id="password" required>
                <i class="bi bi-eye-fill" style="margin-left:405px;" id="togglePassword"></i>
              </div>
              <div class="input-box captcha-box">
                <div style="display:inline; align-items: center; justify-content: space-between; width:370px;">
                  <img src="generate_captcha.php" alt="CAPTCHA Image" id="captchaImage" style="height: 55px; border: 1px solid #ccc; border-radius: 5px; flex-grow: 0; margin-right: 0px;font-size;1rem;margin-top:50px;">
                  <button type="button" id="refreshCaptcha" class="btn btn-secondary" style="padding: 8px 8px; font-size: 0.8em;margin-top:10px;margin-right:5;">Refresh</button>
                </div>
                <input type="text" name="captcha" placeholder="Enter CAPTCHA" id="captchaInput" required style="margin-top: 10px;margin-left:30px;">
              </div>
              <div class="text"><a id="forgotpassword" style="margin-right:10px;">Forgot password?</a></div>
              <div class="button input-box">
                <button type="submit" class="btn" style="margin-top:0px;margin-right:60px;">
                 Login
                </button>
              </div>
            </div>
          </form>


          <form action="index.php" id="forgotPassword-form" method="post" style="display:none;">

            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="forgotEmail" placeholder="Enter your email" required>
              </div>

              <div class="text" style="margin-bottom: 20px;margin-left:260px;display:flex">
                <a id="backToLogin">Back to login?</a>
              </div>

              <div class="button input-box">
                <button type="submit" id='sendCodeBtn'>
                  Send Code
                </button>
              </div>

            </div>
          </form>

          <form id="otpVarification-form" method="post" style="display:none;">

            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" value="some value" id="otpDisabledEmail">
              </div>

              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="text" name="otp" placeholder="Enter code" id="otpCode" required>
              </div>

              <div class="text" style="margin-bottom: 20px;display:flex">
                <a id="backToforgotPasswordForm">Back</a>
                <a id="resendOTP" style='margin-left: auto;'>Resend OTP?</a>
              </div>

              <div class="button input-box">
                <button type="submit" id='verifyCodeBtn'>
                  Verify Code
                </button>
              </div>

            </div>
          </form>


          <form id="createNewPassword-form" method="post" style="display:none;">

            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="newpassword" id='newpassword' placeholder='Enter new password' required>
              </div>

              <div class="invalid-feedback" id='weakPasswordFeedback'></div>

              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirmpassword" id='confirmpassword' placeholder='Confirm password' required>
              </div>

              <div class="invalid-feedback" id='passwordNotSame'>
                New password and confirm password are not same!
              </div>

              <div class="form-check mt-3 ">
                <input class="form-check-input" type="checkbox" value="" id="showPasswords">
                <label class="form-check-label" for="showPasswords" id='showPasswordLabel'>
                  Show password
                </label>
              </div>

              <div class="button input-box">
                <button type="submit" id='changePasswordBtn'>
                  Change Password
                </button>
              </div>

            </div>
          </form>

          </div>

      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const captchaImage = document.getElementById('captchaImage');
      const refreshCaptchaBtn = document.getElementById('refreshCaptcha');

      function refreshCaptcha() {
        captchaImage.src = 'generate_captcha.php?' + new Date().getTime();
      }

      if (refreshCaptchaBtn) {
        refreshCaptchaBtn.addEventListener('click', refreshCaptcha);
      }

      // Initial CAPTCHA load
      refreshCaptcha();
    });
  </script>
  <script src="index.js"></script>


</body>

</html>