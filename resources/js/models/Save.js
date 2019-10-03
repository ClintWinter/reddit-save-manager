class Save {
    constructor() {
        this.saves = [];
        this.count = 15;
        this.pagination = {};
    }

    loadNew(callback) {
        axios.post('/saves', {})
        .then((response) => {
            callback();
            // this.filterResults(this.filters.searchQuery);
        })
        .catch(error => {
            callback(error.response.data);
        });
    }

    load(callback) {
        axios.get('/saves', {
            params: {
                count: this.filters.count
            }
        })
        .then((response) => {
            this.saves = response.data.data;

            this.pagination.current = response.data.current_page;
            this.pagination.total_pages = response.data.last_page;
            this.pagination.next_url = response.data.next_page_url;
            this.pagination.first_url = response.data.first_page_url;
            this.pagination.last_url = response.data.last_page_url;
            this.pagination.previous_url = response.data.prev_page_url;
            this.pagination.from = response.data.from;
            this.pagination.to = response.data.to;
            this.pagination.total = response.data.total;
            this.filters.count = response.data.per_page;

            callback(this.saves);
        })
        .catch(error => {
            callback(error.response.data);
        });
    }
}

export default Save;