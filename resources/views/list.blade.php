<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

    <title>依頼一覧画面</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
    <link href="{{ asset('datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <script>
    var load_page = JSON.parse(sessionStorage.getItem('load_page'))
    if (load_page && load_page == true && window.location.pathname == '/list') {
        window.location.reload();
        sessionStorage.setItem('load_page', JSON.stringify(false));
    }
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>

    .dropdown-menu{
        padding: 0.5rem;
    }

    input.datepicker-input{
        border-radius: unset;
        padding: 3px 4px;
        direction: unset;
        border: 1px solid rgba(0,0,0,.5);
        font-size: 14px;
    }

    .datepicker{
        transform: translate(0, 1.3em);
        font-size: 13px;
    }
        
    label{
        font-size:12px;
    }

    input[type=text], select{
        font-size: 12px !important;
        height: 26px !important;
    }

    #iy899 {
        padding-top: 10px;
        padding-right: 0px;
        padding-bottom: 30px;
        padding-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        text-align: right;
    }

    .modal-open {
        overflow: hidden !important;
        padding: 0 !important;
    }
    #iro63i{
        margin-top: 10px;
    }

    #iro64i {
        margin-top: 0px;
        margin-right: 20px;
        margin-bottom: 0px;
        margin-left: 0px;
        float: right;
        width: 120px;
    }


    #iro65i {
        margin-top: 0px;
        margin-right: 20px;
        margin-bottom: 0px;
        margin-left: 0px;
        float: right;
        width: 90px;
    }

    #ix1v4u {
        float: right;
        width: 120px;
    }

    #iujvh {
        font-weight: 700;
        font-size: 25px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        padding-top: 5px;
        padding-right: 0px;
        padding-bottom: 30px;
        padding-left: 0px;
    }

    .title-header{
        font-weight: 700;
        text-align: center;
        font-size: 30px;
/*        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;*/
    }

    .container {
        border-top-width: 1px;
        border-right-width: 1px;
        border-bottom-width: 1px;
        border-left-width: 1px;
        border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        border-left-style: solid;
        border-top-color: rgb(33, 37, 41);
        border-right-color: rgb(33, 37, 41);
        border-bottom-color: rgb(33, 37, 41);
        border-left-color: rgb(33, 37, 41);
        border-image-source: initial;
        border-image-slice: initial;
        border-image-width: initial;
        border-image-outset: initial;
        border-image-repeat: initial;
        width: 1280px;
        margin-top: 20px;
        margin-right: auto;
        margin-bottom: 0px;
        margin-left: auto;
    }

    .c3508 {
        min-height: 300px;
        height: auto;
    }

    .top-f-left {
        float: left;
        margin-top: 10px;
        margin-right: 15px;
        margin-bottom: 8px;
        margin-left: 0px;
    }

    .top-left-btn {
        width: 110px;
        float: right;
    }

    .btn.btn-primary.mb-2 {
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 20px !important;
        margin-left: 20px;
        width: 100px;
    }

    .table-cover {
        width: 100%;
        display: block;
        margin-left: 15px;
        margin-right: 15px;
    }

    .table-cover table {
        margin-bottom: 50px;
        background-color: #ffffff;
        padding: 0.75rem 0.25rem;
        border: 2px solid black;
        font-size: 13px;
    }

    .table-cover table th , .table-cover table td {
      padding: 0.75rem 0.25rem !important;
    }

    .table-bordered,
    .table-bordered th,
    .table-bordered td,
    .table-bordered tr {
        border-color: black !important;
        text-align: center;
        table-layout: fixed;
        overflow: hidden;
        vertical-align: middle;
    }

    .table-bordered td a {
        text-decoration: underline;
    }

    .grey-bg {
        background-color: #f2f2f2;
    }

    .blue-tr td,
    .blue-tr th {
        background-color: #dce6f1;
    }
    
    .yellow-tr td,
    .yellow-tr th {
        background-color: #ffff99;
    }

    .grey-tr td,
    .grey-tr th {
        background-color: #bfbfbf;
    }
    .blue{
        background-color: #dce6f1;
    }
    .grey{
        background-color: #bfbfbf;
    }
    .yellow{
        background-color: #ffff99;
    }
    .pag-nav {
        margin: auto;
        margin-top: 4px
    }

    .page-link {
        margin-left: 10px !important;
    }

    .sticky {
         position:fixed;
         top: 0;
         z-index: 1000;
         width: 100%;
         background-color: white;
    }

    .sticky .grey-bg {
        border-bottom: none;
    }

    .dot {
        height: 15px;
        width: 15px;
        background-color: black;
        border-radius: 50%;
        display: inline-block;
    }

    input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin: 0;
        padding: 0;
    }

    #check_all:hover {
        cursor: pointer;
    }

    .search-panel .search-panel-1{
        padding-right: 20px;
    }

    .search-panel label {
        margin: 0 !important;
    }

    #home:hover {
        cursor: pointer;
    }
    .table2 th, .tdDot {
        vertical-align: middle !important;
    }

    .col-order{
        cursor: pointer;
    }
    </style>
</head>

<body>
    <form action="{{  route('post_search_print')}}" method="POST" class="form_list">
        @csrf
        <div class="container-fluid sticky">
            <div class="container grey-bg wapper-list">
                <div class="header-box">
                </div>
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <p data-type="paragraph" id="iy899">                            
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <h1 data-type="header" id="iujvh"><span id="home">ライフワン依頼一覧</span>
                        </h1>
                        
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        @if(Auth::guard('m_tant_web')->check() && !$isUserLifeOne)
                        <h1 data-type="header" title="{{Auth::user()->TANT_NAME}}" class="title-header">
                            <span>{{Auth::user()->TANT_NAME}}</span>
                        </h1>
                        @endif
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <a href="{{ route('logout') }}" id="ix1v4u" class="btn btn-primary logout">ログアウト</a>
                        <a href="{{ route('changepass') }}" id="iro64i" class="btn btn-primary">個別設定</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                        <button type="submit" name="submit" value="submit_export" class="btn btn-primary mb-2 error "
                            style="margin-left: 0px;">CSV</button>
                        <button type="submit" name="submit" value="submit_print_pdf"
                            class="btn btn-primary mb-2 error">PDF</button>
                        <button type="submit" name="submit" value="submit_print_excel"
                            class="btn btn-primary mb-2 error">Excel</button>
                        <button type="submit" name="submit" value="submit_detail"
                            class="btn btn-primary mb-2 error">詳細</button>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        @if ($isUserLifeOne)
                        <div class="search-panel-4 float-right">
                            <label>仕入先様名</label>
                            <input type="text" placeholder="" value="{{ isset($paramSearch['name']) ? $paramSearch['name'] : '' }}" id="search-name" style="width: 120px; "/>        
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="float-left" style="width: 240px;">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="a234xzc">
                                    <table class="search-panel">
                                        <tr>
                                            <td class="search-panel-1">
                                                <label>
                                                @if($total_datas != 0)
                                                    {{ ($page_click - 1)  * session()->get('total_row_on_one_page') + 1 }}
                                                @else
                                                    {{ 0 }}
                                                @endif
                                                ～
                                                @if( ($page_click) * session()->get('total_row_on_one_page') >= $total_datas)
                                                    {{ $total_datas }} 件(全{{ $total_datas }}件)
                                                @else
                                                    {{ ($page_click) * session()->get('total_row_on_one_page') }}
                                                件(全{{ $total_datas }}件)
                                                @endif
                                                </label>
                                            </td>
                                            <td class="search-panel-2">
                                                <input type="checkbox"
                                                    class="search_reply" <?php if(Session::has('search_reply')){ echo 'checked';} ?> value="未回答" style="position: relative; top: 4px;" />
                                                <label>完了</label> 
                                            </td>
                                        </tr>
                                    </table>                                
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <label>
                                    <span style="margin-right: 95px">未発注</span>：{{ $arrTotal[0] }}件
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <label>
                                    納期回答未・一部未回答：{{ $arrTotal[1] }}件
                                    </label>
                                </div>                    
                            </div>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <label>
                                    <span style="margin-right: 84px">納期催促</span>：{{ $arrTotal[2] }}件
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="float-right" style="width: calc(100% -240px);">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="float-left">
                                        <label>依頼内容</label>
                                        <select id="search-request" style="width: 120px;">
                                            <option value=""></option>
                                            @foreach ($requestDetails as $request)
                                            <option value="{{ $request->KBNMSAI_CD }}" {{ isset($paramSearch['request_id']) && $paramSearch['request_id'] == $request->KBNMSAI_CD ? 'selected' : '' }}>{{ $request->KBNMSAI_NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            
                                    <div class="float-left" style="padding: 0px 70px">
                                        <label>依頼日</label>
                                        <input type="text" value="{{ isset($paramSearch['irai_day_from']) ? $paramSearch['irai_day_from'] : '' }}" data-date-format="yyyy/mm/dd" autocomplete="off" class="datepicker-input" placeholder="" id="search-irai-day-from" style="width: 120px; "/>
                                        <label style="padding:0px 10px">～</label>
                                        <input type="text" value="{{ isset($paramSearch['irai_day_to']) ? $paramSearch['irai_day_to'] : '' }}" data-date-format="yyyy/mm/dd" autocomplete="off" class="datepicker-input" placeholder="" id="search-irai-day-to" style="width: 120px; "/>        
                                    </div>
                                
                                    <div class="float-left" style="padding: 0px 70px 0px 0px">
                                        <label>ID</label>
                                        <input type="text" value="{{ isset($paramSearch['id']) ? $paramSearch['id'] : '' }}" autocomplete="off" placeholder="" id="search-id" style="width: 120px;"/>    
                                    </div>
                               
                                    <div class="float-right">
                                        <label>状況</label>
                                        <select id="search-status" style="width: 120px;">
                                            <option value=""></option>
                                            @foreach ($statusList as $request)
                                            <option value="{{ $request->KBNMSAI_CD }}" {{ isset($paramSearch['status_id']) && $paramSearch['status_id'] == $request->KBNMSAI_CD ? 'selected' : '' }}>{{ $request->KBNMSAI_NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="float-left">
                                        <label>メーカー</label>
                                        <input type="text" value="{{ isset($paramSearch['maker']) ? $paramSearch['maker'] : '' }}" autocomplete="off" placeholder="" id="search-maker" style="width: 120px; "/>
                                    </div>
                                    <div class="float-left" style="padding: 0px 22px 0px 70px">
                                        <label>納品日</label>
                                        <input type="text" value="{{ isset($paramSearch['nohin_day_from']) ? $paramSearch['nohin_day_from'] : '' }}" placeholder="" id="search-nohin-day-from" autocomplete="off" data-date-format="yyyy/mm/dd" class="datepicker-input"  style="width: 120px; "/>
                                        <label style="padding:0px 10px">～</label>
                                        <input type="text" value="{{ isset($paramSearch['nohin_day_to']) ? $paramSearch['nohin_day_to'] : '' }}" placeholder="" id="search-nohin-day-to" autocomplete="off" data-date-format="yyyy/mm/dd" class="datepicker-input"  style="width: 120px; "/>        
                                    </div>                                
                                    <div class="float-left">
                                        <label>配送先情報</label>
                                        <input type="text" value="{{ isset($paramSearch['address']) ? $paramSearch['address'] : '' }}" autocomplete="off" placeholder="" id="search-address" style="width: 120px; "/>    
                                    </div>                                
                                    <div class="float-right">
                                        <label>品番</label>
                                        <input type="text" value="{{ isset($paramSearch['hinban']) ? $paramSearch['hinban'] : '' }}" placeholder="" autocomplete="off" id="search-hinban" style="width: 120px; "/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <label>
                        <span style="margin-right: 12px">ドライバー情報入力未</span>：{{ $arrTotal[3] }}件
                        </label>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">                 
                        <nav class="pag-nav" aria-label="...">
                            <ul class="pagination">
                                <?php if($total_datas == 0) {?>
                                <li class="page-item ">
                                    <a class="page-link" style="visibility: hidden;">0</a>
                                </li>
                                <?php } ?>
                                <?php
                            $page_avg = floor($page_center / 2);
                            if($total_datas != 0){
                            if ($page_click != 1 && $total_datas > 0) { //Load prev
                                ?>
                                <li class="page-item ">
                                    <a class="page-link " href="{{route('asc_page_current')}}" tabindex="-1">前へ</a>
                                </li>
                                <?php
                            }
                            $page_pre  = $page_click - $page_avg; //số page bên trái của page được click
                            $page_next = $page_click + $page_avg; //số page bên phải của page được click
                            if($page_pre<=0){ //Nếu page trái <=0 thì cộng dồn qua phải
                                $page_next -= $page_pre;
                                $page_next += 1;
                                $page_pre   = 1;
                            }
                            if($page_next > $page_total){ //Nếu page phải > tổng trang thì cộng dồn về trái
                                if($page_pre-($page_next-$page_total)>0){
                                    $page_pre-=$page_next-$page_total;
                                }
                                if($page_click == $page_total && $page_click > 1){
                                    $page_pre = $page_total - 4;
                                    if($page_pre <= 0)
                                        $page_pre = 1;
                                }
                                $page_next = $page_total;
                            }
                            for ($i = $page_pre; $i <= $page_next; $i++) {
                                ?>
                                <li class="page-item <?php if($i==$page_click){echo "active";}?>">
                                    <a class="page-link "
                                        href="{{route('page_click',['page_click'=> $i])}}"><?php echo $i; ?>
                                    </a>
                                </li>
                                <?php
                            }
                            if ($page_click != $page_total && $total_datas > 0) {
                                ?>
                                <li class="page-item">
                                    <a class="page-link " href="{{route('desc_page_current')}}">次へ</a>
                                </li>
                                <?php
                                } }
                            ?>
                            </ul>
                        </nav>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12" id="iro63i">
                            <label>表示</label>
                            <select id="icb8hk">
                                <option value="10"
                                    <?php if(session()->get('total_row_on_one_page') == 10) {echo "selected";}?>>
                                    10件</option>
                                <option value="30"
                                    <?php if(session()->get('total_row_on_one_page') == 30) {echo "selected";}?>>
                                    30件</option>
                                <option value="50"
                                    <?php if(session()->get('total_row_on_one_page') == 50) {echo "selected";}?>>
                                    50件</option>
                            </select>
                            
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12 text-right">
                                <button type="button" class="btn btn-primary mb-2 search_by_item">検索</button>         

                                <button type="button" class="btn btn-primary ml-2 mb-2 search_by_reset">クリア</button>
                            </div>
                            
                        </div>    
                    </div>                   
                </div>

                <div class="row">
                    <div class="table-cover">                    
                    <table class="table table-bordered table2" style="margin-bottom: 0px !important;">
                        <thead>
                            <tr class="blue-tr">
                                @if (!$isUserLifeOne)
                                <th scope="col" class="th1" id="check_all" style="text-decoration: underline;"
                                    width="90"><a>全てチェック</a></th>
                                <th data-col="IRAI_CD" scope="col" class="th2 col-order" width="90">依頼内容<?php if(Session::has('IRAI_CD')){ echo '<i class="fa fa-caret-'.(session()->get('IRAI_CD_asc') == 'asc' ? 'up' : (session()->get('IRAI_CD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="IRAI_YMD" scope="col" class="th3 col-order" width="100">依頼日<?php if(Session::has('IRAI_YMD')){ echo '<i class="fa fa-caret-'.(session()->get('IRAI_YMD_asc') == 'asc' ? 'up' : (session()->get('IRAI_YMD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="HACYU_ID" scope="col" class="th4 col-order" width="100">ID<?php if(Session::has('HACYU_ID')){ echo '<i class="fa fa-caret-'.(session()->get('HACYU_ID_asc') == 'asc' ? 'up' : (session()->get('HACYU_ID_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="STS_CD" scope="col" class="th5 col-order" width="120">状況<?php if(Session::has('STS_CD')){ echo '<i class="fa fa-caret-'.(session()->get('STS_CD_asc') == 'asc' ? 'up' : (session()->get('STS_CD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="MAKER" scope="col" class="th6 col-order" width="120">メーカー<?php if(Session::has('MAKER')){ echo '<i class="fa fa-caret-'.(session()->get('MAKER_asc') == 'asc' ? 'up' : (session()->get('MAKER_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="HAISO_INF" scope="col" class="th7 col-order" width="200">配送先情報<?php if(Session::has('HAISO_INF')){ echo '<i class="fa fa-caret-'.(session()->get('HAISO_INF_asc') == 'asc' ? 'up' : (session()->get('HAISO_INF_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="COMMENT1" scope="col" class="th8 col-order" width="60">備考有<?php if(Session::has('COMMENT1')){ echo '<i class="fa fa-caret-'.(session()->get('COMMENT1_asc') == 'asc' ? 'up' : (session()->get('COMMENT1_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="NOHIN_KIBO_FLG" scope="col" class="th9 col-order" width="85">納品希望有<?php if(Session::has('NOHIN_KIBO_FLG')){ echo '<i class="fa fa-caret-'.(session()->get('NOHIN_KIBO_FLG_asc') == 'asc' ? 'up' : (session()->get('NOHIN_KIBO_FLG_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="FREE" scope="col" class="th10 col-order" width="auto">フリースペース<br/>御社自由入力欄(ライフワン閲覧権限なし)<?php if(Session::has('FREE')){ echo '<i class="fa fa-caret-'.(session()->get('FREE_asc') == 'asc' ? 'up' : (session()->get('FREE_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>

                                @else
                                <th scope="col" class="th1" id="check_all" style="text-decoration: underline;"
                                    width="90"><a>全てチェック</a></th>
                                <th data-col="IRAI_CD" scope="col" class="th2 col-order" width="85">依頼内容<?php if(Session::has('IRAI_CD')){ echo '<i class="fa fa-caret-'.(session()->get('IRAI_CD_asc') == 'asc' ? 'up' : (session()->get('IRAI_CD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="IRAI_YMD" scope="col" class="th3 col-order" width="85">依頼日<?php if(Session::has('IRAI_YMD')){ echo '<i class="fa fa-caret-'.(session()->get('IRAI_YMD_asc') == 'asc' ? 'up' : (session()->get('IRAI_YMD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="HACYU_SYBET_NAME" scope="col" class="th3 col-order" width="70">発注種別<?php if(Session::has('HACYU_SYBET_NAME')){ echo '<i class="fa fa-caret-'.(session()->get('HACYU_SYBET_NAME_asc') == 'asc' ? 'up' : (session()->get('HACYU_SYBET_NAME_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="HACYU_ID" scope="col" class="th4 col-order" width="95">ID<?php if(Session::has('HACYU_ID')){ echo '<i class="fa fa-caret-'.(session()->get('HACYU_ID_asc') == 'asc' ? 'up' : (session()->get('HACYU_ID_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="STS_CD" scope="col" class="th5 col-order" width="100">状況<?php if(Session::has('STS_CD')){ echo '<i class="fa fa-caret-'.(session()->get('STS_CD_asc') == 'asc' ? 'up' : (session()->get('STS_CD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="MAKER" scope="col" class="th6 col-order" width="100">メーカー<?php if(Session::has('MAKER')){ echo '<i class="fa fa-caret-'.(session()->get('MAKER_asc') == 'asc' ? 'up' : (session()->get('MAKER_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="HAISO_INF" scope="col" class="th7 col-order" width="195">配送先情報<?php if(Session::has('HAISO_INF')){ echo '<i class="fa fa-caret-'.(session()->get('HAISO_INF_asc') == 'asc' ? 'up' : (session()->get('HAISO_INF_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="COMMENT2" scope="col" class="th8 col-order" width="60">備考有<?php if(Session::has('COMMENT2')){ echo '<i class="fa fa-caret-'.(session()->get('COMMENT2_asc') == 'asc' ? 'up' : (session()->get('COMMENT2_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="TAIO_TANT_CD" scope="col" class="th9 col-order" width="80">担当者<?php if(Session::has('TAIO_TANT_CD')){ echo '<i class="fa fa-caret-'.(session()->get('TAIO_TANT_CD_asc') == 'asc' ? 'up' : (session()->get('TAIO_TANT_CD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="TAIO_CD" scope="col" class="th9 col-order" width="80">対応状況<?php if(Session::has('TAIO_CD')){ echo '<i class="fa fa-caret-'.(session()->get('TAIO_CD_asc') == 'asc' ? 'up' : (session()->get('TAIO_CD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="LAST_NKAYOTEI_YMD" scope="col" class="th9 col-order" width="110">最終入荷予定日<?php if(Session::has('LAST_NKAYOTEI_YMD')){ echo '<i class="fa fa-caret-'.(session()->get('LAST_NKAYOTEI_YMD_asc') == 'asc' ? 'up' : (session()->get('LAST_NKAYOTEI_YMD_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>
                                <th data-col="HACYUSAKI_NAME" scope="col" class="th9 col-order" width="auto">仕入先様名<?php if(Session::has('HACYUSAKI_NAME')){ echo '<i class="fa fa-caret-'.(session()->get('HACYUSAKI_NAME_asc') == 'asc' ? 'up' : (session()->get('HACYUSAKI_NAME_asc') == 'desc' ? 'down' : '')).'"></i>';} ?></th>                                
                                @endif
                             
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div> 

            </div>
        </div>

        <div class="container-fluid">
            <div class="container grey-bg">
                <div class="row mask-height"></div>
                <div class="row">
                    <div class="table-cover">                    
                    <table class="table table-bordered table2">
                        <thead>
                            <tr class="blue-tr">
                                @if (!$isUserLifeOne)
                                <th scope="col" class="th1" id="check_all" style="text-decoration: underline;"
                                    width="90"><a>全てチェック</a></th>
                                <th data-col="IRAI_CD" scope="col" class="th2 col-order" width="90">依頼内容</th>
                                <th data-col="IRAI_YMD" scope="col" class="th3 col-order" width="100">依頼日</th>
                                <th data-col="HACYU_ID" scope="col" class="th4 col-order" width="100">ID</th>
                                <th data-col="STS_CD" scope="col" class="th5 col-order" width="120">状況</th>
                                <th data-col="MAKER" scope="col" class="th6 col-order" width="120">メーカー</th>
                                <th data-col="HAISO_INF" scope="col" class="th7 col-order" width="200">配送先情報</th>
                                <th data-col="COMMENT1" scope="col" class="th8 col-order" width="60">備考有</th>
                                <th data-col="NOHIN_KIBO_FLG" scope="col" class="th9 col-order" width="85">納品希望有</th>
                                <th data-col="FREE" scope="col" class="th10 col-order" width="auto">フリースペース<br/>御社自由入力欄(ライフワン閲覧権限なし)</th>

                                @else
                                <th scope="col" class="th1" id="check_all" style="text-decoration: underline;"
                                    width="90"><a>全てチェック</a></th>
                                <th data-col="IRAI_CD" scope="col" class="th2 col-order" width="85"><a>依頼内容</a></th>
                                <th data-col="IRAI_YMD" scope="col" class="th3 col-order" width="85">依頼日</th>
                                <th data-col="HACYU_SYBET_NAME" scope="col" class="th3 col-order" width="70">発注種別</th>
                                <th data-col="HACYU_ID" scope="col" class="th4 col-order" width="95">ID</th>
                                <th data-col="STS_CD" scope="col" class="th5 col-order" width="100">状況</th>
                                <th data-col="MAKER" scope="col" class="th6 col-order" width="100">メーカー</th>
                                <th data-col="HAISO_INF" scope="col" class="th7 col-order" width="195">配送先情報</th>
                                <th data-col="COMMENT2" scope="col" class="th8 col-order" width="60">備考有</th>
                                <th data-col="TAIO_TANT_CD" scope="col" class="th9 col-order" width="80">担当者</th>
                                <th data-col="TAIO_CD" scope="col" class="th9 col-order" width="80">対応状況</th>
                                <th data-col="LAST_NKAYOTEI_YMD" scope="col" class="th9 col-order" width="110">最終入荷予定日</th>
                                <th data-col="HACYUSAKI_NAME" scope="col" class="th9 col-order" width="auto">仕入先様名</th>
                                @endif
                            </tr>

                        </thead>
                        <tbody>
                            @if ($page_total > 0)
                                @foreach($lists as $item)
                            <tr>                                 
                                <td>
                                    <input id="chk{{ $item->HACYU_ID }}-0" name="check_box_list[]" data-pdf="{{ $item->PDF_PATH }}" data-excel="{{ $item->EXCEL_PATH }}" class="save_list_checkbox" {{ $item->STS_CD == '01' && !$isUserLifeOne ? 'checked' : '' }} type="checkbox" value="{{ $item->HACYU_ID }}-0">
                                </td>
                                <td style="background: {{ empty($item->IRAI_COLOR) ? 'none' : $item->IRAI_COLOR }}">{{ $item->IRAI_CD_NAME }}</td>
                                <td>{{ !empty($item->IRAI_YMD) ? date('Y/m/d', strtotime($item->IRAI_YMD)) : '' }}</td>
                                @if ($isUserLifeOne)
                                <td>{{ $item->HACYU_SYBET_NAME }}</td>
                                @endif                                
                                <td>
                                    <a class="single_choose"
                                        href="{{ route('search_print',['id'=>$item->HACYU_ID]) }}">{{$item->HACYU_ID}}
                                    </a>
                                </td>
                                <td>{{ $item->STS_CD_NAME }}</td>
                                <td>{{ $item->MAKER }}</td>
                                <td>{!! nl2br(e($item->HAISO_INF)) !!}</td>
                                @if ($isUserLifeOne)
                                <td class="tdDot">@if (!empty($item->COMMENT2)) <span class="dot"></span> @endif</td>
                                <td>{{ $item->TAIO_TANT_NAME }}</td>
                                <td>{{ $item->TAIO_CD }}</td>
                                <td>{{ !empty($item->LAST_NKAYOTEI_YMD) ? date('Y/m/d', strtotime($item->LAST_NKAYOTEI_YMD)) : '' }}</td>
                                <td>{{ $item->HACYUSAKI_NAME }}</td> 
                                @else
                                <td class="tdDot">@if (!empty($item->COMMENT1)) <span class="dot"></span> @endif</td>
                                <td class="tdDot">@if ($item->NOHIN_KIBO_FLG == 1) <span class="dot"></span>@endif</td>
                                <td style="background-color: #FFF2CC;"><textarea data-id="{{ $item->HACYU_ID }}" class="txt-free" style="resize: none; width: 100%" rows="2">{{ $item->FREE }}</textarea></td> 
                                @endif

                                
                            </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    </div>
                </div> 
            </div>               
        </div>

    </form>

    <a id="jumplist1" class="btn btn-raised btn-primary" data-remote="false" data-toggle="modal" data-target="#canceler"
        data-href="#canceler" href="#canceler" style="display:none;">保存</a>
    <div class="modal fade show" id="canceler" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="canceler"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p>メッセージ</p>
                    <p>明細が選択されていません !</p>
                </div>
                <div class="modal-footer" style="justify-content: center;">
                    <button type="button" data-dismiss="modal" class="btn btn-default">OK</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="hdUserLifeOne" value="{{ $isUserLifeOne ? 1 : 0 }}">
    <input type="hidden" id="link-home-url" value="{{ URL::to('/') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>   
    <script src="{{ URL::asset('js/tether.min.js') }}"></script>    
    <script src="{{ URL::asset('datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('datepicker/locales/bootstrap-datepicker.ja.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/scripts.js') }}"></script>
</body>

</html>