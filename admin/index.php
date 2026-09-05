<?php 
    require_once '../src/Functions/helpers.php'; 
    $url = getFullUrl(); 
?>
<!doctype html>
<html lang="en">
  <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Oikonomos - Admin Panel</title>
        <link rel="icon" type="image/x-icon" href="<?= $url; ?>/images/favicon.ico">     
        <link rel="stylesheet" href="<?= $url; ?>/css/main.css">  
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.9.0/d3.min.js" integrity="sha512-vc58qvvBdrDR4etbxMdlTt4GBQk1qjvyORR2nrsPsFPyrs+/u5c3+1Ct6upOgdZoIl7eq6k3a1UPDSNAQi/32A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
        <script src="<?= $url; ?>/js/d3.min.js"></script>
        <script defer src="<?= $url; ?>/js/components/custom.js"></script>   
        <!-- <script defer src="<?= $url; ?>/js/encrypted/dashboard.js"></script>    -->
        <script src="<?= $url; ?>/js/tailwindcss.cdn.js"></script>
        <script type="module" src="<?= $url; ?>/js/main.js"></script>       
        <script src="<?= $url; ?>/js/myFunctions.js"></script>
        <script src="<?= $url; ?>/js/chart.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
         <script src="<?= $url; ?>/js/chartjs-plugin-datalabels.min.js"></script>
         <style>
            [x-cloak] { display: none !important; }
        </style>
  </head>
  <body x-data="dashboardLoad">
    <?php include('../includes/admin/modals/incomeModal.php'); ?>
    <?php include('../includes/admin/modals/viewIncomeModal.php'); ?>
    <?php include('../includes/admin/modals/expenseModal.php'); ?>
    <?php include('../includes/admin/modals/viewExpenseModal.php'); ?>    
    <?php include('../includes/admin/preloader.php'); ?>
    <div class="flex h-screen overflow-hidden">
      <?php include('../includes/admin/sidebar.php'); ?>
      <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        <?php include('../includes/admin/overlay.php'); ?>
        <?php include('../includes/admin/header.php'); ?>
        <main class="bg-gradient-to-r from-slate-500 via-slate-300 to-slate-500 h-screen">
          <div class="p-1 mx-auto max-w-(--breakpoint-2xl) md:p-1">               
                <div style="position: relative; height:100%; width:100%">
                    <?php include('../includes/admin/pages/dashboard.php'); ?>
                    <?php include('../includes/admin/pages/income.php'); ?>
                    <?php include('../includes/admin/pages/income_form.php'); ?>
                    <?php include('../includes/admin/pages/expense.php'); ?>
                    <?php include('../includes/admin/pages/expense_form.php'); ?>
                    <?php include('../includes/admin/pages/attendance.php'); ?>
                    <?php include('../includes/admin/pages/projection.php'); ?>
                </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>