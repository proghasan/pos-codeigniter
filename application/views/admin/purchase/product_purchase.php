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
                        <input type="date" class="form-control" placeholder="Last name"
                            value="<?php echo date('Y-m-d')?>">
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
                                    <input type="txet" class="form-control" placeholder="Supplier">
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
                                    <input type="txet" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Due</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" value="0.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row custom_form" style="margin-top: -13px;">
                                <label class="col-sm-3 col-form-label">Product</label>
                                <div class="col-sm-8">
                                    <input type="txet" class="form-control" placeholder="Supplier">
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
                                    <input type="txet" class="form-control" placeholder="Supplier">
                                </div>
                            </div>
                            <div class="form-group row custom_form">
                                <label class="col-sm-3 col-form-label">Pur.Rate</label>
                                <div class="col-sm-9">
                                    <input type="txet" class="form-control" placeholder="Supplier">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3"></div>
                                <div class="form-group col-md-5">
                                    <label>Qty</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Sale Rate</label>
                                    <input type="text" class="form-control">
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

                </div>
            </div>
        </div>
    </div>
</div>