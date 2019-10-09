<div id="root">
    <div class="row">
        <div class="col-md-12"
            style="border-bottom: 1px solid #ddd;padding: 0px;padding-bottom: 9px;margin-top: -15px;">
            <div class="col-md-8  offset-md-2">
                <form @submit.prevent="getCurrentStock()">
                    <div class="row">
                        <div class="col">
                          <v-select :options="products" v-model="selectedProduct" label="display_name" v-if="products.length > 0"></v-select>
                        </div>
                        <div class="col">
                          <v-select :options="groups" v-model="selectedGroup" label="display_name" v-if="groups.length > 0"></v-select>
                        </div>
                        <div class="col">
                          <select class="form-control" v-model="stock_status">
                            <option value="All">All Stock</option>
                            <option value="current_stock">Current Stock</option>
                            <option value="stock_out">Stock Out</option>
                          </select>
                        </div>
                        <button class="btn btn-sm btn-warning">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center mt-3 mb-3">Product Stock</h3>
             <button class="btn btn-sm btn-primary float-right mb-2"> <i class="fa fa-print"></i> Print</button>
            <table class="table table-bordered table-sm">
              <thead class="text-center">
                  <tr>
                      <th>SL</th>
                      <th>Product Code </th>
                      <th>Product Name</th>
                      <th>Group Name</th>
                      <th>Purchase Rate</th>
                      <th>Sale Rate</th>
                      <th>Total Sale</th>
                      <th>Sale Return</th>
                      <th>Current Stock</th>
                  </tr>
              </thead>
              <tbody class="text-center">
                  <tr v-for="(stock,index) in stocks" :style="stock.current_stock < 10 ? thColor : ''">
                      <td>{{ index+1 }}</td>
                      <td>{{ stock.product_code }}</td>
                      <td>{{ stock.product_name }}</td>
                      <td>{{ stock.group_name }}</td>
                      <td>{{ stock.purchase_rate }}</td>
                      <td>{{ stock.sale_rate }}</td>
                      <td>{{ stock.sale_quantity }}</td>
                      <td>{{ stock.sale_return_quantity }}</td>
                      <td>{{ stock.current_stock }}</td>
                  </tr>
              </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('admin/layouts/vue')?>
<script src="/assets/js/vue/vue-select.min.js"></script>
<script>
  Vue.component('v-select', VueSelect.VueSelect);
  new Vue({
    el: "#root",
    data: {
        stock_status: 'All',
        stocks: [],
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
        thColor: {
            background: 'red',
            color:'white'
        }
    },
    created(){
        this.getCurrentStock();
        this.getSelectedGroups();
        this.getSelectedProducts();
    },
    methods:{
        getCurrentStock(){
            url="/get-current-stock";
            searchItem = {
                product_id: this.selectedProduct==null ? '' : this.selectedProduct.product_id,
                group_id: this.selectedGroup==null ? '' : this.selectedGroup.id,
                stock_status: this.stock_status
            }
            axios.post(url,searchItem).then(res => {
                this.stocks = res.data;
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