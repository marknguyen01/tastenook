window.UserAction = class UserAction {
    static token() {
        return document.querySelector("meta[name=csrf-token]").getAttribute('content');
    }
    static sendRequest(el, url) {
        const xhttp = new XMLHttpRequest();
        xhttp.responseType = 'json';
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                const target = el.querySelector(".action__stats");
                const json = xhttp.response;
                let count = parseInt(target.innerText);

                console.log(count);
                if (json.count_increased) target.innerHTML = count + 1;
                else target.innerHTML = count - 1;
            }
        }
        xhttp.open("POST", url);
        xhttp.setRequestHeader("X-CSRF-TOKEN", this.token());
        xhttp.send();
    }
}
