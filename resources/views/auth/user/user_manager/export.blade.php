<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form class="needs-validation export-form" role="form" novalidate>
            @csrf
            <div class="modal fade" id="exportModal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            {{-- <div class="row mb-0" style="margin-top:10px;">
                                <div class="form-group col-md-6">
                                    <label for="date_form" class="form-label">Date
                                        From</label>
                                    <input class="form-control" type="date" id="date_form" name="date_form">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date_to" class="form-label">Date
                                        To</label>
                                    <input class="form-control" type="date" id="date_to" name="date_to">
                                </div>
                            </div> --}}
                            <div class="col mb-0" style="margin-top:10px;">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input selected_all_row" type="checkbox"
                                        id="selected_column">
                                    <label class="form-check-label" style="margin-right:5px;">Select
                                        All</label>
                                </div>
                            </div>
                            @php
                                $db_table = 'user_manager';
                            @endphp
                            <input type="hidden" id="db_table" value="{{ $db_table }}">
                            <div class="form-inline">
                                @foreach (Schema::getColumnListing($db_table) as $index => $row)
                                    <div class="col mb-0" style="margin-top:10px;">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input selected_row_column" type="checkbox"
                                                name="selected_rows[]" id="selected_column" value="{{ $row }}">
                                            <label class="form-check-label"
                                                style="margin-right:5px;">{{ $row }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="publish-post" id="export">
                                    Export
                                </button>
                                <button type="button" class="publish-post bg-ddd"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                            <center>
                                <p class="display-none text-red" id="checkbox_error">
                                    Please select at least one column!
                                </p>
                            </center>
                            <center>
                                <p class="display-none" id="loader">Exporting.......
                                    please wait</p>
                            </center>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
