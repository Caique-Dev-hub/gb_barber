<?php

if (!isset($_SESSION['admin'])) {
    $this->view('admin/content/login', $dados);
    exit;
}

$servicos = $this->db_servico->getCount();
$combos = $this->db_servico->getCountCombo();

$totalServicos = (int)$servicos['total'] + (int)$combos['total'];

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= URL_BASE ?>assets/img/logo-gb.png" type="imagem.iconx">
    <title>
        GB-Barber
    </title>
    <!-- WOW -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="<?= URL_BASE ?>dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= URL_BASE ?>dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Files -->
    <link id="pagestyle" href="<?= URL_BASE ?>dashboard/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
</head>

<!-- CSS agendamento -->
<style>
    :root {
        --primary: #4F46E5;
        --success: #10B981;
        --warning: #F59E0B;
        --error: #EF4444;
        --red-50: #FEF2F2;
        --red-100: #FEE2E2;
        --red-200: #FECACA;
        --red-300: #FCA5A5;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-600: #4B5563;
        --gray-700: #374151;
        --gray-900: #111827;
    }

    .booking-card {
        position: relative;
        background: white;
        border-radius: 16px;
        width: 100%;
        height: 250px;
        max-width: 780px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--gray-200);
    }

    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(239, 68, 68, 0.1);
    }

    .card-accent {
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(to bottom, var(--error), #FF6B6B);
        transition: all 0.3s ease;
    }

    .booking-card:hover .card-accent {
        width: 8px;
    }

    .red-decoration {
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: radial-gradient(circle, var(--red-100) 0%, rgba(254, 226, 226, 0) 70%);
        z-index: 0;
        opacity: 0.8;
        transition: all 0.5s ease;
    }

    .booking-card:hover .red-decoration {
        transform: scale(1.05);
        opacity: 0.9;
    }

    .booking-content {
        display: flex;
        padding: 24px;
        position: relative;
        z-index: 1;
        height: 100%;
        align-items: center;
    }

    .client-info {
        flex: 1;
        padding-right: 24px;
        border-right: 1px dashed var(--gray-200);
    }

    .booking-info {
        flex: 1;
        padding-left: 24px;
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .booking-name {
        font-size: 26px;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }

    .name-text {
        position: relative;
    }

    .name-text::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, var(--error), transparent 80%);
        transform-origin: left;
        transform: scaleX(0.8);
        transition: transform 0.3s ease;
    }

    .booking-card:hover .name-text::after {
        transform: scaleX(1);
    }

    .verified-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: var(--red-50);
        border: 1px solid var(--red-200);
    }

    .booking-status {
        font-size: 13px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .booking-status.confirmed {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
        border: 1px solid var(--success);
    }

    .booking-status.pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
        border: 1px solid var(--warning);
    }

    .booking-status.canceled {
        background-color: var(--red-50);
        color: var(--error);
        border: 1px solid var(--red-200);
    }

    .contact-details {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .detail-item:hover span {
        color: var(--error);
    }

    .detail-item:hover .icon-wrapper {
        background-color: var(--red-50);
        transform: translateY(-2px);
    }

    .icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--gray-50);
        transition: all 0.2s ease;
    }

    .icon-wrapper svg {
        width: 18px;
        height: 18px;
    }

    .detail-item span {
        font-size: 14px;
        color: var(--gray-600);
        transition: color 0.2s ease;
    }

    .service-detail,
    .date-detail {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .info-label {
        font-size: 12px;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 500;
        color: var(--gray-900);
    }

    @media (max-width: 768px) {
        .booking-content {
            flex-direction: column;
            gap: 24px;
        }

        .client-info {
            padding-right: 0;
            border-right: none;
            border-bottom: 1px dashed var(--gray-200);
            padding-bottom: 24px;
        }

        .booking-info {
            padding-left: 0;
        }

        .red-decoration {
            top: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
        }
    }
</style>


<!-- CSS Card -->
<style>
    :root {
        --primary: #4F46E5;
        --error: #EF4444;
        --success: #10B981;
        --warning: #F59E0B;
        --gray-100: #F3F4F6;
        --gray-600: #4B5563;
        --gray-900: #111827;
    }

    .cards-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        font-family: 'Inter', -apple-system, sans-serif;
        padding: 24px;
        max-width: 1920px;
        margin: 0 auto;
    }

    .card {
        background: white;
        height: 95%;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
        transition: 0.5s all;
        border: 1px solid #EAEDF3;
    }

    .card:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .card-decoration {
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0) 100%);
        border-radius: 0 0 0 80px;
    }

    .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        background: var(--gray-100);
        color: var(--error);
    }

    .highlight .card-icon {
        background: rgba(239, 68, 68, 0.1);
        color: var(--error);
    }

    .card-content {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .card-title {
        font-size: 14px;
        font-weight: 500;
        color: var(--gray-600);
        margin: 0;
    }

    .card-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .card-footer {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        margin-top: 8px;
    }

    .card-change {
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .positive {
        color: var(--success);
    }

    .negative {
        color: var(--error);
    }

    .card-text {
        color: var(--gray-600);
    }

    @media (max-width: 768px) {
        .cards-container {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 480px) {
        .cards-container {
            grid-template-columns: 1fr;
        }
    }

    .ps__thumb-x {
        width: 0 !important;
    }
</style>

<!-- Button -->
<style>
    :root {
        --red-500: #EF4444;
        --red-600: #DC2626;
        --red-100: #FEE2E2;
        --white: #FFFFFF;
    }

    .active-button {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 28px;
        background-color: var(--red-500);
        color: var(--white);
        font-family: 'Inter', -apple-system, sans-serif;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.25);
    }

    .not-active {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 28px;
        background-color: var(--gray-50);
        color: var(--red-600);
        font-family: 'Inter', -apple-system, sans-serif;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.25);
    }

    .active-button:hover {
        background-color: var(--red-600);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(239, 68, 68, 0.3);
    }

    .active-button:active {
        transform: translateY(0);
    }

    .not-active:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(239, 68, 68, 0.3);
    }

    .not-active:active {
        transform: translateY(0);
    }

    .active-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent 25%, rgba(255, 255, 255, 0.15) 50%, transparent 75%);
        background-size: 400% 400%;
        opacity: 0;
        transition: opacity 0.5s ease, background-position 1s ease;
    }

    .active-button:hover::before {
        opacity: 1;
        animation: shine 2s infinite;
    }

    .not-active::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent 25%, rgba(255, 255, 255, 0.15) 50%, transparent 75%);
        background-size: 400% 400%;
        opacity: 0;
        transition: opacity 0.5s ease, background-position 1s ease;
    }

    .not-active:hover::before {
        opacity: 1;
        animation: shine 2s infinite;
    }

    .button-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .active-button:hover .button-icon {
        transform: translateX(3px);
    }

    .not-active:hover .button-icon {
        transform: translateX(3px);
    }

    @keyframes shine {
        0% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Efeito de pulso para atenção extra */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }

    .agendamento-button.pulse {
        animation: pulse 2s infinite;
    }
</style>


<style>
    .cartao {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 24px 32px;
        width: 680px;
        border-left: 5px solid #ff4d4d;
    }

    .lado-esquerdo {
        flex: 1;
    }

    .lado-direito {
        flex: 1;
        border-left: 1px solid #e5e5e5;
        padding-left: 32px;
    }

    h2 {
        margin: 0;
        color: #222;
        font-size: 20px;
    }

    .status {
        display: inline-block;
        background: #fff7e8;
        color: #b8860b;
        border: 1px solid #b8860b;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 13px;
        margin-left: 10px;
        font-weight: 600;
    }

    .informacoes {
        margin-top: 12px;
    }

    .item-informacao {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        color: #555;
    }

    .item-informacao i {
        background: #f3f3f3;
        padding: 8px;
        border-radius: 6px;
        margin-right: 10px;
    }

    .rotulo {
        font-size: 12px;
        color: #999;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .valor {
        font-size: 14px;
        color: #222;
        font-weight: 600;
    }

    .acoes {
        margin-top: 16px;
    }

    button {
        border: none;
        border-radius: 6px;
        padding: 8px 14px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .botao-agendar {
        background: #06d6a0;
        color: #fff;
        margin-right: 8px;
    }

    .botao-agendar:hover {
        background: #05b98a;
    }

    .botao-cancelar {
        background: #ef476f;
        color: #fff;
    }

    .botao-cancelar:hover {
        background: #d93d63;
    }
</style>

<body class="g-sidenav-show  bg-gray-100">

    <!-- Loading -->
    <div class="load">
        <div class="loader"></div>
    </div>

    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 my-2 ps bg-gradient-dark" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
                <img src="<?= URL_BASE ?>dashboard/assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
                <span class="ms-1 text-sm text-white">GB-Barber</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item" style="cursor: pointer;">
                    <a href="<?= URL_BASE ?>dash" class="nav-link active text-white bg-gradient-danger">
                        <span class="nav-link-text ms-1">Reservas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= URL_BASE?>servico/listar" class="nav-link text-white" id="listar_clientes">
                        <span class="nav-link-text ms-1">Serviços</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= URL_BASE ?>clientes/listar">
                        <span class="nav-link-text ms-1">Clientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white">
                        <span class="nav-link-text ms-1">Datas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white">
                        <span class="nav-link-text ms-1">Administradores</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= URL_BASE ?>dash" class="nav-link text-white">
                        <span class="nav-link-text ms-1">Retornar</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-5 text-white">Aplicativo</h6>
                </li>
                <li class="nav-item">
                    <p class="nav-link text-white" href="<?= URL_BASE ?>dashboard/pages/profile.html">
                        <i class="material-symbols-rounded opacity-5">person</i>
                        <span class="nav-link-text ms-1">Profile</span>
                    </p>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= URL_BASE ?>dashboard/pages/sign-in.html">
                        <i class="material-symbols-rounded opacity-5">login</i>
                        <span class="nav-link-text ms-1">Sign In</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= URL_BASE ?>dashboard/pages/sign-up.html">
                        <i class="material-symbols-rounded opacity-5">assignment</i>
                        <span class="nav-link-text ms-1">Sign Up</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">GB-Barber</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center" id="pesquisa_dash">

                    </div>
                    <ul class="navbar-nav d-flex align-items-center  justify-content-end">
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0">
                                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="material-symbols-rounded">notifications</i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="<?= URL_BASE ?>dashboard/assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="<?= URL_BASE ?>dashboard/assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New album</span> by Travis Scott
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                                    <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Payment successfully completed
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <a href="<?= URL_BASE ?>dashboard/pages/sign-in.html" class="nav-link text-body font-weight-bold px-0">
                                <i class="material-symbols-rounded">account_circle</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-2">
            <div class="row">
                <div class="ms-3">
                    <h3 class="mb-0 h4 font-weight-bolder">Seja bem vindo, <?= $_SESSION['admin']['nome_admin'] ?></h3>
                    <p class="mb-4">
                        Área administrativa dedicada à gestão e monitoramento do desempenho do aplicativo e do site.
                    </p>
                </div>
                <div class="cards-container">
                    <div class="card">
                        <div class="card-decoration"></div>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z" />
                            </svg>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title" style="font-size: 20px;">Agendamentos</h3>
                            <p class="card-value">0</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-decoration"></div>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                            </svg>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title" style="font-size: 20px;">Reservas</h3>
                            <p class="card-value">2,300</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-decoration"></div>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.54-9.85l-4.95 4.95-2.12-2.12-1.41 1.41 3.53 3.53 6.36-6.36-1.41-1.41z" />
                            </svg>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title" style="font-size: 20px;">Servicos</h3>
                            <p class="card-value"><?= $totalServicos ?></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-decoration"></div>
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M13 16h-2c-.55 0-1-.45-1-1H3.01v4c0 1.1.9 2 2 2H19c1.1 0 2-.9 2-2v-4h-7c0 .55-.45 1-1 1zm7-9h-4c0-2.21-1.79-4-4-4S8 4.79 8 7H4c-1.1 0-2 .9-2 2v3c0 1.11.89 2 2 2h6v-1c0-.55.45-1 1-1h2c.55 0 1 .45 1 1v1h6c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zM10 7c0-1.1.9-2 2-2s2 .9 2 2H9.99 10z" />
                            </svg>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title" style="font-size: 20px;">Faturamento</h3>
                            <p class="card-value">$103,430</p>
                        </div>
                    </div>
                </div>
            </div>
                <div class="buttons" style="display: <?= $hidden ?? 'flex'?>; justify-content: center; gap: 10px;">
                    <button class="agendamento-button active-button" id="agendamento" onclick="agendamento()">
                        <span class="button-text">Agendamento</span>
                        <span class="button-icon">
                            <svg viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                            </svg>
                        </span>
                    </button>
                    <button class="reserva-button not-active" id="reserva" onclick="reserva()">
                        <span class="button-text">Reservas</span>
                        <span class="button-icon">
                            <svg viewBox="0 0 24 24" width="20" height="20">
                                <path fill="currentColor" d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                            </svg>
                        </span>
                    </button>
                </div>

            <script>
                document.getElementById('reserva').addEventListener('click', function() {
                    const agendamento = document.getElementById('agendamento');

                    this.classList.add('active-button');
                    this.classList.remove('not-active');
                    agendamento.classList.add('not-active');
                    agendamento.classList.remove('active-button');
                })

                document.getElementById('agendamento').addEventListener('click', function() {
                    const reserva = document.getElementById('reserva');

                    this.classList.add('active-button');
                    this.classList.remove('not-active');
                    reserva.classList.add('not-active');
                    reserva.classList.remove('active-button');
                })
            </script>

            <!-- Inicio conteudo -->

            <div class="row" id="conteudo" style="padding-top: 2rem; justify-content: center; gap: 60px;">

                <?php if (isset($conteudo)) : ?>
                    <?php require_once("../app/views/admin/content/$conteudo.php") ?>
                <?php else: ?>
                    <div class="booking-card">
                        <div class="card-accent"></div>

                        <div class="booking-content">
                            <div class="client-info">
                                <div class="booking-header">
                                    <h3 class="booking-name">
                                        <span class="name-text">Maria Silva</span>
                                        <span class="verified-badge">
                                            <svg viewBox="0 0 24 24" width="16" height="16">
                                                <path fill="#EF4444" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                            </svg>
                                        </span>
                                    </h3>
                                    <span class="booking-status confirmed">Confirmado</span>
                                </div>

                                <div class="contact-details">
                                    <div class="detail-item email">
                                        <div class="icon-wrapper">
                                            <svg viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                            </svg>
                                        </div>
                                        <span>maria.silva@exemplo.com</span>
                                    </div>

                                    <div class="detail-item phone">
                                        <div class="icon-wrapper">
                                            <svg viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14zm-4.2-5.78v1.75l3.2-2.99L12.8 9v1.7c-3.11.43-4.35 2.56-4.8 4.7 1.11-1.5 2.58-2.18 4.8-2.18z" />
                                            </svg>
                                        </div>
                                        <span>(11) 98765-4321</span>
                                    </div>
                                </div>
                            </div>

                            <div class="booking-info">
                                <div class="service-detail">
                                    <div class="icon-wrapper">
                                        <svg viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M13 13v8h8v-8h-8zM3 21h8v-8H3v8zM3 3v8h8V3H3zm13.66-1.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Serviço</p>
                                        <p class="info-value">Design de Sobrancelhas</p>
                                    </div>
                                </div>

                                <div class="date-detail">
                                    <div class="icon-wrapper">
                                        <svg viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Data & Hora</p>
                                        <p class="info-value">15/07/2023 - 14:30</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="booking-card">
                        <div class="card-accent"></div>

                        <div class="booking-content">
                            <div class="client-info">
                                <div class="booking-header">
                                    <h3 class="booking-name">
                                        <span class="name-text">Maria Silva</span>
                                        <span class="verified-badge">
                                            <svg viewBox="0 0 24 24" width="16" height="16">
                                                <path fill="#EF4444" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                            </svg>
                                        </span>
                                    </h3>
                                    <span class="booking-status confirmed">Confirmado</span>
                                </div>

                                <div class="contact-details">
                                    <div class="detail-item email">
                                        <div class="icon-wrapper">
                                            <svg viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                            </svg>
                                        </div>
                                        <span>maria.silva@exemplo.com</span>
                                    </div>

                                    <div class="detail-item phone">
                                        <div class="icon-wrapper">
                                            <svg viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14zm-4.2-5.78v1.75l3.2-2.99L12.8 9v1.7c-3.11.43-4.35 2.56-4.8 4.7 1.11-1.5 2.58-2.18 4.8-2.18z" />
                                            </svg>
                                        </div>
                                        <span>(11) 98765-4321</span>
                                    </div>
                                </div>
                            </div>

                            <div class="booking-info">
                                <div class="service-detail">
                                    <div class="icon-wrapper">
                                        <svg viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M13 13v8h8v-8h-8zM3 21h8v-8H3v8zM3 3v8h8V3H3zm13.66-1.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Serviço</p>
                                        <p class="info-value">Design de Sobrancelhas</p>
                                    </div>
                                </div>

                                <div class="date-detail">
                                    <div class="icon-wrapper">
                                        <svg viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="info-label">Data & Hora</p>
                                        <p class="info-value">15/07/2023 - 14:30</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AJAX -->
                    <script class="agendamento">
                        document.addEventListener('DOMContentLoaded', function() {
                            const conteudo = document.getElementById('conteudo');

                            fetch(`<?= URL_BASE ?>dash/listar_agendamento`)

                                .then(response => response.text())
                                .then(data => {
                                    conteudo.innerHTML = data
                                })

                                .catch(error => {
                                    alert(error);
                                })
                        })

                        function agendamento() {
                            const conteudo = document.getElementById('conteudo');

                            fetch(`<?= URL_BASE ?>dash/listar_agendamento`)

                                .then(response => response.text())
                                .then(data => {
                                    conteudo.innerHTML = data
                                })

                                .catch(error => {
                                    alert(error);
                                })
                        }

                        function reserva() {
                            const conteudo = document.getElementById('conteudo');

                            fetch(`<?= URL_BASE ?>dash/listar_reserva`)

                                .then(response => response.text())
                                .then(data => {
                                    conteudo.innerHTML = data
                                })

                                .catch(error => {
                                    alert(error);
                                })
                        }
                    </script>
                <?php endif ?>
            </div>

            <!-- Fim conteudo -->

        </div>
    </main>
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="material-symbols-rounded py-2">settings</i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Material UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="material-symbols-rounded">clear</i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
                    <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
                    <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3 d-flex">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-3">
                <div class="mt-2 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
                <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
                <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="<?= URL_BASE ?>dashboard/assets/js/core/popper.min.js"></script>
    <script src="<?= URL_BASE ?>dashboard/assets/js/core/bootstrap.min.js"></script>
    <script src="<?= URL_BASE ?>dashboard/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= URL_BASE ?>dashboard/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="<?= URL_BASE ?>dashboard/assets/js/plugins/chartjs.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= URL_BASE ?>dashboard/assets/js/material-dashboard.min.js?v=3.2.0"></script>
    <script>
        window.addEventListener('load', function() {
            document.querySelector('.load').style.visibility = 'hidden';
            document.querySelector('.load').style.opacity = '0';
        })
    </script>
</body>

</html>