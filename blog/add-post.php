<?php
require_once("../pdo-connect.php");

$sql = "SELECT * FROM blog WHERE valid = 1 ORDER BY id DESC LIMIT 1";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

//blog_category
$sqlBlogCategory = "SELECT * FROM blog_category";
$stmtBlogCategory = $db_host->prepare($sqlBlogCategory);
try {
    $stmtBlogCategory->execute();
    $rowsBlogCategory = $stmtBlogCategory->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Blog｜新增文章</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../css/blog.css?<?= time() ?>">
</head>
<body>
<div class="container py-5">
    <?php if (isset($_SESSION["img_error_msg"])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION["img_error_msg"] ?>
        </div>
    <?php elseif (isset($_SESSION["img_success_msg"])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION["img_msg"] ?>
        </div>
    <?php endif;
    unset($_SESSION["img_msg"]);
    unset($_SESSION["img_error_msg"]);
    ?>
    <h1>新增文章</h1>
    <div class="py-3 d-flex justify-content-start">
        <a href="blog.php" role="button" class="btn btn-primary">
            <i class="fas fa-chevron-left fa-fw"></i>
            返回列表
        </a>
    </div>
    <form action="doAdd.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="blogTitle" class="form-label">標題</label>
            <input type="text" class="form-control" id="blogTitle" placeholder="輸入文章標題" name="title"
                   value="<?php if (isset($_SESSION["title"])) echo $_SESSION["title"] ?>">
        </div>
        <div class="mb-3">
            <label for="blogAuthor" class="form-label">作者</label>
            <input type="text" class="form-control" id="blogAuthor" placeholder="輸入文章作者" name="author_name"
                   value="<?php if (isset($_SESSION["author_name"])) echo $_SESSION["author_name"] ?>">
        </div>
        <div class=" blog-img mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="blogImgFile" class="form-label">圖片</label>
                <?php if (isset($_SESSION["img_path"])): ?>
                    <button type="submit" name="remove" class="btn btn-outline-danger mb-2">移除</button>
                <?php endif; ?>
            </div>
            <?php if (!isset($_SESSION["img_path"])): ?>
                <span class="d-block mb-2 text-muted fst-italic">上傳檔案</span>
                <input type="file" class="form-control" id="blogImgFile" name="imageFile">
                <span class="d-block my-2 text-muted fst-italic">或輸入連結</span>
                <input type="text" class="form-control" id="blogImgLink" placeholder="輸入圖片網址"
                       name="image">
                <button type="submit" name="upload" class="btn btn-primary mt-2">上傳</button>
            <?php endif; ?>
            <?php if (isset($_SESSION["img_path"])):
                $image = $_SESSION["img_path"];
                ?>
                <input type="hidden" value="<?= $image ?>"
                       name="image_path">
                <div class="blog-preview border rounded p-2">
                    <img src="<?php
                    if (substr($image, 0, 4) !== "http"):
                        echo "./upload/$image";
                    else:
                        echo "$image";
                    endif; ?>" alt="preview">
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="blogContext" class="form-label">內文</label>
            <textarea class="form-control" id="blogContext" rows="10" placeholder="輸入文章內容" name="context"
            ><?php if (isset($_SESSION["context"])) echo $_SESSION["context"] ?></textarea>
        </div>
        <div class="blog-categories">
            <label for="blogCategory" class="form-label">文章分類</label>
            <select class="form-select" aria-label="select category" name="category" id="blogCategory">
                <option <?php if (!isset($_SESSION["category"])) echo "selected" ?> disabled>---請選擇文章分類---</option>
                <?php foreach ($rowsBlogCategory as $valueBlogCategory): ?>
                    <option value="<?= $valueBlogCategory["id"] ?>" <?php if (isset($_SESSION["category"]) == $valueBlogCategory["id"]) echo "selected" ?>><?= $valueBlogCategory["name"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="py-3 d-flex">
            <button type="reset" class="btn btn-outline-primary me-2">清空</button>
            <button type="submit" name="add" class="btn btn-primary">新增</button>
        </div>
    </form>
    <?php
    unset($_SESSION["img_path"]);
    unset($_SESSION["title"]);
    unset($_SESSION["author_name"]);
    unset($_SESSION["context"]);
    unset($_SESSION["category"]);
    ?>

</div>
</body>
</html>