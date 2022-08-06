var iex_key = "pk_c29c4bbe9d3043a2bb912e07eb4cbf94";
var opt_symbols = "https://sandbox.iexapis.com/stable/ref-data/options/symbols/";

//set the variables for getting the current data plus 1 month
var today = new Date();
var dd = String(today.getDate()).padStart(2,'0')
var mm = String(today.getMonth() + 2).padStart(2, '0');
var yyyy = String(today.getFullYear());
today = yyyy + '-' + mm + '-' + dd;
console.log(today)

//function for grabbing the ticker from the stock positions table and making calls to the IEX api
$(document).ready(function(){
    //function to allow me to grab the text from the td class for tickers
    var array = $('.ticker').map(function(){
        return $(this).text();
    }).get();

//functions for making calls to iex api for options    
    array.forEach(element => {
        fetch(`https://cloud.iexapis.com/stable/stock/${element}/quote?token=${iex_key}`)
        .then(resp => resp.json())
        .then(value =>{
            fetch(`https://cloud.iexapis.com/stable/ref-data/options/symbols/${value.symbol}?token=${iex_key}`)
            .then(resp => resp.json())
            .then(val =>{
                for(var key in val){
                    if(val[key].expirationDate < today && (val[key].strike - value.latestPrice) < 2 && (val[key].strike - value.latestPrice) > 0 && val[key].side == 'call'){
                        var breakeven = val[key].strike - value.latestPrice
                        var table_setup = "<tr><td name='expirationdate'>"+val[key].expirationDate+"</td><td>"+val[key].underlying+"</td><td>"+val[key].strike+
                        "</td><td>"+breakeven.toFixed(2)+"</td></tr>";
                        $('.opt_table').append(table_setup)
                    }
                }
            })
        })
    });


    //function for making calls to iex for the relevant news
    array.forEach(ele =>{
        fetch(`https://cloud.iexapis.com/stable/stock/${ele}/news?token=${iex_key}`)
        .then(resp => resp.json())
        .then(val=>{
            for(var key in val){
                if((val[key].summary).includes("downward") || (val[key].summary).includes("bearish") || (val[key].summary).includes("decline")){
                    var bearish_table = "<tr><td>"+val[key].headline+`</td><td><a style='color: white;'target="_blank" href='${val[key].url}'>`+"Click Here</a></td><td>"+ele+"</td><td>"+"Bearish</td></tr>";
                    $('.news_table').append(bearish_table);
                }
                if((val[key].summary).includes("upward") || (val[key].summary).includes("bullish") || (val[key].summary).includes("increas")){
                    var bullish_table = "<tr><td>"+val[key].headline+`</td><td><a target='_blank'href=${+val[key].url}>`+"Click Here</a></td><td>"+ele+"</td><td>"+"Bullish</td></tr>";
                    $('.news_table').append(bullish_table);
                }
            }
        })
    })
   
})
var iex_sandbox = "Tpk_49ea600b81bc49d88aaa89cb49695080"

fetch(`https://sandbox.iexapis.com/stable/stock/FB/quote?token=${iex_sandbox}`)
.then(resp => resp.json())
.then(value =>{
    console.log(value)
})