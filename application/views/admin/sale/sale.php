<style>
.mx-datepicker{
    /* width: 276px !important; */
    width: 100%;
}

</style>
<div id="root">
    <div class="row">
        <div class="col-md-12" style="border-bottom: 1px solid #ddd;padding: 0px;padding-bottom: 9px;margin-top: -15px;">
            <form>
                <div class="form-row">
                    <div class="col">
                      <input type="text" class="form-control" v-model="sale.invoice" readonly>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" v-model="branch_info.branch_name" readonly>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control"  v-model="branch_info.name" readonly>
                    </div>
                    <div class="col">
                      <date-picker v-model="sale.sale_date" lang="en" format="YYYY-MM-DD"></date-picker>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9" style="padding:0px">
            <div class="card custom_card mt-2" style="box-shadow: none !important;border: 1px solid #ddd !important;">
                <div class="card-header custom_card_head text-uppercase">Product sale information</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row custom_form" style="margin-top: -13px;">
                                <label class="col-sm-3 col-form-label">Customer</label>
                                <div class="col-sm-8">
                                  <v-select :options="customers" v-model="selectedCustomer" label="display_name" v-if="customers.length > 0"></v-select>
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
                                    <input type="txet" class="form-control" v-model="selectedCustomer.customer_name" placeholder="Name" readonly>
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" v-model="selectedCustomer.customer_phone" placeholder="Phone" readonly>
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Due</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" v-model="selectedCustomer.current_due" placeholder="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row custom_form" style="margin-top: -13px;">
                                <label class="col-sm-3 col-form-label">Product</label>
                                <div class="col-sm-8">
                                 <v-select :options="products" v-model="selectedProduct" label="display_name" v-if="products.length > 0" @input="genBarcode()"></v-select>
                                </div>
                                <div class="col-sm-1" style="padding: 0px">
                                    <a href="/product" target="_blank"
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
                                    <input :readonly="inputDisable" type="txet" class="form-control" v-model="temp.sale_rate" placeholder="sale Rate" @click="temp.sale_rate = temp.sale_rate == 0 ? '' : temp.sale_rate">
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
                                    <input :readonly="inputDisable" type="text" class="form-control" v-model="temp.sale_rate" @click="temp.sale_rate = temp.sale_rate ==0 ? '': temp.sale_rate" placeholder="Sale Rate">
                                </div>
                            </div>
                            <button @click.prevent="addCart()" class="btn btn-sm btn-warning" style="float: right" :disabled="loading ">{{ loading ? 'loading...' : 'Add Box'}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>SL</th>
                        <th>Pro.Name</th>
                        <th>Group</th>
                        <th>Sale Rate</th>
                        <th>Pur.Rate</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
               <tbody class="text-center">
                    <tr v-for="(cartData,index) in cart" style="display: none" :style="{display: show ? '' : 'hidden'}">
                        <td>{{index+1}}</td>
                        <td>{{cartData.product_name}}</td>
                        <td>{{cartData.group_name}}</td>
                        <td>{{cartData.sale_rate}}</td>
                        <td>{{cartData.sale_rate}}</td>
                        <td>{{cartData.qty}}</td>
                        <td>{{cartData.sale_rate * cartData.qty}}</td>
                        <td>
                            <button @click.prevent="removeFromCart(index)" class="button" type="button">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
               </tbody>
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
                        <input type="text" class="form-control" v-model="sale.sub_total" readonly>
                      </div>
                    <div class="form-group" style="margin-top: -14px;">
                        <label>Discount Amount</label>
                        <input type="text" class="form-control" v-model="sale.discount_amount" @input="calculation()">
                    </div>
                    <div class="form-row" style="margin-top: -14px;">
                        <div class="form-group col-md-6">
                            <label>Vat( % )</label>
                            <input type="text" class="form-control"  v-model="sale.vat_percent" @input="calPercentToAmount()">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vat Amount</label>
                            <input type="text" class="form-control"  v-model="sale.vat_amount" @input="calAmountPercent()">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: -14px;">
                        <label>Transport Amount</label>
                        <input type="text" class="form-control" v-model="sale.transport_cost" @input="calculation()">
                    </div>
                    <div class="form-group" style="margin-top: -14px;">
                        <label>Total Amount</label>
                        <input type="text" class="form-control" v-model="sale.total" readonly>
                    </div>
                    <div class="form-row" style="margin-top: -14px;">
                        <div class="form-group col-md-6">
                            <label>Paid</label>
                            <input type="text" class="form-control" v-model="sale.paid" @input="calculation()">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Due</label>
                            <input type="text" class="form-control" v-model="sale.due" readonly>
                        </div>
                        </div>
                   <div style="margin-top: -14px;">
                    <button @click.prevent="savesale()" type="button" class="btn btn-success btn-sm waves-effect waves-light m-1" :disabled="loading">{{ loading ? 'loading...' : 'sale Now'}}</button>
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
<script src="/assets/js/vue/vue-datepicker.js"></script>
<script>
 Vue.component('v-select', VueSelect.VueSelect);
 new Vue({
     el: "#root",
     component:{
         datePicker: 'date-picker'
     },
     data:{
        show: false,
        loading: false, 
        inputDisable: false,
        temp: {
            product_id: '',
            group_id: '',
            sale_rate: 0,
            sale_rate: 0,
            sub_total: 0,
            qty: 0,
            barcode: ''
        },
        sale: {
            sale_date: moment().format("YYYY-MM-DD"),
            invoice: '',
            supplier_id: '',
            sub_total: 0,
            vat_percent: 0,
            vat_amount: 0,
            transport_cost: 0,
            discount_amount: 0,
            paid: 0,
            due:0,
            total: 0,
            sale: <?php echo $edit_id;?>,
        },
        customers: [],
        selectedCustomer: {
            display_name: 'Select Customer',
            customer_id: '',
            customer_phone: '',
            current_due: ''
        },
        suppliers: [],
        selectedSupplier: {
            display_name: 'Select Supplier',
            supplier_id: '',
            name: '',
            phone: ''
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
        this.getCustomers();
        // this.getInvoice();
        // this.getSelectedSuppliers();
        this.getSelectedProducts();
        this.getSelectedGroups();
        this.getBranch();
        if(this.sale.sale){
            this.editsale();
        }
     },
     methods:{
        getCustomers(){
            axios.get('/get-customes').then(res => {
            this.customers = res.data;
          }) 
        },
        getInvoice(){
          axios.get('/get-sale-invoice').then(res => {
            this.sale.invoice = res.data;
          })
        },
        getSelectedProducts(){
          axios.get('/get-current-stock').then(res => {
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
            // note check this group product have or not this sale_details table
           if(this.selectedProduct.product_id !="" && this.selectedGroup.id !=""){
              this.temp.barcode = this.selectedProduct.product_code+this.selectedGroup.id;
               //check this product already have or not in currentinventory
              axios.post("/check-already-exist",{product_id: this.selectedProduct.product_id , group_id: this.selectedGroup.id}).then(res => {
                  let r =res.data;
                 if(r.success){
                   this.temp.sale_rate = r.sale_rate;
                   this.temp.sale_rate = r.sale_rate;
                   this.inputDisable = true;
                 }else{
                   this.temp.sale_rate = 0;
                   this.temp.sale_rate = 0;
                   this.inputDisable = false;
                 }
              })
           }
        },
        addCart(){
            this.inputDisable = false;
            this.loading = true;
            if(this.selectedProduct.product_id ==""){
                alert("Please Select Product");
                this.loading = false;
                return;
            }
            if(this.selectedGroup.id ==""){
                alert("Please Select Group");
                this.loading = false;
                return;
            }
            if(this.temp.sale_rate == "" || this.temp.sale_rate =="" || this.temp.qty ==""){
                alert("Please Select Fill All Field !!!");
                this.loading = false;
                return;
            }
            let tempCart = {
                product_id: this.selectedProduct.product_id,
                product_name: this.selectedProduct.product_name,
                group_id: this.selectedGroup.id,
                group_name: this.selectedGroup.group_name,
                sale_rate: this.temp.sale_rate,
                sale_rate: this.temp.sale_rate,
                barcode: this.temp.barcode,
                qty: this.temp.qty
            }
            this.cart.push(tempCart);
            this.calculation();
            this.clearFrom();
            this.loading = false;
            this.show = true;
        },
        removeFromCart(index){
            this.cart.splice(index, 1);
            this.calculation();
        },
        calculation(){
            this.sale.sub_total = this.cart.reduce((prev, curr) => { return prev + (parseFloat(curr.sale_rate) * parseFloat(curr.qty) ); }, 0);
            this.sale.total = (parseFloat(this.sale.sub_total) + parseFloat(this.sale.vat_amount) + parseFloat(this.sale.transport_cost)) - parseFloat(this.sale.discount_amount);
            this.sale.due = this.sale.total - parseFloat(this.sale.paid);
        },
        calPercentToAmount(){
            this.sale.vat_amount = (parseFloat(this.sale.sub_total) * parseFloat(this.sale.vat_percent)) / 100;
            this.calculation();
        },
        calAmountPercent(){
            this.sale.vat_percent = (parseFloat(this.sale.vat_amount) * 100) / parseFloat(this.sale.sub_total);
            this.calculation()
        },
        savesale(){
            this.loading = true;
            let url = "/save-sale";
            if(this.sale.sale !=0){ url = "/update-sale"}
            this.sale.supplier_id = this.selectedSupplier.supplier_id;
            if(this.cart.length==0){
                alert("Your Cart Empty !!!");
                this.loading = false;
                return;
            }
            if( this.selectedSupplier.supplier_id ==""){
              alert("Select Supplier.");
              this.loading = false;
              return;
            }
            // date format
            this.sale.sale_date =moment(this.sale.sale_date).format('YYYY-MM-DD');

            axios.post(url,{sale: this.sale,supplier: this.selectedSupplier, cart: this.cart}).then(async res => {
                let r = res.data;
                alert(r.message);
                if(r.success){
                  let conf = confirm('Do you want to view invoice ?');
                  if(conf){
                        let invoice_url = "/product-sale-invoice/"+r.sale_id;
                        window.open(invoice_url, '_blank');
                        await new Promise(re => setTimeout(re, 1000));
                        window.location = '/product-sale';
                    }else{
                        window.location = '/product-sale';
                    }
                }
            })
        },
        editsale(){
            axios.post("/get-single-sale-data",{id: this.sale.sale}).then(res => {
                let r = res.data;
                this.sale = r.masterData;
                this.cart = r.sale_detail;
                this.selectedSupplier = r.supplier;
            })
        },
        clearFrom(){
            this.selectedGroup = null;
            // this.selectedProduct = null;
            this.temp= {
              product_id: '',
              group_id: '',
              sale_rate: 0,
              sale_rate: 0,
              qty: 0,
              barcode: ''
            },
            this.selectedProduct= {
              product_id: '',
              display_name: 'Select Product',
              product_name: '',
              product_code: ''
            },
            this.selectedGroup= {
              display_name: 'Select Group',
              id: '',
              group_name: ''
            }
        }
        
     }
 })
</script>
