function sortSelect(el){
    var options = $(el);
    var arr = options.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options.each(function(i, o) {
        //console.log(i);
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
}

sortSelect('select#country option');
sortSelect('select#country2 option');


var times = localStorage.getItem("times");
if(times == null) {
    times = 0;
} else {
    times = parseInt(times, 10);
}
times++;
localStorage.setItem("times", (times).toString(10))



var login = JSON.parse(localStorage.getItem("login"));
if(login==null){
    login = false;
}

var usual_used = JSON.parse(localStorage.getItem("countries"));
if(usual_used==null){
    usual_used = [];
}
    
var country = localStorage.getItem("country");
if(country==null){
    country = 'TWD';
}

var switched = JSON.parse(localStorage.getItem("switched"));
if(switched==null){
    switched = false;
}
//https://img.icons8.com/color/48/000000/hongkong-flag.png

let about = `
此應用程式之即時匯率是由<a href="https://tw.rter.info/howto_currencyapi.php">全球即時匯率API</a>
所提供。<br><br>
<small>DEVELOPED BY </small>
<a href="https://www.facebook.com/dongfrontend/" target="_blank"><strong>DONGSTUDIO</strong></a>
<br>
<br>
<a tagert="_blank" href="https://www.facebook.com/dongfrontend/"><small>問題回報</small></a>
`;
let pop_used = [
    {
        name: "中國",
        value: "CNY",
        img: "cn"
    },
    {
        name: "韓國",
        value: "KRW",
        img: "kr"
    },
    {
        name: "香港",
        value: "HKD",
        img: "hk"
    },
    {
        name: "日本",
        value: "JPY",
        img: "jp"
    },
    {
        name: "泰國",
        value: "THB",
        img: "th"
    },
    {
        name: "菲律賓",
        value: "PHP",
        img: "ph"
    },
    {
        name: "新加坡",
        value: "SGD",
        img: "sg"
    },
    {
        name: "馬來西亞",
        value: "MYR",
        img: "my"
    },
    {
        name: "美國",
        value: "USD",
        img: "us"
    },
    {
        name: "澳洲",
        value: "AUD",
        img: "au"
    }
];
//vue
new Vue({
    el: "#app",
    data: {
        times,
        currency,
        twd: 0,
        other_rate_input: 0,
        numbers: [7, 8, 9, 4, 5, 6, 1, 2, 3, 0, '.'],
        rate_name: country,
        usual_used,
        has_point: false,
        has_point2: false,
        switched,
        menu_opend: false,
        pop_used,
        about,
        mounted: false,
        login,
        login_el: false
    },
    computed: {
        other_rate(){
            return this.currency['USD'+this.rate_name].Exrate;
        },
        panel_class(){
            return (this.switched)?'panel':'panel pink';
        },
        last_number(){
            return (!this.switched)?'number':'number number_pink';
        },
        menu_class(){
            return (!this.menu_opend)?'menu':'menu menu_in';
        },
        mask_class(){
            return (!this.menu_opend)?'mask':'mask mask_in';
        },
        ham_class(){
            return (!this.menu_opend)?'ham':'ham ham_black';
        },
        switch_class(){
            return (!this.switched)?'switch':'switch switch_pink';
        },
        app_class(){
            return (!this.mounted)?'box':'box mounted';
        },
        login_title_class(){
            if(!this.login_el){
                return (this.times >=2 )?'title fadeIn':'title';
            }else{
                return 'title fadeIn';
            }
        },
        login_button_class(){
            
            if(!this.login_el){
                return (this.times >=2 )?'button fadeIn':'button';
            }else{
                return 'button fadeIn';
            }
        }
    },
    methods: {
        enter_number(num){
            let regex = /^0{2}/;
            var regex2 = /^0[0-9]/;
            let str = this.twd.toString();
            if(num=='.'){
                if(!this.has_point){
                    str += num;
                    this.twd = str.toString();
                    this.has_point = true;
                }
            }else{
                str += num;
                //this.twd = parseFloat(str);
                
                if(regex.test(str)){
                    //console.log(123)
                    this.twd = str.replace('00', '0');
                }else{
                    if(regex2.test(str)){
                        this.twd = str.replace('0', '');
                    }else{
                        this.twd = str;
                    }
                    
                }
                
            }



            
            let str2 = this.other_rate_input.toString();
            if(num=='.'){
                if(!this.has_point2){
                    str2 += num;
                    this.other_rate_input = str2.toString();
                    this.has_point2 = true;
                }
            }else{
                str2 += num;
                if(regex.test(str2)){
                    this.other_rate_input = str2.replace('00', '0');
                }else{
                    if(regex2.test(str2)){
                        this.other_rate_input = str2.replace('0', '');
                    }else{
                        this.other_rate_input = str2;
                    }
                    
                }
                
            }
        },
        to_zero(){
            this.twd = 0;
            this.other_rate_input = 0;
            this.has_point = false;
            this.has_point2 = false;

        },
        change_country(con){
            this.rate_name = con;
        },
        change(){
            this.switched = !this.switched;
            localStorage.setItem("switched", this.switched);
        },
        round2(num){
            return Math.round(num * 100) / 100;
        },
        round4(num){
            return Math.round(num * 10000) / 10000;
        },
        open_menu(){
            this.menu_opend = !this.menu_opend;
        },
        log_in(){
            this.login = true;
            localStorage.setItem("login", JSON.stringify(this.login));
        },
        close_menu(){
            this.menu_opend = false;
        }
    },
    watch: {
        rate_name($new){
            localStorage.setItem("country", $new);

            this.usual_used.unshift($new);

            this.usual_used = (_.uniq(this.usual_used)).slice(0, 6);

            localStorage.setItem("countries", JSON.stringify(this.usual_used));

            if(this.usual_used.length != 1){
                this.menu_opend = !this.menu_opend;
            }
            
            this.login_el = true;
            
        }
    },
    mounted(){
        this.mounted = true;
        
        $(window).keydown( e => {
            if(e.keyCode==8){
                this.to_zero();
            }else if(e.keyCode==32){
                this.change();
            }else if(e.keyCode==190){
                this.enter_number('.');
            }else{
                if(e.keyCode>=48 && e.keyCode<=57){
                    this.enter_number(e.keyCode-48);
                }
            }
        })
        setTimeout(()=>{
            $('.box').addClass('mounted');
        },500);
    }
    
});