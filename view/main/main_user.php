    <div class="container">      
        <?php
          if (isset($_SESSION['persona_google_name']))
             {
             ?>
             <div class="page-header">
               <h4><?php print $_SESSION['persona_google_name'] ?> <small> Welcome to ænima</small></h4>
             </div>               
             <?php        
             }   
        ?>
       <div id="face_box" class="row">
          <ul id="msg_list"></ul> 
       </div>
       <div id="face_btn_box" class="row">
        <div id="face_inner_btn_box" class="col-xs-12 col-sm-6 col-md-8 pull-right">
          <div class="input-group">            
            <input id="chat_input" type="text" class="form-control"/>
            <div class="input-group-btn">
              <button id="chat_send" type="button" class="btn btn-default" tabindex="-1">Send</button>
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
              <span class="caret"/>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                <a href="?r=4">Action</a>
                </li>
                <li>
                <a href="#">Another action</a>
                </li>
                <li>
                <a href="#">Something else here</a>
                </li>
                <li class="divider"/>
                <li>
                <a href="#">Separated link</a>
                </li>
              </ul>
            </div>
          </div>   
       </div>
      </div>        
    </div>