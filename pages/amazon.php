<?php

function amazonScrappe($search, $order='') {
    $url = "https://www.amazon.com/s?k=" . $search;
    if ($order != '' ) {
        if ($order === 'price-asc') {
            $url  .= '&s=price-asc-rank';
         } elseif ($order === 'price-desc') {
             $url .= '&s=price-desc-rank';
         } elseif ($order === 'most-recent'){
             $url .= '&s=date-desc-rank';
         } elseif ($order === 'review-rank') {
             $url .= '&s=review-rank';
         }
    }

    var_dump($url);

    $html = file_get_contents($url);


    // Create a DOMDocument object and load the HTML
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    // Create an XPath object to query the DOM
    $xpath = new DOMXPath($dom);

    // Initialize an array to store the scraped product data
    $products = [];

    // Extract product information using XPath queries
    $titles = $xpath->query("//span[@class='a-size-medium a-color-base a-text-normal']");
    $images = $xpath->query("//img[@class='s-image']");
    $links = $xpath->query("//a[@class='a-link-normal s-underline-text s-underline-link-text s-link-style a-text-normal']");
    $prices = $xpath->query("//span[@class='a-offscreen']");

    // Iterate over the extracted data and populate the products array
    for ($i = 0; $i < $titles->length; $i++) {
        if ($prices[$i] != null) {
            $price = $prices[$i]->textContent;
        } else {
            $price = "Not specified";
        }
        $product = [
            'title' => $titles[$i]->textContent,
            'image' => $images[$i]->getAttribute('src'),
            'link' => $links[$i]->getAttribute('href'),
            'price' => $price
        ];
    
         $products[] = $product;
    }


    return $products;

}

?>