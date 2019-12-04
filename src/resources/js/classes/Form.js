import ErrorBag from "./ErrorBag";

export default class Form {

    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new ErrorBag();
    }

    data() {
        let data = {};
        for (let property in this.originalData) {
            data[property] = this[property];
        }
        return data;
    }

    reset() {
        for (let field in this.originalData) {
            this[field] = this.originalData[field];
        }

        this.errors.clear();
    }

    onSuccess(response) {
        this.reset();
    }

    onFail(error) {
        if (typeof error.response.data.data === 'object') {
            if (error.response.data.data.errors) {
                this.errors.setAll(error.response.data.data.errors);
            } else {
                this.errors.message = error.response.data.data.message;
            }
        } else {
            this.errors.message = 'Please reload the page and try again.';
        }
    }

    submit(requestMethod, url) {
        return new Promise((resolve, reject) => {
            axios[requestMethod](url, this.data())
                .then(response => {
                    this.onSuccess(response);
                    resolve(response);
                })
                .catch(error => {
                    this.onFail(error);
                    reject(error);
                });
        });
    }

    get(url) {
        return this.submit('get', url);
    }

    post(url) {
        return this.submit('post', url);
    }

    put(url) {
        return this.submit('put', url);
    }

    patch(url) {
        return this.submit('patch', url);
    }

    delete(url) {
        return this.submit('delete', url);
    }
}