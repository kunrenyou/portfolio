'use strict';
{
    const targets = document.querySelectorAll('.anim');
    function animObserver(elements, timimg) {
        const options = {
            root: null,
            rootMargin: `0px 0px ${timimg}px 0px`,
            threshold: [0]
        }
        function callback(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }
        const observer = new IntersectionObserver(callback, options);
        elements.forEach(target => {
        observer.observe(target);
    });
    }
    if(window.innerWidth>=768){
    animObserver(targets, -100); /*PC */
    }else{
    animObserver(targets,-50); /*SP */
    }
}