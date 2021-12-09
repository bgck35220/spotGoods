<?php
require_once("pdo-connect.php");
//一定要使用者頁面登入才能用的話，加入此判斷有沒有權限，沒登入成功就無法使用功能
if (!isset($_SESSION["user"])) {  //導進來頁面 先檢查存不存在
    header("location: sign-in.php");
}

$sql = "SELECT * FROM users WHERE id=? AND valid=1";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute([$_SESSION["user"]["id"]]);
    $userExist = $stmt->rowCount();
//    echo $userExist."<br>";
//    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        :root {
            --dark: #555;
            --light: #ccc;
        }

        .cover-fit {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .menu {
            height: 580px;
        }
        .headshot-sm{
            width: 30px;
            height: 30px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid var(--light);
            display: block;
        }

        .headshot {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid var(--light);
            display: block;
        }

        .myList {
            list-style: none;
            padding: 10px 0;
        }

        .myList a {
            text-decoration: none;
            color: var(--dark);
        }

        .headshot-big {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid var(--light);
            display: block;
            margin: 0 auto;
        }

        .border-left {
            border-left: 1px solid var(--light);
        }
    </style>

</head>
<body>

<header class="bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="index.php">team01</a>
                    <div class="d-flex justify-content-end align-items-center">
                        <a class="headshot-sm me-2" href="dashboard.php">
                            <?php if($_SESSION["user"]["headshots"]==NULL):?>
                                <img class="cover-fit" src="./upload/user.png" alt="user.png">
                            <?php else:?>
                                <img class="cover-fit" src="./upload/<?= $_SESSION["user"]["headshots"] ?>"
                                     alt="<?= $_SESSION["user"]["headshots"] ?>">
                            <?php endif; ?>
                        </a>
                        <?= $_SESSION["user"]["account"] ?> <a href="logOut.php" class="btn btn-info text-white ms-4">登出</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>


<div class="container px-4 mt-4">
    <div class="row g-3 menu">
        <div class="col-md-3">
            <div class="p-5 bg-light menu">
                <figure class="d-flex align-items-center">
                    <a class="headshot" href="dashboard.php">
                        <?php if($_SESSION["user"]["headshots"]==NULL):?>
                        <img class="cover-fit" src="./upload/user.png" alt="user.png">
                        <?php else:?>
                        <img class="cover-fit" src="./upload/<?= $_SESSION["user"]["headshots"] ?>"
                             alt="<?= $_SESSION["user"]["headshots"] ?>">
                        <?php endif; ?>
                    </a>
                    <p class="mb-0 ms-3 text-secondary"><?= $_SESSION["user"]["account"] ?></p>
                </figure>
                <ul class="p-0 mt-4">
                    <li class="myList"><a href="dashboard.php">修改個人資訊</a></li>
                    <li class="myList"><a href="">我的訂單</a></li>
                    <li class="myList"><a href="">兌換券</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="p-5 bg-light menu">
                修改個人資訊
                <hr>
                <?php if ($userExist === 0): ?>
                    使用者不存在
                <?php else:
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <form action="doUpdate.php" method="post" class="mt-3" enctype="multipart/form-data">
                        <div class="row gt-3">
                            <div class="col-lg-7 pe-5 mt-3">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>"> <!--隱藏-->
                                <div class="mb-3 d-flex align-items-center text-nowrap">
                                    <label for="account" class="me-4 col-sm-2">使用者帳號</label>
                                    <input id="account" type="text" name="account" class="form-control-plaintext"
                                           value="   <?= $row["account"] ?>" readonly>
                                    <!--只讀取不能更動-->
                                </div>
                                <div class="mb-3 d-flex align-items-center text-nowrap">
                                    <label for="name" class="me-4 col-sm-2">姓名</label>
                                    <input id="name" type="text" name="name" class="form-control"
                                           value="<?= $row["name"] ?>">
                                </div>
                                <div class="mb-3 d-flex align-items-center text-nowrap">
                                    <label for="email" class="me-4 col-sm-2">Email</label>
                                    <input id="email" type="text" name="email" class="form-control"
                                           value="<?= $row["email"] ?>">
                                </div>
                                <div class="mb-3 d-flex align-items-center text-nowrap">
                                    <label for="phone" class="me-4 col-sm-2">手機號碼</label>
                                    <input id="phone" type="text" name="phone" class="form-control"
                                           value="0<?= $row["phone"] ?>">
                                </div>
                                <div class="mb-3 d-flex align-items-center text-nowrap">
                                    <label for="password" class="me-4 col-sm-2">密碼</label>
                                    <input id="password" type="password" name="password" class="form-control"
                                           value="<?= $_SESSION["user"]["password"] ?>">
                                </div>
                                <div class="mb-3 d-flex align-items-center text-nowrap">
                                    <label for="address" class="me-4 col-sm-2">地址</label>
                                    <input id="address" type="text" name="address" class="form-control"
                                           value="<?= $row["address"] ?>">
                                </div>
                                <button class="btn btn-secondary" type="submit">儲存</button>
                            </div>
                            <div class="col-lg-5 px-5 mt-4 border-left">
                                <div class="headshot-big d-block">
                                    <?php if($row["headshots"]==NULL):?>
                                    <img class="cover-fit" src="./upload/user.png" alt="user.png">
                                    <?php else: ?>
                                    <img class="cover-fit" src="./upload/<?= $row["headshots"] ?>" alt="<?= $row["headshots"] ?>">
                                    <?php endif; ?>
                                </div>
                                <input class="mt-3 form-control form-control-sm" type="file" name="myFile" accept=".jpg,.jpeg,.png">
                                <div class="text-muted mt-3">檔案大小: 最大 1 MB</div>
                                <div class="text-muted">檔案限制: .JPG .JPEG, .PNG</div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script>
    //預覽上傳的圖片
    // $('input[type="file"]').prop('myFile',e.originalEvent.dataTransfer.files);
</script>


</body>
</html>