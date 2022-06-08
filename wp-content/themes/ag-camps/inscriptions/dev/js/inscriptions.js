document.addEventListener('DOMContentLoaded', function() {
    const elementCalendrier = document.querySelector('#calendrier_camps');
    const calendrier = new FullCalendar.Calendar(elementCalendrier, {
        timezone:'local',
        locale:'fr-CA',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
        displayEventTime:false,
        events:siteData.home_url+'wp-json/wp/v2/camps',
        eventContent: renderEventsContent,
        eventDidMount: addEventsTooltip,
        loading: function (bool) {
            if(bool){
                document.querySelector('#calendrier_camps').classList.add('loading')
            }else{
                document.querySelector('#calendrier_camps').classList.remove('loading')
            }
        },
        viewDidMount : (view)=>{
            const parent = view.el.parentNode.parentNode;
            const title = parent.querySelector('.fc-toolbar-title')
            let content = title.innerHTML;
            title.insertAdjacentHTML('beforeEnd',` <i class="fa-solid fa-spinner fa-spin-pulse"></i>`)
        },
    });
    calendrier.render();

    document.querySelectorAll('.list-toggle').forEach(x=>{x.addEventListener('click',function(){
        document.querySelector('.container-flex-inscription').classList.toggle('close-list')
    })})
});

function addEventsTooltip(info){
    var tooltip = new tippy(info.el, {
        interactive:true,
        theme:'dark content-camp',
        allowHTML:true,
        content:`<span>${info.event.title}</span>${info.event.extendedProps.description}`,
        placement: 'top-end',
        zIndex:99999,
        appendTo: () => document.body
    });
}

function renderEventsContent(info){
    return {
        html:`  <div class="fc-content-flex fc-sticky ">
                    <span>${info.event.title}</span>
                    <span><span class="places" >${info.event.extendedProps.max_places} places disponibles</span>  <span class="btn">inscription</span><i class="fa-solid fa-right-long"></i></span>
                </div>
        `
    };
}


