<?php
function scrappe($search, $order, $auction, $buy_it_now, $condition)
{
    // Prepare the URL based on the provided parameters
    $url = 'https://www.ebay.com/sch/i.html?_from=R40&_nkw=' . urlencode($search) . '&_sacat=0&_sop=' . $order;

    // Add filters to the URL if they are provided
    if ($auction=== '1') {
        $url .= '&LH_Auction=1';
    }
    if ($buy_it_now === '1') {
        $url .= '&LH_BIN=1';
    }
    if ($condition !== '') {
        $url .= '&LH_ItemCondition=' . $condition;
    }

    var_dump($url);
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
    var_dump($links[0]->getAttribute('href'));
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
    
    //If the href atribute of the first link of the array starts with 'https://ebay.com/itm/123456?' then it is a demo element and we have to remove this product from the list
    /*
    if (substr($products[0]['link'], 0, 31) === 'https://www.ebay.com/itm/123456') {
        array_shift($products);
    } */

    return $products;
}

?>