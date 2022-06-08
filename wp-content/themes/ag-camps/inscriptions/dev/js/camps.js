document.addEventListener('DOMContentLoaded', function() {

    initmap();
    addPriceBracketTooltip();

    const fulldates = Array.from(document.querySelector('#full-days').options).map((x)=>x.value)
    let date_qty = {};
    Array.from(document.querySelector('#valid-days').options).forEach((x)=>{date_qty[x.value] = x.innerHTML;})

    function get2DigitFmt(val) {
        return ('0' + val).slice(-2);
    }

    const pickr = flatpickr("#calendrier", {
        inline: true,
        mode: "multiple",
        dateFormat: "Y-m-d",
        locale:"fr",
        enable:  Array.from(document.querySelector('#valid-days').options).map((x)=>x.value),
        onChange: function(selectedDates, dateStr, instance) {
            debouceFetch()
        },
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const date = dayElem.dateObj;
            const format_date = date.getFullYear()+'-'+get2DigitFmt(date.getMonth() + 1)+'-'+get2DigitFmt(date.getDate());
            if (fulldates.indexOf(format_date) !== -1) {
              dayElem.className += " date-full";
            }
            if(Object.keys(date_qty).indexOf(format_date) !== -1){
                dayElem.insertAdjacentHTML('beforeEnd',`<span title="${date_qty[format_date]} place${date_qty[format_date]>1?'s':''} disponible${date_qty[format_date]>1?'s':''}.">${date_qty[format_date]}</span>`);
            }



        },
        onReady: function(){
            if(this.config._enable.length>0){
                this.jumpToDate(this.config._enable[0]);
            }else if(fulldates.length>0){
                this.jumpToDate(fulldates[0]);
            }
        }
    });

    document.querySelector('.camp-reservation h2').addEventListener('click',function(e){
        e.target.parentNode.classList.toggle('open')
        document.body.classList.toggle('add-to-cart-open')
    })

    document.querySelectorAll('[name="enfants[]"]').forEach(x=>x.addEventListener('click',function(){
        debouceFetch()
    }))

    document.querySelector('#all-week').addEventListener('click',function(){
        pickr.setDate(Array.from(document.querySelector('#valid-days').options).map((x)=>x.value),true)
    })

    document.querySelector('#all-week').addEventListener('click',function(){
        pickr.setDate(Array.from(document.querySelector('#valid-days').options).map((x)=>x.value),true)
    })

    document.querySelector('#inscription').addEventListener('submit',function(e){
        e.preventDefault();
    })

    document.body.addEventListener('click',e=>{
        if(e.target.id == "bouton-add-to-cart"){
            addToCart();
        }
    })


    debouceFetch();
});

let debounceFetchTimeout;
let isFetchingPrice = false;
let queueFetch = false;
function debouceFetch(){
    if(!isFetchingPrice){
        clearTimeout(debounceFetchTimeout);
        debounceFetchTimeout = setTimeout(fetchAddToCart,250);
    }else{
        queueFetch = true;
    }
    
}
function fetchAddToCart(){
    document.querySelector('p.error').innerHTML = "";
    const loader = document.querySelector('#add-to-cart .loader');
    loader.classList.remove('hide')
    isFetchingPrice = true;
    queueFetch = false;
    const form = document.querySelector('#inscription');
    const formdata = new FormData(form)
    let object = {};
    formdata.forEach((value, key) => {
        if(!Reflect.has(object, key)){
            object[key] = value;
            return;
        }
        if(!Array.isArray(object[key])){
            object[key] = [object[key]];    
        }
        object[key].push(value);
    });

    wp.apiFetch({
        path:'inscriptions/load-add-to-cart',
        method:"POST",
        data:object
    }).then(response=>{
        isFetchingPrice = false;
        if(queueFetch){
            fetchAddToCart();
        }else{
            renderAddToCart(response)
            loader.classList.add('hide')
        }
    });
}

function renderAddToCart(data){
    const container = document.querySelector('#add-to-cart .inner');
    const noRes = document.querySelector('#add-to-cart .no-choice');
    if(!data.success){
        container.classList.add('hide');
        noRes.classList.remove('hide');
        return;
    }else{
        noRes.classList.add('hide');
        container.classList.remove('hide');
    }
    container.innerHTML = "";
    container.insertAdjacentHTML('afterbegin',`
        <h4><span>Prix:</span> <span>${data.price}$</span></h4>
        <button id="bouton-add-to-cart" class="ins-btn">Ajouter au panier</button>
        <p><small>Cumul des journées inscrites: ${data.cumulative}</small></p>
    `);
    const old_bracket_el = document.querySelector(`.selected_bracket`);
    if(old_bracket_el){
        old_bracket_el.classList.remove('selected_bracket');
    }

    const bracket_el = document.querySelector(`[data-bracket="${data.price_bracket}"]`);
    if(bracket_el){
        bracket_el.classList.add('selected_bracket');
    }

}

function addToCart(){
    const error = document.querySelector('p.error');
    const loader = document.querySelector('#add-to-cart .loader');
    loader.classList.remove('hide')
    isFetchingPrice = true;
    queueFetch = false;
    const form = document.querySelector('#inscription');
    const formdata = new FormData(form)
    let object = {};
    formdata.forEach((value, key) => {
        if(!Reflect.has(object, key)){
            object[key] = value;
            return;
        }
        if(!Array.isArray(object[key])){
            object[key] = [object[key]];    
        }
        object[key].push(value);
    });

    wp.apiFetch({
        path:'inscriptions/add-to-cart',
        method:"POST",
        data:object
    }).then(response=>{
        loader.classList.add('hide')
        if(response.success){
            location.href = response.redirect;
        }else{
            error.innerHTML = response.error;
        }
        
    });
}

function initmap(){
    const container = document.getElementById('map');
    if(!container) return 
    const lat = parseFloat(container.getAttribute('data-lat'));
    const lng = parseFloat(container.getAttribute('data-lng'));
    const address = container.getAttribute('data-address');

    const map = new google.maps.Map( container,{
        zoom: 16,
        center: {lat:lat,lng:lng},
        scrollwheel : false,
        zoomControl: true,
        disableDefaultUI: true,
    });

    const marker = new google.maps.Marker({
        position: {lat:lat,lng:lng},
        map: map,
        
      });
    
    
    
}


function addPriceBracketTooltip(info){
    document.querySelectorAll('td i.fa-circle-info').forEach(el=>{
        var tooltip = new tippy(el, {
            interactive:true,
            theme:'dark content-camp',
            allowHTML:true,
            content:`Le prix est calculé selon le nombre de journée inscrite cumulative de l'année en cours.`,
            placement: 'top',
            zIndex:99999,
            appendTo: () => document.body
        });
    })
    
}