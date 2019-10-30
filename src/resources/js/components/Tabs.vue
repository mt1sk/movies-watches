<template>
    <div>
        <ul class="nav nav-pills mb-3">
            <li v-for="tab in tabs" class="nav-item">
                <a class="nav-link" :class="{'active' : tab.isActive}" :href="tab.href" @click="selectTab(tab)">{{ tab.name }}</a>
            </li>
        </ul>

        <div class="tab-content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Tabs",
        data() {
            return {
                tabs: []
            }
        },
        created() {
            this.tabs = this.$children;
        },

        methods: {
            selectTab(newTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = newTab.name === tab.name;
                });
            }
        },
    }
</script>

<style scoped>

</style>