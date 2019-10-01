<div id="root">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-uppercase">group From</div>
                <div class="card-body">
                    <div class="col-md-4 col-md-offset-4">
                        <form @submit.prevent="save()">
                            <div class="form-group">
                                <label for="input-1">group Name</label>
                                <input v-model="group.group_name" type="text" class="form-control"
                                    placeholder="Enter group Name">
                            </div>
                            <div class="form-group">
                                <button :disabled="loading" type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square-o"></i>save</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-12 mt-4">
                        <h5 style="margin-bottom:-30px">Group List</h5>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="form-group" style="margin-bottom: 5px;">
                                    <label for="filter" class="sr-only">Filter</label>
                                    <input type="text" class="form-control" v-model="filter" placeholder="Filter Group">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">

                            <datatable class="table table-sm" :columns="columns" :data="groups" :filter-by="filter">
                                <template slot-scope="{ row }">
                                    <tr class="text-center">
                                        <td>{{ row.id }}</td>
                                        <td>{{ row.group_name }}</td>
                                        <td>
                                            <button type="button" class="button btn-success" @click="editGroup(row)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button type="button" class="button btn-danger"
                                                @click="deleteGroup(row.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </datatable>
                            <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layouts/vue')?>
<script src="assets/js/vue/vuejs-datatable.js"></script>
<script>
    new Vue({
        el: "#root",
        data: {
            show: false,
            loading: false,
            groups: [],
            group: {
                group_name: '',
                id: ''
            },
            columns: [
                { label: 'SL', align: 'center', filterable: false },
                { label: 'Group Name', field: 'group_name', align: 'center', sort: true },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        },
        created() {
            this.getgroups();
            this.show = true;
        },
        methods: {
            getgroups() {
                let url = '/get-groups';
                axios.get(url).then(res => {
                    this.groups = res.data;
                })
            },
            save() {
                this.loading = true;
                if (this.group.group_name == "") {
                    alert("group name field required");
                    this.loading = false;
                    return;
                }
                let url = '/save-group';
                if (this.group.id != '') { url = '/update-group' }
                axios.post(url, { group: this.group }).then(res => {
                    let r = res.data;
                    let conf = confirm(r.message);
                    if (r.success) {
                        this.getgroups();
                        this.cleanForm();
                        this.loading = false;
                    }

                })
            },
            editGroup(row) {
                let keys = Object.keys(this.group);
                keys.forEach(key => {
                    this.group[key] = row[key];
                })
            },
            deleteGroup(row) {
                let conf = confirm("Are You Sure !!!");
                if (conf) {
                    axios.post("/delete-group", { id: row }).then(res => {
                        let r = res.data;
                        let conf = confirm(r.message);
                        if (r.success) {
                            this.getgroups();
                        }
                    })
                }
            },
            cleanForm() {
                this.group = {
                    group_name: '',
                    id: ''
                }
            }
        }
    })

</script>