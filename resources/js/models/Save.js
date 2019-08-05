class Save {
    constructor() {
        this.saves = [];
        this.count = 15;
        this.pagination = {};
    }

    all() {
        return axios.get('/saves', {
            params: {
                count: this.count
            }
        })
        .then((response) => {
            this.saves = response.data.data;
            this.updatePagination(response);

            return this.saves;
        })
        .catch(error => error);
    }

    updatePagination(response) {
        this.pagination.current         = response.data.current_page;
        this.pagination.total_pages     = response.data.last_page;
        this.pagination.next_url        = response.data.next_page_url;
        this.pagination.first_url       = response.data.first_page_url;
        this.pagination.last_url        = response.data.last_page_url;
        this.pagination.previous_url    = response.data.prev_page_url;
        this.pagination.from            = response.data.from;
        this.pagination.to              = response.data.to;
        this.pagination.total           = response.data.total;
        this.pagination.per_page        = response.data.per_page;
    }
}

export default Save;