<script type="text/javascript">

$(function ()
{
  $('form').submit(function (e) {
    e.preventDefault();
    var url = 'https://my.suresy.dilatedigital.com.au/api/calculator/quote?';
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
    $('form').submit();
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
        <h1 class="title is-3">Calculator Playground</h1>

        <form id="request">
            <!--
            <fieldset>
                <label>Name</label> <input type="text" name="name" />
            </fieldset>
            -->

            <fieldset>
                <label>Postcode</label> <input type="text" class="input" name="postcode" placeholder="0000" />
            </fieldset>

            <fieldset>
                <label>Suburb</label> <input type="text" class="input" name="suburb" placeholder="ex: Inglewood" />
            </fieldset>

            <fieldset>
                <label>Age</label> <input type="text" class="input" name="age" placeholder="17" />
            </fieldset>

            <fieldset>
                <label>Cover Household Items</label> <input type="text" class="input" name="cover_household_items" placeholder="0" />
            </fieldset>
            
            <fieldset>
                <label>Cover Electronics</label> <input type="text" class="input" name="cover_electronics" placeholder="0" />
            </fieldset>
            
            
            <fieldset>
                <label>Cover Jewellery</label> <input type="text" class="input" name="cover_jewellery" placeholder="0" />
            </fieldset>

            

            <fieldset>
                <label>Cover Sports Equipment</label> <input type="text" class="input" name="cover_sports" placeholder="0" />
            </fieldset>

            <fieldset>
                <label>Excess</label> <input type="text" class="input" name="excess" placeholder="500" value="500" />
            </fieldset>

            <fieldset>
                <label>Security / Dog</label> <select name="security_dog">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </fieldset>

            <fieldset>
                <label>Security / Alarm</label> <select name="security_alarm">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </fieldset>

            <fieldset>
                <label>Promo Code</label> <input type="text" class="input" name="promocode" />
            </fieldset>
            
            
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

