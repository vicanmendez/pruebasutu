
<?php

// Function to scrape product data from eBay
function scrapeFromEbay($search, $order='', $auction='', $buy_it_now='', $condition='', $page=1)
{
    // Call eBay scrapping logic
    require_once '../pages/ebay.php';
    $products = ebayScrappe($search, $order, $auction, $buy_it_now, $condition, $page);
    return $products;
}

// Function to scrape product data from Amazon
function scrapeFromAmazon($search, $order, $condition='', $page=1){
    // Your Amazon scraping logic here
    require_once '../pages/amazon.php';
    $products = amazonScrappe($search, $order, $condition, $page);
    return $products;
}

// Function to scrape product data from MercadoLibre Uruguay
function scrapeFromMercadoLibreUruguay($search, $order="", $filters="")
{
    require_once '../pages/meliuy.php';
    $products = mercadoLibreScrappe($search, $order, $filters);
    return $products;
}

// Main endpoint handler
function handleScrapperEndpoint()
{
    // Check if the request method is GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Extract the parameters from the query string
        $site = $_GET['site'] ?? '';
        $search = $_GET['search'] ?? '';
        $order = $_GET['order'] ?? '';
        $auction = $_GET['auction'] ?? '';
        $buy_it_now = $_GET['buy_it_now'] ?? '';
        $condition = $_GET['condition'] ?? '';
        $page = $_GET['page'] ?? 1;

        //remove spaces from search field
       //$search = str_replace(' ', '+', $search);
        // Perform scraping based on the requested page
        switch ($site) {
            case 'ebay':
                $products = scrapeFromEbay($search, $order, $auction, $buy_it_now, $condition, $page);
                break;
            case 'amazon':
                $products = scrapeFromAmazon($search, $order, $condition, $page);
                break;
            case 'mercadolibre':
                $products = scrapeFromMercadoLibreUruguay($search, $order);
                break;
            default:
                // Invalid page requested
                http_response_code(400);
                echo json_encode(['error' => 'Invalid page requested']);
                return;
        }

        // Return the scraped product data as JSON response
        echo json_encode($products);
   
    } else {
        // Invalid request method
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            }
        }
        
// Call the endpoint handler function
handleScrapperEndpoint();
        
?>