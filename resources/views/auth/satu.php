<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #def7e5;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 90%;
            max-width: 1250px;
            height: 80vh;
            background: white;
            border-radius: 10px;
            border: 2px solid #445054;
        }

        .images img {
            width: 500px;
            margin: 30px;
        }

        .login {
            width: 25%;
            background-color: white;
            border: 2px solid #445054;
            border-radius: 10px;
        }

        .login h3 {
            text-align: center;
        }

        .login form {
            padding: 10px 0px 30px 40px;
        }

        input[type=text] {
            margin-top: 5px;
            margin-bottom: 15px;
            
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="images">
            <img src="images/login1.png" alt="">
        </div>
        <div class="login">
            <h3>Login</h3>
            <form action="">
                <label for="email">Email</label><br>
                <input type="text" id="email" name="email" placeholder="Masukkan Email">
                <br>

                <label for="password">Password</label><br>
                <input type="text" id="password" name="password" placeholder="Masukkan Password">
                <br>

                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>

</html>