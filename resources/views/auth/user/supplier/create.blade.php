<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/supplier') }}" method="post" class="needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="row">

                                <div class="col-6">
                                    <label for="supplier_name" class="form-label">Supplier Name</label>
                                    <input type="text" name="supplier_name" class="form-control"
                                        placeholder="Enter Supplier Name" required />
                                </div>
                                <div class="col-6">
                                    <label for="supplier_item" class="form-label">Supplier Item</label>
                                    <textarea name="supplier_item" class="form-control" placeholder="Enter Supplier Item"></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="category_id" class="form-label">Category</label>
                                    <input type="text" name="category_name" class="form-control"
                                        placeholder="Enter Category Name" required />
                                </div>
                                <div class="col-6">
                                    <label for="reputation_id" class="form-label">Reputation</label>
                                    <input type="text" name="reputation_name" class="form-control"
                                        placeholder="Enter Reputation Name" required />
                                </div>
                                <div class="col-6">
                                    <label for="important_note" class="form-label">Important Note</label>
                                    <textarea name="important_note" class="form-control" placeholder="Enter Important Note"></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="attachment" class="form-label">Attachment</label>
                                    <input type="file" name="attachment" class="form-control" />

                                </div>
                                <div class="col-6">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" class="form-control" placeholder="Enter Address"></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="Enter Phone" />
                                </div>
                                <div class="col-6">
                                    <label for="zone" class="form-label">Zone</label>
                                    <input type="text" name="zone" class="form-control"
                                        placeholder="Enter Zone" />
                                </div>
                                <div class="col-6">
                                    <label for="fax" class="form-label">Fax</label>
                                    <input type="text" name="fax" class="form-control" placeholder="Enter Fax" />
                                </div>
                                <div class="col-6">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="text" name="website" class="form-control"
                                        placeholder="Enter Website" />
                                </div>
                                <div class="col-6">
                                    <label for="zip_po" class="form-label">ZIP/PO</label>
                                    <input type="text" name="zip_po" class="form-control"
                                        placeholder="Enter ZIP/PO" />
                                </div>
                                <div class="col-12">
                                    <label for="concern_person" class="form-label">Concern Persons</label>
                                    <div id="concernPersonsForCreate">

                                        <div class="concern-person mb-2">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="text" name="concern_person[]"
                                                        class="form-control" placeholder="Concern Person" required />
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="mobile[]" class="form-control"
                                                        placeholder="Mobile" required />
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="designation[]" class="form-control"
                                                        placeholder="Designation" />
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="email" name="email_address[]" class="form-control"
                                                        placeholder="Email Address" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="button" class="btn btn-secondary"
                                        id="addConcernPersonForCreate">Add More</button>
                                </div>

                            </div>



                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
