document.querySelector('.carousel').addEventListener('wheel', function(event) {
    if (event.deltaY !== 0) {
        event.preventDefault();
        this.scrollLeft += event.deltaY;
    }
});