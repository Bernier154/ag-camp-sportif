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
        events:'https://agcampsportif.lan/wp-json/wp/v2/camps',
        eventContent: renderEventsContent,
        eventDidMount: addEventsTooltip
    });
    calendrier.render();
});

function addEventsTooltip(info){
    var tooltip = new tippy(info.el, {
        content: info.event.extendedProps.description,
        placement: 'top-end'
    });
}

function renderEventsContent(info){
    console.log(info)
    return {
        html:`  <div class="fc-content-flex fc-sticky ">
                    <span>${info.event.title}</span>
                    <span>12 places disponibles  <span class="btn">inscription</span><i class="fa-solid fa-right-long"></i></span>
                </div>
        `
    };
}

