<?php 
    $content=file_get_contents('https://tw.rter.info/capi.php');
    $currency_d=json_decode($content);
    $currency=json_encode($currency_d);
    //echo $currency;
?>
<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="全台灣最快的新台幣(TWD)匯率換算網頁應用程式">
        <meta name="keywords" lang="zh-Hant-TW" content="全台灣最快的新台幣(TWD)匯率換算網頁應用程式, 匯率, 外匯, 最新外匯, 匯率換算, 換匯, 最佳換匯銀行, 美元匯率, 日圓匯率, 歐元匯率, 人民幣匯率">
        <!-- <link rel="stylesheet prefetch" href="src/style.css"> -->
        <link rel="stylesheet" type="text/css" href="src/style.css">


        <link rel="shortcut icon" sizes="64x64" type="image/png" href="src/favicon.png"/>
        <link rel="apple-touch-icon" href="src/icon.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="src/icon.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="src/icon.png" />


        
        <meta property="og:image" content="">
        <meta property="og:title" content="TWDEX BETA 1.0 | 最快的新台幣(TWD)匯率換算網頁應用程式">
        <meta property="og:description" content="全台灣最快、迅速的新台幣匯率換算網頁應用程式，無廣告、方便、迅速、即開即使用！！">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://twdex.dongstudio.xyz">



        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <title>TWDEX BETA 1.0 | 全台灣最快的新台幣(TWD)匯率換算網頁應用程式 </title>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136866574-1"></script>

    </head>
    <body>
        <div id="app">
            <div class="box">
                <div :class="ham_class" @click="open_menu">
                    <div class="line line1"></div>
                    <div class="line line2"></div>
                </div>
                <div :class="menu_class">
                    <div class="menu-block utc-block">
                        <div class="utc">UTC</div>
                        <p>{{this.currency.USDTWD.UTC}}</p>
                    </div>
                    <div class="menu-block recent-used">
                        <div class="title"><i class="far fa-flag"></i>經常使用</div>
                        <ul>
                            <li v-for="country in usual_used" @click="change_country(country)">
                                <span><i class="fas fa-coins"></i></i>{{country}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="menu-block pop-used">
                        <div class="title"><i class="far fa-flag"></i>最受歡迎</div>
                        <ul>
                            <li v-for="country in pop_used" @click="change_country(country.value)">
                                <img :src=`src/flags/${country.img}.svg` alt="">
                                <div class="name">{{country.name}}</div>
                            </li>
                        </ul>
                    
                    </div>
                    <div class="menu-block">
                        <div class="title"><i class="far fa-flag"></i>更多貨幣</div>
                        <div class="select-dropdown">
                            <select name="" id="country" v-model="rate_name">
                                <?php foreach($currency_d as $key => $obj):?>
                                    <?php if(strlen($key)==6): ?>
                                    <option value="<?php echo substr($key, 3, 6); ?>"><?php echo substr($key, 3, 6); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="menu-block about">
                        <div class="title"><i class="far fa-flag"></i>關於TWDEX</div>
                        <p v-html="about"></p>
                        <div class="media">
                            <a href="https://www.facebook.com/dongfrontend/" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.instagram.com/d0ngy1n/" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://github.com/Lockingdong/twdex" target="_blank">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div :class="panel_class">
                    <div class="cur-rate">
                        <div v-if="!switched">1 TWD = {{round4((other_rate/currency.USDTWD.Exrate))}} {{rate_name}}</div>
                        <div v-else>1 {{rate_name}} = {{round4(currency.USDTWD.Exrate/other_rate)}} TWD</div>
                    </div>
                    <div class="input-area" v-if="!switched">
                        <div class="rate-wrap">
                            <input class="rate-input" type="text" v-model="twd" disabled ><span class="rate-name">TWD</span>
                        </div>
                        <div class="arrow">▼</div>
                        <div class="rate-wrap">
                            <div class="rate-output">
                                {{round2((other_rate/currency.USDTWD.Exrate)*twd)}}
                            </div>
                            <span class="rate-name">{{rate_name}}</span>
                        </div>   
                    </div>
                    <div class="input-area" v-else>
                        <div class="rate-wrap">
                            <input class="rate-input" type="text" v-model="other_rate_input" disabled><span class="rate-name">{{rate_name}}</span>
                        </div>
                        <div class="arrow">
                            ▼ 
                        </div>
                        <div class="rate-wrap">
                            <div class="rate-output">
                                {{round2((currency.USDTWD.Exrate/other_rate)*other_rate_input)}}
                            </div>
                            <span class="rate-name">TWD</span>
                        </div>   
                    </div>
                </div>
                <div class="buttons">
                    <div class="number" v-for="number in numbers" :value="number" @click="enter_number(number)">{{number}}</div>
                    <!-- <div class="number" value="." @click="enter_number('.')">.</div> -->
                    <div :class="last_number" @click="to_zero">c</div>
                </div>
                <div :class="switch_class" @click="change">轉換</div>
                <div :class="mask_class" @click="close_menu"></div>

                <transition name="fade">
                <div class="login" v-if="!login">
                    <div class="wrap">
                        <div :class="login_title_class">
                            很好<br>準備開始吧！
                        </div>
                        <div :class="login_button_class" @click="log_in">
                            開始體驗
                        </div>
                    </div>
                </div>
                </transition>
                
                <transition name="fade">
                <div class="start-page" v-if="usual_used.length==0">
                    <div class="title">
                        <div class="text text1">歡迎使用!!!</div>
                        <div class="logo">
                            <img src="src/twdex.png" alt="">
                        </div>
                        <div class="text text2">請選擇您想轉換的貨幣</div>
                    </div>
                    <div class="countries">
                        <ul>
                            <li v-for="country in pop_used" @click="change_country(country.value)">
                                <img :src=`src/flags/${country.img}.svg` alt="">
                                <div class="name">{{country.name}}</div>
                            </li>
                        </ul>
                        <div class="select-dropdown">
                            <select name="" id="country2" v-model="rate_name">
                                <?php foreach($currency_d as $key => $obj):?>
                                    <?php if(strlen($key)==6): ?>
                                    <option value="<?php echo substr($key, 3, 6); ?>"><?php echo substr($key, 3, 6); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                </transition>
                
            </div>


            
        </div>

    <?php echo '
        <script>
            let currency = '.$currency.';
        </script>
    ';?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.8/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.10.1/lodash.js"></script>
    <script src="src/all.js"></script>
    </body>
</html>