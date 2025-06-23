<footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <!-- Insert website logo -->
          <img src="images/2.jpg" alt="Website Logo" style="margin-bottom: 15px;">
          <!-- Display visitor count -->
          <p style="font-weight:600;font-size:1.2rem;">SCHOOL MANAGEMENT SYSTEM</p>
          <!-- Display time zone -->
          <p>DPS Damanjodi,Sector-3 NALCO Township,Damanjodi,ODISHA<br>PinCode-763008,District-Koraput</br></p>
          <p></p>
        </div>
        <div class="col-md-4">
          <p style="margin-top: 15px;font-weight:600">Time Zone: <?php 
                        date_default_timezone_set('Asia/Kolkata');
                        $current_time = date('D M d Y H:i:s \G\M\TO (T)');
                      
                        echo "<p>$current_time</p>";
                        ?></p>
        </div>
        <div class="col-md-4">
          <div class="footer-links">
           
          <p style="margin-top: 15px;font-weight:600">Follow Us On:</p>
          </div>
          <div class="social-icons" style="margin-top: 15px">
            <a href="https://www.facebook.com/profile.php?id=61574525621512"><i class="fab fa-facebook-f facebook"></i></a>
            <a href="https://x.com/DPSTapi"><i class="fa-brands fa-x-twitter twitter"></i></a>
            <a href="https://www.instagram.com/dpsdamanjodi50/"><i class="fab fa-instagram instagram"></i></a>
            <!-- <a href="#"><i class="fab fa-linkedin-in linked-in"></i></a> -->
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-12">
          <p style="font-size:1.3rem;">&copy; <?php echo date('Y'); ?> <a href="http://localhost/school-management-system/" style="font-weight:600;">DPS DAMANJODI</a>. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>



  <script src="https://kit.fontawesome.com/a81368914c.js"></script>
  <script src="js/bootstrap.bundle.js"></script>
  <script src="./shared/app.js"></script>
</body>

</html>
