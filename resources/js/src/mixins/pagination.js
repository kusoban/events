const mixin = {
    data() {
        return {
            pagination: {
                length: 1,
                page: 1,
            },
        }
    },
    methods: {
        setPagination(data) {
            this.pagination.length = data.last_page;
        },
    }
}


export default mixin