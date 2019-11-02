import ErrorBag from "./ErrorBag";

export default class Form {
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new ErrorBag();
    }

    reset() {
        for (let field in this.originalData) {
            this[field] = this.originalData[field];
            /*delete this[field];*/
        }

        this.errors.clear();
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
}