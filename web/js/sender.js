async function sendRequest(url, data = {}, $method = 'GET') {
    switch ($method) {
        case "GET":{
            return sendGETRequest(url, data);
        }
        case "POST":{
            return sendPOSTRequest(url, data);
        }
    }
}

function http_build_query(jsonObj) {
    const keys = Object.keys(jsonObj);
    const values = keys.map(key => jsonObj[key]);

    return keys
        .map((key, index) => {
            return `${key}=${values[index]}`;
        })
        .join("&");
}

async function sendGETRequest(url, data = {}) {
    var requestFields = {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    };
    let queryString = http_build_query(data);
    console.log(baseUri+url+'?'+queryString);
    let result = {};
    await fetch(baseUri+url+'?'+queryString, requestFields)
        .then((response) => {
            //console.log(response);
            if (response.status >= 200 && response.status < 300) {
                result = response.json();
            } else {
                let error = new Error(response.statusText);
                error.response = response;
                throw error
            }
        })
        .catch((error) => console.log(error));

    return result;
}

async function sendPOSTRequest(url, data = {}) {
    var requestFields = {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    let result = {};
    await fetch(baseUri+url, requestFields)
        .then((response) => {
            if (response.status >= 200 && response.status < 300) {
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response;
                } else {
                    return response.text().then(text => {
                        console.log(text);
                    });
                }
            } else {
                var error = new Error(response.statusText);
                error.response = response;
                throw error
            }
        })
        .then((response) => response.json())
        .then((data) => {
            result = data;
            console.log(data);
        }).catch((error) => console.log(error));

    return result;
}