<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    if ($requestMethod === 'POST') 
    {
        echo "imageId=" + $_REQUEST["imageId"] + ", categoryId=" + $_REQUEST["categoryId"];
    }
    else if ($requestMethod === 'GET')
    {
        header('Content-Type: application/json');
        $data = array(
            array("id" => 1,
            "label" => "Unknown"
            ),
            array("id" => 2,
            "label" => "No Solar Panels"
            ),
            array("id" => 3,
            "label" => "Solar Panels"
            )
        );
        echo json_encode($data);
    }
?>