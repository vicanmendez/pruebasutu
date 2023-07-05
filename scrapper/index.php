
<?php

// Function to scrape product data from eBay
function scrapeFromEbay($search, $order='', $auction='', $buy_it_now='', $condition='')
{
    // Call eBay scrapping logic
    require_once '../pages/ebay.php';
    $products = ebayScrappe($search, $order, $auction, $buy_it_now, $condition);
    return $products;
}

// Function to scrape product data from Amazon
function scrapeFromAmazon($search, $order){
    // Your Amazon scraping logic here
    require_once '../pages/amazon.php';
    $products = amazonScrappe($search, $order);
    // Dummy data for demonstration purposes
    /*
    $products = [
        ['title' => 'Product 3', 'price' => 15.99, 'url' => 'https://www.amazon.com/product3'],
        ['title' => 'Product 4', 'price' => 24.99, 'url' => 'https://www.amazon.com/product4'],
        // Add more products as needed
    ];
    */
    
    return $products;
}

// Function to scrape product data from MercadoLibre Uruguay
function scrapeFromMercadoLibreUruguay($search, $order, $filters)
{
    // Your MercadoLibre Uruguay scraping logic here
    
    // Dummy data for demonstration purposes
    $products = [
        ['title' => 'Product 5', 'price' => 12.99, 'url' => 'https://www.mercadolibre.com.uy/product5'],
        ['title' => 'Product 6', 'price' => 21.99, 'url' => 'https://www.mercadolibre.com.uy/product6'],
        // Add more products as needed
    ];
    
    return $products;
}

// Main endpoint handler
function handleScrapperEndpoint()
{
    // Check if the request method is GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Extract the parameters from the query string
        $page = $_GET['page'] ?? '';
        $search = $_GET['search'] ?? '';
        $order = $_GET['order'] ?? '';
        $auction = $_GET['auction'] ?? '';
        $buy_it_now = $_GET['buy_it_now'] ?? '';
        $condition = $_GET['condition'] ?? '';
        //remove spaces from search field
       //$search = str_replace(' ', '+', $search);
        // Perform scraping based on the requested page
        switch ($page) {
            case 'ebay':
                $products = scrapeFromEbay($search, $order, $auction, $buy_it_now, $condition);
                break;
            case 'amazon':
                $products = scrapeFromAmazon($search, $order);
                break;
            case 'mercadolibre':
                $products = scrapeFromMercadoLibreUruguay($search, $order, $filters);
                break;
            default:
                // Invalid page requested
                http_response_code(400);
                echo json_encode(['error' => 'Invalid page requested']);
                return;
        }

        // Return the scraped product data as JSON response
        echo json_encode($products);
        /*
        foreach ($products as $product) {
            echo 'product:' . $product['title'];
            echo 'price: ' . $product['price'];
            echo 'link:' . $product['link'];
            echo 'Imagen: ' . $product['image'];
        }
        */
    } else {
        // Invalid request method
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            }
        }
        
// Call the endpoint handler function
handleScrapperEndpoint();
        
?>