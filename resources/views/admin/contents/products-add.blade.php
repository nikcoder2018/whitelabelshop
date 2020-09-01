@extends('admin.layouts.main')

@section('external_css')
    <link href="{{asset('assets/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection
@section('stylesheets')
<style>
    .category-list{
        min-height: 150px;
        overflow-y:scroll;
        overflow-x: hidden;
    }
</style>
@endsection
@section('content')
<form>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <header class="card-header">
                    All products |
                    <a href="{{route('products.index')}}" class="btn btn-white btn-sm">Products List</a>
                    <span class="pull-right">
                        <button type="submit" class="btn btn-success btn-sm">Save & Publish</button>
                        <button type="sumbit" class="btn btn-primary btn-sm">Save as draft</button>
                    </span>
                </header>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Product Title
                </div>
                <div class="card-body">
                    <input type="text" name="Title" class="form-control round-input" placeholder="E.g. Blue Jeans">
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Description
                </div>
                <div class="card-body">
                    <div class="summernote"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Options
                </div>
                <div class="card-body">
                    <div class="tabbable tabs-left">
                        <ul class="nav nav-tabs">
                        <li class="nav-item general"><a class="nav-link active show" href="#tab_general" data-toggle="tab">General</a></li>
                        <li class="nav-item inventory"><a class="nav-link" href="#tab_stock" data-toggle="tab">Inventory</a></li>
                        <li class="nav-item attribute"><a class="nav-link" href="#tab_attribute" data-toggle="tab">Attributes</a></li>
                        </ul>
                        <div class="tab-content">
                        <div class="tab-general tab-pane fade active show" id="tab_general">  
                            <div class="form-group">
                            <div class="row">
                                <label class="col-sm-6 control-label" for="inputRegularPrice">Regular Price ($)</label>
                                <div class="col-sm-6">
                                <input type="number" placeholder="Regular Price" id="inputRegularPrice" name="inputRegularPrice" class="form-control" min="0" step="any" value="">
                                </div>
                            </div>  
                            </div>
                            <div class="form-group">
                            <div class="row">
                                <label class="col-sm-6 control-label" for="inputSalePrice">Sale Price ($)</label>
                                <div class="col-sm-6">
                                <input type="number" placeholder="Sale Price" id="inputSalePrice" name="inputSalePrice" class="form-control" min="0" step="any" value=""> 
                                <a href="#" class="create_sale_schedule">Create Schedule</a>
                                </div>
                            </div>  
                            </div>
                        </div>
                        
                        <div class="tab-stock tab-pane fade" id="tab_stock">
                            <div class="form-group">
                            <div class="row">
                                <label class="col-sm-6 control-label" for="inputManageStock">Manage Stock</label>
                                <div class="col-sm-6">
                                <label class="">
                                    <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" name="manage_stock" id="manage_stock" class="shopist-iCheck" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                    &nbsp;Enable stock management for product
                                </label>                                             
                                </div>
                            </div>    
                            </div>
                            <div class="form-group stock-qty" style="display: none;">
                            <div class="row">  
                                <label class="col-sm-6 control-label" for="inputStockQty">Stock Qty</label>
                                <div class="col-sm-6">
                                <input type="number" min="0" placeholder="Stock Qty" id="inputStockQty" name="inputStockQty" class="form-control" value="0">
                                </div>
                            </div>
                            </div>
                            <div class="form-group back-to-order-page" style="display: none;">
                            <div class="row">  
                                <label class="col-sm-6 control-label" for="inputBackToOrder">Backorders?</label>
                                <div class="col-sm-6">
                                <select id="back_to_order_status" name="back_to_order_status" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="not_allow">Not Allow</option>
                                    <option value="allow_notify_customer">Allow and Notify Customer</option>
                                    <option value="only_allow">Only Allow</option>
                                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-back_to_order_status-container"><span class="select2-selection__rendered" id="select2-back_to_order_status-container" title="Not Allow">Not Allow</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="row">  
                                <label class="col-sm-6 control-label" for="inputStockAvailability">Stock Availability</label>
                                <div class="col-sm-6">
                                <select id="stock_availability_status" name="stock_availability_status" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="in_stock">In Stock</option>
                                    <option value="out_of_stock">Out of Stock</option>                  
                                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-stock_availability_status-container"><span class="select2-selection__rendered" id="select2-stock_availability_status-container" title="In Stock">In Stock</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                            </div>  
                            </div>
                        </div>
                                                                                                            
                        <div class="tab-advanced tab-pane fade" id="tab_attribute">
                            <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                <input type="text" class="form-control" name="attrNameByProduct" id="attrNameByProduct" placeholder="name example - size or colors or quantity">
                                </div>
                                <div class="col-sm-5">
                                <input type="text" class="form-control" name="attrValuesByProduct" id="attrValuesByProduct" placeholder="attribute values example - small,medium,large">
                                <span>Enter attribute values by comma separator</span>
                                </div>
                                <div class="col-sm-3">
                                <a class="btn btn-default btn-sm add-new-attribute" href="">Add Attribute</a>
                                </div>
                            </div>    
                            </div>
                        </div>  
                        
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Publish
                </div>
                <div class="card-body">
                    
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Category
                </div>
                <div class="card-body">
                    <div class="category-list">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Tags
                </div>
                <div class="card-body">
                    @php
                        $tags_array = array();
                        foreach($tags as $tag){
                            array_push($tags_array, $tag->tag);
                        }    
                        $tags = implode(',', $tags_array);
                    @endphp
                    <input name="tagsinput" id="tagsinput" class="tagsinput" value="{{$tags}}" />
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('external_js')
    <script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('js/jquery.tagsinput.js')}}"></script>
@endsection

@section('scripts')
<script src="{{asset('js/form-component.js')}}"></script>
<script>

    jQuery(document).ready(function(){

        $('.summernote').summernote({
            height: 200,                 // set editor height

            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor

            focus: true                 // set focus to editable area after initializing summernote
        });
    });

</script>
@endsection
