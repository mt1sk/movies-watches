<template>
    <div class="container pt-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Authentication</div>

                    <div class="card-body">
                        <tabs>
                            <tab name="Sign in" :selected="true">
                                <div class="alert alert-danger" v-if="loginForm.errors.length > 0">
                                    <!--<p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>-->
                                    <ul>
                                        <li v-for="error in loginForm.errors">
                                            {{ error }}
                                        </li>
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <label for="loginEmail">Email address</label>
                                    <input v-model="loginForm.email" type="email" class="form-control" id="loginEmail" aria-describedby="emailHelp" placeholder="Enter email">
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label>
                                    <input v-model="loginForm.password" type="password" class="form-control" id="loginPassword" placeholder="Password">
                                </div>
                                <!--<div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>-->
                                <button type="submit" class="btn btn-primary" @click="login">Submit</button>
                            </tab>

                            <tab name="Registration">
                                Registration form...
                            </tab>
                        </tabs>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Tabs from './Tabs.vue';
    import Tab from './Tab.vue';
    export default {
        name: "Authentication",
        components: {
            Tabs,
            Tab
        },
        data() {
            return {
                loginForm: {
                    email: '',
                    password: '',
                    errors: [],
                }
            }
        },

        methods: {
            login() {
                axios.post('/api/v1/login', this.loginForm)
                    .then(response => {
                        localStorage.accessToken = response.data.data.token.access_token;
                        location.reload();
                    })
                    .catch(error => {
                        if (typeof error.response.data.data === 'object') {
                            if (error.response.data.data.errors) {
                                this.loginForm.errors = _.flatten(_.toArray(error.response.data.data.errors));
                            } else {
                                this.loginForm.errors = [error.response.data.data.message];
                            }
                        } else {
                            this.loginForm.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },
        },
    }
</script>

<style scoped>

</style>