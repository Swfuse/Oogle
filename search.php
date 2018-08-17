<?php
include("config.php");
include("classes/SitesResultsProvider.php");
include("classes/ImageResultsProvider.php");
if(isset($_GET["term"])){
    $term = $_GET["term"];
}
else {
    exit("Enter search text");
}


$type = isset($_GET["type"]) ? $_GET["type"] : "sites";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="   crossorigin="anonymous"></script>
    <title>Welcome to my Ooodle</title>
</head>
<body>
    <div class="wrapper">
        <div class="header">
                <div class="headerContent">
                    <div class="logoContainer">
                        <a href="index.php">
                            <img src="/assets/img/logo.png" alt="Logo myDoodle">
                        </a>
                    </div>
                
                <div class="searchContainer">
                    <form action="search.php" method="GET">
                        <div class="searchBarContainer">
                            <input type="text" class="searchBox" name="term" value="<?php echo $term;  ?>">
                            <input type="hidden" name="type" value="<?php echo $type;  ?>">
                            <button class="searchButton">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAO6SURBVGhD7ZhLbExhFMfHK4JEEDYIwkZY2lg0mbkzJSXEK3ZeG4+NdMFWbmq+21baEiuKpDvEupsmCBqV0ERZNQgJaYhWtPPd23rO9T93zvDd22vaMd/cTmN+yUk7OWfO4/vO95pYlSpVykOqaWxt0pL1hiWv4m+nIeRjQ9gPIDcgralGu67uYnYum1cWpunOTAr7SFLIvqRluxOJYdkjKLSjtnl0FbuYelJpmcBIPwtLeCJBMV9plja3Zeexu6kBiZxE+3wPS7IoEbI33uysZLfRgva4EJoUBAW+RYHtkFOQA0nhnMBaaUD73f5b4dAPxK3MenYfDbmZGJ8MknwEMWKuO4NNx7HVHF6C7wvYy3HfF/bLuPl5EZuWl4SViWP0fqgJ5D7LejaZFEZ6dDW+81T144mQXYUGQgu0OwUXtleEcHaySVFsackugL+7qj/Pp5XZyyblAWfA4WDQYmciSI2VWQY/rwJ+++OmO5tN9BMyGz2sKgmj0d6u+s2Js5vVesmd2P5gdIawumSwC3arvrEhdLBKL9RCaiAsync6FyUKOerzb9mD+2+5s1itD7TRNX8g2c4qLWDDWOH3j1lJD69jtT6QeKcvSKN9mlXawCyPqjHQurWs0gddI9QgWPiHWKUNOhDVGAnh7GKVPuD4vhoEu8pxVmkDg/NBjZGwZIpV+sBivKkGwZppYJUWNrW7c7BT/VRjJK3MBlbrA63V4g9i32GVFmgrV/3TjaHOHFrIan3Qy04NhMK+0QWQ1SUTcpt+yCq90PMUwUbUYHSLZXVJxM3M0nG+hX2G1fqh09YfTNo6nqvwe8nnFy/Hsj606OqN5L+oQdFifTtMdz6bFA3Oo4M+fxAqjNXlAy3QFgyM/f8etQebTBoqgkZf9QX/nyJ59tLo45R/ogbPJSBfo6BtbFaQ3Jrwt9MfKdOtNwwaMbTYQFgiGNFuQzjHas85y9ncg84J7xcX7E7Bhf37u8IeivxHCPqhAAm9CEsoLxh1JzdT8j0kG2aTF2op739hf4Rtrye4mJblBhykpml4MQJ2BZMqRrwChLOHZgKfB4N6yPVIiiEoEQTsDyRQUGiRoz0vq62Eop6H2UKiK4be2HRbRYJ01oSNrHftgPTQYRe2FgoUQhJdMXkoID2KjLRMJkRmH91ijbNy40R3J7TplZACVIm+mH+BkqRkA8kHpVpM5FSLqVSqxVQq/10xOGhb2byyKViMkG/iTWNr2LTyCS1muhWRx1fMdC0ij1eMsM9P6yKqVJlyYrFfTV6VRUJXlsIAAAAASUVORK5CYII=">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tabsContainer">
                <ul class="tabList">
                    <li class="<?php echo $type == 'sites' ? 'active' : '' ?>"><a href='<?php echo "search.php?term=$term&type=sites"; ?>'>Sites</a></li>
                    <li class="<?php echo $type == 'images' ? 'active' : '' ?>"><a href='<?php echo "search.php?term=$term&type=images"; ?>'>Images</a></li>
                </ul>
            </div>
        </div>

        <div class="mainResultsSection">
            <?php
                if($type == "sites") {
                    $resultsProvider = new SiteResultsProvider($con);
                    $pageLimit = 20;
                }
                else {
                    $resultsProvider = new ImageResultsProvider($con);
                    $pageLimit = 30;
                }
                $numResults = $resultsProvider->getNumResults($term);
                echo "<p class='resultsCount'>$numResults results found</p>"; 
                
                echo $resultsProvider->getResultsHtml($page, $pageLimit, $term);
            ?>
        </div>

        <div class="paginationContainer">
            <div class="pageButtons">
                <div class="pageNumberContainer">
                    <img src="assets/img/pageStart.png" alt="">
                </div>
                <?php

                    $pagesToShow = 10;
                    $numPages = ceil($numResults / $pageLimit);
                    $pagesLeft = min($pagesToShow, $numPages);

                    $currentPage = $page - floor($pagesToShow / 2);

                    if($currentPage < 1) {
                        $currentPage = 1;
                    }
                    if($currentPage + $pagesLeft > $numPages + 1) {
                        $currentPage = $numPages + 1 - $pagesLeft;
                    }
                    while ($pagesLeft !=0 && $currentPage <= $numPages) {
                        if($currentPage == $page) {
                            echo "<div class='pageNumberContainer'>
                            <img src='assets/img/pageSelected.png'>
                            <span class='pageNumber'>$currentPage</span>
                            </div>";
                        } else {
                            echo "<div class='pageNumberContainer'>
                            <a href='search.php?term=$term&type=$type&page=$currentPage'>
                                <img src='assets/img/page.png'>
                                <span class='pageNumber'>$currentPage</span>
                            </a>
                            </div>";
                        }



                        $currentPage++;
                        $pagesLeft--;
                    }
                ?>
                <div class="pageNumberContainer">
                    <img src="assets/img/pageEnd.png" alt="">
                </div>
            </div>
        </div>

    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>