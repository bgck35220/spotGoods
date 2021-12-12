<?php
session_start();
if(isset($_SESSION["user"])){
    header("location:admin.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.0.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<style>
  :root {
    --green: #66806A;
    --lightgreen: #7baa81;
    --yellow: #ffc107;
  }

  .login-all {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .logo {
    border-radius: 20%;
    margin-bottom: 1rem;
  }

  .login-style {
    max-width: 450px;
    box-shadow: .1rem 0.1rem 1.1rem #aaa;
    border-radius: 10px;
    overflow: hidden;
  }

  .title {
    background-color: var(--green);
    color: white;
    font-weight: 200;
    letter-spacing: .2rem;
    padding: 1rem 0;
  }

  .form-text {
    color: var(--green);
    font-weight: bold;
    font-size: 1.5rem;
    padding: 1.5rem 1.5rem 1rem 1.8rem;
    text-align: left;
  }

  .form-input {
    padding: 0px 1.5rem;
  }

  .form-input input {
    border: none;
    border-bottom: 1px solid #ccc;
    /* border-radius: 0; */
  }

  .form-input label {
    color: #777;
    border: none;
    padding: 1rem 0 0 2rem;
  }

  .form-button {
    background-color: var(--green);
    color: white;
    padding: .4rem 1.5rem;
    margin-bottom: .9rem;
    border: none;
    border-radius: .2rem;
    transition: .2s;
  }

  .form-button:hover {
    background-color: var(--lightgreen);
    /* box-shadow: 0rem .5rem .2rem rgb(226, 226, 226); */
  }

  .from-Lost {
    text-decoration: none;
    color: #777;
    font-size: .9rem;
  }

  .from-Lost:hover {
    color: var(--lightgreen);
  }
</style>

<body>
  <div class="container">
    <div class="row justify-content-center align-items-center  vh-100">
      <div class=" col-lg-7 login-all">
        <div class="mb-3">
          <!-- <img class="logo" src="https://picsum.photos/50/50/?random=1"> -->
 
        </div>
        <div class="container text-center  m-0 p-0  login-style">
          <div>
            <div class="title">LOGIN</div>
            <h1 class="form-text">管理員後台管理</h1>
            <form action="doLogin.php" method="POST">
              <div class="form-floating mb-3 form-input">
                <input type="" class="form-control" id="floatingInput" placeholder="name@example.com"
                  name="account" required>
                <label for="floatingInput">帳號 Username</label>
              </div>
              <div class="form-floating mb-5 form-input">
                <input type="password" class="form-control" id="floatingInput" placeholder="name@example.com"
                  name="password" required>
                <label for="floatingInput">密碼 Password</label>
              </div>
              <div>
                <button class="form-button" type="submit" name="action">登入</button>
                
              </div>
              <div class="mb-4">
                <!-- <a href="#" class="from-Lost">忘記密碼?</a> -->
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

</html>