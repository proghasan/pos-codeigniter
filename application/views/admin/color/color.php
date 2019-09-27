<div id="root">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-uppercase">color From</div>
                <div class="card-body">
                    <div class="col-md-4 col-md-offset-4">
                        <form @submit.prevent="save()">
                            <div class="form-group">
                                <label for="input-1">color Name</label>
                                <input v-model="color.color_name" type="text" class="form-control"
                                    placeholder="Enter color Name">
                            </div>
                            <div class="form-group">
                                <button :disabled="loading" type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square-o"></i>save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card" style="display: none" :style="{display: show ? '' : 'none'}">
                <div class="card-header"><i class="fa fa-table"></i> Color List</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="text-center"
                                style="font-weight:bold;color:#fff;background: radial-gradient(circle, rgba(63,94,251,1) 0%, rgba(252,70,107,1) 100%);">
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="(color,index) in colors">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ color.color_name }}</td>
                                    <td>
                                        <button @click="edit(color)" type="button"
                                            class="btn btn-success btn-sm btn-round waves-effect waves-light">Edit</button>
                                        <button @click="deletecolor(color.id)" type="button"
                                            class="btn btn-danger btn-sm btn-round waves-effect waves-light">Deleted</button>
                                        <!-- <a href=""><i class="fas fa-trash-alt"></i></a> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layouts/vue')?>
<script>
    new Vue({
        el: "#root",
        data: {
            show: false,
            loading: false,
            colors: [],
            color: {
                color_name: '',
                id: ''
            }
        },
        created() {
            this.getcolors();
            this.show = true;
        },
        methods: {
            getcolors() {
                let url = '/get-colors';
                axios.get(url).then(res => {
                    this.colors = res.data;
                })
            },
            save() {
                this.loading = true;
                if (this.color.color_name == "") {
                    alert("color name field required");
                    this.loading = false;
                    return;
                }
                let url = '/save-color';
                if (this.color.id != '') { url = '/update-color' }
                axios.post(url, { color: this.color }).then(res => {
                    let r = res.data;
                    let conf = confirm(r.message);
                    if (r.success) {
                        this.getcolors();
                        this.cleanForm();
                        this.loading = false;
                    }

                })
            },
            edit(row) {
                let keys = Object.keys(this.color);
                keys.forEach(key => {
                    this.color[key] = row[key];
                })
            },
            deletecolor(row) {
                let conf = confirm("Are You Sure !!!");
                if (conf) {
                    axios.post("/delete-color", { id: row }).then(res => {
                        let r = res.data;
                        let conf = confirm(r.message);
                        if (r.success) {
                            this.getcolors();
                        }
                    })
                }
            },
            cleanForm() {
                this.color = {
                    color_name: '',
                    id: ''
                }
            }
        }
    })

</script>