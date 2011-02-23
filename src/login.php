<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>KonfeWeb System</title>
        <link rel="stylesheet" type="text/css" href="css/feedback.css" />
    </head>
    <body>
        <p class="emphasis"><a href="adminindex.php">Back to Start</a></p>
        <p class="emphasis"><a href="admin.php">Back to Admin</a></p>

        <h1>Login</h1>
        <form action="submitlogin.php" method="post">
            <label for="user">User</label> <br />
            <input type="text" name="user" /> <br />
            <label for="pass">Password</label> <br />
            <input type="text" name="pass" /> <br />
            <br />
            <input type="submit" value="Login" />
        </form>
        <br />

    </body>
</html>
