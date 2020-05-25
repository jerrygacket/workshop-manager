async function getOperations(uuid) {
    //console.log(uuid);
    let data = {"uuid": uuid};
    await sendRequest('/site/get-operations', data, 'GET')
        .then((response) =>  {
            if (response.error) {
                alert(response.message);
            }  else {
                setOperations(uuid, response.result);
                // console.log(response.result);
            }
        })
        .catch((error) => console.log(error));
}

function setOperations(uuid, operations) {
    let div = document.getElementById('result'+uuid);
    div.innerHTML = operations;
}

async function addOperation(elem) {
    url = '/site/add-operation';
    // alert(elem.dataset.operationid);
    let done = document.getElementById('inputDone' + elem.dataset.operationid).value;
    let comment = document.getElementById('comment' + elem.dataset.operationid).value;
    let data = {
        "techCardUuid": elem.dataset.techcarduuid,
        "operationUuid": elem.dataset.operationuuid,
        "description": elem.dataset.description,
        "comment": comment,
        "done": done,
        "total": elem.dataset.total
    };
    await sendRequest(url, data, 'GET')
        .then((response) =>  {
            if (response.error) {
                alert(response.message);
            }  else {
                setOperations(elem.dataset.techcarduuid, response.result);
                // console.log(response.result);
            }
        })
        .catch((error) => console.log(error));
}