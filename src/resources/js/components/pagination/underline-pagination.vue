<template>
  <renderless-pagination
    ref="pagination"
    :data="response"
    :limit="limit"
    :delimiter="delimiter"
    @pagination-change-page="onPaginationChangePage"
    @pagination-animate="animate"
  >
    <nav
      v-if="computed.showPagination"
      slot-scope="{ data, computed, next, previous, toPage }"
      aria-label="Page navigation example"
    >
      <ul class="pagination">
        <li
          v-if="showDisabled || computed.prevPageUrl"
          class="page-item"
          :class="computed.prevPageUrl ? '' : 'disabled'"
          @click="previous"
        >
            <a class="page-link" href="#" aria-label="Previous">&laquo;</a>
        </li>
        <transition-group
          ref="container"
          tag="ul"
          class="pagination"
          name="pagination"
          mode="out-in"
        >
          <li
            v-for="(page, index) in computed.pageRange"
            :key="`item-${index}`"
            class="page-item"
            :class="{'active': page === computed.currentPage}"
            @click="event => toPage(event, page)"
          >
            <a class="page-link" href="#">{{ page }}</a>
          </li>
          <div
            key="underline"
            class="w-full absolute pin-underline"
          >
            <hr
              ref="underline"
              class="w-16 h-1 bg-green-400 m-0 transition-transform"
            />
          </div>
        </transition-group>
        <li
          v-if="showDisabled || computed.nextPageUrl"
          class="page-item"
          :class="computed.nextPageUrl ? '' : 'disabled'"
          @click="next"
        >
          <a class="page-link" href="#" aria-label="Next">&raquo;</a>
        </li>
      </ul>
    </nav>
  </renderless-pagination>
</template>

<script>
    import RenderlessPagination from "./renderless-pagination";
export default {
  name: 'underline-pagination',
    components: {
        RenderlessPagination,
    },
  props: {
    response: {
      type: Object,
      default: () => {},
    },
    limit: {
      type: Number,
      default: 0,
    },
    showDisabled: {
      type: Boolean,
      default: false,
    },
    delimiter: {
      type: String,
      default: () => '...',
    },
  },
  methods: {
    onPaginationChangePage(page) {
      this.$emit('pagination-change-page', page);
    },
    animate(index) {
      if (this.$refs.container) {
        const pageItem = this.$refs.container.children[index].elm;
        const underline = this.$refs.underline;
        const midP = pageItem.getBoundingClientRect().width / 2;
        const midU = underline.getBoundingClientRect().width / 2;
        const offset =
          pageItem.getBoundingClientRect().x -
          this.$refs.container.$el.getBoundingClientRect().x +
          midP -
          midU;
        underline.style.transform = `translateX(${offset}px)`;
      }
    },
  },
};
</script>

<style lang="scss">
.pin-underline {
  bottom: -0.75rem;
}
</style>
