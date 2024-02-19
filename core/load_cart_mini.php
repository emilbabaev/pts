<?
    require_once $_SERVER['DOCUMENT_ROOT'] . "/pn/bd.php";
    $search = "";

    if (isset($_COOKIE['city']))
    {
        $search = " and `id`=" . $_COOKIE['city'] . "";
    }

    $result = mysql_query("SELECT * FROM `city` WHERE 1 " . $search . " LIMIT 1");
    $count = mysql_num_rows($result);

    if ($count > 0)
    {
        $city = mysql_fetch_array($result);
    }

    if ($city['id'] == 1)
    {
        $table = "prod";
    }
    else if ($city['id'] == 2)
    {
        $table = "prod_vologda";
    }

    if (isset($_COOKIE["prod"]) && !empty($_COOKIE["prod"]))
    {
        $myProd = explode('#', $_COOKIE["prod"]);
        $totalPrice = 0;
        if (count($myProd) > 0 && $myProd[0] != "")
        {
            $count = count($myProd);
            for ($i = 0; $i < $count; ++$i)
            {
                $temp = explode(',', $myProd[$i]);
                $myId = $temp[0];
                $myStatus = $temp[3];
                if ($myStatus == 0)
                {
                    $result = mysql_query("SELECT price FROM `" . $table . "` WHERE `id`='" . $myId . "'");
                    $catalog_cart = mysql_fetch_array($result);
                    $totalPrice += ($catalog_cart['price'] * $temp[2]);
                }
            }
        }
        $data = [
            "count" => count($myProd),
            "totalPrice" => $totalPrice
        ];
        echo json_encode($data);
    }
?>