<script type="text/javascript">

$(function ()
{
  $('form').submit(function (e) {
    e.preventDefault();
    var url = 'http://my.suresy.com.au/billing/playground/submit?';
    var arr = $(this).serializeArray();
    var params = {};
    for(var k in arr)
    {
      var o = arr[k];
      params[o.name] = o.value;
    }
    var paramsStr = jQuery.param(params);
    url = url + paramsStr + '&pretty=yes';
    
    console.log('url: ' + url);
    $('#response').attr('src', url);
    
  });
  
  $('input, select').change(function (e){
    //$('form').submit();
  });
  
});  
</script>
<style type="text/css">
  
  .header
  {
    display: none;
  }
  
</style>

<div class="columns">
    <div class="column">
        <h1 class="title is-3">Billing Playground</h1>

        <form id="request">
            <fieldset>
                <label>Test Mode</label>
                <select name="test">
                  <option value="yes">Yes</option>
                  <option value="no">No (transactions live)</option>
                </select>
            </fieldset>
            
            <fieldset>
                <label>Policy ID</label> <input type="text" class="input" name="policy_id" placeholder="1" />
            </fieldset>
            
            
            <fieldset>
                <label>Card Holder Name</label> <input type="text" class="input" name="cc_name" placeholder="John Smith" />
            </fieldset>

            <fieldset>
                <label>Card Number</label> <input type="text" class="input" name="cc" placeholder="5555 5555 5555 5555" />
            </fieldset>

            <fieldset>
                <label>Card Expiration Month</label> <input type="text" class="input" name="cc_mon" placeholder="MM" />
            </fieldset>

            <fieldset>
                <label>Card Expiration Year</label> <input type="text" class="input" name="cc_year" placeholder="YY" />
            </fieldset>
            
            <fieldset>
                <label>Card CVV</label> <input type="text" class="input" name="cc_cvv" placeholder="000" />
            </fieldset>
            
            
<!--
            <fieldset>
                <label>Amount</label> <input type="text" class="input" name="amount" placeholder="1.00" value="1.00" />
            </fieldset>
-->

            

<!--
            <fieldset>
                <label>Description</label> <input type="text" class="input" name="description" placeholder="Test Suresy subscription #123" />
            </fieldset>
-->

            
            
            
            <fieldset id="buttons">
              <button type="submit" id="submit" class="button is-primary">SUBMIT</button>
              <button type="reset" class="button">Reset</button>
            </fieldset>
        </form>
    </div>

    <div class="column" id="column_iframe">
        <h4 class="title is-3">API Response:</h4>
        <iframe href="" id="response"></iframe>
    </div>
</div>

