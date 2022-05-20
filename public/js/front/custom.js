(function (){
    let body = document.body,
        html = document.documentElement;

    let height = Math.max(body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight, html.offsetHeight);
    if(!document.querySelector('.product-container'))body.style.height = `${height}px`;
    if(!document.querySelector('.product-container'))html.style.height = `${height}px`;
    height = height*65/100;
    if(!document.querySelector('.product-container'))document.querySelector('.wrapper').style.minHeight = `${height}px`;
    if(document.querySelector('.cart-container')) document.querySelector('.cart-container').style.minHeight = `${height}px`;
    if(document.querySelector('.page-container')) document.querySelector('.page-container').style.minHeight = `${height}px`;
    if(document.querySelector('.auth-container')) document.querySelector('.auth-container').style.minHeight = `${height}px`;

})();
