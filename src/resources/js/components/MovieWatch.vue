<template>
    <div class="row justify-content-center pt-1">
        <form class="mt-2 mx-5" @keydown="watchForm.errors.clear($event.target.name)">
            <div class="alert alert-danger mt-3" v-if="watchForm.errors.message">
                <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                <p class="mb-0">{{ watchForm.errors.message }}</p>
            </div>
            <div class="form-row">
                <div class="form-group col-4 col-sm-5">
                    <input v-model="watchForm.year" type="text" name="year" class="form-control" id="movieYear" placeholder="Year">
                    <small class="form-text text-danger" v-show="watchForm.errors.has('year')">
                        {{ watchForm.errors.get('year') }}
                    </small>
                </div>

                <div class="form-group col-4 col-sm-5">
                    <input v-model="watchForm.count" type="text" name="count" class="form-control" id="movieCount" placeholder="Count watches">
                    <small class="form-text text-danger" v-show="watchForm.errors.has('count')">
                        {{ watchForm.errors.get('count') }}
                    </small>
                </div>

                <div class="form-group col-2 col-sm-1">
                    <button type="submit" class="btn btn-success" :disabled="watchForm.errors.any()" @click.prevent="saveWatch">
                        &#10004;
                    </button>
                </div>
                <div class="form-group col-2 col-sm-1">
                    <a href="#" class="btn btn-danger" @click.prevent="deleteWatch">X</a>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Form from "../classes/Form";

    export default {
        name: "MovieWatch",

        props: {
            watch: {required: true},
        },

        data() {
            return {
                watchForm: new Form({
                    year: '',
                    count: 0,
                })
            }
        },

        mounted() {
            this.watchForm.year = this.watch.year;
            this.watchForm.count = this.watch.count;
        },

        methods: {
            saveWatch() {
                this.watchForm.patch('/api/v1/watches/' + this.watch.id)
                    .then(response => {
                        for (let field in this.watchForm.data()) {
                            this.watchForm[field] = response.data.data[field];
                        }
                    });
            },
            deleteWatch() {
                if (confirm('Are you sure ?!')) {
                    this.watchForm.delete('/api/v1/watches/' + this.watch.id)
                        .then(response => {
                            this.$emit('watchDeleted');
                        });
                }
            },
        },
    }
</script>

<style scoped>

</style>