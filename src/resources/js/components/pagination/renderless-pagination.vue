<script>
import { range, first, last } from 'lodash';
export default {
  props: {
    data: {
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
  data: () => ({
    pages: [],
  }),
  computed: {
    isApiResource() {
      return !!this.data.meta;
    },
    path() {
      return this.isApiResource ? this.data.meta.path : this.data.path;
    },
    currentPage() {
      return this.isApiResource ? this.data.meta.current_page : this.data.current_page;
    },
    currentPageIndex() {
      return this.pages.findIndex(page => page == this.currentPage);
    },
    firstPageUrl() {
      return this.isApiResource ? this.data.links.first : null;
    },
    from() {
      return this.isApiResource ? this.data.meta.from : this.data.from;
    },
    lastPage() {
      return this.isApiResource ? this.data.meta.last_page : this.data.last_page;
    },
    lastPageUrl() {
      return this.isApiResource ? this.data.links.last : null;
    },
    nextPageUrl() {
      return this.isApiResource ? this.data.links.next : this.data.next_page_url;
    },
    perPage() {
      return this.isApiResource ? this.data.meta.per_page : this.data.per_page;
    },
    prevPageUrl() {
      return this.isApiResource ? this.data.links.prev : this.data.prev_page_url;
    },
    to() {
      return this.isApiResource ? this.data.meta.to : this.data.to;
    },
    total() {
      return this.isApiResource ? this.data.meta.total : this.data.total;
    },
    offset() {
      return [this.currentPage - this.limit, this.currentPage + this.limit];
    },
    resolveOffsetLeft() {
      return first(this.offset) > 1 ? first(this.offset) : 2;
    },
    resolveOffsetRight() {
      return last(this.offset) < this.lastPage - 1 ? last(this.offset) : this.lastPage - 1;
    },
    ranges() {
      return [this.resolveOffsetLeft, this.resolveOffsetRight];
    },
    shouldInsertLeft() {
      return first(this.ranges) > 2;
    },
    shouldInsertRight() {
      return last(this.ranges) < this.lastPage - 1;
    },
    resolveLeft() {
      return first(this.ranges) - 1 === 2 ? 2 : this.delimiter;
    },
    resolveRight() {
      return last(this.ranges) + 1 === this.lastPage - 1 ? this.lastPage - 1 : this.delimiter;
    },
    showPagination() {
      return this.lastPage > 1;
    },
    pageRange() {
      if (this.limit < 1) {
        return this.lastPage;
      }
      if (this.showPagination) {
        return this.init()
          .fill()
          .unshiftPages(this.resolveLeft, this.shouldInsertLeft)
          .unshiftPages(1)
          .pushPages(this.resolveRight, this.shouldInsertRight)
          .pushPages(this.lastPage)
          .get();
      }
      return this.get();
    },
  },
  watch: {
    currentPageIndex(newValue, oldValue) {
      if (newValue !== oldValue) {
        this.$emit('pagination-animate', newValue);
      }
    },
  },
  created() {
    this.$emit('created');
  },
  mounted() {
    this.$emit('mounted');
  },
  methods: {
    unshiftPages(page, bool = true,) {
      if (bool) {
        this.pages.unshift(page);
      }
      return this;
    },
    pushPages(page, bool = true) {
      if (bool) {
        this.pages.push(page);
      }
      return this;
    },
    fill() {
      const [from, to] = this.ranges;
      this.pages = range(from, to + 1);
      return this;
    },
    init() {
      this.pages = [];
      return this;
    },
    get() {
      return this.pages;
    },
    previousPage() {
      this.selectPage(this.currentPage - 1);
    },
    nextPage() {
      this.selectPage(this.currentPage + 1);
    },
    selectPage(page) {
      if (page === this.delimiter || page == this.currentPage) {
        return;
      }
      this.$emit('pagination-change-page', page);
    },
  },
  render() {
    return this.$scopedSlots.default({
      data: this.data,
      limit: this.limit,
      computed: {
        isApiResource: this.isApiResource,
        currentPage: this.currentPage,
        firstPageUrl: this.firstPageUrl,
        from: this.from,
        lastPage: this.lastPage,
        lastPageUrl: this.lastPageUrl,
        nextPageUrl: this.nextPageUrl,
        perPage: this.perPage,
        prevPageUrl: this.prevPageUrl,
        to: this.to,
        total: this.total,
        pageRange: this.pageRange,
        path: this.path,
        showPagination: this.showPagination,
      },
      previous: event => {
        event.preventDefault();
        this.prevPageUrl && this.previousPage();
      },
      next: event => {
        event.preventDefault();
        this.nextPageUrl && this.nextPage();
      },
      toPage: (event, page) => {
        event.preventDefault();
        this.selectPage(page);
      },
    });
  },
};
</script>
