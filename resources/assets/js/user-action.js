window.UserAction = class UserAction {
    static token() {
        return document.querySelector("meta[name=csrf-token]").getAttribute('content');
    }
    static sendRequest(el, url) {
        const xhttp = new XMLHttpRequest();
        xhttp.responseType = 'json';
        xhttp.onreadystatechange = () => {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                const json = xhttp.response;
                if (json.action == "vote")
                    this.updateVoteCount(el, json);
            }
        }
        xhttp.open("POST", url);
        xhttp.setRequestHeader("X-CSRF-TOKEN", this.token());
        xhttp.send();
    }
    static updateVoteCount(el, json) {
        const profileActionEl = el.parentElement;
        const upvoteEl = profileActionEl.querySelector('.upvote_stat');
        const downvoteEl = profileActionEl.querySelector('.downvote_stat');
        const tastyEl = (profileActionEl.parentElement.parentElement).querySelector('.tasty_stat');

        const upvoteCount = parseInt(json.upvotes);
        const downvoteCount = parseInt(json.downvotes);
        const tastyCount = parseInt(json.user_tasties);


        upvoteEl.innerText = upvoteCount;
        downvoteEl.innerText = downvoteCount;
        tastyEl.innerText = tastyCount;


    }
    static createCommentForm(el, action) {
        if (!(el.parentElement.querySelector('.comment__form'))) {

            let form = document.createElement("form");
            form.method = 'post';
            form.action = action;
            form.setAttribute('class', 'mt-1 mt-lg-3 comment__form');

            let tokenInput = document.createElement('input');
            tokenInput.value = this.token();
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';

            let textarea = document.createElement('textarea');
            textarea.name = 'content';
            textarea.setAttribute('class', 'form-control my-2');

            let submitButton = document.createElement('button');
            submitButton.type = 'submit';
            submitButton.setAttribute('class', 'btn btn-primary');
            submitButton.innerText = 'Submit';

            form.appendChild(textarea);
            form.appendChild(tokenInput);
            form.appendChild(submitButton);

            el.parentElement.appendChild(form);
        }
    }
}
