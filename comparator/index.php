<?php

function handleComparatorEndpoint() {
    $pages = isset($_GET['pages']) ? $_GET['pages'] : null;
    //convert pages to array
    if ($pages !== null) {
        $pages = explode(',', $pages);
    }
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $order = isset($_GET['order']) ? $_GET['order'] : '';
    $auction = isset($_GET['auction']) ? $_GET['auction'] : '';
    $buy_it_now = isset($_GET['buy_it_now']) ? $_GET['buy_it_now'] : '';
    $condition = isset($_GET['condition']) ? $_GET['condition'] : '';
    $filters = isset($_GET['filters']) ? $_GET['filters'] : '';
    // Perform scraping based on the requested page
    if ($pages != null) { //si se piden muchas paginas
        foreach ($pages as $page) {
            switch ($page) {
                case 'ebay':
                    require_once '../pages/ebay.php';
                    $ebayProducts = ebayScrappe($search, $order, $auction, $buy_it_now, $condition);
                    echo json_encode($ebayProducts);
                    break;
                case 'amazon':
                    require_once '../pages/amazon.php';
                    $amazonProducts = amazonScrappe($search, $order, $filters);
                    echo json_encode($amazonProducts);
                    break;
                case 'mercadolibre':
                    require_once '../pages/mercadolibre.php';
                    $mercadolibreProducts = mercadolibreScrappe($search, $order, $filters);
                    echo json_encode($mercadolibreProducts);
                    break;
            }
        }
    }
     
}

handleComparatorEndpoint();

?>