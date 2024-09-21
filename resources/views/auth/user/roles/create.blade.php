<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/task') }}" method="post" class="needs-validation" novalidate>
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="category_id" class="form-label">Sub Category</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="" disabled>Select Sub Category</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{$subcategory->id }}" >{{ $subcategory->sub_category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="name" class="form-label">Task Name</label>
                                    <span class="bg-red"> *</span>
                                    <input type="text" name="name" class="form-control" placeholder="Please Enter Task Name Here" required />
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <span class="bg-red"> *</span>
                                    <select name="status" class="form-control">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
