<script id="item_list_src" type="text/x-handlebars-template" data-template-name="item_list">
       <table class="table table-striped table-striped table-bordered" id="list_table">
         <thead>
           <tr>
            {{#items}}
               {{#ifCond this '!=' 'id'}}
                  <th>{{this}}</th> 
               {{/ifCond}}                
            {{/items}} 
            <th>Edit</th>
           </tr>
         </thead>
         <tbody>
           {{#data}}
                 <tr>                
                 {{#each this}}
                   {{#ifCond @key '!=' 'id'}}
                     <td>{{this}}</td>
                   {{/ifCond}}                     
                 {{/each}}
                 {{#each this}}
                   {{#ifCond @key '==' 'id'}}
                     <td><a id="id_{{this}}" class="btn btn-primary load_modal_list"><i class="icon-search"></i></a></td>
                   {{/ifCond}} 
                 {{/each}}                 
                 </tr>                                                     
           {{/data}}        
         </tbody>
       </table>
</script>