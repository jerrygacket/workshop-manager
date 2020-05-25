let baseUri = window.location.origin;

window.onload = function() {
    let operButtons = document.getElementsByClassName('ajaxLink');
    for (var i = 0; i < operButtons.length; i++) {
        let linkUuid = operButtons[i].dataset.uuid;
        operButtons[i].addEventListener('click', (e) => {
            e.preventDefault();
            getOperations(linkUuid);
        });
        // console.log(operButtons[i].id); //second console output
    }
};