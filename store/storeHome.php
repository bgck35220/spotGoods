<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- 瀏覽器小圖示 -->
    <link rel="icon" href="../images/storeIcon.ico" type="image/x-icon" />
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <!-- icons cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- swiper css link  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <!-- css -->
    <link rel="stylesheet" href="css/storeStyle.css">

    <title>storegoods</title>
</head>

<body>

<!-- 導覽列 -->
<header class="header">
    <!-- LOGO圖示 -->
    <a href="storeHome.html" class="logo"><i class="fas fa-store"></i> Logo</a>
    <!-- 地圖 -->
    <a href="#" class="logo-map"><i class="fas fa-map-marker-alt"></i> Map</a>
    <!-- 搜尋列 -->
    <form action="" class="search-form">
        <input type="search" id="search-box" placeholder="search here...">
        <label for="search-box" class="fas fa-search"></label>
    </form>
    <!-- 菜單、個人資料、最愛店家、購物車 -->
    <div class="icons">
        <div id="menu-btn" class="fas fa-bars"></div>
        <div id="search-btn" class="fas fa-search"></div>
        <a href="login.html" class="fas fa-user"></a>
        <a href="#" class="fas fa-heart"></a>
        <a href="cart.html" class="fas fa-shopping-cart">
            <!-- 顯示購物車有多少商品 -->
            <span class="badge lblCartCount"> 5 </span>
        </a>
    </div>
</header>

<!-- 商品種類 -->
<section>
    <div class="commodity-sort">
        <div class="h-20"></div>
        <nav class="commodity-sort-nav">
            <ul class="commodity-sort-ul">
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/discount.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                <div class="www">
                                    優惠
                                </div>
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/freshGroceries.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                生鮮雜貨
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/convenienceStore.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                便利商店
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                藥局
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                百貨商場
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                嚴選餐廳
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                珍珠奶茶
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                台灣美食
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                甜點
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                咖啡和茶
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                中式美食
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                義大利美食
                            </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="commodity-sort-a">
                        <div class="commodity-sort-img-size">
                            <img src="images/deals.png" alt="" class="commodity-sort-img">
                        </div>
                        <span class="commodity-sort-text">
                                健康飲食
                            </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</section>

<!-- 幻燈片 -->
<section class="home">
    <div class="swiper home-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/food-1.jpg" alt="">
                </div>
                <div class="content">
                    <span>upto 50% off</span>
                    <h3>smartphones</h3>
                    <a href="#" class="btn">shop now</a>
                </div>
            </div>
            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/food-2.jpg" alt="">
                </div>
                <div class="content">
                    <span>upto 50% off</span>
                    <h3>smartwatch</h3>
                    <a href="#" class="btn">shop now</a>
                </div>
            </div>
            <div class="swiper-slide slide">
                <div class="image">
                    <img src="images/food-3.jpg" alt="">
                </div>
                <div class="content">
                    <span>upto 50% off</span>
                    <h3>headphones</h3>
                    <a href="#" class="btn">shop now</a>
                </div>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>


<div class="container">
    <div class="row">
        <aside class="col-lg-3">
            <div class="sticky-top">
                <div class="mb-2">
                    <a role="button" class="btn btn-primary" href="product-list.php">回列表</a>
                </div>
                <div class="mb-2">
                    <h3>產品分類</h3>
                    <ul class="list-unstyled category-list">
                        <?php foreach ($categoryArr as $key => $value): ?>
                            <li class="<?php if (isset($cate) && $key == $cate) echo "active" ?>"><a
                                        href="product-list.php?cate=<?= $key ?>"><?= $value ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="mb-2">
                    <label for="">價錢篩選</label>
                    <form action="product-list.php" method="get">
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control me-2 text-end" name="minPrice"
                                   value="<?= $minPrice ?>">
                            <div class="me-2">~</div>
                            <input type="number" class="form-control me-2 text-end" name="maxPrice"
                                   value="<?= $maxPrice ?>">
                            <button type="submit" class="btn btn-primary text-nowrap">篩選</button>
                        </div>
                    </form>
                </div>
                <div class="mb-2">
                    <label for="">搜尋</label>
                    <form action="product-list.php" method="get">
                        <div class="d-flex align-items-center">
                            <input type="search" class="form-control me-2" name="s"
                                   value="<?php if (isset($search)) echo $search; ?>">
                            <button type="submit" class="btn btn-primary text-nowrap">搜尋</button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>
        <main class="col-lg-9">
            <?php if ($productCount > 0): ?>
                <div class="py-2 d-flex justify-content-end order-block">
                    <div>排序
                        <a class="<?php if (isset($order) && $order === "nameDesc") echo "active" ?>"
                           href="product-list.php?order=nameDesc">名稱 ↓</a>
                        <a class="<?php if (isset($order) && $order === "nameAsc") echo "active" ?>"
                           href="product-list.php?order=nameAsc">名稱 ↑</a>
                        <a class="<?php if (isset($order) && $order === "priceDesc") echo "active" ?>"
                           href="product-list.php?order=priceDesc">價錢 ↓</a>
                        <a class="<?php if (isset($order) && $order === "priceAsc") echo "active" ?>"
                           href="product-list.php?order=priceAsc">價錢 ↑</a>
                    </div>
                </div><!--order-block-->
                <?php if (isset($p)): ?>
                    <div class="py-2">第 <?= $startNo ?>~<?= $endNo ?> 筆, 共 <?= $totalProductCount ?> 筆</div>
                <?php else: ?>
                    <div class="py-2">共 <?= $productCount ?> 筆</div>
                <?php endif; ?>
                <div class="row product-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-6 col-lg-4 mb-3">

                            <div class="card">
                                <a href="product.php?id=<?= $row["id"] ?>">
                                    <figure class="m-0 ratio ratio-4x3">
                                        <div>
                                            <img class="cover-fit" src="../images/<?= $row["img"] ?>"
                                                 alt="<?= $row["name"] ?>">
                                        </div>
                                    </figure>
                                </a>
                                <div class="py-2 px-3">
                                    <div class="pb-2">
                                        <a class="badge bg-info text-white"
                                           href="product-list.php?cate=<?= $row["category_id"] ?>"><?= $categoryArr[$row["category_id"]] ?></a>
                                    </div>
                                    <h3 class="" title="<?= $row["name"] ?>"><a
                                                href="product.php?id=<?= $row["id"] ?>"><?= $row["name"] ?></a></h3>
                                    <div>$<?= $row["price"] ?></div>
                                </div>
                            </div><!--card-->

                        </div>
                    <?php endwhile; ?>
                    <?php if (isset($p)): ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $pageCount; $i++): ?>
                                    <li class="page-item <?php if ($p == $i) echo "active" ?>"><a class="page-link"
                                                                                                  href="product-list.php?p=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                沒有資料
            <?php endif; ?>
        </main>
    </div>

</div>


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<!-- swiper js link      -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<script src="js/storeScript.js"></script>
</body>

</html>