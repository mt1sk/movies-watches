export default class ErrorBag {
    constructor() {
        this.errors = {};
        /*this.errorsArr = [];*/
        this.message = '';
    }

    get(field) {
        if (this.has(field)) {
            return this.errors[field][0];
        }
    }

    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }

    setAll(errors) {
        this.errors = errors;
        /*this.errorsArr = _.flatten(_.toArray(this.errors));*/
    }

    clear(field) {
        if (field !== undefined) {
            delete this.errors[field];
        } else {
            this.errors = {};
            this.message = '';
        }
    }

}