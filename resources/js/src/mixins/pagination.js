const mixin = {
    data() {
        return {
            pagination: {
                length: 1,
                page: 1,
                nextUrl: '',
                prevUrl: '',
            },
        }
    },
    methods: {
        setPagination(data) {
            this.pagination.length = data.last_page;
            this.pagination.nextUrl = data.next_page_url;
            this.pagination.prevUrl = data.prev_page_url;
        },
    }
}


export default mixin