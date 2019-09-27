<div id="root">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-uppercase">Unit From</div>
                <div class="card-body">
                    <div class="col-md-4 col-md-offset-4">
                        <form @submit.prevent="save()">
                            <div class="form-group">
                                <label for="input-1">Unit Name</label>
                                <input v-model="unit.unit_name" type="text" class="form-control"
                                    placeholder="Enter Unit Name">
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
                <div class="card-header"><i class="fa fa-table"></i> Unit List</div>
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
                                <tr v-for="(unit,index) in units">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ unit.unit_name }}</td>
                                    <td>
                                        <button @click="edit(unit)" type="button"
                                            class="btn btn-success btn-sm btn-round waves-effect waves-light">Edit</button>
                                        <button @click="deleteUnit(unit.id)" type="button"
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
            units: [],
            unit: {
                unit_name: '',
                id: ''
            }
        },
        created() {
            this.getUnits();
            this.show = true;
        },
        methods: {
            getUnits() {
                let url = '/get-units';
                axios.get(url).then(res => {
                    this.units = res.data;
                })
            },
            save() {
                this.loading = true;
                if (this.unit.unit_name == "") {
                    alert("Unit name field required");
                    this.loading = false;
                    return;
                }
                let url = '/save-unit';
                if (this.unit.id != '') { url = '/update-unit' }
                axios.post(url, { unit: this.unit }).then(res => {
                    let r = res.data;
                    let conf = confirm(r.message);
                    if (r.success) {
                        this.getUnits();
                        this.cleanForm();
                        this.loading = false;
                    }

                })
            },
            edit(row) {
                let keys = Object.keys(this.unit);
                keys.forEach(key => {
                    this.unit[key] = row[key];
                })
            },
            deleteUnit(row) {
                let conf = confirm("Are You Sure !!!");
                if (conf) {
                    axios.post("/delete-unit", { id: row }).then(res => {
                        let r = res.data;
                        let conf = confirm(r.message);
                        if (r.success) {
                            this.getUnits();
                        }
                    })
                }
            },
            cleanForm() {
                this.unit = {
                    unit_name: '',
                    id: ''
                }
            }
        }
    })

</script>