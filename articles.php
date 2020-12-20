<?php
    //keeps track of page number
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    //fetch articles
    $url = "https://newsapi.org/v2/everything?sortBy=popularity&pageSize=9&page=$page&qInTitle=coffee&excludeDomains=google.com,reuters.com,themarketfeed.com,yankodesign.com,adsoftheworld.com,stereogum.com,designboom.com,bloomberg.com,techinasia.com,the-gadgeteer.com&language=en&apiKey=fca558e258b84f8b9b58d0988a853eab"; 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($curl, CURLOPT_URL, $url);
    $resultArticles = curl_exec($curl);
    $resultArticlesArray = json_decode($resultArticles, true);
    $articles = $resultArticlesArray["articles"];
    $numOfPages = (int) ($resultArticlesArray["totalResults"] / 10);

    //fetch random authors
    $url = "https://randomuser.me/api/?page=$page&results=9&nat=us"; 
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($curl, CURLOPT_URL, $url);
    $resultAuthors = curl_exec($curl);
    $resultAuthorsArray = json_decode($resultAuthors, true);
    $authors = $resultAuthorsArray["results"];
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        
    </head>
    <body>
        <div class="top">
            <div class="text-light">The Coffee Times</div>
            <h5 class="text-light">Giving you a latte news.</h5>
        </div>

        <div class="articles">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                    for ($i=0; $i < 9; $i++) { 
                        ?>
                        <div class="col">
                            <div class="card h-100 bg-light shadow">
                                <img src="<?php echo $articles[$i]["urlToImage"]?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $articles[$i]["title"]?></h4>
                                    <h5 class="card-title"><?php echo $authors[$i]["name"]["first"];?> <?php echo $authors[$i]["name"]["last"]?></h5>
                                    <p class="card-text"><?php echo $articles[$i]["description"]?></p>
                                    <a href="<?php echo $articles[$i]["url"]?>" class="btn btn-dark"><?php echo $articles[$i]["source"]["name"]?></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
        
        <footer>
            <ul class="pagination justify-content-center">
                <?php if ($page > 1) { ?>
                    <li class="m-3"?>
                        <a href="<?php echo "?page=".($page - 1)?>">prev</a>
                    </li>
                <?php }else { ?>
                    <li style="font-family: Arial, Helvetica, sans-serif; cursor: default; font-size: 15px; font-weight: 700;" class="text-secondary m-3"?>
                        prev
                    </li>
                <?php } ?>
                    

                <?php if ($page == 10) {?>
                    <li class="m-3"?><a href="?page=3">8</a></li>
                <?php } ?>

                <?php if ($page > 1) {?>
                    <li class="m-3"?>
                        <a href="<?php if($page >= $numOfPages){ echo '#'; } else { echo "?page=".($page - 1); } ?>"><?php echo $page - 1?></a>
                    </li>
                <?php } ?>

                <li class="m-3"?>
                    <a style="text-decoration: underline;" href="<?php echo "?page=".($page);?>"><?php echo $page?></a>
                </li>

                <?php if ($page < 10) { ?>
                    <li class="m-3"?>
                        <a href="<?php echo "?page=".($page + 1); ?>"><?php echo $page + 1?></a>
                    </li>
                <?php } ?>

                <?php if ($page == 1) { ?>
                    <li class="m-3"?><a href="?page=3">3</a></li>
                <?php } ?>

                <?php if ($page < 10) { ?>
                    <li class="m-3"?>
                        <a href="<?php echo "?page=".($page + 1)?>">next</a>
                    </li>
                <?php } else { ?>
                    <li style="font-family: Arial, Helvetica, sans-serif; cursor: default; font-size: 15px; font-weight: 700;" class="text-secondary m-3"?>
                        next
                    </li>
                <?php } ?>
            </ul>
        </footer>
    </body>
</html>


