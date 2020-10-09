<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/public/css/style.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->

</head>
@php

$UrlPage= (int)Request::route('numb');
$UrlSearch= (string)Request::route('fulltext');
$decode_limit = json_decode($limit);
$decode_all = $all;
$Ma_p = $Ma;
$Email_p = $Email;
$Sdt_p =  $Sdt;
$idx = 0;
$eachPage = 20;
$eachPaginate = 8;
$page_Start = 0;
$urljs = 0;
$paginate = $decode_all;
$totalPage = ceil($decode_all/20);


$newPaginate=array();
for($i = 1; $i <= $totalPage; $i++) 
{ 
    $slice_refresh=array_slice($newPaginate, $i,8);
     array_push($newPaginate,$i);
 } 
 if($UrlPage !=0)
  { 
      for($i=1; $i <=$totalPage; $i++) 
    { $from=($i - 1) * $eachPaginate; 
        $slice_refresh=array_slice($newPaginate, $from, $eachPaginate); 
        if (in_array($UrlPage, $slice_refresh)) 
        {
             $page_Start=$slice_refresh[0]==1 ? 0 : 
             $slice_refresh[0]-1;
         } 
        } 
    } 
         $slice_Paginate=array_slice($newPaginate, $page_Start, $eachPaginate); 
         if($UrlPage !=0) { $urljs=count($slice_Paginate); }
          @endphp 



    <body class="antialiased">
   
        <div class="container-fluid mycontainer">
        @include('pages.block-3')
            <form>
                <div class="row myrow">
                    <div class="col-md-3 mt-col-3">
                        @include('pages.block-1')

                    </div>
                    <div class="col-md-9 mt-col-9">
                        @include('pages.block-2')
                    </div>

                </div>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
        let MaSo = [];
        let Email = [];
        let Sdt = [];
        MaSo = JSON.parse('<?php echo $Ma_p ?>') ;
        Email = JSON.parse('<?php echo $Email_p  ?>') ;
        Sdt = JSON.parse('<?php echo $Sdt_p  ?>') ;

        function ExistValue(_jsonArray,value)
        {
            let flag = false;
            let name;
            let obj;
            let hasValue;
            for ( obj of _jsonArray) {
               
                 hasValue = Object.values(obj).includes(value);
                if (hasValue) {
                    flag = hasValue;
                }
          }
            return flag;
        }

        </script>
        @include('pages.js-1')
        @include('pages.js-2')
        

    </body>

</html>