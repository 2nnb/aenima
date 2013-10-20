<script id="item_modal_src" type="text/x-handlebars-template" data-template-name="item_modal">
<div class="modal fade" id="modal_item" style="color:gray;">
  <div class="modal-dialog">
    <div class="modal-content">
       <form id='form_tweets2' class="form-horizontal" role="form">
         <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel"><i class="icon-trash icon-pencil"></i> Options</h4>
         </div>         
         <div class="modal-body">
            {{#data}}
               <p>Order</p>
               <input id="order2" name="order"  class="form-control" maxlength="100" type="text" placeholder="Order" value="{{place}}">
               <p>Handle</p>
               <input id="handle2" name="handle" class="form-control" maxlength="100" type="text" placeholder="Handle" value="{{handle}}">
               <p>Status</p>
               <textarea id="status2" name="status" class="form-control" style="width: 100%; height: 100px;" maxlength="120" placeholder="Status..">{{status}}</textarea>
               <input id="time2" name="time" type="hidden" value="{{time}}">
               <input id="id2" name="id"  type="hidden" value="{{id}}">
            {{/data}}   
         </div>
          <div class="modal-footer">
            <button type="button"id="data_update" class="btn btn-success"><i class="icon-repeat icon-large"></i> Update</button>
            <button type="button" id="data_delete" class="btn btn-danger" aria-hidden="true"><i class="icon-trash icon-large"></i> Delete</button>
          </div>
          </form>
    </div>
  </div>
</div>
</script>