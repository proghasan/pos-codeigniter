<div id="root">
    <div class="row">
        <div class="col-md-12" style="border-bottom: 1px solid #ddd;padding: 0px;padding-bottom: 9px;margin-top: -15px;">
            <form>
                <div class="form-row">
                    <div class="col">
                      <input type="text" class="form-control" v-model="singleData.invoice" readonly>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" v-model="branch_info.branch_name" readonly>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control"  v-model="branch_info.name" readonly>
                    </div>
                    <div class="col">
                      <input type="date" class="form-control" v-model="singleData.purchase_date">
                      <!-- <date-picker :readonly="true" format="YYYY-MM-DD" name="date1"></date-picker> -->
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
                                    <input type="txet" class="form-control" v-model="temp.barcode" placeholder="-------" readonly>
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
                                <v-select :options="groups" v-model="selectedGroup" label="display_name" v-if="groups.length > 0" @input="genBarcode()"></v-select>
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Pur.Rate</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" v-model="temp.purchase_rate" placeholder="Purchase Rate" @click="temp.purchase_rate = temp.purchase_rate == 0 ? '' : temp.purchase_rate">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3"></div>
                                <div class="form-group col-md-5">
                                    <label>Qty</label>
                                    <input type="text" class="form-control" v-model="temp.qty" @click="temp.qty = temp.qty==0 ? '' : temp.qty" placeholder="Qty">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Sale Rate</label>
                                    <input type="text" class="form-control" v-model="temp.sale_rate" @click="temp.sale_rate = temp.sale_rate ==0 ? '': temp.sale_rate" placeholder="Sale Rate">
                                </div>
                            </div>
                            <button @click.prevent="addCart()" class="btn btn-sm btn-warning" style="float: right">Add Box</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Pro.Name</th>
                        <th>Group</th>
                        <th>Pur.Rate</th>
                        <th>Qty</th>
                        <th>Sale Rate</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
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
<script src="/assets/js/moment.min.js"></script>
<script>
 Vue.component('v-select', VueSelect.VueSelect);
 new Vue({
     el: "#root",
     data:{
        temp: {
            product_id: '',
            group_id: '',
            purchase_rate: 0,
            sale_rate: 0,
            sub_total: 0,
            qty: 0,
            barcode: ''
        },
        singleData: {
            purchase_date: moment().format("YYYY-MM-DD"),
            invoice: '',
            supplier_id: '',
            sub_total: 0,
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
            product_name: '',
            product_code: ''
        },
        groups: [],
        selectedGroup: {
            display_name: 'Select Group',
            id: '',
            group_name: ''
        },
        branch_info: {
            branch_name: '',
            name: '' // login person name
        }, 
        cart: [],

     },
     created(){
        this.getInvoice();
        this.getSelectedSuppliers();
        this.getSelectedProducts();
        this.getSelectedGroups();
        this.getBranch();
     },
     methods:{
        getInvoice(){
          axios.get('/get-purchase-invoice').then(res => {
            this.singleData.invoice = res.data;
          })
        },
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
        getBranch(){
          axios.get('/get-branch-info').then(res => {
            this.branch_info = res.data;
          })
        },
        genBarcode(){
            // note check this group product have or not this purchase_details table
            // if find then this all data temp and readoly all input field 
           if(this.selectedProduct.product_id !="" && this.selectedGroup.id !=""){
              this.temp.barcode = this.selectedProduct.product_code+this.selectedGroup.id;
           }
        },
        addCart(){
            if(this.selectedProduct.product_id ==""){
                alert("Please Select Product");
                return;
            }
            if(this.selectedGroup.id ==""){
                alert("Please Select Group");
                return;
            }
            if(this.temp.sale_rate == "" || this.temp.purchase_rate =="" || this.temp.qty ==""){
                alert("Please Select Fill All Field !!!");
                return;
            }
            let tempCart = {
                product_id: this.selectedProduct.product_id,
                product_name: this.selectedProduct.product_name,
                group_name: this.selectedGroup.group_name,
                purchase_rate: this.temp.purchase_rate,
                sale_rate: this.temp.sale_rate,
                barcode: this.temp.barcode,
                qty: this.temp.qty
            }
            this.cart.push(tempCart);
        }
     }
 })
</script>