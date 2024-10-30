<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

  <div class="container">
    <h2>Registration Form</h2>
    <form method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"
          onkeyup="checkEmail()">
        <span class="text-danger" id="email-danger-span"></span>
        <span class="text-success" id="email-success-span"></span>
      </div>

      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="pswd"
          onkeyup="checkPwd()">
        <span class="text-danger" id="pwd-danger-span"></span>
        <span class="text-success" id="pwd-success-span"></span>

        <!-- Individual spans for each condition -->
        <span class="text-danger" id="upper-case-span"></span>
        <span class="text-danger" id="lower-case-span"></span>
        <span class="text-danger" id="digit-span"></span>
        <span class="text-danger" id="special-char-span"></span>
        <span class="text-danger" id="length-span"></span>
      </div>

      <button type="submit" class="btn btn-primary" name="SAVE" id="submit">Submit</button>
    </form>
  </div>

  <script>
    var button = document.getElementById("submit");
    button.disabled = true;
    var emailValid = false;
    var passwordValid = false;

    function checkEmail() {
        var email = document.getElementById("email").value;
        var valids = ["gmail.com", "yahoo.com", "outlook.com"];
        var emailDanger = document.getElementById("email-danger-span");
        var emailSuccess = document.getElementById("email-success-span");

        if (email.indexOf('@') != -1) {
            var domain = email.split('@')[1];
            if (valids.includes(domain)) {
                emailSuccess.innerHTML = "Valid email";
                emailDanger.innerHTML = "";
                emailValid = true;
            } else {
                emailDanger.innerHTML = "Invalid email";
                emailSuccess.innerHTML = "";
                emailValid = false;
            }
        } else {
            emailDanger.innerHTML = "";
            emailSuccess.innerHTML = "";
            emailValid = false;
        }
        checkFormCompletion();
    }

    function checkPwd() {
        var pwd = document.getElementById("password").value;

        // Regular expressions for each condition
        var specialChar = /[!@#$%^&*]/;
        var upperCase = /[A-Z]/;
        var lowerCase = /[a-z]/;
        var digit = /[0-9]/;

        // Individual condition spans
        var upperCaseSpan = document.getElementById("upper-case-span");
        var lowerCaseSpan = document.getElementById("lower-case-span");
        var digitSpan = document.getElementById("digit-span");
        var specialCharSpan = document.getElementById("special-char-span");
        var lengthSpan = document.getElementById("length-span");

        // Check each condition and display feedback
        if (pwd.length >= 8) {
            lengthSpan.innerHTML = "";
        } else {
            lengthSpan.innerHTML = " & at least 8 characters.";
            passwordValid = false;
        }

        if (specialChar.test(pwd)) {
            specialCharSpan.innerHTML = "";
        } else {
            specialCharSpan.innerHTML = " & one special character";
            passwordValid = false;
        }

        if (upperCase.test(pwd)) {
            upperCaseSpan.innerHTML = "";
        } else {
            upperCaseSpan.innerHTML = "Must include one uppercase letter";
            passwordValid = false;
        }

        if (lowerCase.test(pwd)) {
            lowerCaseSpan.innerHTML = "";
        } else {
            lowerCaseSpan.innerHTML = " & one lowercase letter";
            passwordValid = false;
        }

        if (digit.test(pwd)) {
            digitSpan.innerHTML = "";
        } else {
            digitSpan.innerHTML = " & one digit";
            passwordValid = false;
        }

        // Enable password success span if all conditions are met
        if (pwd.length >= 8 && specialChar.test(pwd) && upperCase.test(pwd) && lowerCase.test(pwd) && digit.test(pwd)) {
            document.getElementById("pwd-danger-span").innerHTML = "";
            document.getElementById("pwd-success-span").innerHTML = "Your password is secure.";
            passwordValid = true;
        } else {
            document.getElementById("pwd-success-span").innerHTML = "";
            passwordValid = false;
        }
        checkFormCompletion();
    }

    // Enable the button if both email and password are valid
    function checkFormCompletion() {
        button.disabled = !(emailValid && passwordValid);
    }
</script>

</body>

</html>


<?php

if (isset($_POST['SAVE'])) {
  $e = $_POST["email"];
  $p = $_POST["pswd"];

  $q = "INSERT INTO reg(email,password) VALUES ('" . $e . "','" . $p . "')";

  if (mysqli_query($conn, $q)) {
    echo 'success';
  }
}

?>