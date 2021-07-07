<?php 
    include "helper/userHelper.php";
    use LoginHelper\UserHelperClass;

    session_start();

    $menuInstance = new UserHelperClass();
    $menu = $menuInstance->getMenuByWeekAndYear();

?>
<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset=utf-8>
    <meta http-equiv=X-UA-Compatible content="IE=edge">
    <meta name=viewport content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name=description content="">
    <meta name=author content="">
    <title>Bestelltool Meyer Menü</title>
    <link href=vendor/fontawesome-free/css/all.min.css rel=stylesheet type=text/css>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel=stylesheet>
    <link href=css/sb-admin-2.min.css rel=stylesheet>
</head>

<body id=page-top>
    <div id=wrapper>
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id=accordionSidebar>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href=index.html>
                <div class="sidebar-brand-text mx-3"><img src=img/logo.png width=150></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class=nav-link href=index.html>
                
                    <span>Overview</span></a>
            </li>
            <div class=sidebar-heading>
            </div>
            <li class=nav-item>
                <a class=nav-link href=#>
                    <span>Bestellen</span>
                </a>
            </li>
            <li class=nav-item>
                <a class=nav-link href=#>
                
                    <span>Rechnungen</span>
                </a>
            </li>
            <hr class=sidebar-divider>
            <div class=sidebar-heading>
            </div>
            <li class=nav-item>
                <a class=nav-link href=./logout.php>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        
        <div id=content-wrapper class="d-flex flex-column">
            <div id=content>
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id=sidebarToggleTop class="btn btn-link d-md-none rounded-circle mr-3"></button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href=# id=searchDropdown role=button data-toggle=dropdown aria-haspopup=true aria-expanded=false>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby=searchDropdown>
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class=input-group>
                                        <input class="form-control bg-light border-0 small" placeholder="Search for..." aria-label=Search aria-describedby=basic-addon2>
                                        <div class=input-group-append>
                                            <button class="btn btn-primary" type=button></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-link dropdown-toggle">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class=container-fluid>
                    <div class=row>
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Bestellungen diese Woche (KW <?php echo date('W'); ?>)</h6>
                                </div>
                                <div class=card-body>
                                        <?php
                                            include "helper/foodHelper.php";
                                            use FoodHelper\FoodHelperClass;
                                        
                                            $foodInstance = new FoodHelperClass();
                                            $food = $foodInstance->getFoodByWeek(date('W'));

                                            $i = 0;
                                            foreach($food as $foo){
                                                $i++;
                                                echo '<table> <tbody> <tr> <td style="padding-right: 20px;" ><img src="https://shop.meyer-menue.de/assets/image/' . $foo['menuimage'] . '" width="275"></img></td> <td><h4>' . $foo['date'] . ' - Menü ' . $foo['menuID'] . '</h4><br><b>' . $foo['title'] . '</b><br><div style="margin-left: 20px;">' . $foo['description'] . '</div></td> <td></td> </tr> </tbody> </table>';
                                                if($i < count($food)){
                                                    echo '<div style="padding-bottom: 20px; padding-top: 20px;"></div>';
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
    <a class="scroll-to-top rounded" href=#page-top></a>
    
    <script src=vendor/jquery/jquery.min.js></script>
    <script src=vendor/bootstrap/js/bootstrap.bundle.min.js></script>
    <script src=vendor/jquery-easing/jquery.easing.min.js></script>
    <script src=js/sb-admin-2.min.js></script>
    <script src=vendor/chart.js/Chart.min.js></script>
    <script src=js/demo/chart-area-demo.js></script>
    <script src=js/demo/chart-pie-demo.js></script>
    </div>
</body>

</html>