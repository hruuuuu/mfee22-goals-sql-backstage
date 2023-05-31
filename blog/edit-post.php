<?php
require_once("../pdo-connect.php");
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT blog.*,
       blog_author.id AS id,
       blog_author.name AS author_name,
       blog_category.id AS id,
       blog_category.name AS category_name
       FROM blog
           JOIN blog_author ON blog_author.id = blog.author_id
           JOIN blog_category ON blog_category.id = blog.category_id
WHERE blog.valid = 1 AND blog.id = ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$id]);
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

    $itemsPerPage = 5;
    $page = ceil($id / $itemsPerPage);
} else {
    header("location: blog.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Blog｜編輯文章</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../css/blog.css">
</head>
<body>
<div class="container py-5">
    <?php if (isset($_SESSION["img_error_msg"])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION["img_error_msg"] ?>
        </div>
    <?php endif;
    unset($_SESSION["img_error_msg"]);
    ?>
    <h1>編輯文章</h1>
    <div class="py-3 d-flex justify-content-start">
        <a href="blog.php?page=<?= $page ?>" role="button" class="btn btn-primary">
            <i class="fas fa-chevron-left fa-fw"></i>
            返回列表
        </a>
    </div>
    <?php foreach ($rows as $value): ?>
        <form action="doEdit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="mb-3">
                <label for="blogTitle" class="form-label">標題</label>
                <input type="text" class="form-control" id="blogTitle" placeholder="輸入文章標題" name="title"
                       value="<?= isset($_SESSION["title"]) ? $_SESSION["title"] : $value["title"] ?>">
            </div>
            <div class="mb-3">
                <label for="blogAuthor" class="form-label">作者</label>
                <input type="hidden" name="author_id" value="<?= $value["author_id"] ?>">
                <input type="text" class="form-control" id="blogAuthor" placeholder="輸入文章作者" name="author_name"
                       value="<?= isset($_SESSION["author_name"]) ? $_SESSION["author_name"] : $value["author_name"] ?>"
                       required>
            </div>
            <?php ?>
            <div class=" blog-img mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="blogImgFile" class="form-label">圖片</label>
                    <?php if (isset($_SESSION["img_path"])): ?>
                        <button type="submit" name="remove" class="btn btn-outline-danger mb-2">移除</button>
                    <?php endif; ?>
                </div>
                <?php if (!isset($_SESSION["img_path"]) && !isset($_SESSION["prev_img_path"])): ?>
                    <span class="d-block mb-2 text-muted fst-italic">上傳檔案</span>
                    <input type="file" class="form-control" id="blogImgFile" name="imageFile">
                    <span class="d-block my-2 text-muted fst-italic">或輸入連結</span>
                    <input type="text" class="form-control" id="blogImgLink" placeholder="輸入圖片網址" name="image">
                    <button type="submit" name="upload" class="btn btn-primary my-2">上傳</button>
                <?php endif; ?>
                <?php $_SESSION["prev_img_path"] = $value["image"];
                if (isset($_SESSION["img_path"])):
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
                <?php elseif (isset($_SESSION["prev_img_path"])):
                    $image = $_SESSION["prev_img_path"];
                    ?>
                    <hr/>
                    <span class="d-block my-2">使用原圖</span>
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
                          required><?= isset($_SESSION["context"]) ? $_SESSION["context"] : $value["context"] ?></textarea>
            </div>
            <div class=" blog-categories">
                <label for="blogCategory" class="form-label">文章分類</label>
                <select class="form-select" aria-label="select category" name="category" id="blogCategory">
                    <option disabled>---請選擇文章分類---</option>
                    <?php foreach ($rowsBlogCategory as $valueBlogCategory): ?>
                        <option value="<?= $valueBlogCategory["id"] ?>"
                            <?php
                            if (!isset($_SESSION["category"])):
                                if ($value["category_id"] === $valueBlogCategory["id"]):
                                    echo "selected";
                                endif;
                            else:
                                if ($_SESSION["category"] === $valueBlogCategory["id"]):
                                    echo "selected";
                                endif;
                            endif; ?>
                        >
                            <?= $valueBlogCategory["name"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="py-3 d-flex">
                <input type="hidden" value="<?= $page ?>" name="page">
                <button type="reset" class="btn btn-outline-primary me-2">清空</button>
                <button type="submit" name="save" class="btn btn-primary">儲存</button>
            </div>
        </form>
    <?php endforeach;
    unset($_SESSION["img_path"]);
    unset($_SESSION["prev_img_path"]);
    unset($_SESSION["title"]);
    unset($_SESSION["author_name"]);
    unset($_SESSION["context"]);
    unset($_SESSION["category"]);
    ?>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>