<html>
  <head>
    <title>Promocode Manager - Suresy</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    
  </head>
  <link href="/css/admin.css?c=<?= time() ?>" rel="stylesheet" />
  <script type="text/javascript">
    $(function (){
      $('#pagination li').click(function (e){
        e.preventDefault();
        var pageLink = $(this).find('.page_link');
        console.log(pageLink.length, pageLink);
        window.location.href=pageLink.attr('href');
      });
      
      $('.rate_input').blur(function (e)
      {
        e.preventDefault();
        var r = $(this).closest('.rate_record');
        saveRate(r);
      });
      
      $('.rate_input').change(function (e)
      {
        e.preventDefault();
        var r = $(this).closest('.rate_record');
        saveRate(r);
      });
    });
    
    
    
    function saveRate(record)
    {
      var record_id = record.data('record');
      var rateData = {
        code: record.find('.record_code').val(),
        rate: record.find('.record_rate').val(),
        starts: record.find('.record_starts').val(),
        expires: record.find('.record_expires').val(),
        enabled: record.find('.record_enabled').val(),
      };
      
      
        
        
      var rateInput = {};
      
      if(rateData.code && rateData.code != "") { rateInput.code = rateData.code; }
      if(rateData.starts && rateData.starts != "") { rateInput.starts = rateData.starts; }
      if(rateData.rate && rateData.rate != "") { rateInput.rate = rateData.rate; }
      if(rateData.expires && rateData.expires != "") { rateInput.expires = rateData.expires; }
      if(rateData.enabled && rateData.enabled != "") { rateInput.enabled = rateData.enabled; }
        
      
      var inputData = {
          data: rateInput,
          id: record_id
        };
        
     
      $.ajax('/backstage/admin/promocode/manager/update',
      {
        type: 'POST',
        dataType: 'json',
        data: inputData,
        complete: function (response, status)
        {
          
        }
      });
      
      
    }
    
  </script>
  <body>
    <div id="menu_container" class="container">
      <?= isset($nav_tpl) ? $nav_tpl : '' ?>
    </div>
    <div id="content">      
      <div id="rate_manager2">
<!--         <h1>Promocode Manager</h1> -->
        <!-- 
        <a href="/backstage/admin/policies/export" id="download_policies">Download Policies CSV</a>
        <form action="/backstage/admin/rate/manager" id="search_form" method="get">
          <fieldset>
            <label style="width:100px;display: inline-block;">Filter</label>
            <select name="type" id="rate_type">
              <option value="">Choose Rate Type</option>
              <option value="anchor" <?= $type == 'anchor' ? 'selected' : '' ?>>Anchor Rates</option>
              <option value="excess" <?= $type == 'excess' ? 'selected' : '' ?>>Excess Rates</option>
              <option value="age" <?= $type == 'age' ? 'selected' : '' ?>>Age Rates</option>
              <option value="cover_household_items" <?= $type == 'cover_household_items' ? 'selected' : '' ?>>Household Cover Rates</option>
              <option value="cover_electronics" <?= $type == 'cover_electronics' ? 'selected' : '' ?>>Electronics Cover Rates</option>
              <option value="cover_jewellery" <?= $type == 'cover_jewellery' ? 'selected' : '' ?>>Jewellery Cover Rates</option>
              <option value="cover_sports" <?= $type == 'cover_sports' ? 'selected' : '' ?>>Sports Cover Rates</option>
              <option value="postcode" <?= $type == 'postcode' ? 'selected' : '' ?>>Postcodes</option>
              <option value="security" <?= $type == 'security' ? 'selected' : '' ?>>Security Rates (dog, alarm, housemates)</option>
              <option value="leap" <?= $type == 'leap' ? 'selected' : '' ?>>Leap Year Rates</option>
              <option value="gst" <?= $type == 'gst' ? 'selected' : '' ?>>GST Rate</option>
              <option value="stamp_duty" <?= $type == 'stamp_duty' ? 'selected' : '' ?>>Stamp Duty Rate</option>
            </select>
            <select name="limit" id="num_rows">
              <option value="">Number of Results</option>
              <option <?= $limit == '50' ? 'selected' : '' ?>>50</option>
              <option <?= $limit == '100' ? 'selected' : '' ?>>100</option>
              <option <?= $limit == '200' ? 'selected' : '' ?>>200</option>
              <option <?= $limit == '300' ? 'selected' : '' ?>>300</option>
              <option <?= $limit == '500' ? 'selected' : '' ?>>500</option>
  
            </select>
            <button type="submit">Find</button>
          </fieldset>
        </form>
        -->
        
      </div>
      
      
      <div id="add_promocode">
        <h2>Add a Promocode</h2>
        
        <form action="/backstage/admin/promocode/manager/add" method="post">
          <fieldset id="code">
            <label>Code</label>
            <input type="text" name="data[code]" placeholder="code" />
          </fieldset>
          
          <fieldset id="rate">
            <label>Rate</label>
            <input type="text" name="data[rate]" placeholder="0.00" />
          </fieldset>
          
          <fieldset id="starts">
            <label>Start Date</label>
            <input type="date" name="data[starts]" />
          </fieldset>
          
          <fieldset id="ends">
            <label>End Date</label>
            <input type="date" name="data[expires]" />
          </fieldset>
          
          <fieldset id="enabled">
            <label>Enabled</label>
            <select name="data[enabled]">
              <option value="yes">yes</option>
              <option value="no">no</option>
            </select>
          </fieldset>
          
          <fieldset>
            <button type="submit">Submit</button>
          </fieldset>
          
        </form>
      </div>
      
      
      
      
      
      
      
      <br /><br /><br />
      
      
      
      
      <h2>Existing Promocodes</h2>
      
      <div id="rates_results">
        <form action="/backstage/admin/promocode/manager">  
          <table>
            <thead>
              <tr>
                <th>Promocode</th>
                <th>Rate</th>
                <th>Starts</th>
                <th>Expires</th>
                <th>Enabled</th>
                <th>Modified</th>
                <th>Action</th>
                              
              </tr>
            </thead>
            <tbody>
    <?php foreach($promocodes as $key=>$promocode) : ?>
              <tr data-record="<?= $promocode->calc_promocode_id ?>" class="rate_record">
                <td>
                  <input type="text" class="rate_input record_code" name="code" value="<?= $promocode->code ?>" disabled="disabled" />
                </td>
                <td>
                  <input type="text" class="rate_input record_rate" name="rate" value="<?= number_format($promocode->rate,3) ?>"  />
                </td>
                <td>
                  <input type="date" class="rate_input record_starts" name="starts" value="<?= $promocode->starts ? date("Y-m-d", strtotime($promocode->starts)) : '' ?>"  />
                </td>
                <td>
                  <input type="date" class="rate_input record_expires" name="expires" value="<?= $promocode->expires ? date("Y-m-d", strtotime($promocode->expires)) : '' ?>"  />
                </td>
                <td>
                  
                  <select name="enabled" class="rate_input record_enabled">
                    <option <?= $promocode->enabled == "yes" ? "selected" : "" ?>>yes</option>
                    <option <?= $promocode->enabled == "no" ? "selected" : "" ?>>no</option>
                  </select>
                  
                </td>
                
                <td class="date"><?= date('M d, Y H:i', strtotime($promocode->modified)) ?></td>
                
                <td>
                  <a href="/backstage/admin/promocode/manager/delete?id=<?= $promocode->calc_promocode_id ?>">Delete</a>
                  
                </td>
                
              </tr>
    <?php endforeach; ?>
            </tbody>
          </table>
          <br /><br /><br />
          <div id="pagination">
            <strong><?= number_format($count, 0) ?> Results (page <?= $page ?> of <?= $pages ?>)</strong>
            <ul>
              <?php for($i=0; $i < intval($pages); $i++) { ?>
                <?php if($i+1 == intval($page)) : ?>
                <li class="active"><span><?= $i+1 ?></span></li>
                <?php else : ?>
                <li><a href="/backstage/admin/promocode/manager/<?= $i+1 ?>?<?= $url_query ?>" class="page_link">
                  <span><?= $i+1 ?></span>
                  </a>
                </li>
                <?php endif; ?>
              <?php } ?>
            </ul>
          </div>
          <input type="hidden" name="action" value="edit" />
        </form>
        
        
        
        
        
        
      </div>
    
    
    </div>
  </body>
</html>