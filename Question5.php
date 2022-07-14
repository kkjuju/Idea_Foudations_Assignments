<!DOCTYPE html>
<html>
<head>
    <title>Question 5</title>
</head>
<body>
<?php
// Defining variables
$name = $email = $mobile = $string = $err = "";
$flag = true;

// Checking for a POST request
if (isset($_POST['submit'])) {
    $name = test_input($_POST["name"]);
    $nameValidation = alphaNumeric($_POST["name"]);
    $string = test_input($_POST["string"]);
    $stringValidation = specialChar($_POST["string"]);
    $mobile = test_input($_POST["mobile"]);
    $email = test_input($_POST["email"]);
    $emailValidation = businessEmail($_POST["email"]);
    if (!$nameValidation) {

        echo "In name only alpha numeric is allowed";

    } else if (!$stringValidation) {

        echo 'In string \'*,|\)\' mentioned special characters not allowed';


    } else if (!$emailValidation) {

        echo "Sorry! We don't accept public email addresses. Enter valid businessEmail";

    } else {
        echo "<h2>Your Input:</h2>";

        echo $name;
        echo "<br>";
        echo $email;
        echo "<br>";
        echo $mobile;
        echo "<br>";
        echo $string;
        echo "<br>";
    }
}

/**
 * Removing the redundant HTML characters if any exist.
 * @param $data
 * @return string
 */
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

/**
 * @param $data
 * @return bool
 */
function alphaNumeric($data)
{
    if (ctype_alnum($data)) {
        $flag = true;
    } else {
        $flag = false;
    }
    return $flag;
}

/**
 * @param $data
 * @return bool
 */
function specialChar($data)
{
    $regex = preg_match('/[*,|\)]/', $data);
    if ($regex) {
        $flag = false;
    } else {
        $flag = true;
    }
    return $flag;
}

/**
 * @param $data
 * @return bool
 */
function businessEmail($data)
{
    $denied_hostnames = array("gmail.com", "yahoo.com", "mail.com", "test.com", "test.in");

    foreach ($denied_hostnames as $hn) {
        if (strstr($_POST['email'], "@" . $hn)) {
            return false;
        }
    }
    return true;
}

?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label>Name:</label>
    <input type="text" name="name" required>
    <br>
    <br>
    <label>Mobile No:</label>
    <input type="number" name="mobile" required>
    <br>
    <br>
    <label>string:</label>
    <input type="text" name="string" required>
    <br>
    <br>
    <label>E-mail:</label>
    <input type="email" name="email" required>
    <br>
    <br>
    <input type="submit" name="submit"
           value="Submit">
</form>
</body>
</html>