<?php
    $page = isset($_REQUEST["page"]) ? ($_REQUEST["page"]) : null;
    if($page !== null) {
        switch ($page) {
            case 'ebay':
                $array_search = [
                    [
                    "key" => "price-asc",
                    "value" => "precio ascendente"
                    ],
                    [
                    "key" => "price-desc",
                    "value" => "precio descendente"
                    ],
                    [
                    "key" => "ending-soonest",
                    "value" => "finaliza pronto"
                    ],
                    ["key" => "most-recent",
                    "value" => "más reciente"
                    ],
                    [
                    "key" => "nearest",
                    "value" => "más cercano"
                    ]
                ];
                echo json_encode($array_search);
                break;
            case 'amazon':
                $array_search = [
                    [
                    "key" => "price-asc",
                    "value" => "precio ascendente"
                    ],
                    [
                    "key" => "price-desc",
                    "value" => "precio descendente"
                    ],
                    [
                    "key" => "most-recent",
                    "value" => "más reciente"
                    ],
                    [
                    "key" => "review-rank",
                    "value" => "más valorado"
                    ]
                ];
                echo json_encode($array_search);
                break;
            case 'mercadolibre':
                $array_search = [
                    [
                    "key" => "price-asc",
                    "value" => "precio ascendente"
                    ],
                    [
                    "key" => "price-desc",
                    "value" => "precio descendente"
                    ],
                    [
                    "key" => "most-relevant",
                    "value" => "más relevante"
                    ]
                ];
                echo json_encode($array_search);
                break;
           default:
                $array_search = [
                    [
                    "key" => "price-asc",
                    "value" => "precio ascendente"
                    ]
                ];
                echo json_encode($array_search);
                break;
        }
    }


?>