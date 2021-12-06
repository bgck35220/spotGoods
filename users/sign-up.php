<!doctype html>
<html lang="en">
<head>
    <title>Sign up</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
<header class="bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="index.php">team01</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form action="doSignUp.php" method="post">
                <h2 class="text-center">帳號註冊</h2>
                <div class="mb-3">
                    <label for="account">帳號</label>
                    <input id="account" type="text" name="account" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="name">姓名</label>
                    <input id="name" type="text" name="name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email">email</label>
                    <input id="email" type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password">密碼</label>
                    <input id="password" type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="repassword">確認密碼</label>
                    <input id="repassword" type="password" name="repassword" class="form-control">
                </div>
                <button class="btn btn-secondary" type="submit">送出</button>
            </form>
        </div>
    </div>
</div>


</body>
</html>