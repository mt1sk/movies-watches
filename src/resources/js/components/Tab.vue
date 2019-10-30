<template>
    <div class="tab-pane fade" :class="{'show active' : isActive}">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "Tab",
        props: {
            name: {required: true},
            selected: {default: false},
        },
        data() {
            return {
                isActive: this.selected,
            }
        },
        computed: {
            href() {
                return '#' + this.name.toLowerCase().replace(/ /g, '-');
            },
        }
    }
</script>

<style scoped>

</style>