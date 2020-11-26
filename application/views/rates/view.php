<html>
  <head>
    <title>Rate Manager - Suresy</title>
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
    });
    
    
    
    function saveRate(record)
    {
      var record_id = record.data('record');
      var rateData = {
        key: record.find('.record_key').val(),
        value: record.find('.record_value').val(),
        rate: record.find('.record_rate').val(),
        range_min: record.find('.record_range_min').val(),
        range_max: record.find('.record_range_max').val(),
      };
      
      
        
        
      var rateInput = {};
      
      if(rateData.key && rateData.key != "") { rateInput.key = rateData.key; }
      if(rateData.value && rateData.value != "") { rateInput.value = rateData.value; }
      if(rateData.rate && rateData.rate != "") { rateInput.rate = rateData.rate; }
      if(rateData.range_min && rateData.range_min != "") { rateInput.range_min = rateData.range_min; }
      if(rateData.range_max && rateData.range_max != "") { rateInput.range_max = rateData.range_max; }
        
      
      var inputData = {
          data: rateInput,
          calc_rate_id: record_id
        };
        
     
      $.ajax('/backstage/admin/rate/manager/update',
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
      <div id="rate_manager">
        <h1>Rate Manager</h1>
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
        
        
      </div>
      
      <h2>Rates</h2>
      
      <div id="rates_results">
        <div id="search_container">
          <form action="/backstage/admin/rate/manager" method="get">
            <input type="search" name="search" placeholder="search" value="<?= isset($search) && $search ? $search : '' ?>" />
            <select name="searchby">
              <option value="type" <?= $searchby == 'type' ? 'selected' : '' ?>>Type</option>
              <option value="key" <?= $searchby == 'key' ? 'selected' : '' ?>>User Choice (Amount/Key)</option>
              <option value="rate" <?= $searchby == 'rate' ? 'selected' : '' ?>>Rate</option>
              <option value="value" <?= $searchby == 'value' ? 'selected' : '' ?>>Value</option>

            </select>
            <button type="submit">Search</button>
            
            <?php if(isset($search) && $search) : ?>
            
            <a href="/backstage/admin/rate/manager">Clear Search</a>
            
            
            <?php endif; ?>
          </form>
        </div>
        
        <form action="/backstage/admin/rate/manager">  
          <table>
            <thead>
              <tr>
                <?php
                
                $sort_key = "type";
                $sort_str = "&sort[".$sort_key."]=";
                $sort_dir = "ASC";
                if($sort && is_array($sort) && isset($sort[$sort_key]) && $sort[$sort_key] == "ASC")
                {
                  $sort_dir = "DESC";
                }
                $sort_str .= $sort_dir;
                
                $active_value = NULL;
                if(isset($sort[$sort_key]))
                {
                  $active_value = "active " . $sort[$sort_key];
                }
                  
                ?>
                <th><a class="<?= $active_value ?>" href="/backstage/admin/rate/manager?<?= $url_query_sort ?><?= $sort_str ?>">Type</a></th>
                
                
                <?php
                
                $sort_key = "key";
                $sort_str = "&sort[".$sort_key."]=";
                $sort_dir = "ASC";
                if($sort && is_array($sort) && isset($sort[$sort_key]) && $sort[$sort_key] == "ASC")
                {
                  $sort_dir = "DESC";
                }
                $sort_str .= $sort_dir;
                
                $active_value = NULL;
                if(isset($sort[$sort_key]))
                {
                  $active_value = "active " . $sort[$sort_key];
                }
                  
                ?>
                <th><a class="<?= $active_value ?>" href="/backstage/admin/rate/manager?<?= $url_query_sort ?><?= $sort_str ?>">User Choice (Amount/Key)</a></th>
                
                
                
                <?php
                
                $sort_key = "rate";
                $sort_str = "&sort[".$sort_key."]=";
                $sort_dir = "ASC";
                if($sort && is_array($sort) && isset($sort[$sort_key]) && $sort[$sort_key] == "ASC")
                {
                  $sort_dir = "DESC";
                }
                $sort_str .= $sort_dir;
                
                $active_value = NULL;
                if(isset($sort[$sort_key]))
                {
                  $active_value = "active " . $sort[$sort_key];
                }
                  
                ?>
                <th><a class="<?= $active_value ?>" href="/backstage/admin/rate/manager?<?= $url_query_sort ?><?= $sort_str ?>">Rate</a></th>
                
                
                <?php
                
                $sort_key = "value";
                $sort_str = "&sort[".$sort_key."]=";
                $sort_dir = "ASC";
                if($sort && is_array($sort) && isset($sort[$sort_key]) && $sort[$sort_key] == "ASC")
                {
                  $sort_dir = "DESC";
                }
                $sort_str .= $sort_dir;
                
                $active_value = NULL;
                if(isset($sort[$sort_key]))
                {
                  $active_value = "active " . $sort[$sort_key];
                }
                  
                ?>
                <th><a class="<?= $active_value ?>" href="/backstage/admin/rate/manager?<?= $url_query_sort ?><?= $sort_str ?>">Value</a></th>
                
                
                
                <?php
                
                $sort_key = "range_min";
                $sort_str = "&sort[".$sort_key."]=";
                $sort_dir = "ASC";
                if($sort && is_array($sort) && isset($sort[$sort_key]) && $sort[$sort_key] == "ASC")
                {
                  $sort_dir = "DESC";
                }
                $sort_str .= $sort_dir;
                
                
                
                $sort_key = "range_max";
                $sort_str2 = "&sort[".$sort_key."]=";
                $sort_dir2 = "ASC";
                if($sort && is_array($sort) && isset($sort[$sort_key]) && $sort[$sort_key] == "ASC")
                {
                  $sort_dir2 = "DESC";
                }
                $sort_str2 .= $sort_dir2;
                  
                  
                ?>
                <th>Range ( &nbsp;<a href="/backstage/admin/rate/manager?<?= $url_query_sort ?><?= $sort_str ?>">Min</a> &nbsp;&nbsp;>&nbsp;&nbsp; <a href="/backstage/admin/rate/manager?<?= $url_query_sort ?><?= $sort_str2 ?>">Max</a> &nbsp;)</th>
                <?php
                
                $sort_key = "modified";
                $sort_str = "&sort[".$sort_key."]=";
                $sort_dir = "ASC";
                if($sort && is_array($sort) && isset($sort[$sort_key]) && $sort[$sort_key] == "ASC")
                {
                  $sort_dir = "DESC";
                }
                $sort_str .= $sort_dir;
                
                $active_value = NULL;
                if(isset($sort[$sort_key]))
                {
                  $active_value = "active " . $sort[$sort_key];
                }
                  
                ?>
                <th><a class="<?= $active_value ?>" href="/backstage/admin/rate/manager?<?= $url_query_sort ?><?= $sort_str ?>">Modified</a></th>
    
              </tr>
            </thead>
            <tbody>
    <?php foreach($rates as $key=>$rate) : ?>
              <tr data-record="<?= $rate->calc_rate_id ?>" class="rate_record rate_<?= $rate->type ?>">
                <td>
                  <input type="text" class="rate_input record_type" name="type" value="<?= $rate->type ?>" readonly />
                </td>
                <td class="td_key">
                  <input type="text" class="rate_input record_key" name="key" value="<?= $rate->key ?>" <?= $rate->type == 'anchor' ? 'readonly' : '' ?> />
                </td>
                <td class="td_rate">
                  <input type="text" class="rate_input record_rate" name="rate" value="<?= number_format($rate->rate, 3) ?>" />
                </td>
                <td class="td_value">
                  <input type="text" class="rate_input record_value" name="value" value="<?= $rate->value ?>" />
                </td>
                <td class="td_range">
                  <input type="text" class="rate_input record_range_min" name="range_min" value="<?= $rate->range_min ?>" placeholder="0" />
                  <input type="text" class="rate_input record_range_max" name="range_max" value="<?= $rate->range_max ?>" placeholder="0" />              
                </td>
                <td class="date"><?= date('M d, Y H:i', strtotime($rate->modified)) ?></td>
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
                <li><a href="/backstage/admin/rate/manager/<?= $i+1 ?>?<?= $url_query ?>" class="page_link">
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