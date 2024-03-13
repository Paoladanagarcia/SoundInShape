const create_popup = (bgcolor, msg) => {   
    $('body').append(`<div class="popup-container">`+msg+`</div>`);
    const width = 50;
    const side = (100 - width) / 2;
    // console.log($('.popup-container'));
    $('.popup-container').css({
        'width': width+'%',
        'left': side+'%',
        'right': side+'%',
        'top': '15%',
        'margin': '0',
        'padding': '1em',

        'background-color': bgcolor,
        'border-radius': '5px',
        'position': 'fixed',
        'border': '1px solid black',
        'text-align': 'center',
        'color': 'white',
        'font-size': '110%',

        'transition': 'all .5s ease-out'
    });

    const popup_closing_styles = {
        'background-color': 'transparent',
        'color': 'transparent',
        'border': 'none',
        'transition': 'all 1s ease-out'
    }

    setTimeout(() => {
        $('.popup-container').css(popup_closing_styles);
        setTimeout(() => $('.popup-container').remove(), 1000);
    }, 3000);
};