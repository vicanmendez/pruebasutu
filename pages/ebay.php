<?php
function ebayScrappe($search, $order='', $auction, $buy_it_now, $condition='', $page=1){
    // Prepare the URL based on the provided parameters
    $url = 'https://www.ebay.com/sch/i.html?_from=R40&_nkw=' . urlencode($search);

    if ($order != '') {
        if ($order === 'price-asc') {
           $url  .= '&_sacat=0&_sop=15';
        } elseif ($order === 'price-desc') {
            $url .= '&_sacat=0&_sop=16';
        } elseif ($order === 'ending-soonest'){
            $url .= '&_sacat=0&_sop=1';
        } elseif ($order === 'most-recent'){
            $url .= '&_sacat=0&_sop=10';
        } elseif ($order === 'nearest') {
            $url .= '&_sacat=0&_sop=7';
        }
    }

    
    // Add filters to the URL if they are provided
    if ($auction=== '1') {
        $url .= '&LH_Auction=1';
    }
    if ($buy_it_now === '1') {
        $url .= '&LH_BIN=1';
    }
    if ($condition !== '') {
        if($condition === 'new') { 
            $condition = '1000';
        } elseif($condition==='openbox') {
            $condition = '1500';
        }elseif($condition === 'used') {
            $condition = '3000';
        }elseif($condition === 'excellent') {
            $condition = '2010';
        } elseif($condition === 'very_good') {
            $condition = '2020';
        } elseif($condition === 'good') {
            $condition = '2030';
        } elseif($condition === 'for_parts') {
            $condition = '7000';
        }
        $url .= '&LH_ItemCondition=' . $condition;
    }

    // Add the page parameter to the URL if it is provided
    if ($page > 1) {
        $url .= '&_pgn=' . $page;
    }

    // Fetch the HTML content of the eBay page
    $html = file_get_contents($url);


    // Create a DOMDocument object and load the HTML
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    // Create an XPath object to query the DOM
    $xpath = new DOMXPath($dom);

    // Initialize an array to store the scraped product data
    $products = [];

    // Extract product information using XPath queries
    $titles = $xpath->query("//div[@class='s-item__title']");
    $images = $xpath->query("//div[@class='s-item__image-wrapper image-treatment']");
    $links = $xpath->query("//a[contains(@class, 's-item__link')]");
    $prices = $xpath->query("//span[@class='s-item__price']");
    // Iterate over the extracted data and populate the products array
    for ($i = 0; $i < $titles->length; $i++) {
        $product = [
            'title' => $titles[$i]->textContent,
            'image' => $images[$i]->firstChild->getAttribute('src'),
            'link' => $links[$i]->getAttribute('href'),
            'price' => $prices[$i]->textContent
        ];

        $products[] = $product;
    }

    //remove the first product because it is an ad
    array_shift($products);

    return $products;
}

?>