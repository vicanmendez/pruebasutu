<?php

function mercadoLibreScrappe($search, $order="", $filters=""){
    $url = "https://listado.mercadolibre.com.uy/" . urlencode($search);

    $html = file_get_contents($url);

    // Create a DOMDocument object and load the HTML
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    // Create an XPath object to query the DOM
    $xpath = new DOMXPath($dom);

    // Initialize an array to store the scraped product data
    $products = [];

    // Extract product information using XPath queries
    $titles = $xpath->query("//h2[@class='ui-search-item__title shops__item-title']");
    $currencies = $xpath->query("//span[@class='andes-money-amount__currency-symbol']");
    $prices = $xpath->query("//span[@class='andes-money-amount__fraction']");
    $imageDataSrcs = $xpath->query('//img[@width="160"]/@data-src');  // Query the data-src attribute of img tags
    $links = $xpath->query("//a[@class='ui-search-link']");

    foreach ($titles as $index => $titleNode) {
        $title = $titleNode->textContent;
        $price = $prices->item($index)->textContent;
        $currency = $currencies->item($index)->textContent;
        if ($currency == "U\$S") {
            $currency = "USD";
        } elseif ($currency == "$") {
            $currency = "UYU";
        }
        $imageUrl = isset($imageDataSrcs->item($index)->nodeValue) ? ($imageDataSrcs->item($index)->nodeValue) : "";  // Get the data-src attribute value        
        $link = $links->item($index)->getAttribute('href');  // Get the href attribute value
        // Store the data in the products array
        $products[] = [
            'title' => $title,
            'price' => $currency . " " . $price,
            'image' => $imageUrl,
            'link' => $link
        ];

    }


    return $products;

}


?>