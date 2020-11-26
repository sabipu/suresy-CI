var claimItemTpl = undefined;
var claimWitnessTpl = undefined;
var claimFileTpl = undefined;
var claim_id = undefined;
var claim = {
  items: [],
  witness: [],
  files: [],
  user: {
    name: undefined,
    phone: undefined,
    id: undefined,
  },
  policy: {
    id: undefined,
    type: undefined,
    start_date: undefined,
  },
  
};
var lastSave = undefined;

function setupClaimForm() {
  claimItemTpl = $('#incident_item_template').html();
  Mustache.parse(claimItemTpl);
  $('#claim_another_item').click(function (e)
  {
    e.preventDefault();
    addNewReportedItem();
  });
  claimWitnessTpl = $('#incident_witness_template').html();
  Mustache.parse(claimWitnessTpl);
  $('#claim_add_witness').click(function (e)
  {
    e.preventDefault();
    addNewWitness();
  });
  claimFileTpl = $('#incident_file_template').html();
  Mustache.parse(claimFileTpl);
  $('#claim_another_file').click(function (e)
  {
    e.preventDefault();
    addNewFile();
  });
  $('#make_claim_form select').change(function (e) { if(!$(this).hasClass('ignore-input')) { updateClaim(); }});
  $('#make_claim_form input, #make_claim_form textarea').blur(function (e) { if(!$(this).hasClass('ignore-input')) { updateClaim(); } });  
  $('#make_claim_form').submit(function(e){
    e.preventDefault();
    saveClaim('insert', true, function (result, success){
      $('#make_claim_form').hide();
      $('#claim_submitted').show();
    });
  });
  
}

function addNewFile()
{
  var desc = $('#claim_doc_description').val();
  var type = $('#claim_doc_type').val();
  var file = $('#claim_doc').val();

  var fileData = $("#claim_doc")[0].files[0];
  var upload = new Upload(fileData);
  var fileInfo = {name: upload.getName(), type: upload.getType(), size: upload.getSize()};
  var item = {num: claim.files.length + 1, description: desc, type: type, file: file};
  claim.files.push(item);
  
  $('#incident_files').append(Mustache.render(claimFileTpl, item));
  $('#claim_doc_description').val('').focus();
  $('#claim_doc_type').val($('#claim_doc_type option').first().text());
  $('#claim_doc').val('');
  
  
  upload.success = function (data)
  {
    for(var i = 0; i<claim.files.length; i++)
    {
      var file = claim.files[i];
      if(file.num == item.num)
      {
        file.file_id = data.file_id;
        break;
      }
      //claim.files.push();
    }
//     claim.files.push();
    updateClaim();
  };
  upload.error = function (error)
  {
	  
  };
  upload.doUpload({doc_type: type, description: desc, claim_id: claim_id});
}


function addNewWitness()
{
  var name = $('#claim_witness_name').val();
  var type = $('#claim_witness_type').val();
  var phone = $('#claim_witness_phone').val();
  var item = {num: claim.witness.length + 1, name: name, type: type, phone: phone};
  claim.witness.push(item);
  $('#incident_witnesses').append(Mustache.render(claimWitnessTpl, item));
  $('#claim_witness_name').val('').focus();
  $('#claim_witness_type').val($('#claim_witness_type option').first().text());
  $('#claim_witness_phone').val('');
  lastSave = undefined;
  updateClaim();
}

function addNewReportedItem()
{
  var name = $('#claim_item_name').val();
  var price = parseFloat($('#claim_item_price').val());
  var when = $('#claim_item_when').val();
  var item = {num: claim.items.length + 1, name: name, price: price, when: when};
  claim.items.push(item);
  $('#incident_items').append(Mustache.render(claimItemTpl, item));
  $('#claim_item_name').val('').focus();
  $('#claim_item_price').val('');
  $('#claim_item_when').val('');
  lastSave = undefined;
  updateClaim();
}

function updateClaim (ignoreSave)
{
  updateClaimData();
    
  $('#incident_date').text(formatDate(parseDateInput(claim.claim_incident_date)));
  
  var claim_type = 'Theft';
  if(claim.claim_type == 'F') claim_type = 'Fire';
  else if(claim.claim_type == 'D') claim_type = 'Damage';
  
  $('#incident_info_claim_type_value').text(claim_type);
  $('.incident_item_remove').unbind().click(function (e){
    e.preventDefault();
    var itemNo = parseInt($(this).parent().data('item'));
    for(var i = 0; i<claim.items.length;i++)
    {
      if(claim.items[i].num == itemNo)
      {        
        claim.items.splice(i,1); break;
      }
    }
    $(this).parent().remove();
    updateClaim();
  });
  $('.incident_witness_remove').unbind().click(function (e){
    e.preventDefault();
    var itemNo = parseInt($(this).parent().data('item'));
    for(var i = 0; i<claim.witness.length;i++)
    {
      if(claim.witness[i].num == itemNo)
      {        
        claim.witness.splice(i,1); break;
      }
    }
    $(this).parent().remove();
    updateClaim();
  });
  $('.incident_file_remove').unbind().click(function (e){
    e.preventDefault();
    var itemNo = parseInt($(this).parent().data('item'));
    var item = undefined;
    for(var i = 0; i<claim.files.length;i++)
    {
      if(claim.files[i].num == itemNo)
      {       
        item = {};
        for(var k in claim.files[i])
        {
          item[k] = claim.files[i][k];
        } 
        claim.files.splice(i,1); break;
      }
    }
    if(typeof item.file_id != 'undefined')
    {
      $.ajax('/claims/make/upload/remove',
      {
        dataType: 'json',
        type: 'POST',
        data: {file_id: item.file_id, file: item},
        complete: function (response, status)
        {
	        
        }
      });
    }
    
    $(this).parent().remove();
    updateClaim();
  });
  $('#incident_items_title').text(claim.items.length + (claim.items.length == 1 ? ' Item Reported' : ' Items reported' ) + ' $' + claim.itemsTotal);
  
  if(!ignoreSave) saveClaim('save', false, function (){});
  
}

function saveClaim(action, force, callback)
{
  if(!force && typeof lastSave != 'undefined')
  {
    var c = false;    
    for(var k in lastSave)
    {
      if(!c && lastSave[k] != claim[k]) { c = true; break; }
    }
    if(!c) return;
  }
  var inputData = {claim: claim, action:action, claim_id: claim_id};

  $.ajax('/claims/make/new', {
    type: 'POST',
    dataType: 'json',
    data: inputData,
    complete: function (response, status)
    {
      claim_id = response.responseJSON.claim_id;
      lastSave = {};
      for(var k in inputData.claim) { lastSave[k] = inputData.claim[k]; }
      if(typeof callback != 'undefined')
      {
        callback({input: inputData, response: response}, status);
      }
    }
    
  });
  
}


function updateClaimData()
{
  var inputs = $('#make_claim_form').find('select, input, textarea');
  for(var i=0; i < inputs.length; i++)
  {
    var $el = $(inputs[i]);
    claim[$el.attr('name')] = $el.val();
  }
  var itemsTotal = 0;
  for(var i=0;i<claim.items.length;i++)
  {
    itemsTotal += claim.items[i].price;
  }
  claim.itemsTotal = itemsTotal;
  
  
}
var startStep = 1;
var currentStepIndex = 1;
var totalSteps = 6;
function setupClaimFormSteps()
{
  $('#claim_next_step').click(function (e){
    e.preventDefault();
    nextClaimStep();
  });
  
  $('#claim_prev_step').click(function (e){
    e.preventDefault();
    previousClaimStep();
  });
}

function nextClaimStep()
{
  var nextStepIndex = currentStepIndex + 1;
  if(nextStepIndex > totalSteps)
  {
    return;
  }
  
  showClaimStep(nextStepIndex);
  
}

function previousClaimStep()
{
  var nextStepIndex = currentStepIndex - 1;
  if(nextStepIndex < startStep) { return; }
  
  showClaimStep(nextStepIndex);
  
}

function showClaimStep(index)
{
  if(index > startStep)
  {
    $('#claim_prev_step').show();
  }
  else
  {
    $('#claim_prev_step').hide();
  }
  if(index < totalSteps)
  {
    $('#claim_submit').hide();
    $('#claim_next_step').show();
  }
  else
  {
     $('#claim_next_step').hide();
     $('#claim_submit').show();
  }
  var target = '#claim_step' + index;
  
  $('.claim__step.active__step').removeClass('active__step').hide();
  $(target).addClass('active__step').show();
  currentStepIndex = index;
  
  switch (currentStepIndex) {
      case 1:
          claimStep1();
          break;
      case 2:
          claimStep2();
          break;
      case 3:
          claimStep3();
          break;
      case 4:
          claimStep4();
          break;
      case 5:
          claimStep5();
          break;
      case 6:
          claimStep6();
          break;
  }
  
}


function claimStep1(){

}
function claimStep2(){
  
}
function claimStep3(){
  
}
function claimStep4(){
  
}
function claimStep5(){
  
}
function claimStep6(){
  
}


$(function () {
  setupClaimFormSteps();
  setupClaimForm();
  updateClaim(false);
});


jQuery(function() {
  initSelectClaimType();
});

function initSelectClaimType() {
  $('input.fire').click(function() {
    $('.tab').hide();
    $('.fire__checked').show();
    $('.fire__checked input:radio').prop('checked', checked);
  });

  $('input.theft').click(function() {
    $('.tab').hide();
    $('.theft__checked').show();
  });

  $('input.damage').click(function() {
    $('.tab').hide();
    $('.damage__checked').show();
  });
}