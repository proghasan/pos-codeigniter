<div id="root">
    <div class="row">
        <div class="col-md-12"
            style="border-bottom: 1px solid #ddd;padding: 0px;padding-bottom: 9px;margin-top: -15px;">
            <div class="col-md-8  offset-md-2">
                <form @submit.prevent="getPurchaseReports()">
                    <div class="row">
                        <div class="col">
                        <date-picker v-model="start_date" lang="en" format="YYYY-MM-DD"></date-picker>
                        </div>
                        <div class="col">
                        <date-picker v-model="end_date" lang="en" format="YYYY-MM-DD"></date-picker>
                        </div>     
                        <div class="col">
                          <v-select :options="suppliers" v-model="selectedSupplier" label="display_name" v-if="suppliers.length > 0"></v-select>
                        </div>
                        <button class="btn btn-sm btn-warning">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row" style="display: none" :style="{display: show ? '' : 'none'}">
        <div class="col-md-12">
            <h3 class="text-center mt-3 mb-3">Purchase Report</h3>
             <button class="btn btn-sm btn-primary float-right mb-2"> <i class="fa fa-print"></i> Print</button>
            <table class="table table-bordered table-sm">
              <thead class="text-center">
                  <tr>
                      <th>SL</th>
                      <th>Date</th>
                      <th>Invoice</th>
                      <th>Supplier Code</th>
                      <th>Supplier</th>
                      <th>Discount</th>
                      <th>Total</th>
                      <th>Paid</th>
                      <th>Due</th>
                      <th>Prev. Due</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody class="text-center">
                  <tr v-for="(purchase,index) in purchases">
                    <td>{{index+1}}</td>
                    <td>{{purchase.purchase_date}}</td>
                    <td>{{purchase.invoice}}</td>
                    <td>{{purchase.supplier_code}}</td>
                    <td>{{purchase.name}}</td>
                    <td>{{purchase.discount_amount}}</td>
                    <td>{{purchase.total}}</td>
                    <td>{{purchase.paid}}</td>
                    <td>{{purchase.total - purchase.paid}}</td>
                    <td>{{purchase.previous_due}}</td>
                    <td>
                    <button @click.prevent="edit(purchase.purchase_id)" type="button" class="button"><i class="fa fa-pencil"></i></button>
                    <button type="button" class="button"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
              </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layouts/vue')?>
<script src="/assets/js/vue/vue-select.min.js"></script>
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/vue/vue-datepicker.js"></script>
<script>
  Vue.component('v-select', VueSelect.VueSelect);
  new Vue({
    el: "#root",
    data: {
        show: false,
        start_date: moment().format("YYYY-MM-DD"),
        end_date: moment().format("YYYY-MM-DD"),
        purchases: [],
        suppliers: [],
        selectedSupplier: {
            display_name: 'Select Supplier',
            supplier_id: '',
            name: '',
            previous_due:''
        },
    },
    created(){
        this.getPurchaseReports();
        this.getSelectedSuppliers();
    },
    methods:{
        getSelectedSuppliers(){
          axios.get('/get-selected-suppliers').then(res => {
            this.suppliers = res.data;
          })
        },
        getPurchaseReports(){
          this.start_date =moment(this.start_date).format('YYYY-MM-DD');
          this.end_date =moment(this.end_date).format('YYYY-MM-DD');
          let supplier_id = this.selectedSupplier == null ? '' : this.selectedSupplier.supplier_id;
          axios.post('/get-purchase-reports',{start_date: this.start_date, end_date: this.end_date,supplier_id: supplier_id}).then(res => {
            this.purchases = res.data;
            this.show = true;
          })
        },
        edit(id){
          window.open('/product-purchase/'+id, '_blank');
        }
    }

  })
</script>