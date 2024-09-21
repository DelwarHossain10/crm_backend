<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/order') }}" method="post" class="needs-validation" role="form" novalidate>
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-6">
                                    <label for="client_order_id" class="form-label">Client Order</label>
                                    <input type="text" name="client_order_id" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <label for="sale_order_subject" class="form-label">Sale Order Subject</label>
                                    <input type="text" name="sale_order_subject" class="form-control"  required />
                                </div>
                                <div class="col-6">
                                    <label for="prospect_id" class="form-label">Prospect ID</label>
                                    <input type="text" name="prospect_id" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="company_attention_person" class="form-label">Company Attention Person</label>
                                    <input type="text" name="company_attention_person" class="form-control"  required />
                                </div>
                                <div class="col-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control"  required />
                                </div>
                                <div class="col-6">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" name="designation" class="form-control" required />
                                </div>
                                <div class="col-6">
                                    <label for="order_item" class="form-label">Order Item</label>
                                    <textarea name="order_item" class="form-control" required></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="key_account_person_id" class="form-label">Key Account Person ID</label>
                                    <input type="text" name="key_account_person_id" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="sale_order_description" class="form-label">Sale Order Description</label>
                                    <textarea name="sale_order_description" class="form-control"></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="attachment" class="form-label">Attachment</label>
                                    <input type="file" name="attachment" class="form-control" />

                                </div>
                                <div class="col-6">
                                    <label for="lead_name" class="form-label">Lead Name</label>
                                    <input type="text" name="lead_name" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="sale_order_date" class="form-label">Sale Order Date</label>
                                    <input type="date" name="sale_order_date" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="client_order_date" class="form-label">Client Order Date</label>
                                    <input type="date" name="client_order_date" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="email_address" class="form-label">Email Address</label>
                                    <input type="email" name="email_address" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="Department" class="form-label">Department</label>
                                    <input type="text" name="Department" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="quotation_id" class="form-label">Quotation ID</label>
                                    <input type="text" name="quotation_id" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="ordered_amount" class="form-label">Ordered Amount</label>
                                    <input type="text" name="ordered_amount" class="form-control"  />
                                </div>
                                <div class="col-6">
                                    <label for="delivered" class="form-label">Delivered</label>
                                    <select name="delivered" class="form-control">
                                        <option value="0" >No</option>
                                        <option value="1" >Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer justify-content-end">
                                <button type="submit" class="publish-post">Save</button>
                                <button type="button" class="publish-post bg-ddd"
                                    data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
