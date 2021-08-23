<?php

                // Cek apakah terdapat data pada page URL
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

if (!isset($_POST['search'])) {
    $limit = 50;
    $where = "";
} else {
    $page = 1;
    $link_prev = 1;

    if (($perusahaan == "") && ($category == "Kategori") && ($status == "Status") && ($sales == "Sales") && ($city == "")) {
        echo "<script>window.location.replace('see_data.php'); </script>";
    } else {

        $limit = 50000;
        $info = "Data dengan ";

        if ($perusahaan != "") {
            $s_perusahaan = "nama_perusahaan LIKE '%".$perusahaan."%'";
            $info = $info.", nama_perusahaan <b>".$perusahaan." </b> ";
        } else {
            $s_perusahaan = "";
        }

        if ($category != "Kategori") {
            $s_category = "id_category = '".$category."'";
            $sql_category = $pdo->prepare("SELECT * FROM category WHERE id_category='".$category."'");
            $sql_category->execute();
            while ($category = $sql_category->fetch()) {
                $info = $info."kategori <b>".$category['kategori']."</b> ";
            }
        } else {
            $s_category = "";
        }


        if ($status != "Status") {
            $s_status = "id_status = '".$status."'";
            $sql_status = $pdo->prepare("SELECT * FROM status WHERE id_status='".$status."'");
            $sql_status->execute();
            while ($status = $sql_status->fetch()) {
                $info = $info.", status <b>".$status['status']."</b> ";
            }
        } else {
            $s_status = "";
        }


        if ($sales != "Sales") {
            $s_sales = "id_sales = '".$sales."'";
            $sql_sales = $pdo->prepare("SELECT * FROM sales WHERE id_sales='".$sales."'");
            $sql_sales->execute();
            while ($sales = $sql_sales->fetch()) {
                $info = $info.", sales <b>".$sales['nama']."</b> ";
            }
        } else {
            $s_sales = "";
        }




        if ($city != "") {
            $s_city = "kota LIKE '%".$city."%'";
            $info = $info.", kota <b>".$city." </b> ";
        } else {
            $s_city = "";
        }



        if (($s_perusahaan != "") || ($s_category != "") || ($s_status != "") || ($s_sales != "") || ($s_city != "")) {
            $where = "WHERE ";

            if ($s_perusahaan != "") {
                $where = $where.$s_perusahaan;
            }
            if ($s_perusahaan != "") {
                if (($s_category != "") || ($s_status != "") || ($s_sales != "") || ($s_city != "")) {
                    $where = $where. " AND ";
                }
            }

            if ($s_category != "") {
                $where = $where.$s_category;
            }

            if ($s_category != "") {
                if (($s_status != "") || ($s_sales != "") || ($s_city != "")) {
                    $where = $where. " AND ";
                }
            }

            if ($s_status != "") {
                $where = $where.$s_status;
            }

            if ($s_status != "") {
                if (($s_sales != "") || ($s_city != "")) {
                    $where = $where." AND ";
                }
            }

            if ($s_sales != "") {
                $where = $where.$s_sales;
            }

            if ($s_sales != "") {
                if (($s_city != "")) {
                    $where = $where." AND ";
                }
            }



            if ($s_city != "") {
                $where = $where.$s_city;
            }
        } else {
            $where = "";
        }


        $sql_jml = $pdo->prepare("SELECT COUNT(*) FROM customer ".$where);
                            $sql_jml->execute(); // Eksekusi querynya
                            $get_jml = $sql_jml->fetchColumn();

                            $info = $info." berjumlah <b>".$get_jml." data </b>";
                        }
                    }
                    ?>