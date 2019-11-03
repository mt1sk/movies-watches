<template>
    <div>
        <a @click="isNewVisible = !isNewVisible" class="badge badge-info" href="javascript:;">Adding</a>
        <form v-show="isNewVisible" class="mt-2" @keydown="form.errors.clear($event.target.name)">
            <div class="alert alert-danger mt-3" v-if="form.errors.message">
                <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                <p class="mb-0">{{ form.errors.message }}</p>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="movieName">Title</label>
                    <input v-model="form.name" type="text" name="name" class="form-control" id="movieName" placeholder="Title">
                    <small class="form-text text-danger" v-show="form.errors.has('name')">{{ form.errors.get('name') }}</small>
                </div>
                <div class="form-group col-sm-2">
                    <label for="movieCount">Watches</label>
                    <input v-model="form.count" type="text" name="count" class="form-control" id="movieCount" placeholder="Watches count">
                    <small class="form-text text-danger" v-show="form.errors.has('count')">{{ form.errors.get('count') }}</small>
                </div>
                <div class="form-group col-sm-4">
                    <label for="movieYear">Watch year</label>
                    <input v-model="form.year" type="text" name="year" class="form-control" id="movieYear" placeholder="Watch year">
                    <small class="form-text text-danger" v-show="form.errors.has('year')">{{ form.errors.get('year') }}</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="movieDuration">Movie duration</label>
                    <input v-model="form.duration" type="text" name="duration" class="form-control" id="movieDuration" placeholder="Movie duration">
                    <small class="form-text text-danger" v-show="form.errors.has('duration')">{{ form.errors.get('duration') }}</small>
                </div>
            </div>
            <button type="submit" class="btn btn-success" :disabled="form.errors.any()" @click.prevent="addMovie">Add...</button>
        </form>
    </div>
</template>

<script>
    import Form from '../classes/Form';
    export default {
        name: "MovieAdd",
        data() {
            return {
                isNewVisible: false,
                form: new Form({
                    name: '',
                    count: 1,
                    year: new Date().getFullYear().toString(),
                    duration: '',
                }),
            }
        },

        methods: {
            addMovie() {
                this.form.post('/api/v1/movies').then(response => {
                    this.isNewVisible = false;
                    this.$emit('updateMoviesList');
                });
            },
        },
    }
</script>

<style scoped>

</style>