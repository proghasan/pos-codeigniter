<div id="root">
    <div class="row">
        <div class="col-md-12" style="border-bottom: 1px solid #ddd;padding: 0px;padding-bottom: 9px;margin-top: -15px;">
            <form>
                <div class="form-row">
                    <div class="col">
                      <input type="text" class="form-control" value="201912121" readonly>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" value="Main Shop" readonly>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" value="Admin" readonly>
                    </div>
                    <div class="col">
                      <input type="date" class="form-control" placeholder="Last name" value="<?php echo date('Y-m-d')?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9" style="padding:0px">
            <div class="card custom_card mt-2" style="box-shadow: none !important;border: 1px solid #ddd !important;">
                <div class="card-header custom_card_head text-uppercase">Product Purchase information</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row custom_form" style="margin-top: -13px;">
                                <label class="col-sm-3 col-form-label">Supplier</label>
                                <div class="col-sm-8">
                                  <v-select :options="suppliers" v-model="selectedSupplier" label="display_name" v-if="suppliers.length > 0"></v-select>
                                </div>
                                <div class="col-sm-1" style="padding: 0px">
                                    <a href="/supplier" target="_blank"
                                        class="btn btn-xs btn-danger float-right small-btn">
                                        <i class="fa fa-plus custom-icon"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" v-model="selectedSupplier.name" placeholder="Name" readonly>
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Due</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" v-model="selectedSupplier.due_amount" placeholder="0.00" readonly>
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Barcode</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" v-model="product.barcode" placeholder="-------" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row custom_form" style="margin-top: -13px;">
                                <label class="col-sm-3 col-form-label">Product</label>
                                <div class="col-sm-8">
                                 <v-select :options="products" v-model="selectedProduct" label="display_name" v-if="products.length > 0"></v-select>
                                </div>
                                <div class="col-sm-1" style="padding: 0px">
                                    <a href="/supplier" target="_blank"
                                        class="btn btn-xs btn-danger float-right small-btn">
                                        <i class="fa fa-plus custom-icon"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Pr.Group</label>
                                <div class="col-sm-9">
                                <v-select :options="groups" v-model="selectedGroup" label="display_name" v-if="groups.length > 0"></v-select>
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Pur.Rate</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" v-model="product.purchase_rate" placeholder="Purchase Rate" @click="product.purchase_rate = product.purchase_rate == 0 ? '' : product.purchase_rate">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3"></div>
                                <div class="form-group col-md-5">
                                    <label>Qty</label>
                                    <input type="text" class="form-control" v-model="product.qty" @click="product.qty = product.qty==0 ? '' : product.qty" placeholder="Qty">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Sale Rate</label>
                                    <input type="text" class="form-control" v-model="product.sale_rate" @click="product.sale_rate = product.sale_rate ==0 ? '': product.sale_rate" placeholder="Sale Rate">
                                </div>
                            </div>
                            <button class="btn btn-sm btn-warning" style="float: right">Add Box</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right: 0px">
            <div class="card custom_card mt-2" style="box-shadow: none !important;border: 1px solid #ddd !important;">
                <div class="card-header custom_card_head text-uppercase">
                    <span>Amount Calculation</span>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-top: -16px;">
                        <label>Sub Total</label>
                        <input type="text" class="form-control" value="0.00" readonly>
                      </div>
                    <div class="form-group" style="margin-top: -14px;">
                        <label>Discount</label>
                        <input type="text" class="form-control" value="0.00">
                    </div>
                    <div class="form-row" style="margin-top: -14px;">
                        <div class="form-group col-md-6">
                            <label>Vat( % )</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vat Amount</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: -14px;">
                        <label>Transport Amount</label>
                        <input type="text" class="form-control" value="0.00">
                    </div>
                    <div class="form-group" style="margin-top: -14px;">
                        <label>Total Amount</label>
                        <input type="text" class="form-control" value="0.00">
                    </div>
                   <div style="margin-top: -14px;">
                    <button type="button" class="btn btn-success btn-sm waves-effect waves-light m-1">Purchase Now</button>
                    <button type="button" class="btn btn-danger btn-sm waves-effect waves-light m-1">Cancel</button>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layouts/vue') ?>
<script src="/assets/js/vue/vue-select.min.js"></script>
<script>
 Vue.component('v-select', VueSelect.VueSelect);
 new Vue({
     el: "#root",
     data:{
        product: {
            purchase_date: '',
            product_id: '',
            group_id: '',
            supplier_id: '',
            purchase_rate: 0,
            sale_rate: 0,
            sub_total: 0,
            qty: 0,
            vat_percent: 0,
            vat_amount: 0,
            transport_amount: 0,
            total: 0
        },
        suppliers: [],
        selectedSupplier: {
            display_name: 'Select Supplier',
            supplier_id: '',
            name: '',
            due:''
        },
        products: [],
        selectedProduct: {
            product_id: '',
            display_name: 'Select Product',
            product_name: ''
        },
        groups: [],
        selectedGroup: {
            display_name: 'Select Group',
            id: '',
            group_name: ''
        },
        shop_info: {
            invoice: '',
            branch_name: '',
            user_name: ''
        }



     },
     created(){
        this.getSelectedSuppliers();
        this.getSelectedProducts();
        this.getSelectedGroups();
     },
     methods:{
        getSelectedSuppliers(){
          axios.get('/get-selected-suppliers').then(res => {
            this.suppliers = res.data;
          })
        },
        getSelectedProducts(){
          axios.get('/get-selected-products').then(res => {
            this.products = res.data;
          })
        },
        getSelectedGroups(){
          axios.get('/get-seleted-groups').then(res => {
            this.groups = res.data;
          })
        },

     }
 })
</script>