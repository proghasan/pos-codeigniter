<div id="root">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-uppercase">product From</div>
                <div class="card-body">
                    <form @submit.prevent="save()">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Product Code</label>
                                    <div class="col-sm-8">
                                        <input type="text" v-model="product.code" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Product Name</label>
                                    <div class="col-sm-8">
                                        <input v-model="product.product_name" type="text" class="form-control"
                                            placeholder="Enter Product Code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">Color</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" v-model="product.color">
                                            <option value="">Select Color</option>
                                            <option :value="color.id" v-for="color in colors">{{ color.color_name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="/color" target="_blank"
                                            class="btn btn-xs btn-warning float-right small-btn">
                                            <i class="fa fa-plus custom-icon"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">Unit</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" v-model="product.unit">
                                            <option value="">Select Unit</option>
                                            <option :value="unit.id" v-for="unit in units">{{ unit.unit_name }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="/unit" target="_blank"
                                            class="btn btn-xs btn-warning float-right small-btn">
                                            <i class="fa fa-plus custom-icon"></i>
                                        </a>
                                    </div>
                                </div>

                                <button :disabled="loading" type="submit"
                                    class="btn btn-danger btn-sm float-right ml-2  btn-round px-4">
                                    <i class="fa fa-times"></i>Cancel
                                </button>
                                <button :disabled="loading" type="submit"
                                    class="btn btn-primary btn-sm float-right btn-round px-4">
                                    <i class="fa fa-check-square-o"></i>Save
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- product list -->
                    <h5 class="mt-5 mb-3 text-uppercase">Product List</h5>
                    <table class="table table-bordered table-sm" style="display:none"
                        :style="{display: show ? '' : 'none'}">
                        <thead class="text-center">
                            <tr>
                                <th>SL</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr v-for="(product,index) in products">
                                <td>{{index+1}}</td>
                                <td>{{product.code}}</td>
                                <td>{{product.product_name}}</td>
                                <td>{{product.unit_name}}</td>
                                <td>
                                    <a href="javascript:void(0)" @click="edit(product)"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:void(0)"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <!-- product list -->

                </div>

            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layouts/vue') ?>
<script>
    new Vue({
        el: "#root",
        data: {
            show: false,
            loading: false,
            products: [],
            units: [],
            colors: [],
            product: {
                product_name: '',
                color: '',
                unit: '',
                code: '',
                product_id: ''
            }
        },
        created() {
            this.getproducts();
            this.getcolors();
            this.getUnits();
            this.getProductCode();
            this.show = true;
        },
        methods: {
            getcolors() {
                let url = '/get-colors';
                axios.get(url).then(res => {
                    this.colors = res.data;
                })
            },
            getUnits() {
                let url = '/get-units';
                axios.get(url).then(res => {
                    this.units = res.data;
                })
            },
            getProductCode() {
                axios.get("/get-product-code").then(res => {
                    this.product.code = res.data;
                })
            },
            getproducts() {
                axios.get('/get-products').then(res => {
                    this.products = res.data;
                })
            },
            save() {
                this.loading = true;
                if (this.product.product_name == "" || this.product.code == "" || this.product.color == "" || this.product.unit == "") {
                    alert("Please fill the all field");
                    this.loading = false;
                    return;
                }
                let url = '/save-product';
                if (this.product.product_id != '') { url = '/update-product' }
                axios.post(url, { product: this.product }).then(res => {
                    let r = res.data;
                    let conf = confirm(r.message);
                    if (r.success) {
                        this.getproducts();
                        this.cleanForm();
                        this.getProductCode();
                        this.loading = false;
                    }

                })
            },
            edit(row) {
                let keys = Object.keys(this.product);
                keys.forEach(key => {
                    this.product[key] = row[key];
                })
            },
            deleteproduct(row) {
                let conf = confirm("Are You Sure !!!");
                if (conf) {
                    axios.post("/delete-product", {
                        id: row
                    }).then(res => {
                        let r = res.data;
                        let conf = confirm(r.message);
                        if (r.success) {
                            this.getproducts();
                        }
                    })
                }
            },
            cleanForm() {
                this.product = {
                    product_name: '',
                    color: '',
                    unit: '',
                    code: '',
                    product_id: ''
                }
            }
        }
    })
</script>