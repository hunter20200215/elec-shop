(function (){
    let body = document.body,
        html = document.documentElement;

    let height = Math.max(body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight, html.offsetHeight);
    body.style.height = `${height}px`;
    html.style.height = `${height}px`;
    height = height*95/100;
    if(document.querySelector('.wrapper')){
        document.querySelector('.wrapper').style.minHeight = `${height}px`;
    }
    if(document.querySelector('.content-wrapper')){
        document.querySelector('.content-wrapper').style.minHeight = `${document.querySelector('.content-wrapper').parentElement.scrollHeight * 95 /100}px`;
        if(document.querySelector('.content-container')){
            document.querySelector('.content-container').style.minHeight = `${document.querySelector('.content-wrapper').scrollHeight * 93 /100}px`;
        }
    }
})();
function toggleOtherSettings(){
    let otherSettings = document.querySelector('#otherSettings');
    if(otherSettings.classList.contains('hidden-settings')){
        if(otherSettings.classList.contains('other-settings-close-animation')) otherSettings.classList.remove('other-settings-close-animation');
        otherSettings.classList.add('other-settings-open-animation');
        otherSettings.classList.remove('hidden-settings');
    }
    else{
        otherSettings.classList.remove('other-settings-open-animation');
        otherSettings.classList.add('other-settings-close-animation')
        otherSettings.classList.add('hidden-settings');
    }
}
