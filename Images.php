<?php
    header('Content-Type: application/json');
    $data = array(
        array(
            "image_url" => "Images/906008fe-0e4e-4258-a480-7d043f471598_rgb_2016.png",
            "label" => "No Solar Panels",
            "color" => "bg-danger",
            "text-style" => "text-white",
            "active" => false
        ),
        array(
            "image_url" => "Images/3459fd10-11ce-49df-a5f2-b3427f1bb83b_rgb_2016.png",
            "label" => "No Solar Panels",
            "color" => "bg-danger",
            "text-style" => "text-white",
            "active" => false
        ),
        array(
            "image_url" => "Images/24cfc0dc-30fb-429e-a9e2-39123a7c543f_rgb_2016.png",
            "label" => "Solar Panels",
            "color" => "bg-success",
            "text-style" => "text-white",
            "active" => false
        ),
        array(
            "image_url" => "Images/3c169b7e-fce0-4af9-b0ec-510532accce6_rgb_2016.png",
            "label" => "Unknown",
            "color" => "",
            "text-style" => "text-muted",
            "active" => true
        ),
        array(
            "image_url" => "Images/3c5e8fdf-812f-4fcc-8095-5a6226562a89_rgb_2016.png",
            "label" => "Unknown",
            "color" => "",
            "text-style" => "text-muted",
            "active" => false
        ),
        array(
            "image_url" => "Images/8ad7a8ea-2f48-47fb-84f2-ade5edf146fc_rgb_2016.png",
            "label" => "Unknown",
            "color" => "",
            "text-style" => "text-muted",
            "active" => false
        ),
        array(
            "image_url" => "Images/035356b6-e050-45bf-8693-fdfff0b21283_rgb_2016.png",
            "label" => "Unknown",
            "color" => "",
            "text-style" => "text-muted",
            "active" => false
        )
    );
    echo json_encode($data);
?>