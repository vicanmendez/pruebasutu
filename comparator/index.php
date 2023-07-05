<?php

function handleComparatorEndpoint() {
    $pages = isset($_GET['pages']) ? $_GET['pages'] : '';
    //convert pages to array
    $pages = explode(',', $pages);
    var_dump($pages);
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $order = isset($_GET['order']) ? $_GET['order'] : '';
    $auction = isset($_GET['auction']) ? $_GET['auction'] : '';
    $buy_it_now = isset($_GET['buy_it_now']) ? $_GET['buy_it_now'] : '';
    $condition = isset($_GET['condition']) ? $_GET['condition'] : '';
    // Perform scraping based on the requested page
    foreach ($pages as $page) {
        switch ($page) {
            case 'ebay':
                require_once '../pages/ebay.php';
                $ebayProducts = ebayScrappe($search, $order, $auction, $buy_it_now, $condition);
                break;
            case 'amazon':
                require_once '../pages/amazon.php';
                $amazonProducts = amazonScrappe($search, $order, $filters);
                break;
            case 'mercadolibre':
                require_once '../pages/mercadolibre.php';
                $mercadolibreProducts = mercadolibreScrappe($search, $order, $filters);
                break;
        }
    }
}

handleComparatorEndpoint();

?>