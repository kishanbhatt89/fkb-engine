@extends('layouts.master')

@section('content')
        
    @include('admin.clients.partials._toolbar')
    
    <div class="post d-flex flex-column-fluid" id="kt_post">
        
        <div id="kt_content_container" class="container-xxl">
         
            <div class="card">
                                                
                <div class="card-body py-4">
                    
                    <div class="d-flex flex-stack mb-5">
    
                        <div class="d-flex align-items-center position-relative my-1">
        
                            <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Clients"/>

                        </div>
    
                        @include('admin.clients.partials._filter')
    
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                            
                            <div class="fw-bolder me-5">
                                <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
                            </div>

                            <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Delete Selected</button>      
                                                    
                        </div>
                        
                    </div>

                    @include('admin.clients.partials._table')

                </div>
                
            </div>
            
        </div>
        
    </div>

    <!-- ADD File -->

    <div class="modal fade" id="kt_modal_edit" tabindex="-1" aria-hidden="true" aria-label="Close">
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('gapp') }}/js/custom/clients/client-dataTable.js"></script>
    <script src="{{ asset('gapp') }}/js/custom/clients/client-functions.js"></script>
    <script src="{{ asset('gapp') }}/js/custom/clients/client-utils.js"></script>
@endsection