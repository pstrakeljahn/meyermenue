<?php 
    include "helper/userHelper.php";
    include "helper/miscHelper.php";
    include "helper/foodHelper.php";

    use ApiHandler\ApiHandlerClass;
    use MiscHelper\MiscHelperClass;
    use FoodHelper\FoodHelperClass;
    $misc = new MiscHelperClass();
    session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type=image/x-icon href=https://shop.meyer-menue.de/favicon.ico>

    <title>Bestelltool Meyer Menü</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3"><img src="img/logo.png" width="150"></img></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                <i class="fas fa-info-circle"></i>
                    <span>Overview</span></a>
            </li>
            <div class="sidebar-heading">
            </div>
            <li class="nav-item active">
                <a class="nav-link" href="order.php">
                <i class="fas fa-utensils"></i>
                    <span>Bestellen</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="invoice.php">
                <i class="fas fa-file-invoice-dollar"></i>
                    <span>Rechnungen</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
            </div>
            <li class="nav-item">
                <a class="nav-link" href="./logout.php">
                <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-link dropdown-toggle">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php 
                                    echo $_SESSION['UserData']['name'];
                                ?></span>
                            </div>
                        </li>

                    </ul>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                        <div class="card mb-4 border-bottom-danger">
                                <div class="card-body">
                                    <?php
                                        echo 'Die folgenden Tage sind Bestelltage:<br>';
                                        foreach($misc::ALLOWED_DAYS as $day){
                                            $arrDays[] = $misc->translate($day);
                                            if(isset($_GET['kw']) && isset($_GET['year'])){
                                                $arrDate[] = $misc->getStartAndEndDate($_GET['kw'], $_GET['year'], true, $day);
                                            }
                                        }
                                        echo '<div style="margin-left: 30px;"><b>'.implode(", ", $arrDays).'</b></div>';

                                    ?>
                                </div>
                            </div>
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div>
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php
                                                if(isset($_GET['kw'])){
                                                    echo 'KW '.$_GET['kw'];
                                                } else {
                                                    echo 'Woche auswählen';
                                                }
                                            ?>
                                        </button>
                                        <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                            <?php
                                                for($i=0; $i<3; $i++){
                                                    $kw = (int)date('W')+$i;
                                                    $year = (int)date('Y');
                                                    echo '<a class="dropdown-item" href="order.php?kw='.$kw.'&year='.$year.'">KW '.$kw.'</a>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                        <?php
                                        if(isset($_GET['kw']) && isset($_GET['year'])){
                                            
                                            $date = $misc->getStartAndEndDate($_GET['kw'], $_GET['year']);
                                            echo $date['start'].' - '.$date['end'];
                                        }
                                        ?>
                                </div>
                                <div class="card-body">
                               <?php
                                        if(!isset($_GET['kw']) && !isset($_GET['year'])){
                                            echo '<p style="text-align: center;">Wählen Sie eine Woche aus!</p>';
                                        } else {
                                            $menus = json_decode(ApiHandlerClass::getFood($_GET['year'], $_GET['kw']), true);
                                            foreach($menus as $menu){
                                                $test = $menu['date'];
                                                if(in_array($menu['date'], $arrDate)){
                                                    $arrMenu[] = $menu;
                                                }
                                            }
                                            $foodInstance = new FoodHelperClass();
                                            $food = $foodInstance->getFoodByWeek($_GET['kw'], $arrMenu);
                                            
                                            $cache = [];
                                            foreach($food as $foo){
                                                $cache[$foo['date']][] = $foo;
                                            }

                                            foreach($cache as $day => $food){
                                                $dto = new DateTime();
                                                $test = $dto->format('l');
                                                if($_GET['kw'] === $dto->format('W') && $day === $misc->translate($dto->format('l'))){
                                                    continue;
                                                }
                                                $i=0;
                                                echo '
                                                <div class="card shadow mb-4">
                                                    <a href="#collapseCardExample'.$day.'" class="d-block card-header py-3" data-toggle="collapse"
                                                        role="button" aria-expanded="true" aria-controls="collapseCardExample'.$day.'">
                                                        <h6 class="m-0 font-weight-bold text-primary">'.$day.'</h6>
                                                    </a>
                                                    <div class="collapse" id="collapseCardExample'.$day.'">
                                                        <div class="card-body">';
                                                        foreach($food as $foo){
                                                            $i++;
                                                            echo '<table> <tbody> <tr> <td style="padding-right: 20px;" ><img src="https://shop.meyer-menue.de/assets/image/' . $foo['menuimage'] . '" width="275"></img></td> <td><h4>Menü ' . $foo['menuID'] . '</h4><br><b>' . $foo['title'] . '</b><br><div style="margin-left: 20px;">' . $foo['description'] . '</div></td> <td></td> </tr> </tbody> </table>';
                                                            if($i < count($food)){
                                                                echo '<div style="padding-bottom: 20px; padding-top: 20px;"></div>';
                                                            }
                                                        }
                                                        echo '</div>
                                                    </div>
                                                </div>
                                                ';
                                            }

                                            
                                        }
                                        ?>

                                    
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>